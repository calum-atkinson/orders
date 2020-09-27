<?php


namespace App\Service;


use App\Entity\Offer;
use App\Entity\Order;
use App\Service\Offer\OfferFactory;
use Doctrine\ORM\EntityManager;
use Exception;

class PriceCalculationService
{

    private EntityManager $entityManager;
    private OfferFactory $offerFactory;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->offerFactory = new OfferFactory();
    }

    public function calculateTotal(Order $order): Order
    {
        $tickets = $order->getTickets()->toArray();

        $total = $this->calculateTotalWithoutDiscount($tickets);
        $discount = $this->calculateDiscount($tickets);
        $discountedTotal = $total - $discount;

        $order->setTotal($discountedTotal);
        $order->setDiscount($discount);

        return $order;
    }

    public function calculateTotalWithoutDiscount(Array $tickets): Int
    {
        $total = 0;
        foreach ($tickets as $ticket)
        {
            $total += $ticket->getTicketType()->getPrice();
            if ($ticket->hasAddOn()){
                $addOn = $ticket->getAddOn();
                $total += $addOn->getAddOnType()->getPrice();
            }
        }

        return $total;
    }

    public function calculateDiscount(Array $tickets): int
    {
        $repository = $this->entityManager->getRepository(Offer::class);
        $offerName = $repository->findOneBy(['active' => true])->getName();

        try {
            $offer = $this->offerFactory->getOffer($offerName);
            return $offer->calculateDiscount($tickets);
        } catch (Exception $e) {
            return 0;
        }
    }

}
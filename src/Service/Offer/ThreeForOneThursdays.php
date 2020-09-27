<?php


namespace App\Service\Offer;


class ThreeForOneThursdays extends AbstractOffer
{

    public function calculateDiscount(Array $tickets): int
    {
        if (!$this->isTodayThursday()) {
            return 0;
        }

        $freeTickets = $this->calculateFreeTickets(sizeof($tickets));

        $prices = array();
        foreach ($tickets as $ticket) {
            $basePrice = $ticket->getTicketType()->getPrice();

            $addOnPrice = 0;
            if ($ticket->hasAddOn()) {
                $addOnPrice = $ticket->getAddOn()->getAddOnType()->getPrice();
            }
            $totalPrice = $basePrice + $addOnPrice;
            $prices[] = $totalPrice;
        }

        sort($prices);
        $discount = 0;

        for ($i = 0; $i < $freeTickets; $i++) {
            $discount += $prices[$i];
        }
        return $discount;
    }

    public function isTodayThursday(): bool
    {
        return (date('w') == 4);
    }

    public function calculateFreeTickets(int $numberOfTickets): int
    {
        return floor($numberOfTickets / 3) * 2;
    }
}
<?php

namespace App\Controller;

use App\Entity\AddOn;
use App\Entity\AddOnType;
use App\Entity\Order;
use App\Entity\Ticket;
use App\Entity\TicketType;
use App\Repository\AddOnTypeRepository;
use App\Repository\OrderRepository;
use App\Repository\TicketTypeRepository;
use App\Service\PriceCalculationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private EntityManager $entityManager;
    private OrderRepository $orderRepository;
    private TicketTypeRepository $ticketTypeRepository;
    private AddOnTypeRepository $addOnTypeRepository;
    private PriceCalculationService $priceCalculationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        TicketTypeRepository $ticketTypeRepository,
        AddOnTypeRepository $addOnTypeRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->ticketTypeRepository = $ticketTypeRepository;
        $this->addOnTypeRepository = $addOnTypeRepository;
        $this->priceCalculationService = new PriceCalculationService($entityManager);
    }

    /**
     * @Route("/order", name="getOrders", methods={"GET"})
     * @return JsonResponse
     */
    public function getOrders(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();
        array_map(fn($order) => $this->priceCalculationService->calculateTotal($order), $orders);
        return new JsonResponse($orders);
    }

    /**
     * @Route("/order/{orderId}", name="getOrder", methods={"GET"})
     * @param int $orderId
     * @return JsonResponse
     */
    public function getOrder(int $orderId)
    {
        $order = $this->orderRepository->find($orderId);
        if ($order === null) {
            throw new NotFoundHttpException("Order ${orderId} not found");
        }

        $order = $this->priceCalculationService->calculateTotal($order);
        return new JsonResponse($order);
    }

    /**
     * @Route("/order", name="createOrder", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createOrder(Request $request): JsonResponse
    {
        $jsonObject = json_decode($request->getContent(), true);

        $order = new Order();
        $order->setName($jsonObject['name']);
        foreach ($jsonObject['tickets'] as $jsonTicket) {
            $this->addTicket($jsonTicket, $order);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $order = $this->priceCalculationService->calculateTotal($order);
        return new JsonResponse($order);
    }

    /**
     * @Route("/order/{orderId}/ticket", name="addTicketToOrder", methods={"POST"})
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function addTicketToOrder(Request $request, int $orderId): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Order::class);
        $ticketTypeRepository = $this->getDoctrine()->getRepository(TicketType::class);
        $addOnTypeRepository = $this->getDoctrine()->getRepository(AddOnType::class);

        $order = $repository->find($orderId);
        if (!$order) {
            throw new NotFoundHttpException("Order Id ${orderId} could not be found");
        }

        $jsonArray = json_decode($request->getContent(), true);
        foreach ($jsonArray as $jsonObject) {
            $this->addTicket($jsonObject, $order);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $order = $this->priceCalculationService->calculateTotal($order);
        return new JsonResponse($order);
    }

    /**
     * @param $jsonTicket
     * @param Order $order
     */
    public function addTicket($jsonTicket, Order $order): void
    {
        $ticketType = $this->ticketTypeRepository->find($jsonTicket['type']);
        if (!$ticketType) {
            throw new BadRequestHttpException("Invalid ticket type");
        }

        $ticket = new Ticket();
        $ticket->setOrderId($order);
        $ticket->setTicketType($ticketType);

        if (isset($jsonTicket['addOnType'])) {
            $addOnType = $this->addOnTypeRepository->find($jsonTicket['addOnType']);
            if (!$addOnType) {
                throw new BadRequestHttpException("Invalid add on type");
            }

            $addOn = new AddOn();
            $addOn->setAddOnType($addOnType);
            $ticket->setAddOn($addOn);
        }

        $order->addTicket($ticket);
    }
}

<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\ManyToOne(targetEntity=TicketType::class)
     */
    private $ticketType;

    /**
     * @ORM\OneToOne(targetEntity=AddOn::class, mappedBy="ticket", cascade={"persist", "remove"})
     */
    private $addOn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getTicketType(): ?TicketType
    {
        return $this->ticketType;
    }

    public function setTicketType(TicketType $ticketType): self
    {
        $this->ticketType = $ticketType;
        return $this;
    }

    public function getAddOn(): ?AddOn
    {
        return $this->addOn;
    }

    public function hasAddOn(): bool
    {
        if ($this->addOn) {
            return true;
        }
        return false;
    }

    public function setAddOn(AddOn $addOn): self
    {
        $this->addOn = $addOn;

        // set the owning side of the relation if necessary
        if ($addOn->getTicket() !== $this) {
            $addOn->setTicket($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        $ticket = [
            "id" => $this->id,
            "type" => $this->ticketType->getName()
        ];
        $price = $this->ticketType->getPrice();

        if ($this->hasAddOn()) {
            $addOnType = $this->addOn->getAddOnType();
            $ticket['addOn'] = $addOnType->getName();
            $price += $addOnType->getPrice();
        }

        $ticket['price'] = $price;
        return $ticket;
    }
}

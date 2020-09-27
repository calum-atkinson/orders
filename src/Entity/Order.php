<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(
 *     name="order",
 *     schema="cinema"
 * )
 */
class Order implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="order_id", orphanRemoval=true, cascade={"persist"})
     */
    private $tickets;

    private int $total;
    private int $discount;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setOrderId($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getOrderId() === $this) {
                $ticket->setOrderId(null);
            }
        }

        return $this;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "total" => $this->total,
            "discount" => $this->discount,
            "tickets" => $this->tickets->toArray()
        ];
    }

}

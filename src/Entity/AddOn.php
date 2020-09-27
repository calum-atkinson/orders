<?php

namespace App\Entity;

use App\Repository\AddOnRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddOnRepository::class)
 */
class AddOn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Ticket::class, inversedBy="addOn", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity=AddOnType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $add_on_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getAddOnType(): ?AddOnType
    {
        return $this->add_on_type;
    }

    public function setAddOnType(AddOnType $add_on_type): self
    {
        $this->add_on_type = $add_on_type;

        return $this;
    }
}

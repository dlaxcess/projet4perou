<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $visitorFirstName;

    /**
     * @ORM\Column(name="visitor_name", type="string", length=255)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Length(min=2, minMessage="Vous devez entrer au moins {{ limit }} caractères")
     */
    private $visitorName;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $visitorBirthDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Discounts")
     */
    private $discount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ticketPrice;

    /**
     * @ORM\Column(name="booked", type="boolean")
     */
    private $booked =false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TicketOrder", inversedBy="tickets")
     */
    private $ticketOrder;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank
     */
    private $country;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscount(): ?Discounts
    {
        return $this->discount;
    }

    public function setDiscount(?Discounts $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTicketPrice(): ?int
    {
        return $this->ticketPrice;
    }

    public function setTicketPrice(int $ticketPrice): self
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    public function getVisitorBirthDate(): ?\DateTimeInterface
    {
        return $this->visitorBirthDate;
    }

    public function setVisitorBirthDate(\DateTimeInterface $visitorBirthDate): self
    {
        $this->visitorBirthDate = $visitorBirthDate;

        return $this;
    }

    public function getVisitorFirstName(): ?string
    {
        return $this->visitorFirstName;
    }

    public function setVisitorFirstName(?string $visitorFirstName): self
    {
        $this->visitorFirstName = $visitorFirstName;

        return $this;
    }

    public function getVisitorName(): ?string
    {
        return $this->visitorName;
    }

    public function setVisitorName(string $visitorName): self
    {
        $this->visitorName = $visitorName;

        return $this;
    }

    public function getBooked(): ?bool
    {
        return $this->booked;
    }

    public function setBooked(bool $booked): self
    {
        $this->booked = $booked;

        return $this;
    }

    public function getTicketOrder(): ?TicketOrder
    {
        return $this->ticketOrder;
    }

    public function setTicketOrder(?TicketOrder $ticketOrder): self
    {
        $this->ticketOrder = $ticketOrder;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

}

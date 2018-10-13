<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="datetime")
     */
    private $visitDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rate;

    /**
     * @ORM\Column(name="visitor_name", type="string", length=255)
     */
    private $visitorName;

    /**
     * @ORM\Column(name="booked", type="boolean")
     */
    private $booked =false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TicketOrder", inversedBy="tickets")
     */
    private $ticketOrder;

    public function __construct()
    {
        $this->visitDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(?Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(?Rate $rate): self
    {
        $this->rate = $rate;

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

    public function getOrder(): TicketOrder
    {
        return $this->ticketOrder;
    }

    public function setOrder(?TicketOrder $ticketOrder): self
    {
        $this->ticketOrder = $ticketOrder;

        return $this;
    }
}

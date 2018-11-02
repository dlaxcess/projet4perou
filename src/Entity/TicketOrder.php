<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class TicketOrder
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
    private $orderDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bookingCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingEmail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="ticketOrder", cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ticketAmount;

    public function __construct()
    {
        $this->orderDate = new \DateTime();

        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getBookingCode(): ?string
    {
        return $this->bookingCode;
    }

    public function setBookingCode(string $bookingCode): self
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    public function getBookingEmail(): ?string
    {
        return $this->bookingEmail;
    }

    public function setBookingEmail(string $bookingEmail): self
    {
        $this->bookingEmail = $bookingEmail;

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
            $ticket->setTicketOrder($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getTicketOrder() === $this) {
                $ticket->setTicketOrder(null);
            }
        }

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getTicketAmount(): ?int
    {
        return $this->ticketAmount;
    }

    public function setTicketAmount(int $ticketAmount): self
    {
        $this->ticketAmount = $ticketAmount;

        return $this;
    }
}

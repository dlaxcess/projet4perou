<?php

namespace App\Entity;

use App\Validator\Constraints\ThousandLimit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\Constraints\ValidVisitDate;
use App\Validator\Constraints\BeforeNoon;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today midnight", message = "Vous ne pouvez réserver un billet avant le {{ compared_value }}")
     * @ValidVisitDate()
     * @ThousandLimit()
     * @Assert\NotBlank()
     */
    private $visitDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Duration")
     * @ORM\JoinColumn(nullable=false)
     * @BeforeNoon()
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="'{{ value }}' n'est pas une adresse valide")
     * @Assert\NotBlank()
     */
    private $bookingEmail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="ticketOrder", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalPrice;


    public function __construct()
    {
        $this->orderDate = new \DateTime();

        $this->bookingCode = date_format($this->orderDate, 'Ymd') . 'LVR' . md5(uniqid());

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
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgesPricesRepository")
 */
class AgesPrices
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $minAge;

    /**
     * @ORM\Column(type="float")
     */
    private $ticketPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;

        return $this;
    }

    public function getTicketPrice(): ?float
    {
        return $this->ticketPrice;
    }

    public function setTicketPrice(float $ticketPrice): self
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }
}

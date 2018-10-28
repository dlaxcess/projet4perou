<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountsRepository")
 */
class Discounts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $discountName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $discountDescription;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discountValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscountName(): ?string
    {
        return $this->discountName;
    }

    public function setDiscountName(string $discountName): self
    {
        $this->discountName = $discountName;

        return $this;
    }

    public function getDiscountDescription(): ?string
    {
        return $this->discountDescription;
    }

    public function setDiscountDescription(?string $discountDescription): self
    {
        $this->discountDescription = $discountDescription;

        return $this;
    }

    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }

    public function setDiscountValue(?float $discountValue): self
    {
        $this->discountValue = $discountValue;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 25/10/18
 * Time: 12:22
 */

namespace App\Services;


use App\Entity\AgesPrices;
use App\Entity\Discounts;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;

class TicketPriceGenerator
{
    private $em;
    private $ticketPrice = 0;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function generatePrice(Ticket $ticket)
    {
        $agesPrices = $this->em->getRepository(AgesPrices::class)->findAll();

        $today = new \DateTime();
        $visitorAge = $ticket->getVisitorBirthDate()->diff($today)->y;

        foreach ($agesPrices as $agePrice) {

            if ($agePrice->getMinAge() <= $visitorAge) {
                $this->ticketPrice = $agePrice->getTicketPrice();
            }

        }

        $discount = $ticket->getDiscount();
        $discountValue = $ticket->getDiscount()->getDiscountValue();

        if ($discount != null) {

            if ($discountValue > 0) {
                $this->ticketPrice = $discountValue;
            }

            if ($discountValue < 0) {
                $this->ticketPrice -= $discountValue;
            }

            if ($discountValue < 0 ) {
                $this->ticketPrice = $this->ticketPrice * $discountValue;
            }
        }

        echo $this->ticketPrice;
        die();



        $ticketRates = [
            [0, 0],
            [4, 8],
            [12, 16],
            [60, 12],
            ['tarif réduit', 10]
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 25/10/18
 * Time: 12:22
 */

namespace App\Services;


use App\Entity\AgesPrices;
use App\Entity\Ticket;
use App\Entity\TicketOrder;
use Doctrine\ORM\EntityManagerInterface;

class TicketPriceGenerator
{
    private $em;
    private $ticketPrice = 0;
    private $ticketOrderTotPrice = 0;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setTicketCollectionPrices(TicketOrder $ticketOrder)
    {
        $ticketCollection = $ticketOrder->getTickets();
        $ticketOrderDuration = $ticketOrder->getDuration()->getName();

        foreach ($ticketCollection as $ticket) {
            $ticketPrice = $this->generatePrice($ticket, $ticketOrderDuration);
            $ticket->setTicketPrice($ticketPrice);
            $this->ticketOrderTotPrice += $ticketPrice;
        }
    }

    public function generatePrice(Ticket $ticket, string $ticketOrderDuration)
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

            if ($discountValue >= 1 && $this->ticketPrice > $discountValue) {
                $this->ticketPrice = $discountValue;
            }

            if ($discountValue < 0 && $this->ticketPrice > abs($discountValue)) {
                $this->ticketPrice += $discountValue;
            }

            if ($discountValue > 0 && $discountValue < 1) {
                $this->ticketPrice = $this->ticketPrice * $discountValue;
            }
        }


        if ($ticketOrderDuration == 'halfday') {
            $this->ticketPrice = $this->ticketPrice/2;
        }

        return $this->ticketPrice;

    }

    public function getTotalOrderPrice() {
        return $this->ticketOrderTotPrice;
    }
}
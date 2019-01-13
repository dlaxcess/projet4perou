<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 25/10/18
 * Time: 12:22
 */

namespace App\Services;


use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Repository\AgesPricesRepository;

class TicketPriceGenerator
{
    private $agePricesRepository;
    private $ticketPrice = 0;
    private $ticketOrderTotPrice = 0;

    public function __construct(AgesPricesRepository $APRepo)
    {
        $this->agePricesRepository = $APRepo;
    }

    public function setTicketCollectionPrices(TicketOrder $ticketOrder)
    {
        $ticketCollection = $ticketOrder->getTickets();

        foreach ($ticketCollection as $ticket) {
            $ticketPrice = $this->generatePrice($ticket);
            $ticket->setTicketPrice($ticketPrice);
            $this->ticketOrderTotPrice += $ticketPrice;
        }
    }

    public function generatePrice(Ticket $ticket)
    {
        $agesPrices = $this->agePricesRepository->findAll();

        $today = new \DateTime();
        $visitorAge = $ticket->getVisitorBirthDate()->diff($today)->y;

        $ticketOrderDuration = $ticket->getTicketOrder()->getDuration()->getName();

        // Price with Age
        foreach ($agesPrices as $agePrice) {

            if ($agePrice->getMinAge() <= $visitorAge) {
                $this->ticketPrice = $agePrice->getTicketPrice();
            }
        }

        // Price with discount
        $discount = $ticket->getDiscount();
        $discountValue = $ticket->getDiscount()->getDiscountValue();

        if ($discount) {

            switch (true) {
                case ($discountValue >= 1 && $this->ticketPrice > $discountValue):
                    $this->ticketPrice = $discountValue;
                    break;
                case ($discountValue < 0 && $this->ticketPrice > abs($discountValue)):
                    $this->ticketPrice += $discountValue;
                    break;
                case ($discountValue > 0 && $discountValue < 1):
                    $this->ticketPrice = $this->ticketPrice * $discountValue;
                    break;
                default:
                    break;
            }

//            if ($discountValue >= 1 && $this->ticketPrice > $discountValue) {
//                $this->ticketPrice = $discountValue;
//            }
//
//            if ($discountValue < 0 && $this->ticketPrice > abs($discountValue)) {
//                $this->ticketPrice += $discountValue;
//            }
//
//            if ($discountValue > 0 && $discountValue < 1) {
//                $this->ticketPrice = $this->ticketPrice * $discountValue;
//            }
        }

        /* Price by visit duration */
        if ('halfday' == $ticketOrderDuration) {
            $this->ticketPrice = $this->ticketPrice/2;
        }

        return $this->ticketPrice;

    }

    public function getTotalOrderPrice() {
        return $this->ticketOrderTotPrice;
    }
}
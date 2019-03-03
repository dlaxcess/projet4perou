<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 05/01/19
 * Time: 23:18
 */

namespace App\Services;


use App\Entity\TicketOrder;
use App\Repository\DiscountsRepository;
use App\Repository\DurationRepository;


class TicketOrderRefactorer
{
    private $durationRepo;
    private $discountsRepo;
    private $discountsArray;

    public function __construct(DurationRepository $durationRepo, DiscountsRepository $discountsRepo)
    {
        $this->durationRepo = $durationRepo;
        $this->discountsRepo = $discountsRepo;
    }

    public function refactorTicketOrder(TicketOrder $ticketOrder)
    {
        $duration = $this->durationRepo->find($ticketOrder->getDuration()->getId());
        $ticketOrder->setDuration($duration);

        $this->discountsArray = $this->discountsRepo->findAll();
        $ticketCollection = $ticketOrder->getTickets();

        $discountTab = [
            'Tarif normal' => $this->discountsArray[0],
            'Tarif réduit' => $this->discountsArray[1],
            'Coupon réduction' => $this->discountsArray[2],
            'réduction de 10%' => $this->discountsArray[3],
        ];

        foreach ($ticketCollection as $ticket) {
            $ticket->setDiscount($discountTab[$ticket->getDiscount()->getDiscountName()]/*$this->discountsArray[$ticket->getDiscount()->getId()-1]*/);
        }

        return $ticketOrder;
    }
}
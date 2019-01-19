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

    public function refactorTicketOrder(TicketOrder $ticketOrder) {
        $duration = $this->durationRepo->find($ticketOrder->getDuration()->getId());
        $ticketOrder->setDuration($duration);

        $this->discountsArray = $this->discountsRepo->findAll();
        $ticketCollection = $ticketOrder->getTickets();

        foreach ($ticketCollection as $ticket) {
            $ticket->setDiscount($this->discountsArray[$ticket->getDiscount()->getId()-1]);
//            foreach ($this->discountsArray as $discount) {
//                if ($ticket->getDiscount() == $discount) {
//                    $ticket->setDiscount($discount);
//                }
//            }
        }

        return $ticketOrder;
    }
}
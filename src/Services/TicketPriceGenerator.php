<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 25/10/18
 * Time: 12:22
 */

namespace App\Services;


use App\Entity\Ticket;

class TicketPriceGenerator
{
    public function generatePrice(Ticket $ticket)
    {
        $today = new \DateTime();
        $visitorAge = $ticket->getVisitorBirthDate()->diff($today)->y;
        echo $visitorAge;
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
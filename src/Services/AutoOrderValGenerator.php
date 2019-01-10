<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 05/01/19
 * Time: 23:18
 */

namespace App\Services;


use App\Entity\TicketOrder;


class AutoOrderValGenerator
{
    private $generatedBookingCode = 'LVR';

    public function generateBookingCode(TicketOrder $ticketOrder) {
        $this->generatedBookingCode .= date_format($ticketOrder->getOrderDate(), 'Ymd');
        $this->generatedBookingCode .= strtoupper(substr($ticketOrder->getDuration()->getName(), 0, 2));
        $this->generatedBookingCode .= date_format($ticketOrder->getVisitDate(), 'Ymd');

        return $this->generatedBookingCode;
    }
}
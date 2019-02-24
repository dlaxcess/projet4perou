<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 23/02/19
 * Time: 22:04
 */

namespace App\Tests\Services;

use App\Services\TicketPriceGenerator;
use App\Entity\TicketOrder;
use App\Entity\Ticket;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TicketPriceGeneratorTest extends TestCase
{
    public function testGeneratePrice()
    {
        $ticketPriceGenerator = new TicketPriceGenerator();

        $testOrder = new TicketOrder();
        $testTicket1 = new Ticket();
        $testTicket2 = new Ticket();
    }
}
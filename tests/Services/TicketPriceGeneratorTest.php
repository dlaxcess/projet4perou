<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 23/02/19
 * Time: 22:04
 */

namespace App\Tests\Services;

use App\Entity\AgesPrices;
use App\Entity\Discounts;
use App\Entity\Duration;
use App\Services\TicketPriceGenerator;
use App\Entity\TicketOrder;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketPriceGeneratorTest extends WebTestCase
{
    private $doctrine;

    public function setUp()
    {
        $kernel = static::bootKernel();
        $this->doctrine = $kernel->getContainer()->get('doctrine');
    }

    public function testGeneratePrice()
    {
        $agesPricesRepo = $this->doctrine->getRepository(AgesPrices::class);

        $ticketOrderDuration = new Duration();
        $ticketOrderDuration
            ->setName('day');

        $testOrder = new TicketOrder();

        $testOrder
            ->setVisitDate(new \DateTime(date('Y-m-d', strtotime('+1 day'))))
            ->setDuration($ticketOrderDuration)
            ->setBookingEmail('flipiste@free.fr');

        $testTicket1 = new Ticket();

        $discount1 = new Discounts();
        $discount1
            ->setDiscountName('Tarif normal')
            ->setDiscountValue(null);


        $testTicket1
            ->setVisitorFirstName('phil')
            ->setVisitorName('perou')
            ->setVisitorBirthDate(new \DateTime('1981-11-03'))
            ->setDiscount($discount1)
            ->setCountry('FR');

        $testOrder
            ->addTicket($testTicket1);

        $ticketPriceGenerator = new TicketPriceGenerator($agesPricesRepo);
        $this->assertEquals(16, $ticketPriceGenerator->generatePrice($testTicket1));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 11/03/2019
 * Time: 10:25
 */

namespace App\Tests\Validator\Constraints;


use App\Entity\Discounts;
use App\Entity\Duration;
use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Repository\TicketRepository;
use App\Validator\Constraints\ThousandLimitValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ThousandLimitValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        $ticketRepo = $this->createMock(TicketRepository::class);

        $ticketRepo->expects($this->any())
            ->method('getOneDateTicketAmount')
            ->willReturn(999);

        return new ThousandLimitValidator($ticketRepo);
    }

    public function testNotValid()
    {
        $ticketOrderDuration = new Duration();
        $ticketOrderDuration->setName('day');

        $discount = new Discounts();
        $discount
            ->setDiscountName('Tarif normal')
            ->setDiscountValue(null);

        $testTicket = new Ticket();
        $testTicket
            ->setVisitorFirstName('phil')
            ->setVisitorName('perou')
            ->setVisitorBirthDate(new \DateTime('1981-11-03'))
            ->setDiscount($discount)
            ->setCountry('FR');

        $testTicket2 = new Ticket();
        $testTicket2
            ->setVisitorFirstName('phil')
            ->setVisitorName('perou')
            ->setVisitorBirthDate(new \DateTime('1981-11-03'))
            ->setDiscount($discount)
            ->setCountry('FR');

        $ticketOrder  = new TicketOrder;
        $ticketOrder
            ->setVisitDate(new \DateTime(date('Y-m-d', strtotime('+1 day'))))
            ->setDuration($ticketOrderDuration)
            ->setBookingEmail('flipiste@free.fr')
            ->addTicket($testTicket)
            ->addTicket($testTicket2);

        $this->setObject($ticketOrder);
        $this->validator->validate(new \DateTime(date('Y-m-d', strtotime('+1 day'))), $this->constraint);

        $this->assertSame(1, $violationsCount = \count($this->context->getViolations()), sprintf('1 violation expected. Got %u.', $violationsCount));

    }

    public function testValid()
    {
        $ticketOrderDuration = new Duration();
        $ticketOrderDuration->setName('day');

        $discount = new Discounts();
        $discount
            ->setDiscountName('Tarif normal')
            ->setDiscountValue(null);

        $testTicket = new Ticket();
        $testTicket
            ->setVisitorFirstName('phil')
            ->setVisitorName('perou')
            ->setVisitorBirthDate(new \DateTime('1981-11-03'))
            ->setDiscount($discount)
            ->setCountry('FR');

        $ticketOrder  = new TicketOrder;
        $ticketOrder
            ->setVisitDate(new \DateTime(date('Y-m-d', strtotime('+1 day'))))
            ->setDuration($ticketOrderDuration)
            ->setBookingEmail('flipiste@free.fr')
            ->addTicket($testTicket);

        $this->setObject($ticketOrder);
        $this->validator->validate(new \DateTime(date('Y-m-d', strtotime('+1 day'))), $this->constraint);

        $this->assertNoViolation();
    }
}
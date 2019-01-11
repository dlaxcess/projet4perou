<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 11/01/19
 * Time: 17:58
 */

namespace App\DataFixtures;


use App\Entity\Ticket;
use App\Entity\TicketOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class LoadTicketOrder extends Fixture
{
    private $discountRepository;
    private $durationRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->discountRepository = $em->getRepository('App:Discounts');
        $this->durationRepository = $em->getRepository('App:Duration');
    }

    public function load(ObjectManager $manager)
    {
        $duration = $this->durationRepository->find(1);
        for ($i = 0; $i <= 998; $i++) {

            $ticket = new Ticket();

            $ticket->setVisitorFirstName('zertyu');
            $ticket->setVisitorName('yhgvcd');
            $ticket->setVisitorBirthDate(new \DateTime('1980-01-20 00:00:00'));
            $ticket->setDiscount($this->discountRepository->find(1));
            $ticket->setCountry('FR');

            $TicketOrderEntry = new TicketOrder();

            $TicketOrderEntry->setVisitDate(new \DateTime('2019-01-20 00:00:00'));
            $TicketOrderEntry->setDuration($duration);
            $TicketOrderEntry->setBookingEmail('flipiste@free.fr');
            $TicketOrderEntry->addTicket($ticket);

            $manager->persist($TicketOrderEntry);
        }
        $manager->flush();
    }
}
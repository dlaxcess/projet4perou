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
use App\Repository\DiscountsRepository;
use App\Repository\DurationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadTicketOrder extends Fixture implements DependentFixtureInterface
{
    private $discountRepository;
    private $durationRepository;

    public function __construct(DiscountsRepository $discountRepo, DurationRepository $durationRepo)
    {
        $this->discountRepository = $discountRepo;
        $this->durationRepository = $durationRepo;
    }

    public function load(ObjectManager $manager)
    {
        $duration = $this->durationRepository->find(1);
        for ($i = 0; $i <= 996; $i++) {

            $ticket = new Ticket();

            $ticket->setVisitorFirstName('zertyu');
            $ticket->setVisitorName('yhgvcd');
            $ticket->setVisitorBirthDate(new \DateTime('1980-01-20 00:00:00'));
            $ticket->setDiscount($this->discountRepository->find(1));
            $ticket->setCountry('FR');

            $TicketOrderEntry = new TicketOrder();

            $TicketOrderEntry->setVisitDate(new \DateTime('2019-01-21 00:00:00'));
            $TicketOrderEntry->setDuration($duration);
            $TicketOrderEntry->setBookingEmail('flipiste@free.fr');
            $TicketOrderEntry->addTicket($ticket);

            $manager->persist($TicketOrderEntry);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadAgesPrices::class,
            LoadDiscounts::class,
            LoadDuration::class,
        );
    }
}
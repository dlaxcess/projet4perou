<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 28/10/18
 * Time: 17:44
 */

namespace App\DataFixtures;

use App\Entity\AgesPrices;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAgesPrices extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $agesPrices = array(
            array('minAge' => 0, 'ticketPrice' => 0),
            array('minAge' => 4, 'ticketPrice' => 8),
            array('minAge' => 12, 'ticketPrice' => 16),
            array('minAge' => 60, 'ticketPrice' => 12)
        );

        foreach ($agesPrices as $agePrice) {
            $agesPricesEntry = new AgesPrices();

            foreach ($agePrice as $column => $value) {
                $agesPricesEntry->{'set' . ucfirst($column)}($value);
            }

            $manager->persist($agesPricesEntry);
        }
        $manager->flush();
    }
}

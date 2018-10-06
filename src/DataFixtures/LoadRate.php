<?php

namespace App\DataFixtures;

use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRate extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $rates = array(
            array('name' => 'normal', 'price' => 16, 'description' => 'à partir de 12 ans'),
            array('name' => 'enfant', 'price' => 8, 'description' => 'à partir de 4 ans et jusqu\'à 12 ans'),
            array('name' => 'nouveau-né', 'price' => 0, 'description' => 'moins de 4 ans'),
            array('name' => 'senior', 'price' => 12, 'description' => 'à partir de 60 ans'),
            array('name' => 'réduit', 'price' => 10, 'description' => 'Tarif réduit')
        );

        foreach ($rates as $rate) {
            $rateEntry = new Rate();

            foreach ($rate as $column => $value) {
                $rateEntry->{'set' . ucfirst($column)}($value);
            }

            $manager->persist($rateEntry);
        }

        /*$names = array(
            'normal',
            'enfant',
            'nouveau-né',
            'senior',
            'réduit'
        );

        $prices = array(
            '16',
            '8',
            '0',
            '12',
            '10'
        );

        $descriptions = array(
            'à partir de 12 ans',
            'à partir de 4 ans et jusqu\'à 12 ans',
            'moins de 4 ans',
            'à partir de 60 ans',
            'Tarif réduit'
        );

        for ($i = 0; $i < count($names); $i++) {
            $rate = new Rate();
            $rate->setName($names[$i])
                ->setPrice($prices[$i])
                ->setDescription($descriptions[$i])
            ;

            $manager->persist($rate);
        }*/

        $manager->flush();
    }
}

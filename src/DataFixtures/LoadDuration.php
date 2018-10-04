<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 30/09/2018
 * Time: 18:11
 */

namespace App\DataFixtures;

use App\Entity\Duration;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDuration implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'day',
            'halfday'
        );

        foreach ($names as $name) {
            $duration = new Duration();
            $duration->setName($name);

            $manager->persist($duration);
        }

        $manager->flush();
    }
}
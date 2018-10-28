<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 28/10/18
 * Time: 20:58
 */

namespace App\DataFixtures;

use App\Entity\Discounts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDiscounts extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $discounts = array(
            array('discountName' => 'Tarif réduit', 'discountDescription' => 'étudiant, employé du musée, d\'un service du ministère de la culture, militaire', 'discountValue' => 10 ),
            array('discountName' => 'Coupon réduction', 'discountDescription' => 'bon pour une réduction de 2€', 'discountValue' => -2 ),
            array('discountName' => 'réduction de 10%', 'discountDescription' => 'bon pour une réduction de 10%', 'discountValue' => 0.9 ),
        );

        foreach ($discounts as $discount) {
            $discountEntity = new Discounts();

            foreach ($discount as $column => $value) {
                $discountEntity->{'set' . ucfirst($column)}($value);
            }

            $manager->persist($discountEntity);
        }
        $manager->flush();
    }
}
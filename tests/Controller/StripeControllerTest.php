<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 08/03/2019
 * Time: 14:41
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StripeControllerTest extends WebTestCase
{
    public function testPrepareStripeOrder()
    {
        $client = static::createClient();

        $client->request('GET', '/billetterie/prepareOrder');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCheckoutOrder()
    {
        $client = static::createClient();

        $client->request('GET', '/billetterie/checkoutOrder');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testPaymentSuccess()
    {
        $client = static::createClient();

        $client->request('GET', '/billetterie/StripePaiementSucces');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
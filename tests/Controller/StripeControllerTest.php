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
    /**
     * @dataProvider provideUrls
     */
    public function testStripeRedirection($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function provideUrls()
    {
        return [
            ['/billetterie/prepareOrder'],
            ['/billetterie/checkoutOrder'],
            ['/billetterie/StripePaiementSucces'],
        ];
    }
}
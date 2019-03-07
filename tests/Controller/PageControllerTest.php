<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 03/03/19
 * Time: 18:03
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testBilletterie()
    {
        $client = static::createClient();

        $client->request('GET', '/billetterie');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /*echo $client->getResponse()->getContent();*/

        $crawler = $client->request('GET', '/billetterie');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("billetterie")')->count()
        );
    }

}
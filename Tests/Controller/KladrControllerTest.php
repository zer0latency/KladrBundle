<?php

namespace zer0latency\KladrBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KladrControllerTest extends WebTestCase
{
    public function testRegion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/region');
    }

    public function testStreet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/street');
    }

    public function testDoma()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/doma');
    }

}

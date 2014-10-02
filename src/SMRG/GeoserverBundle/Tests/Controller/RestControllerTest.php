<?php

namespace SMRG\GeoserverBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestControllerTest extends WebTestCase
{
    public function testGetprojects()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProjects');
    }

    public function testGetroutes()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getRoutes');
    }

    public function testGetevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getEvents');
    }

}

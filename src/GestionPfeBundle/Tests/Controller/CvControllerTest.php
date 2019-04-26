<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CvControllerTest extends WebTestCase
{
    public function testRemplircv()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/RemplirCv');
    }

    public function testAffichecv()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AfficheCv');
    }

    public function testModifiercv()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ModifierCv');
    }

}

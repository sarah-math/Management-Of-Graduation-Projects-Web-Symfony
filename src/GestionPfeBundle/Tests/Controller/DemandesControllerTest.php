<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemandesControllerTest extends WebTestCase
{
    public function testPostuler()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Postuler');
    }

    public function testSupprimerdemande()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/SupprimerDemande');
    }

}

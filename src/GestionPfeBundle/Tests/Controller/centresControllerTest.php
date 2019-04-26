<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class centresControllerTest extends WebTestCase
{
    public function testAjoutcentre()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajoutCentre');
    }

    public function testModifiercentre()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifierCentre');
    }

    public function testSupprimercentre()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimerCentre');
    }

}

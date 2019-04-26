<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class formationsControllerTest extends WebTestCase
{
    public function testAjoutformation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajoutFormation');
    }

    public function testModifierformation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifierFormation');
    }

    public function testSupprimerformation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimerFormation');
    }

}

<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class competencesControllerTest extends WebTestCase
{
    public function testAjoutcompetence()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajoutCompetence');
    }

    public function testSupprimercompetence()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimerCompetence');
    }

    public function testModifiercompetence()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifierCompetence');
    }

}

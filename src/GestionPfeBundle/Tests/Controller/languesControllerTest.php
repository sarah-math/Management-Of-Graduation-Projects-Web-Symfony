<?php

namespace GestionPfeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class languesControllerTest extends WebTestCase
{
    public function testAjoutlangue()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajoutLangue');
    }

    public function testModifierlangue()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ModifierLangue');
    }

    public function testSupprimerlangue()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimerLangue');
    }

}

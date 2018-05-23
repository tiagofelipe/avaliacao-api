<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Uloc\Bundle\AppBundle\Entity\Criterio;
use Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class CriterioEstabelecimentoControllerTest extends ApiTestCase
{

    public function  testGETCriterioEstabelecimentoIndex()
    {

        $criterio= new Criterio();
        $criterio->setNome('asasas');
        $criterio->setAtivo(true);
        $est = new Estabelecimento();
        $est->setCnpj('11111111');
        $est->setNomeFantasia('nome');
        $est->setTipo(1);
        $est->setRazaoSocial( 'a');
        $critEst = new CriterioEstabelecimento();
        $critEst->setCriterio($criterio);
        $critEst->setEstabelecimento($est);
        $em = $this->getEntityManager();
        $em->persist($criterio);
        $em->persist($est);
        $em->persist($critEst);
        $em->flush();

        $response = $this->client->get('/api/public/criterioestabelecimento/'.$est->getId().'/', array(
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'id', 10);
        $this->asserter()->assertResponsePropertyEquals($response, 'criterio.nome', 'asasas');
    }
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/criterioestabelecimento/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /criterioestabelecimento/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'uloc_bundle_appbundle_criterioestabelecimento[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'uloc_bundle_appbundle_criterioestabelecimento[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}

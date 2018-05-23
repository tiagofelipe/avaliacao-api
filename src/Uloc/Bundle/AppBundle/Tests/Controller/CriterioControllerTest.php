<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Uloc\Bundle\AppBundle\Entity\Criterio;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class CriterioControllerTest extends ApiTestCase
{


    public function testPOST () {

        $data = array(
            'nome' => 'criterio de teste',
            'ativo' => true,

        );

        $response = $this->client->post('/api/criterio/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }
    public function testPUT () {

        $criterio = new Criterio();
        $criterio->setNome('teste');
        $criterio->setAtivo(true);
        $em = $this->getEntityManager();
        $em->persist($criterio);
        $em->flush();

        $data = array(
            'nome' => 'Atualizado',
            'ativo' => false,
        );

        $response = $this->client->post('/api/criterio/'.$criterio->getId().'/update', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nome', 'Atualizado');
        $this->asserter()->assertResponsePropertyExists($response, 'ativo');

    }

    public function testDELETE () {

        $criterio = new Criterio();
        $criterio->setNome('teste');
        $criterio->setAtivo(true);
        $em = $this->getEntityManager();
        $em->persist($criterio);
        $em->flush();


        $response = $this->client->delete('/api/criterio/'.$criterio->getId(), array(
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->debugResponse($response);
        $this->assertEquals(204, $response->getStatusCode());

    }
}

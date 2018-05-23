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
        $est->setCnpj('112311');
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


    }

    public function testPOST () {

        $criterio= new Criterio();
        $criterio->setNome('asasas');
        $criterio->setAtivo(true);
        $est = new Estabelecimento();
        $est->setCnpj('11112111');
        $est->setNomeFantasia('nome');
        $est->setTipo(1);
        $est->setRazaoSocial( 'a');
        $em = $this->getEntityManager();
        $em->persist($criterio);
        $em->persist($est);
        $em->flush();

        $data = array(
            'criterio' => $criterio->getId(),
            'estabelecimento'=>$est->getId(),

        );

        $response = $this->client->post('/api/criterioestabelecimento/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }


    public function testDELETE () {

        $criterio= new Criterio();
        $criterio->setNome('asasas');
        $criterio->setAtivo(true);
        $est = new Estabelecimento();
        $est->setCnpj('11113111');
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


        $response = $this->client->delete('/api/criterioestabelecimento/'.$critEst->getId(), array(
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->debugResponse($response);
        $this->assertEquals(204, $response->getStatusCode());
        // $this->printDebug(dump($response));
    }
}

<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class EstabelecimentoControllerTest extends ApiTestCase
{

    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp($forcePurge, $basicData);
    }

    public function testPOST()
    {

        $data = array(
            'cnpj' => '121212',
            'nomeFantasia' => 'nome de teste',
            'razaoSocial' => 'razao de teste',
            'tipo' => 1,
        );

        $response = $this->client->post('/api/estabelecimento/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }

    public function testUpload()
    {

        $banner = new Estabelecimento();
        $banner->setRazaoSocial('teste');
        $banner->setNomeFantasia('teste');
        $banner->setTipo(1);
        $banner->setCnpj('123');
        $em = $this->getEntityManager();
        $em->persist($banner);
        $em->flush();

        $response = $this->client->post('/api/estabelecimento/' . $banner->getId() . '/upload', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:/Users/casa/Pictures/isaac-newton.png', 'r')
                )
            )
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nomeFantasia', 'teste');
        $this->debugResponse($response);
    }

    public function testGETEstabelecimentoIndex()
    {

        $estabelecimento = new Estabelecimento();
        $estabelecimento->setCnpj('11111000110010');
        $estabelecimento->setNomeFantasia('Fantasia de natal');
        $estabelecimento->setRazaoSocial('Exiks');


        $response = $this->client->get('/api/public/estabelecimento/', array(
            'headers' => $this->getAuthorizedHeaders('tiago')


        ));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
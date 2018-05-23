<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Uloc\Bundle\AppBundle\Entity\Funcionario;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class FuncionarioControllerTest extends ApiTestCase
{
    public function testPOST () {

        $data = array(
            'cargo' => 'cargo de teste',

            'nome' => 'nome de teste',


        );

        $response = $this->client->post('/api/funcionario/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }

    public function testUpload()
    {

        $func = new Funcionario();
        $func->setNome('teste');
        $func->setCargo('teste');
        $em = $this->getEntityManager();
        $em->persist($func);
        $em->flush();

        $response = $this->client->post('/api/funcionario/' . $func->getId() . '/upload', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:/Users/casa/Pictures/isaac-newton.png', 'r')
                )
            )
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nome', 'teste');
        $this->debugResponse($response);
    }

    public function testGETFuncIndex()
    {

        $estabelecimento = new Funcionario();
        $estabelecimento->setCargo('secretario');
        $estabelecimento->setNome('Joap');



        $response = $this->client->get('/api/public/funcionario/', array(
            'headers' => $this->getAuthorizedHeaders('tiago')


        ));
        $this->assertEquals(200, $response->getStatusCode());
    }

}

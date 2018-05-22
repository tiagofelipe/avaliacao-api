<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 21/05/18
 * Time: 18:10
 */

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class AvaliacaoControllerTest extends ApiTestCase
{
    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp($forcePurge, $basicData);
    }

    public function testNewPublicAvaliacaoAction(){
        $estabid = $this->createEstabelecimento()->getId();

        $data = array(
            'nota' => rand(1, 5),
            'comentario' => 'Comentário de teste',
            'estabelecimento' => $estabid
        );

        $response = $this->client->post('/api/public/avaliacao/new', array(
            'body' => \json_encode($data)
        ));

        $this->debugResponse($response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testInvalidPublicAvaliacaoAction(){

        $data = array(
            'nota' => rand(1, 5),
            'comentario' => 'Comentário de teste'
        );

        $response = $this->client->post('/api/public/avaliacao/new', array(
            'body' => \json_encode($data)
        ));

        $this->assertEquals(400, $response->getStatusCode());
    }
}

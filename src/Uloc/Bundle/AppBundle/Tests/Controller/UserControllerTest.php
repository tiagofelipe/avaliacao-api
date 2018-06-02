<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 21/05/18
 * Time: 16:40
 */

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class UserControllerTest extends ApiTestCase
{
    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp($forcePurge, $basicData);
    }

    public function testPOSTUsuarioWorks(){

        $login = 'cobaia'.rand(0, 999);
        $data = array(
            'username' => $login,
            'email' => $login.'@hotmail.com',
            'password' => 'abc'
        );

        // 1) Create a user resource
        $response = $this->client->post('/api/usuario/new', [
            'body' => json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'username', $login);
    }

    public function testGETEstabelecimentos () {

        $user = $this->createUser('user', 'teste');
        $user1 = $this->createUser('cobaia');
        $estab = $this->createEstabelecimento();
        $estab1 = $this->createEstabelecimento('26.182.818/0001-66', 'Estabelecimento Teste', 'Estabelecimento Teste');
        $estab2 = $this->createEstabelecimento('93.656.131/0001-02', 'Estabelecimento Teste 2', 'Estabelecimento Teste 2');

        $em = $this->getEntityManager();

        $user->addEstabelecimento($estab);
        $user->addEstabelecimento($estab1);
        $user1->addEstabelecimento($estab2);
        $em->flush();

        $response = $this->client->get('/api/usuario/'.$user->getId().'/listEstabelecimentos', array(
            'headers' => $this->getAuthorizedHeaders('user')
        ));

        //$this->debugResponse($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyCount($response, 'estabelecimentos', 2);
    }
}

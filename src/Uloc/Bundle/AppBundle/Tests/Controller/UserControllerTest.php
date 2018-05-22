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
}

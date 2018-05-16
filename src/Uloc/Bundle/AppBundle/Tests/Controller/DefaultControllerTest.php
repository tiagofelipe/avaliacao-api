<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Uloc\Bundle\AppBundle\Test\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends ApiTestCase
{
    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp();
    }

    public function testApiAccessNotToken()
    {

        $response = $this->client->get('/api/status');

        $this->assertEquals(401, $response->getStatusCode());

        #print_r($this->getAuthorizedHeaders('tiago'));
        #$this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testApiPublicAcessToken()
    {
        $response = $this->client->get('/api/public/status');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testApiAccessWithToken()
    {

        $data = [];

        $response = $this->client->get('/api/status', [
            'body' => json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTokenCreatorValidPassword(){
        $user = $this->getEntityManager()
            ->getRepository('UlocAppBundle:Usuario')
            ->findOneBy(['username' => 'tiago']);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        //Testa se o password é válido
        $isValid = $this->getService('security.password_encoder')
            ->isPasswordValid($user, 'teste1');
        //Testa se o password é inválido
        $isInValid = $this->getService('security.password_encoder')
            ->isPasswordValid($user, 'teste1b');

        $this->assertTrue($isValid, "Password precisa ser válido");
        $this->assertFalse($isInValid, "Teste de password inválido não passou");

        $token = $this->getService('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        #print_r(['token' => $token]);
    }
}

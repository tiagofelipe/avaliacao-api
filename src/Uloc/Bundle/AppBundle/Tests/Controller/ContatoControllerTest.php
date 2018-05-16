<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Tests\Controller;
use Uloc\Bundle\AppBundle\Entity\Contato;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class ContatoControllerTest extends ApiTestCase
{


    public function  testGETContatoIndex()
    {

        $contato= new Contato();
        $contato->setMensagem('asasas');
        $contato->setEmail('email@email.com');
        $contato->setTelefone('989898999');


        $response = $this->client->get('/api/contato/', array(
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));
    $this->assertEquals(200, $response->getStatusCode());
    $this->asserter()->assertResponsePropertyIsArray($response, 'items');
    $this->asserter()->assertResponsePropertyCount($response, 'items', 2);
    $this->asserter()->assertResponsePropertyEquals($response, 'items[1].nickname', 'CowboyCoder');
    }


}

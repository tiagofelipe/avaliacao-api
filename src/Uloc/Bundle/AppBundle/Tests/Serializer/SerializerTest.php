<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */


namespace Uloc\Bundle\AppBundle\Tests\Serializer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentation;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;
use Uloc\Bundle\AppBundle\Test\FixturesData;

class SerializerTest extends ApiTestCase
{

    public function testSerializer(){

        $data = $this->getEntityManager()->getRepository(Pessoa::class)->findAll();

        $apiRepresentation = new ApiRepresentation();
        $serialized = $apiRepresentation->serialize($data, 'json', 'public');

        $this->assertEquals(true, false, 'Teste');
    }

}

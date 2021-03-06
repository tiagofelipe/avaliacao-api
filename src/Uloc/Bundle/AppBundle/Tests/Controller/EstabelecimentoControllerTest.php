<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Pais;
use Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class EstabelecimentoControllerTest extends ApiTestCase
{

    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp($forcePurge, $basicData);
    }

    public function testGETS(){
        $usuario = $this->createUser('user', 'teste');
        $estab = $this->createEstabelecimento('93.656.198/0001-02', 'Estabelecimento Teste 2', 'Estabelecimento Teste 2');
        $em = $this->getEntityManager();

        $usuario->addEstabelecimento($estab);
        $em->flush();

        $response = $this->client->get('/api/estabelecimento/usuario/'.$usuario->getId(), array(
            'headers' => $this->getAuthorizedHeaders('user')
        ));

        $this->debugResponse($response);
        $this->assertEquals(200, $response->getStatusCode());
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
        $em = $this->getEntityManager();
        $estabelecimento = new Estabelecimento();
        $estabelecimento->setCnpj('11111000110010');
        $estabelecimento->setNomeFantasia('Fantasia de natal');
        $estabelecimento->setRazaoSocial('Exiks');
        $em->persist($estabelecimento);
        $em->flush();


        $endereco = $this->createEndereco('fundo','39400000');
        $endereco->setEstabelecimento($estabelecimento);
        $em->flush();

        $response = $this->client->get('/api/public/estabelecimento/', array(
            'headers' => $this->getAuthorizedHeaders('tiago')


        ));
        $this->debugResponse($response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostEndereco(){
        $em = $this->getEntityManager();

        $pais= new Pais();
        $pais->setSigla('BR');
        $pais->setNome('Brasil');
        $pais->setNomeGlobal('Brasil');
        $em->persist($pais);

        $uf = new UnidadeFederativa();
        $uf->setNome('Minas Gerais');
        $uf->setSigla('MG');
        $uf->setPais($pais);
        $em->persist($uf);

        $municipio=new \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio();
        $municipio->setNome('Montes Claros');
        $municipio-> setIbge('MOC');
        $municipio->setUf($uf);
        $em->persist($municipio);

        $bairro=new Bairro();
        $bairro->setMunicipio($municipio);
        $bairro->setNome('Centro');
        $em->persist($bairro);


        $rua = new Logradouro();
        $rua->setBairro($bairro);
        $rua->setCep('39400000');
        $rua->setLogradouro('avenida');
        $em->persist($rua);

        $em->flush();

        $data = array(
            'logradouro' => $rua->getId(),
            'cep' => $rua->getCep(),
            'complemento' => 'teste',


        );

        $response = $this->client->post('/api/endereco/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }


}
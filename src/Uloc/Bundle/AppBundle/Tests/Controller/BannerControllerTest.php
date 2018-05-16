<?php

namespace Uloc\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Uloc\Bundle\AppBundle\Entity\Banner;
use Uloc\Bundle\AppBundle\Test\ApiTestCase;

class BannerControllerTest extends ApiTestCase
{

    protected function setUp($forcePurge = false, $basicData = true)
    {
        parent::setUp($forcePurge, $basicData);
    }

    private $dirArquivoUpload = '';

    public function testPOST () {

        $data = array(
            'nome' => 'arquivo de teste',
            'dataExibicao' => '2017/12/25 12:12:12',
            'dataExpiracao' => '2017/12/26 12:12:12',
            'situacao' => true,
            'posicao' => 2,
            'hasVideo' => false,
            'url' => 'http://google.com'
        );

        $response = $this->client->post('/api/banner/new', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());

    }

    public function testUpload () {

        $banner = new Banner();
        $banner->setNomeOriginal('arquivo de teste');
        $banner->setDataExibicao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setDataExpiracao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setHasVideo(false);
        $banner->setPosicao(1);
        $banner->setSituacao(true);
        $em = $this->getEntityManager();
        $em->persist($banner);
        $em->flush();

        $response = $this->client->post('/api/banner/'.$banner->getId().'/upload', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:Users/Jonathan/Documents/wtis.jpg', 'r')
                )
            )
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nome', 'arquivo de teste');
        $this->debugResponse($response);
    }

    public function testPUT () {

        $banner = new Banner();
        $banner->setNomeOriginal('arquivo de teste');
        $banner->setDataExibicao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setDataExpiracao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setHasVideo(false);
        $banner->setPosicao(5);
        $banner->setSituacao(true);
        $em = $this->getEntityManager();
        $em->persist($banner);
        $em->flush();

        $data = array(
            'nome' => 'Atualizado',
            'dataExibicao' => '2017/12/25 12:13:12',
            'situacao' => true,
            'posicao' => 3,
            'hasVideo' => false
        );

        $response = $this->client->put('/api/banner/'.$banner->getId().'/update', array(
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nomeOriginal', 'Atualizado');
        $this->asserter()->assertResponsePropertyExists($response, 'posicao');
        //$this->debugResponse($response);
    }

    public function testUpdateFoto(){
        $banner = new Banner();
        $banner->setNomeOriginal('arquivo de teste');
        $banner->setDataExibicao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setDataExpiracao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setHasVideo(false);
        $banner->setPosicao(10);
        $banner->setSituacao(true);
        $em = $this->getEntityManager();
        $em->persist($banner);
        $em->flush();

        $response = $this->client->post('/api/banner/'.$banner->getId().'/upload', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:Users\Jonathan\Documents\wtis.jpg', 'r')
                )
            )
        ));

        $response = $this->client->post('/api/banner/'.$banner->getId().'/updateFoto', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:Users\Jonathan\Documents\wtis.jpg', 'r')
                )
            )
        ));

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyContains($response, 'nomeOriginal', '554271.jpg');

    }

    public function testDELETE () {

        $banner = new Banner();
        $banner->setNomeOriginal('arquivo de teste');
        $banner->setDataExibicao(new \DateTime('2017/12/25 12:12:12'));
        $banner->setDataExpiracao(new \DateTime('2017/12/26 12:12:12'));
        $banner->setHasVideo(false);
        $banner->setPosicao(7);
        $banner->setSituacao(true);
        $banner->setUrl('');
        $em = $this->getEntityManager();
        $em->persist($banner);
        $em->flush();

        $response = $this->client->post('/api/banner/'.$banner->getId().'/upload', array(
            'headers' => $this->getAuthorizedHeaders('tiago'),
            'multipart' => array(
                array(
                    'name' => 'file',
                    'contents' => fopen('C:\Users\Jonathan\Documents\leanna.jpg', 'r')
                )
            )
        ));

        $response = $this->client->delete('/api/banner/'.$banner->getId(), array(
           'headers' => $this->getAuthorizedHeaders('tiago')
        ));

        $this->debugResponse($response);
        $this->assertEquals(204, $response->getStatusCode());
        // $this->printDebug(dump($response));
    }

}

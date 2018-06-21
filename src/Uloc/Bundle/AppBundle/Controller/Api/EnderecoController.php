<?php
/**
 * Created by PhpStorm.
 * User: casa
 * Date: 19/06/2018
 * Time: 09:54
 */

namespace Uloc\Bundle\AppBundle\Controller\Api;

use function React\Promise\resolve;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Pais;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;

class EnderecoController extends BaseController
{

    /**
     * Lists all estabelecimento entities.
     *
     * @Route("/api/public/paises/", name="api_paises_index")
     * @Method("GET")
     */
    public function indexPaises()
    {
        $em = $this->getDoctrine()->getManager();

        $paises = $em->getRepository(Pais::class)->findAll();

        if (!$paises){
            $this->throwApiProblemException('Não se encontrou países cadastrados', JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->createApiResponse($paises, JsonResponse::HTTP_OK);

    }

    /**
     * Lista cidades pelo id do estado
     *
     * @Route("/api/public/municipios/{id}", name="api_municipios_index")
     * @Method("GET")
     * @param $id
     * @return Response
     */

    public  function  indexMunicipios($id){
        $em = $this->getDoctrine()->getManager();
        $uf = $em->getRepository(UnidadeFederativa::class)->find($id);
        $municipios = $em->getRepository(UnidadeFederativa::class)->findByUf($uf);

        if (!$municipios){
            $this->throwApiProblemException('Não se encontrou municípios Cadastrados nesse estado', JsonResponse::HTTP_NOT_FOUND);
        }

        $resposta = [ 'municipios' => $municipios ];

        return $this->createApiResponseEncodeArray($resposta, JsonResponse::HTTP_OK);

    }

    /**
     * Lista cidades pelo id do estado
     *
     * @Route("/api/public/logradouro/{cep}", name="api_logradouro_show")
     * @Method("GET")
     * @param $cep
     * @return Response
     */
    public function showLogradouro($cep){
        $em = $this->getDoctrine()->getManager();
        $logradouro = $em->getRepository(Logradouro::class)->findByCep($cep);


        if (!$logradouro){
            $this->throwApiProblemException('CEP não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($logradouro, JsonResponse::HTTP_OK);


    }

    /**
     * Lista cidades pelo id do estado
     *
     * @Route("/api/public/estabelecimentos/municipio/{id}", name="api_estabelecimento_municipio_show")
     * @Method("GET")
     * @param $id
     * @return Response
     */
    public function indexEstabelecimentosMunicipio($id){
        $em = $this->getDoctrine()->getManager();
        $estabelecimentos = $em->getRepository(Estabelecimento::class)->getEstabelecimentosMunicipio($id);

        if (!$estabelecimentos){
            $this->throwApiProblemException('Não foram encontrados estabelecimentos para a cidade informada', JsonResponse::HTTP_NOT_FOUND);
        }
        $response = ['estabelecimentos'=>$estabelecimentos];

        return $this->createApiResponseEncodeArray($response, JsonResponse::HTTP_OK);

    }

    /**
     * Creates a new estabelecimento entity.
     *
     * @Route("/api/endereco/new", name="api_endereco_new")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $endereco = new Endereco();
        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\EnderecoType', $endereco);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($endereco);
        $em->flush();

        return $this->createApiResponse($endereco, JsonResponse::HTTP_CREATED);

    }

}
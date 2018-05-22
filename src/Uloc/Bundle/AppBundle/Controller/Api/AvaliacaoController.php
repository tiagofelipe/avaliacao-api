<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Avaliacao;
use Uloc\Bundle\AppBundle\Form\AvaliacaoType;

class AvaliacaoController extends BaseController
{

    /**
     * @Route("/api/public/avaliacao/new", name="api_avaliacao_new")
     * @Method("POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction (Request $request) {

        $data = \json_decode($request->getContent(), true);

        if (!isset($data['estabelecimento']) && !isset($data['criterioEstabelecimento']) && !isset($data['funcionario'])){
            $this->throwApiProblemException('Avaliação inválida', JsonResponse::HTTP_BAD_REQUEST);
        }

        $avaliacao = new Avaliacao();

        $form = $this->createForm(AvaliacaoType::class, $avaliacao);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($avaliacao);
        $em->flush();

        return $this->createApiResponse($avaliacao, JsonResponse::HTTP_CREATED);
    }

    /**
     *
     */
    public function listAction () {

    }
}

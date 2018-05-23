<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Form\CriterioEstabelecimentoType;

/**
 * Criterioestabelecimento controller.
 *
 *
 */
class CriterioEstabelecimentoController extends BaseController
{
    /**
     * Lists all criterioEstabelecimento entities. O ID É O ID DO ESTABELECIMENTO
     *
     * @Route("/api/public/criterioestabelecimento/{id}/", name="criterioestabelecimento_index")
     * @Method("GET")
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $estabelecimento = $em->getRepository('UlocAppBundle:Estabelecimento')->find($id);
        $criterios = $em->getRepository('UlocAppBundle:CriterioEstabelecimento')->findByEstabelecimento($estabelecimento);

        if (!$criterios){
            $this->throwApiProblemException('nenhum criterio para esse estabelecimento foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($criterios, JsonResponse::HTTP_OK);
    }

    /**
     * Creates a new criterioEstabelecimento entity.
     *
     * @Route("/api/criterioestabelecimento/new", name="criterioestabelecimento_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $criterio = new CriterioEstabelecimento();
        $form = $this->createForm(CriterioEstabelecimentoType::class, $criterio);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($criterio);
        $em->flush();

        $response = $this->createApiResponse($criterio, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Finds and displays a criterioEstabelecimento entity.
     *
     * @Route("/api/public/criterioestabelecimento/show/{id}", name="criterioestabelecimento_show")
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:CriterioEstabelecimento');
        $criterio = $repository->find($id);
        if(!$criterio){
            $this->throwApiProblemException('Criterio não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $response = $this->createApiResponse($criterio, JsonResponse::HTTP_OK);

        return ($response);
    }

    /**
     * Displays a form to edit an existing criterioEstabelecimento entity.
     *
     * @Route("/api/criterioestabelecimento/{id}/update", name="criterioestabelecimento_update")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CriterioEstabelecimento $criterio
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CriterioEstabelecimento $criterio)
    {
        if(!$criterio){
            $this->throwApiProblemException('Não encontramos o critério informado', JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CriterioEstabelecimentoType::class, $criterio);
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($criterio, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Deletes a criterioEstabelecimento entity.
     *
     * @Route("/api/criterioestabelecimento/{id}", name="criterioestabelecimento_delete")
     * @Method("DELETE")
     * @param CriterioEstabelecimento $criterio
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $id
     */
    public function deleteAction( CriterioEstabelecimento $criterio)
    {
        if(!$criterio){
            $this->throwApiProblemException('Não encontramos o critério informado', JsonResponse::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($criterio);
        $em->flush();
        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

}

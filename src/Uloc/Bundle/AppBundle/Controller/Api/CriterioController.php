<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Criterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Form\CriterioType;

/**
 * Criterio controller.
 *
 *
 */
class CriterioController extends BaseController
{
    /**
     * Lists all criterio entities.
     *
     * @Route("/api/public/criterio/", name="criterio_index")
     * @Method("GET")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $criterios = $em->getRepository('UlocAppBundle:Criterio')->findAll();

        if (!$criterios){
            $this->throwApiProblemException('nenhum critério foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($criterios, JsonResponse::HTTP_OK);
    }

    /**
     * Creates a new criterio entity.
     *
     * @Route("/api/criterio/new", name="criterio_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_INTRANET')")
     */
    public function newAction(Request $request)
    {
        $criterio = new Criterio();
        $form = $this->createForm(CriterioType::class, $criterio);
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
     * Finds and displays a criterio entity.
     *
     * @Route("/api/public/criterio/{id}", name="criterio_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:Criterio');
        $banner = $repository->find($id);
        if(!$banner){
            $this->throwApiProblemException('Banner não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $response = $this->createApiResponse($banner, JsonResponse::HTTP_OK);

        return ($response);
    }

    /**
     * Displays a form to edit an existing criterio entity.
     *
     * @Route("/api/public/criterio/{id}/edit", name="criterio_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_INTRANET')")
     */
    public function editAction(Request $request, $id)
    {
            $criterio = $this->getDoctrine()->getRepository(Criterio::class)->find($id);

            if(!$criterio){
                $this->throwApiProblemException('Não encontramos o critério informado', JsonResponse::HTTP_NOT_FOUND);
            }

            $form = $this->createForm(CriterioType::class, $criterio);
            $this->processForm($request, $form);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $response = $this->createApiResponse($criterio, JsonResponse::HTTP_CREATED);

            return $response;
    }

    /**
     * Deletes a criterio entity.
     *
     * @Route("/api/criterio/{id}", name="criterio_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_INTRANET')")
     */
    public function deleteAction(Request $request, $id)
    {
        $criterio = $this->getDoctrine()->getRepository(Criterio::class)->find($id);

        if(!$criterio){
            $this->throwApiProblemException('Não encontramos o critério informado', JsonResponse::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($criterio);
        $em->flush();
        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

}

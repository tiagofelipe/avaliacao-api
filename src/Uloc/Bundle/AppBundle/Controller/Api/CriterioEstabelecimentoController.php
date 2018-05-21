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

/**
 * Criterioestabelecimento controller.
 *
 * @Route("criterioestabelecimento")
 */
class CriterioEstabelecimentoController extends BaseController
{
    /**
     * Lists all criterioEstabelecimento entities. O ID É O ID DO ESTABELECIMENTO
     *
     * @Route("/api/public/criterio/criterioestabelecimento/{id}", name="criterioestabelecimento_index")
     * @Method("GET")
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $estabelecimento = $em->getRepository('UlocAppBundle:Estabelecimento');
        $criterios = $em->getRepository('UlocAppBundle:CriterioEstabelecimento')->findByEstabelecimento($estabelecimento);

        if (!$criterios){
            $this->throwApiProblemException('nenhum criterio para esse estabelecimento foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($criterios, JsonResponse::HTTP_OK);
    }

    /**
     * Creates a new criterioEstabelecimento entity.
     *
     * @Route("/new", name="criterioestabelecimento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $criterioEstabelecimento = new Criterioestabelecimento();
        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\CriterioEstabelecimentoType', $criterioEstabelecimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($criterioEstabelecimento);
            $em->flush();

            return $this->redirectToRoute('criterioestabelecimento_show', array('id' => $criterioEstabelecimento->getId()));
        }

        return $this->render('criterioestabelecimento/new.html.twig', array(
            'criterioEstabelecimento' => $criterioEstabelecimento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a criterioEstabelecimento entity.
     *
     * @Route("/{id}", name="criterioestabelecimento_show")
     * @Method("GET")
     */
    public function showAction(CriterioEstabelecimento $criterioEstabelecimento)
    {
        $deleteForm = $this->createDeleteForm($criterioEstabelecimento);

        return $this->render('criterioestabelecimento/show.html.twig', array(
            'criterioEstabelecimento' => $criterioEstabelecimento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing criterioEstabelecimento entity.
     *
     * @Route("/{id}/edit", name="criterioestabelecimento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CriterioEstabelecimento $criterioEstabelecimento)
    {
        $deleteForm = $this->createDeleteForm($criterioEstabelecimento);
        $editForm = $this->createForm('Uloc\Bundle\AppBundle\Form\CriterioEstabelecimentoType', $criterioEstabelecimento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('criterioestabelecimento_edit', array('id' => $criterioEstabelecimento->getId()));
        }

        return $this->render('criterioestabelecimento/edit.html.twig', array(
            'criterioEstabelecimento' => $criterioEstabelecimento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a criterioEstabelecimento entity.
     *
     * @Route("/{id}", name="criterioestabelecimento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CriterioEstabelecimento $criterioEstabelecimento)
    {
        $form = $this->createDeleteForm($criterioEstabelecimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($criterioEstabelecimento);
            $em->flush();
        }

        return $this->redirectToRoute('criterioestabelecimento_index');
    }

    /**
     * Creates a form to delete a criterioEstabelecimento entity.
     *
     * @param CriterioEstabelecimento $criterioEstabelecimento The criterioEstabelecimento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CriterioEstabelecimento $criterioEstabelecimento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('criterioestabelecimento_delete', array('id' => $criterioEstabelecimento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Estabelecimento controller.
 *
 * @Route("estabelecimento")
 */
class EstabelecimentoController extends BaseController
{
    /**
     * Lists all estabelecimento entities.
     *
     * @Route("/", name="estabelecimento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $estabelecimentos = $em->getRepository('UlocAppBundle:Estabelecimento')->findAll();

        if (!$estabelecimentos){
            throw $this->throwApiProblemException('Não há ', JsonResponse::HTTP_NOT_FOUND);
        }

    }

    /**
     * Creates a new estabelecimento entity.
     *
     * @Route("/new", name="estabelecimento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $estabelecimento = new Estabelecimento();
        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\EstabelecimentoType', $estabelecimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estabelecimento);
            $em->flush();

            return $this->redirectToRoute('estabelecimento_show', array('id' => $estabelecimento->getId()));
        }

        return $this->render('estabelecimento/new.html.twig', array(
            'estabelecimento' => $estabelecimento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a estabelecimento entity.
     *
     * @Route("/{id}", name="estabelecimento_show")
     * @Method("GET")
     */
    public function showAction(Estabelecimento $estabelecimento)
    {
        $deleteForm = $this->createDeleteForm($estabelecimento);

        return $this->render('estabelecimento/show.html.twig', array(
            'estabelecimento' => $estabelecimento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing estabelecimento entity.
     *
     * @Route("/{id}/edit", name="estabelecimento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Estabelecimento $estabelecimento)
    {
        $deleteForm = $this->createDeleteForm($estabelecimento);
        $editForm = $this->createForm('Uloc\Bundle\AppBundle\Form\EstabelecimentoType', $estabelecimento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estabelecimento_edit', array('id' => $estabelecimento->getId()));
        }

        return $this->render('estabelecimento/edit.html.twig', array(
            'estabelecimento' => $estabelecimento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a estabelecimento entity.
     *
     * @Route("/{id}", name="estabelecimento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Estabelecimento $estabelecimento)
    {
        $form = $this->createDeleteForm($estabelecimento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estabelecimento);
            $em->flush();
        }

        return $this->redirectToRoute('estabelecimento_index');
    }

    /**
     * Creates a form to delete a estabelecimento entity.
     *
     * @param Estabelecimento $estabelecimento The estabelecimento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Estabelecimento $estabelecimento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estabelecimento_delete', array('id' => $estabelecimento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Uloc\Bundle\AppBundle\Entity\Criterio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Criterio controller.
 *
 * @Route("criterio")
 */
class CriterioController extends Controller
{
    /**
     * Lists all criterio entities.
     *
     * @Route("/", name="criterio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $criterios = $em->getRepository('UlocAppBundle:Criterio')->findAll();

        return $this->render('criterio/index.html.twig', array(
            'criterios' => $criterios,
        ));
    }

    /**
     * Creates a new criterio entity.
     *
     * @Route("/new", name="criterio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $criterio = new Criterio();
        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\CriterioType', $criterio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($criterio);
            $em->flush();

            return $this->redirectToRoute('criterio_show', array('id' => $criterio->getId()));
        }

        return $this->render('criterio/new.html.twig', array(
            'criterio' => $criterio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a criterio entity.
     *
     * @Route("/{id}", name="criterio_show")
     * @Method("GET")
     */
    public function showAction(Criterio $criterio)
    {
        $deleteForm = $this->createDeleteForm($criterio);

        return $this->render('criterio/show.html.twig', array(
            'criterio' => $criterio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing criterio entity.
     *
     * @Route("/{id}/edit", name="criterio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Criterio $criterio)
    {
        $deleteForm = $this->createDeleteForm($criterio);
        $editForm = $this->createForm('Uloc\Bundle\AppBundle\Form\CriterioType', $criterio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('criterio_edit', array('id' => $criterio->getId()));
        }

        return $this->render('criterio/edit.html.twig', array(
            'criterio' => $criterio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a criterio entity.
     *
     * @Route("/{id}", name="criterio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Criterio $criterio)
    {
        $form = $this->createDeleteForm($criterio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($criterio);
            $em->flush();
        }

        return $this->redirectToRoute('criterio_index');
    }

    /**
     * Creates a form to delete a criterio entity.
     *
     * @param Criterio $criterio The criterio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Criterio $criterio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('criterio_delete', array('id' => $criterio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

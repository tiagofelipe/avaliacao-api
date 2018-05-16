<?php

namespace Uloc\Bundle\AppBundle\Controller\Web;

use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Contato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contato controller.
 *
 * @Route("contato")
 */
class ContatoController extends BaseController
{
    /**
     * Creates a new contato entity.
     *
     * @Route("/", name="contato")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contato = new Contato();

        //Verificar se está logado
        $user = $this->getUser();
        if ($user) {
            $contato->setNome($user->getPessoa()->getNome());
            $contato->setEmail($user->getEmail());
            $contato->setTelefone($user->getPessoa()->getTelefones()->first()->getTelefone());
        }

        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\ContatoWebsiteType', $contato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contato);
            $em->flush();

            //Envia e-mail para remetente do contato
            $protocolo = '#' . str_pad($contato->getId(), 5, 0, STR_PAD_LEFT);
            $subject = $protocolo . ' Novo contato registrado';
            $from = $this->getParameter('contato_principal');
            $this->sendMail(
                $subject,
                $contato->getEmail(),
                $contato->getNome(),
                $from['email'],
                $from['nome'],
                'Emails/contato.sucess.html.twig',
                array(
                    "contato" => $contato,
                    "protocolo" => $protocolo
                )
            );

            return $this->redirectToRoute('contato_suscesso', array('protocolo' => $contato->getId()));
        }

        return $this->render('contato.html.twig', array(
            'contato' => $contato,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new contato entity.
     *
     * @Route("/contato/sucesso", name="contato_suscesso")
     * @Method({"GET"})
     */
    public function sucessoAction(Request $request)
    {
        return $this->render('contato.sucesso.html.twig', array('protocolo' => $request->get('protocolo')));
    }
}

<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Contato;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Form\ContatoType;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadata;


/**
 * Contato controller.
 *
 * @Security("is_granted('ROLE_INTRANET')")
 * @Route("api/contato")
 */
class ContatoController extends BaseController
{

    /**
     * Lists all contato entities.
     *
     * @Route("/", name="api_contato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $messages = $this->getDoctrine()->getRepository(Contato::class)->findAll();

        if (!$messages){
            throw $this->throwApiProblemException('Não há mensagens', JsonResponse::HTTP_NOT_FOUND);
        }

        /*$messages = $this->montaObjeto($messages, [
            'id',
            'nome',
            'email',
            'telefone',
            'assunto',
            'mensagem',
            'data',
            'isRespondido',
            'lido'

        ]);

        $data = ['mensagens' => $messages];*/

        //return $this->createApiResponse($data);
        return $this->createApiResponse($messages);
    }

    /**
     * Lists all contato entities with pagination.
     *
     * @Route("/list", name="api_contate_index")
     * @Method("GET")
     */
    public function indexPaginationAction(Request $request)
        {

                 $qb = $this->getDoctrine()
                ->getRepository(Contato::class)
                ->findAllQueryBuilder();

            $paginatedCollection = $this->get('pagination_factory')
                ->createCollection($qb, $request, 'api_contate_index');


            $response = $this->createApiResponse($paginatedCollection, 200);
            return $response;
      //  return $this->createApiResponse($entity);
    }



    /**
     * @Route("/sendmail", name="api_sendMail_send")
     * @Method("POST")
     *
     * @param Request $request
     * @return Response
     */
    public function sendEmailAction (Request $request) {

  /*      $email = $request->get('destinatario');
        $assunto = $request->get('assunto');
        $mensagem = $request->get('mensagem');
*/
        $data = \json_decode($request->getContent(), true);
        $mensagem = $data['mensagem'];
        $assunto = $data['assunto'];
        $destinatario = $data['destinatario'];
        $remetente = $this->getParameter('contato_principal');

        //Envia e-mail
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($assunto))
            ->setFrom($remetente['email'], $remetente['nome'])
            ->setTo($destinatario)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/email.answer.html.twig
                    'Emails/contato.email.html.twig',
                    array(
                        'mensagem' => $mensagem
                    )
                ),
                'text/html'
            );
        $mailer->send($message);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->createApiResponse('enviado');
    }

    /**
     * @Route("/{id}/response", name="api_responseMail_response")
     * @Method("POST")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function responderEmailAction (Request $request, $id) {

        $entity = $this->getDoctrine()->getRepository(Contato::class)->find($id);

        if(!$entity){
            throw $this->throwApiProblemException('Mensagem não encontrada', JsonResponse::HTTP_NOT_FOUND);
        }

        $data = \json_decode($request->getContent(), true);
        $email = isset($data['email']) && !empty($data['email']) ? $data['email'] : $entity->getEmail();
        $resposta = $data['mensagem'];

        $remetente = $this->getParameter('contato_principal');

        //Envia e-mail
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message('Rogério Menezes Leiloeiro - Resposta ao seu contato'))
            ->setFrom($remetente['email'], $remetente['nome'])
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/email.answer.html.twig
                    'Emails/contato.resposta.html.twig',
                    array(
                        'contato' => $entity,
                        'mensagem' => $resposta
                    )
                ),
                'text/html'
            );
        $mailer->send($message);

        $entity->setIsRespondido(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->createApiResponse('enviado');

    }

    /**
     * Creates a new contato entity.
     *
     * @Route("/new", name="api_contato_new")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $entity = new Contato();
        $form = $this->createForm(ContatoType::class, $entity);
        $this->processForm($request, $form);

        if (!$form->isValid()){
            throw $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $response = $this->createApiResponse($entity, JsonResponse::HTTP_CREATED, function (ApiRepresentationMetadata $metadata) {
            $metadata->setGroup('public')
                ->addProperties(
                    [
                        'id',
                        'nome',
                        'email',
                        'telefone',
                        'assunto',
                        'mensagem'
                    ]
                )->build();
        }, 'public');

        return $response;
    }

    /**
     * Finds and displays a contato entity.
     *
     * @Route("/{id}", name="api_contato_show")
     * @Method("GET")
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $entity = $this->getDoctrine()->getRepository(Contato::class)->find($id);

        if(!$entity){
            throw $this->throwApiProblemException('Mensagem não encontrada', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($entity, JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/naoRespondidos", name="api_contato_naorespondidos")
     * @Method("GET")
     *
     * @return Response
     */
    public function listNaoRespondidosAction(){
        $mensagens = $this->getDoctrine()->getRepository(Contato::class)->findNaoRespondidos();

        if(!$mensagens){
            throw $this->throwApiProblemException('Não há contatos pendentes', JsonResponse::HTTP_NOT_FOUND);
        }

        $data = ['mensagens' => $mensagens];

        return $this->createApiResponse($data);

    }

    /**
     * Displays a form to edit an existing contato entity.
     *
     * @Route("/{id}/edit", name="api_contato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction()
    {
        // ?????
    }

    /**
     *
     * @Route("/{id}/lido", name="api_contato_lido")
     * @Method({"PUT", "PATCH"})
     * @param $id
     * @return Response
     */
    public function lidoAction($id)
    {
        $entity = $this->getDoctrine()->getRepository(Contato::class)->find($id);

        if(!$entity){
            throw $this->throwApiProblemException('Mensagem não encontrada', JsonResponse::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $entity->setLido(true);
        // $em->persist($entity);
        $em->flush();
        return $this->createApiResponse($entity, JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * Deletes a contato entity.
     *
     * @Route("/{id}", name="api_contato_delete")
     * @Method("DELETE")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $msg = $this->getDoctrine()->getRepository(Contato::class)->find($id);

        if (!$msg) {
            throw $this->throwApiProblemException('Mensagem não encontrada', JsonResponse::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($msg);
        $em->flush();

        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
    /**
     * Seta isexcluido true in a  contato entity.
     *
     * @Route("/{id}", name="api_contato_lixeira")
     * @Method("PATCH")
     * @param $id
     * @return Response
     */
    public function sendToLixeiraAction($id){
        $em = $this-> getDoctrine()->getManager();
        $entity = $em->getRepository(Contato::class)->find($id);
        if (!$entity) {
            throw $this->throwApiProblemException('Mensagem não encontrada', JsonResponse::HTTP_NOT_FOUND);
        }
        $entity->setIsExcluido(true);
        $em->flush();
        return $this->createApiResponse('apagado', JsonResponse::HTTP_NO_CONTENT);
    }

}
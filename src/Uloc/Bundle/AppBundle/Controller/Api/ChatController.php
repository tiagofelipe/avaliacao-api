<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Uloc\Bundle\AppBundle\Entity\Chat\ChatGrupo;
use Uloc\Bundle\AppBundle\Entity\Chat\ChatMensagem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Helpers\Helpers;

class ChatController extends BaseController
{

    /**
     * @Route("/api/chat/messages")
     * @Method("GET")
     */
    public function messagesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $onlyNotReads = $request->get('onlyNotReads');
        if($onlyNotReads){
            if($onlyNotReads === 'true' || $onlyNotReads === 1){
                $onlyNotReads = true;
            } else{
                $onlyNotReads = false;
            }
        }

        if ($request->get('grupo')) {
            // Mensagens de grupo
            // TODO
        } else {
            // Mensagem privada
            //$mensagens = $em->getRepository(ChatMensagem::class)->findBy(array('usuario' => $user->getId(), 'destinatario' => $request->get('user')), array('data' => 'ASC'));
            $mensagens = $em->getRepository(ChatMensagem::class)->findTransactionalMessages($user->getId(), $request->get('user'), $onlyNotReads);
        }

        if (!$mensagens) {
            $mensagens = [];
        }

        return $this->createApiResponse($mensagens);
    }

    /**
     * @Route("/api/chat/naoLidas")
     * @Method("GET")
     */
    public function messagesNaoLidasAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        //$mensagens = $em->getRepository(ChatMensagem::class)->findBy(array('usuario' => $user->getId(), 'destinatario' => $request->get('user')), array('data' => 'ASC'));
        $mensagens = $em->getRepository(ChatMensagem::class)->findNotReadedMessages($user->getId());


        if (!$mensagens) {
            return $this->createApiResponseEncodeArray(["total" => 0, 'mensagens' => null]);
        }

        return $this->createApiResponseEncodeArray(["total" => count($mensagens), 'mensagens' => $mensagens]);
    }

    /**
     * @Route("/api/chat/sendMessage")
     * @Method("POST")
     */
    public function enviaMensagemAction(Request $request)
    {

        $data = \json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $mensagem = new ChatMensagem();
        $mensagem->setUsuario($this->getUser());
        /*$response = array(
            'remetente' => $mensagem->getUsuario()->getNome()
        );*/

        if ($request->get('grupo')) {
            // A mensagem é para um grupo
            $grupo = $em->getRepository(ChatGrupo::class)->findByNome($request->get('grupo'));
            if (!$grupo) {
                throw $this->throwApiProblemException('Grupo não encontrado', JsonResponse::HTTP_NOT_FOUND);
            }
            $mensagem->setGrupo($grupo);
            //$response['grupo'] = $mensagem->getGrupo()->getNome();
        } else {
            // A mensagm é privada
            $destinatario = $em->getRepository(Usuario::class)->find(intval($request->get('destinatario')));
            if (!$destinatario) {
                throw $this->throwApiProblemException('Destinatário não encontrado', JsonResponse::HTTP_NOT_FOUND);
            }
            $mensagem->setDestinatario($destinatario);
            //$response['destinatario'] = $mensagem->getDestinatario()->getNome();
        }

        $mensagem->setMensagem($data['mensagem']);

        $em->persist($mensagem);
        $em->flush();

        //$response['mensagem'] = $mensagem->getMensagem();

        return $this->createApiResponse($mensagem, JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/api/chat/online", name="api_chat_usersonline")
     */
    public function getUsersOnlineAction(Request $request)
    {
        //Verifica os usuários com sinais nos últimos 5 minutos
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository(Usuario::class)->findUsersChat($this->getUser()->getId());

        foreach ($usuarios as $key => $usuario) {
            $nome = isset($usuario['nome']) ? Helpers::adjustName($usuario['nome']) : $usuario['username'];
            if ($usuario['image']) {
                $image = str_replace(['/app_dev.php', '/app.php'], '', $request->getUriForPath('/public/perfil/' . $usuario['image']));
            } else {
                $image = str_replace(['/app_dev.php', '/app.php'], '', $request->getUriForPath('/public/perfil/noimg.php?nome=' . $usuario['nome']));
            }
            $usuarios[$key]['image'] = $image;
            $usuarios[$key]['nome'] = $nome;
        }

        return $this->createApiResponseEncodeArray($usuarios);
    }

}

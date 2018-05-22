<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Uloc\Bundle\AppBundle\Api\ApiProblem;
use Uloc\Bundle\AppBundle\Api\ApiProblemException;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Form\UsuarioType;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadata;

/**
 * User controller.
 *
 */
class UserController extends BaseController
{

    /**
     * Lists all entities.
     *
     * @Route("/api/usuarios/", name="api_users_index")
     * @Route("/api/usuarios")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        list($page, $limit, $offset) = $this->getPagination($request, 2, self::MAX_RESULT_LIMIT);

        $filtros = [];

        $busca = $request->query->get('busca');
        if (strlen(trim($busca)) > 0) {
            $filtros['busca'] = $busca;
        }

        $tipo = $request->query->get('tipo');
        if (strlen(trim($tipo)) > 0) {
            $filtros['tipo'] = $tipo;
        }

        $data = $em->getRepository('UlocAppBundle:Usuario')->findAllSimple($limit, $offset, $filtros);
        $total = $data['total'];

        $response = array(
            'result' => $this->serialize($data['result'], 'array', 'public', function (ApiRepresentationMetadata $metadata) {
                Usuario::loadApiRepresentation($metadata);
            }),
            "limit" => $limit,
            "total" => (int)$total,
            "totalPages" => ceil($total / $limit),
            "offset" => $page
        );

        return $this->createApiResponseEncodeArray($response);
    }

    /**
     * @Route("/api/usuarios/{id}", name="api_usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->createApiResponse($usuario, 200, null, 'api_edit');
    }

    /**
     * @Route("/api/usuarios/{id}", name="api_usurio_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->showAction($usuario, $request);
    }

    /**
     * @Route("/api/public/usuario/new", name="api_usuario_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        $data = json_decode($request->getContent(), true);
        $plainPassword = @$data['password'];
        $password = $this->get('security.password_encoder')->encodePassword($usuario, $plainPassword);
        $usuario->setPassword($password);

        $roles = ['ROLE_USER', 'ROLE_INTRANET'];
        /* if($request->get('role') === 'comitente'){
            $roles[] = 'ROLE_COMITENTE';
        } */
        $usuario->setRoles($roles);

        $em = $this->getDoctrine()->getManager();

        /* $pessoaID = intval(@$data['pessoa']['id']);
        if ($pessoaID > 0) {
            $pessoa = $em->getRepository(Pessoa::class)->find($pessoaID);
            if(!$pessoa){
                return $this->throwApiProblemException('Pessoa não encontrada');
            }
            $usuario->setPessoa($pessoa);
            $pessoa->addUsuario($usuario);
        } */

        $em->persist($usuario);
        $em->flush();

        // return $this->showAction($usuario, $request);
        return $this->createApiResponse($usuario, JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/api/usuarios/{id}", name="api_usurio_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($usuario);
        /*if ($usuario->getPessoa()) {
            $em->remove($usuario->getPessoa());
        }*/
        $em->flush();

        return $this->createApiResponseEncodeArray([], 200);
    }

    /**
     * @Route("/api/usuarios/{id}/password", name="api_usurio_password_update")
     * @Method({"PATCH", "PUT"})
     */
    public function updatePasswordAction(Request $request, Usuario $usuario)
    {

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);

            throw new ApiProblemException($apiProblem);
        }

        $plainPassword = @$data['password'];
        $password = $this->get('security.password_encoder')
            ->encodePassword($usuario, $plainPassword);
        $usuario->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->createApiResponseEncodeArray(['status' => 'updated'], 200);
    }
}

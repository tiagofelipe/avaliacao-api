<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Uloc\Bundle\AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Api\Exception\BadCredentialsException;

class TokenController extends BaseController
{
    /**
     * @Route("/api/auth")
     * @Method("POST")
     */
    public function newTokenAction(Request $request)
    {
        $userGET = $request->request->get('user');
        if (strlen($userGET) < 2) {
            throw new BadCredentialsException('Usuário inválido');
        }
        $passGET = $request->request->get('pass');
        if (strlen($passGET) < 3) {
            throw new BadCredentialsException('Senha inválida');
        }

        /** @var Usuario $user */
        $user = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->loadUserByUsername($userGET, false);

        if (!$user) {
            throw $this->createNotFoundException("Credenciais não encontrada");
        }

        $roles = $user->getRoles();
        if (!is_array($roles)) {
            return new JsonResponse(['error' => 'Usuário sem permissão'], JsonResponse::HTTP_NOT_FOUND);
        }

        /* $channel = $request->get('channel');

        if (!in_array('ROLE_INTRANET', $roles) && !in_array('ROLE_ROOT', $roles) && $channel !== 'client') {
            throw new BadCredentialsException('Usuário sem permissão de acesso à intranet');
        } */

        // verifica as permissões do usuario
        $roles = $user->getRoles();
        if((is_array($roles) && count($roles) < 1) || !is_array($roles)) {
            throw new BadCredentialsException('Usuário sem permissão de acesso');
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $passGET);

        if (!$isValid) {
            throw new BadCredentialsException('Credenciais inválidas');
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + (3600 * 24) // 1 day expiration
            ]);

        $userContent = [
            "id" => $user->getId(),
            "email" => $user->getEmail(),
            // "nome" => $user->getPessoa() ? $user->getPessoa()->getNome() : $user->getUsername(),
            "nome" => $user->getNome(),
            "foto" => 'https://www.gravatar.com/avatar/' . trim(strtolower(md5($user->getEmail()))),

        ];

        if ($user->getPessoa()) {
            $userContent['pessoa'] = $user->getPessoa()->getId();
        }


        return new JsonResponse([
            'token' => $token,
            'user' => $userContent
        ]);
    }

    /**
     * @Route("/api/userCredentials")
     * @Method("GET")
     */
    public function userCredentialsAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user->getPessoa()) {
           $this->throwApiProblemException('Pessoa não encontrada.');
        }

        return $this->createApiResponseEncodeArray(
            [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "token" => $user->getPassword(),
                "pessoa" => [
                    "id" => $user->getPessoa()->getId(),
                    "nome" => $user->getPessoa()->getNome(),
                    "representantes" => $user->getPessoa()->getRepresentantes()
                ]
            ]
        );
    }
}
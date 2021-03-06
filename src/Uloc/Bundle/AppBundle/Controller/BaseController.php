<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Stopwatch\Stopwatch;
use Uloc\Bundle\AppBundle\Api\ApiProblem;
use Uloc\Bundle\AppBundle\Api\ApiProblemException;
use Uloc\Bundle\AppBundle\Helpers\Utils;
use Uloc\Bundle\AppBundle\Repository\UsuarioRepository;

//use Uloc\Bundle\AppBundle\Repository\ApiTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentation;

abstract class BaseController extends Controller
{

    use Utils;

    const MAX_RESULT_LIMIT = 100;

    const NAO_ENCONTRADO = "Objeto não encontrado";
    const METODO_NAO_DISPONIVEL = "Médodo não disponível para esta rota";

    const TIPO_IDENTIFICADOR_RG = 1;

    /**
     * O usuário atual está logado?
     *
     * @return boolean
     */
    public function isUserLoggedIn()
    {
        return $this->container->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * Responde não autorizado se o usuário não estiver logado
     *
     * @return JsonResponse
     */
    public function apiRequireLogin()
    {
        if (!$this->container->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->throwApiProblemException('Não autorizado. Você precisa estar autenticado para continuar esta ação.');
        }
    }

    /**
     * Loga um usuário no sistema
     *
     * @param Usuario $user
     */
    public function loginUser(Usuario $user)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

        $this->container->get('security.token_storage')->setToken($token);
    }

    /**
     * @return UsuarioRepository
     */
    protected function getUserRepository()
    {
        return $this->getDoctrine()
            ->getRepository('UlocAppBundle:Usuario');
    }

    /**
     * @return ApiTokenRepository
     */
    protected function getApiTokenRepository()
    {
        return $this->getDoctrine()
            ->getRepository('UlocAppBundle:ApiToken');
    }

    /**
     * Retorna o Json Web Token
     * @param Request $request
     * @return string|void
     */
    protected function getToken(Request $request)
    {
        /*
        * TODO: Verificar tipo de autenticação para retornar o token correto JWT|Token
        */
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }

        return $token;
    }

    /*
     * Cria uma resposta HTTP para a API
     * @return Response
    */
    protected function createApiResponse($data, $statusCode = 200, $metadata = null, $group = 'public', $forcePhpEncode = null)
    {

        if (null !== $forcePhpEncode) {
            //TODO: implement others encoders (XML etc...)
            $data = \json_encode($data);
            $headers = array(
                'Content-Type' => 'application/uloc.console+json'
            );
            return new Response($data, $statusCode, $headers);
        }

        $json = $this->serialize($data, 'json', $group, $metadata);

        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/uloc.console+json'
        ));
    }

    protected function createApiResponseEncodeArray($data, $code = 200)
    {
        return $this->createApiResponse($data, $code, null, null, true);
    }

    /*
    * Serializa um objeto ou array
    * @return string a JSON encoded string on success or FALSE on failure.
    */
    protected function serialize($data, $format = 'json', $group = 'public', $metadata = null)
    {
        /* TODO: Analisar o JMSerialize para uso */
        /* $context = new SerializationContext();
        $context->setSerializeNull(true);

        $request = $this->get('request_stack')->getCurrentRequest();
        $groups = array('Default');
        if ($request->query->get('deep')) {
            $groups[] = 'deep';
        }
        $context->setGroups($groups);

        return $this->container->get('jms_serializer')
            ->serialize($data, $format, $context); */

        $apiRepresentation = new ApiRepresentation();
        if (null !== $metadata) {
            $apiRepresentation->setMetadata($metadata);
        }
        $serialize = $apiRepresentation->serialize($data, $format, $group);

        return $serialize;

        //return \json_encode($data);
    }

    /**
     * Processa um formulário baseado na carga útil recebida
     * Process a form based on payload received
     * @param Request $request
     * @param FormInterface $form
     */
    protected function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);

            throw new ApiProblemException($apiProblem);
        }

        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

    /*
     * API Exception
     * @return ApiProblemException
    */
    protected function throwApiProblemException($message, $statusCode = 400)
    {

        $apiProblem = new ApiProblem(
            $statusCode,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $message);

        throw new ApiProblemException($apiProblem);
    }

    /*
     * Exception for an invalid handle submit
     * Exceção para um manipulador de formulário inválido
     * @return ApiProblemException
    */
    protected function throwApiProblemValidationException(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);

        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }

    protected function sendMail($subject, $to, $toName, $from = null, $fromName = null, $template, array $params, $format = 'text/html')
    {

        //Envia e-mail
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($subject))
            ->setFrom($from, $fromName)
            ->setTo($to, $toName)
            ->setBody(
                $this->renderView(
                    $template,
                    $params
                ),
                $format
            );
        return $mailer->send($message);
    }

    public function getPagination(Request $request, $default, $max)
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', $default);
        $limit = $limit > $max ? $max : $limit;
        $offset = ($page * $limit) - $limit;
        return [$page, $limit, $offset];
    }

    public static $IMAGE_TYPES = array('jpg', 'png', 'jpeg', 'gif');

}

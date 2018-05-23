<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Funcionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Form\FuncionarioType;

/**
 * Funcionario controller.
 *
 *
 */
class FuncionarioController extends BaseController
{
    /**
     * Lists all funcionario entities.
     *
     * @Route("/api/public/funcionario/", name="funcionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $funcionarios = $em->getRepository('UlocAppBundle:Funcionario')->findAll();

        if (!$funcionarios){
            throw $this->throwApiProblemException('Não há Funcionários cadastrados ainda', JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->createApiResponse($funcionarios, JsonResponse::HTTP_OK);

    }

    /**
     *
     *
     * @Route("/api/funcionario/{id}/upload", name="api_foto_upload")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @param Funcionario $funcionario
     * @return Response
     * @internal param $id
     */
    public function uploadAction(Request $request, Funcionario $funcionario)
    {
        $file = $request->files->get('file');
        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/funcionarios');


        $funcionario->setFoto($result);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->createApiResponse($funcionario, JsonResponse::HTTP_CREATED);

    }

    /**
     *
     *
     * @Route("/api/funcionario/{id}/updateFoto", name="api_funcionario_updateFoto")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @param Funcionario $funcionario
     * @return Response
     * @internal param $id
     */
    public function updateFotoAction (Request $request,Funcionario $funcionario){

        if(!$funcionario){
            $this->throwApiProblemException('Não foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/funcionarios';

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file){
            throw $this->throwApiProblemException(array('Problemas com a imagem' => $file), JsonResponse::HTTP_BAD_REQUEST);
        }


        $excluido = unlink($dir.'/'.$funcionario->getFoto());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir foto, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }


        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/funcionarios');

        $funcionario->setFoto($result);
        $funcionario->setFoto($file->getClientOriginalName());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($funcionario, JsonResponse::HTTP_CREATED);

        return $response;
    }


    /**
     * Creates a new funcionario entity.
     *
     * @Route("api/funcionario/new", name="funcionario_new")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $funcionario = new Funcionario();
        $form = $this->createForm('Uloc\Bundle\AppBundle\Form\FuncionarioType', $funcionario);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($funcionario);
        $em->flush();

        return $this->createApiResponse($funcionario, JsonResponse::HTTP_CREATED);

    }

    /**
     * Finds and displays a funcionario entity.
     *
     * @Route("api/public/funcionario/{id}", name="funcionario_show")
     * @Method("GET")
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:Funcionario');
        $funcionario = $repository->find($id);

        if(!$funcionario){
            $this->throwApiProblemException('establecimento não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $response = $this->createApiResponse($funcionario, JsonResponse::HTTP_OK);

        return ($response);
    }


    /**
     * Displays a form to edit an existing funcionario entity.
     *
     * @Route("/api/funcionario/{id}/update", name="api_funcionario_update")
     * @Method({"PATCH", "PUT"})
     * @param Request $request
     * @param Funcionario $funcionario
     * @return Response
     * @internal param $id
     */
    public function updateAction(Request $request,Funcionario $funcionario)
    {

        if(!$funcionario){
            $this->throwApiProblemException('Funcionario não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(FuncionarioType::class, $funcionario);
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($funcionario, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Deletes a funcionario entity.
     *
     * @Route("/api/funcionario/{id}", name="api_funcionario_delete")
     * @Method("DELETE")
     * @param Funcionario $funcionario
     * @return Response
     * @internal param $id
     */
    public function deleteAction(Funcionario $funcionario)
    {
        if(!$funcionario){
            $this->throwApiProblemException('Funcionario não cadastrado', JsonResponse::HTTP_NOT_FOUND);
        }

        if(!$funcionario->getFoto()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($funcionario);
            $em->flush();

            return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/funcionarios';

        $excluido = unlink($dir.'/'.$funcionario->getFoto());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir o funcionario, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($funcionario);
        $em->flush();

        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

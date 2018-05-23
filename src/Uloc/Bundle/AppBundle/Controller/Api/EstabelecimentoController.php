<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Form\EstabelecimentoType;

/**
 * Estabelecimento controller.
 *
 *
 */
class EstabelecimentoController extends BaseController
{
    /**
     * Lists all estabelecimento entities.
     *
     * @Route("api/public/estabelecimento/", name="estabelecimento_index")
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
     *
     *
     * @Route("/api/estabelecimento/{id}/upload", name="api_logo_upload")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @param Estabelecimento $estabelecimento
     * @return Response
     * @internal param $id
     */
    public function uploadAction(Request $request, Estabelecimento $estabelecimento)
    {
        $file = $request->files->get('file');
        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/logo');


        $estabelecimento->setLogo($result);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($estabelecimento, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     *
     *
     * @Route("/api/estabelecimento/{id}/updateLogo", name="api_estabelecimento_updateFoto")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @param Estabelecimento $estabelecimento
     * @return Response
     * @internal param $id
     */
    public function updateFotoAction (Request $request,Estabelecimento $estabelecimento){

        if(!$estabelecimento){
            $this->throwApiProblemException('Não foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/logos';

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file){
            throw $this->throwApiProblemException(array('Problemas com o logo' => $file), JsonResponse::HTTP_BAD_REQUEST);
        }


        $excluido = unlink($dir.'/'.$estabelecimento->getlogo());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir logo, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }


        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/logos');

        $estabelecimento->setLogo($result);
        $estabelecimento->setLogo($file->getClientOriginalName());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($estabelecimento, JsonResponse::HTTP_CREATED);

        return $response;
    }



    /**
     * Creates a new estabelecimento entity.
     *
     * @Route("api/estabelecimento/new", name="estabelecimento_new")
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
     * @Route("api/public/estabelecimento/{id}", name="estabelecimento_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:Estabelecimento');
        $estabelecimento = $repository->find($id);

        if(!$estabelecimento){
            $this->throwApiProblemException('establecimento não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $response = $this->createApiResponse($estabelecimento, JsonResponse::HTTP_OK);

        return ($response);
    }


    /**
     * Displays a form to edit an existing estabelecimento entity.
     *
     * @Route("/api/estabelecimento/{id}/update", name="api_estabelecimento_update")
     * @Method({"PATCH", "PUT"})
     * @param Request $request
     * @param Estabelecimento $estabelecimento
     * @return Response
     * @internal param $id
     */
    public function updateAction(Request $request,Estabelecimento $estabelecimento)
    {

        if(!$estabelecimento){
            $this->throwApiProblemException('Estabelecimento não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(EstabelecimentoType::class, $estabelecimento);
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($estabelecimento, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Deletes a estabelecimento entity.
     *
     * @Route("/api/estabelecimento/{id}", name="api_estabelecimento_delete")
     * @Method("DELETE")
     * @param Estabelecimento $estabelecimento
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $id
     */
    public function deleteAction(Estabelecimento $estabelecimento)
    {
        if(!$estabelecimento){
            $this->throwApiProblemException('Banner não cadastrado', JsonResponse::HTTP_NOT_FOUND);
        }

        if(!$estabelecimento->getlogo()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estabelecimento);
            $em->flush();

            return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/logos';

        $excluido = unlink($dir.'/'.$estabelecimento->getlogo());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir o estabelecimento, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($estabelecimento);
        $em->flush();

        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

<?php

namespace Uloc\Bundle\AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Banner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Form\BannerType;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadata;

/**
 * Banner controller.
 *
 * @Security("is_granted('ROLE_INTRANET')")
 */
class BannerController extends BaseController
{
    /**
     * Lists all banner entities.
     *
     * @Route("/api/banner/", name="api_banner_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $banners = $em->getRepository('UlocAppBundle:Banner')->findAll();

        if (!$banners){
            $this->throwApiProblemException('nenhum encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->createApiResponse($banners, JsonResponse::HTTP_OK);
    }

    /**
     * Creates a new banner entity.
     *
     * @Route("/api/banner/new", name="api_banner_new")
     * @Method("POST")
     *
     * @param Request $request
     * @return Response
     */
    public function newAction (Request $request){

        $banner = new Banner();
        $form = $this->createForm(BannerType::class, $banner);
        $this->processForm($request, $form);

        if(!$form->isValid()){
            throw $this->throwApiProblemValidationException($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($banner);
        $em->flush();

        $response = $this->createApiResponse($banner, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Creates a new banner entity.
     *
     * @Route("/api/banner/{id}/upload", name="api_banner_upload")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @return Response
     */
    public function uploadAction(Request $request, $id)
    {
        $entity = $this->getDoctrine()->getRepository(Banner::class)->find($id);

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file){
            // remove a entidade caso tenha algo errado com o arquivo do banner
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->throwApiProblemException(array('Problemas com o banner' => $file), JsonResponse::HTTP_BAD_REQUEST);
        }

        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/slides');

        $entity = $this->getDoctrine()->getRepository(Banner::class)->find($id);

        $entity->setNomeArquivo($result);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($entity, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Creates a new banner entity.
     *
     * @Route("/api/banner/{id}/updateFoto", name="api_banner_updateFoto")
     * @Method({"POST","PATCH"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateFotoAction (Request $request, $id){

        $repository = $this->getDoctrine()->getRepository('UlocAppBundle:Banner');
        $banner = $repository->find($id);

        if(!$banner){
            $this->throwApiProblemException('Não foi encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/slides';

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file){
            throw $this->throwApiProblemException(array('Problemas com o banner' => $file), JsonResponse::HTTP_BAD_REQUEST);
        }


        $excluido = unlink($dir.'/'.$banner->getNomeArquivo());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir banner, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }


        $fileUploader = $this->get('app.file_uploader');

        $result = $fileUploader->upload($file, 'images/slides');

        $banner->setNomeArquivo($result);
        $banner->setNomeOriginal($file->getClientOriginalName());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($banner, JsonResponse::HTTP_CREATED);

        return $response;
    }

    /**
     * Finds and displays a banner entity.
     *
     * @Route("/api/banner/{id}", name="api_banner_show")
     * @Method("GET")
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:Banner');
        $banner = $repository->find($id);
        if(!$banner){
         $this->throwApiProblemException('Banner não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $response = $this->createApiResponse($banner, JsonResponse::HTTP_OK);

        return ($response);
    }
//TODO: Update de imagem
    /**
     * Displays a form to edit an existing banner entity.
     *
     * @Route("/api/banner/{id}/update", name="api_banner_update")
     * @Method({"PATCH", "PUT"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateAction(Request $request, $id)
    {
        $banner = $this->getDoctrine()->getRepository(Banner::class)->find($id);

        if(!$banner){
            $this->throwApiProblemException('Banner não encontrado', JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(BannerType::class, $banner);
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = $this->createApiResponse($banner, JsonResponse::HTTP_CREATED,
            function (ApiRepresentationMetadata $metadata) {
                $metadata->setGroup('public')
                    ->addProperties(
                        [
                            'id',
                            'nomeArquivo', //TODO: CHECAR RETORNO
                            'nomeOriginal',
                            'dataExibicao',
                            'posicao',
                            'situacao',
                            'hasVideo'
                        ]
                    )->build();
            }, 'public');

        return $response;
    }

    /**
     * Deletes a banner entity.
     *
     * @Route("/api/banner/{id}", name="api_banner_delete")
     * @Method("DELETE")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('UlocAppBundle:Banner');
        $banner = $repository->find($id);

        if(!$banner){
            $this->throwApiProblemException('Banner não cadastrado', JsonResponse::HTTP_NOT_FOUND);
        }

        if(!$banner->getNomeArquivo()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banner);
            $em->flush();

            return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $dir = $this->get('app.file_uploader')->getDestino().'/images/slides';

        $excluido = unlink($dir.'/'.$banner->getNomeArquivo());

        if(!$excluido){
            throw $this->throwApiProblemException('Erro ao excluir banner, tente novamente', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($banner);
        $em->flush();

        return $this->createApiResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

}

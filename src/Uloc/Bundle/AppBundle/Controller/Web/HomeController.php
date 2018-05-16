<?php

namespace Uloc\Bundle\AppBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Uloc\Bundle\AppBundle\Controller\BaseController;
use Uloc\Bundle\AppBundle\Entity\Banner;
use Uloc\Bundle\AppBundle\Entity\Leilao;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uloc\Bundle\AppBundle\Entity\LeilaoCache;

/**
 * Home controller for Web View.
 *
 */
class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function indexAction()
    {

        /*
         * TODO: Cache
         * TODO: Avaliar necessidade de análise de quantidade de lotes em destaque, muitos podem prejudicar o desempenho
         */
        $em = $this->getDoctrine()->getManager();

        $leiloes = $em->getRepository('UlocAppBundle:Leilao')->findActives();
        //$lotes = $em->getRepository('UlocAppBundle:Lote')->findby(array('destaque' => true, 'isPublished' => true), array('order'=>'ASC'));
        $lotes = $em->getRepository('UlocAppBundle:Lote')->findActivesDestaques();
      
        //$banners = $em->getRepository(Banner::class)->findby(array('situacao'=>true),array('posicao'=>'asc'));
        $banners = $em->getRepository(Banner::class)->findAtivos();

        $response = $this->render('home.html.twig', array(
            'leiloes' => $leiloes,
            'lotes' => $lotes,
            'banners'=> $banners
        ));

        //$response->setSharedMaxAge(600); // 10min
        // (optional) set a custom Cache-Control directive
        //$response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/updateTimer", name="updateTimerTMP")
     * @Method("GET")
     */
    public function updateTimerTMPAction()
    {

        $em = $this->getDoctrine()->getManager();

        $leilao = $em->getRepository(Leilao::class)->find(4);
        $leilao->setTimerPregao(10);
        $em->persist($leilao);
        $em->flush();

        return new Response('OK');
    }
}

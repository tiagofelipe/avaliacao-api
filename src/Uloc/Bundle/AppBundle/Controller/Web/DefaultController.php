<?php

namespace Uloc\Bundle\AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Uloc\Bundle\AppBundle\Controller\BaseController;

class DefaultController extends BaseController
{
    /**
     * @Route("/sobre-nos", name="sobre-nos")
     */
    public function sobreNosAction()
    {
        return $this->render('sobre-nos.html.twig');
    }

}

<?php

namespace InvEO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CoreController extends Controller
{
    /**
     * @Route("/", name="core.index")
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig');
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default_page")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }
}

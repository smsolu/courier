<?php

namespace AppBundle\Controller\prueba;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PruebaController extends Controller
{
    /**
     * @Route("/prueba/bla", name="prueba_page")
     * @Template()
     */
    public function indexAction()
    {
//        echo "holaaa";die();
        return array();
//        return $this->render('AppBundle:Default:index.html.twig');
    }
}

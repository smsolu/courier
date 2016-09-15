<?php

namespace ListViewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ListViewBundle\Services\ListView;


/**
 * @Route("/listview")
 */
class ListViewController extends Controller
{
    /**
     * Route("/{listview}/{parameters}",defaults={"parameters" = null}, name="listview")
     * @Template()
     */
    public function ListViewAction($request,ListView $listview,$parameters=null){
/*    
      1. Setea la ruta de ordenamiento
      2. Crear el Paginator
      3. Realizar las visualizaciones
 */
               
        $listview->setOrderRoute($request->attributes->get('_route'));
        $paginator  = $this->get('knp_paginator')
            ->paginate(
                $listview->getQuery(),
                $listview->getPage(),
                $listview->getResultPage()
            );

        if($listview->getSendObjects()){
            $pos = 0; foreach($paginator as $ope){ $ope->setObjects($paginator, $pos);   $pos++; }
        }
        return array('data' => $paginator, 'list' => $listview, 'parameters' => json_decode($parameters,true), 'paginator_enabled'=> true);
    }
   
}

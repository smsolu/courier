<?php

namespace LegalPro\Bundles\UserGroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/*HACER EN UN FUTURO, TENER EN CUENTA QUE UN PERMISO PUEDE ESTAR ENGANCHADO CON OTRO 
 * (EJ: SI TENGO PERMISO DE EDITAR DEBERIA TENER PERMISO DE VER)*/
/**
 * @Route("/group")
 */
class FrontendController extends Controller
{
    /**
     * @Route("/list/{page}", defaults={"page" = 1}, name="group_list")
     * @Template()
     */
    public function listAction($page)
    {
//        $user = $this->getUser();
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery(
//            'SELECT u
//            FROM CommonBundle:User u
//            WHERE u.estudio = :estudio'
//        )->setParameter('estudio', $user->getEstudio());
//
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $query,
//            $page/*page number*/,
//            10/*limit per page*//*HACER: parametrisar*/
//        );
//            
//        $list = new ListView();
//        $list->setTitle('Empleados')
//                ->addColumn('', 'email',array(
//                    'type' => 'link',
//                    'route' => new LinkColumn('user_show', array('id'=> 'getId')),
//                    'value' => '<span class="glyphicon glyphicon-pencil"></span>'
//                    )
//                )
//                ->addColumn('Nombre', 'username')
//                ->addColumn('E-mail', 'email',array(
//                    'type' => 'string',
//                    )
//                );
//        
//        
//        return array('list' => $list, 'pagination' => $pagination);
        return array('name' => $name);
    }
    /**
     * @Route("/{id}/show", name="group_show")
     * @Template()
     */
    public function showAction($id)
    {
        return array('name' => $id);
    }
    /**
     * @Route("/new", name="group_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/{id}/edit", name="group_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        return array('name' => $name);
    }
}

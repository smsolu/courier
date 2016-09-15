<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\UserRoleType;
use UserBundle\Form\Type\UserType;
use AppBundle\Entity\User;

use ListViewBundle\Services\ListView;
use ListViewBundle\Services\LinkColumn;
//HACER: desacoplar bundle del AppBundle


//use LegalPro\Bundles\CommonBundle\Services\MenuGenerator\MenuGenerator;
/**
* @Route("/user")
*/
class UserController extends Controller
{
    /**
     * @Route("/{id}/add-group", name="user_add-group")
     * @Template("UserBundle:Frontend:userRole.html.twig")
     */
    public function userAddGroupAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CommonBundle:User')->find($id);
        if(!$this->isValidUser($user)){
            return $this->redirectToRoute('user_list', array(), 301);
        }
        $group = array();
        $form = $this->createForm(new UserRoleType(), $group);
        $form->add('Agregar', 'submit');
        $form->handleRequest($request);
        if($form->isValid()) {
            $data = $form->getData();
            $user->addGroup($data['group']);
            $em->flush();
            return $this->redirectToRoute('user_show', array('id'=>$id), 301);
        }
        return array('form' => $form->createView());
    }
    /**
     * @Route("/{id}/remove-group/{idGroup}", name="user_remove-group")
     */
    public function userRemoveGroupAction($id, $idGroup)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CommonBundle:User')->find($id);
        if(!$this->isValidUser($user)){
            return $this->redirectToRoute('user_list', array(), 301);
        }
        $group = $em->getRepository('CommonBundle:Group')->find($idGroup);
        if($group){
            $user->removeGroup($group);
            $em->flush();
        }
        return $this->redirectToRoute('user_show_groups', array('id'=>$id), 301);
    }
    public function userAddRolAction($name)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/list/{page}", defaults={"page" = 1}, name="user_list")
     
     * @Template()
     */
    public function listAction($page)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u
            FROM AppBundle:User u
            WHERE u.estudio = :estudio'
        )->setParameter('estudio', $user->getEstudio());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page/*page number*/,
            3/*limit per page*//*HACER: parametrisar*/
        );
            
        $list = new ListView();
        $list->setTitle('Empleados')
                ->addColumn('', 'email',array(
                    'type' => 'link',
                    'route' => new LinkColumn('user_show', array('id'=> 'getId')),
                    'value' => '<span class="glyphicon glyphicon-pencil"></span>'
                    )
                )
                ->addColumn('Nombre', 'username')
                ->addColumn('E-mail', 'email',array(
                    'type' => 'string',
                    )
                );
        
        
        return array('list' => $list, 'pagination' => $pagination);
    }
    /**
     * @Route("/{id}/show/grupos", name="user_show_groups")
     * @Template()
     */
    public function userShowGroupsAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CommonBundle:User')->find($id);

        if(!$this->isValidUser($user)){
            return $this->redirectToRoute('user_list', array(), 301);
        }
        
        $group = array();
        $form = $this->createForm(new UserRoleType(), $group);
        $form->add('Agregar', 'submit');
        $form->handleRequest($request);
        if($form->isValid()) {
            $data = $form->getData();
            $user->addGroup($data['group']);
            $em->flush();
            return $this->redirectToRoute('user_show_groups', array('id'=>$id), 301);
        }
        return array('user' => $user, 'form' => $form->createView());
    }
    /**
     * @Route("/{id}/show/{section}", defaults={"section" = "general"}, name="user_show")
     * @Template()
     */
    public function showAction(User $user, $section, Request $request){
        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository('AppBundle:User')->find($id);
        
        if(!$this->isValidUser($user)){
            return $this->redirectToRoute('user_list', array(), 301);
        }
        switch($section){    
            //Si llegara a haber mas secciones, irian aca
            default:
                $form = $this->createForm(new UserType(), $user,array('disabled' => true));
                break;
        }
        $cancelPath = $this->generateUrl('user_show', array('id' => $user->getid(), 'section' => $section));
//        $editPath = $this->generateUrl('user_edit', array('id' => $user->getid(), 'section' => $section));
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($user->getUsername())
                ->setForm($form->createView())
                ->setCancelPath($cancelPath);
//                ->setEditPath($editPath);
        
        return array('abmManager' => $abmManager, 'user'=>$user, 'section'=>$section);
    }
    /**
     * @Route("/new", name="user_new")
     * @Template()
     */
    public function newAction(Request $request){
        $usuario = new User;
        $form = $this->createForm(UserType::class, $usuario); 
        $form->handleRequest($request);
        if($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setEnabled(true);
            $user->setUsername($usuario->getUsername());
            $user->setEmail($usuario->getEmail());
            $user->setEstudio($this->getUser()->getEstudio());
            /*HACER: autogenerada y enviar al mail*/
            $user->setPassword("123");
            $userManager->updateUser($user);
            if ($request->request->has('modificar')){
                return $this->redirectToRoute('user_show', array('id'=>$user->getId()), 301);
            }
            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('user_show', array('id' => $user->getId())) . '">' . $user->getUsername() . ' Se ha creado correctamente</a>');                
            return $this->redirectToRoute('user_list', array(), 301);
        }
        $cancelPath = $this->generateUrl('user_list');
        $abmManager = $this->get('ABM_AbmManager')
            ->setTitle("Nuevo Usuario")
            ->setForm($form->createView())
            ->setCancelPath($cancelPath);
        return array('abmManager' => $abmManager);
    }
    
    private function isValidUser($user){
        return ($user && $user->getEstudio() == $this->getUser()->getEstudio());
    }
}

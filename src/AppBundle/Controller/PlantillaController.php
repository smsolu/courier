<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\Plantilla;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\EditException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\UndoDeleteException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use PhpOffice\PhpWord\TemplateProcessor;

    /**
     * @Route("/plantilla")
     */
class PlantillaController extends Controller
{
    /**
     * @Route("/list/{id}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"id"=0 ,"page" = 1, "resultpage" = 10,"order_col"="tipo","order_status"=1}, name="plantilla_list")
     * @Template()
     */
    public function listAction(Request $request,$page,$resultpage,$order_col,$order_status, Plantilla $folder = null)
    {
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions();
            $list = $templateManager->getList($folder,$order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request);
        }catch(CheckPermissionsException $e){
            //Hacer: QUe vaya a la pantalla main o a un ade error
            throw $e;
        }
    }
    /**
     * @Route("/edit/{id}", name="plantilla_edit")
     * @Template()
     */
    public function editAction(Request $request,Plantilla $plantilla)
    {
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions($plantilla);
            $form = $templateManager->getForm($plantilla,false,array('fileRequired'=>false));
            $form->handleRequest($request);
            if($form->isValid()) {
                $plantilla = $templateManager->doEdit($form->getData());
                $this->get('session')->getFlashBag()->add('success', "La plantilla ".$this->get('translator')->trans('edit_ok') );
                return $this->redirectToRoute('plantilla_show', array('id'=>$plantilla->getId()), 301);
            }
            $cancelPath = $this->generateUrl('plantilla_show', array('id' => $plantilla->getid()));        
            $abmManager = $this->get('ABM_AbmManager')
                    ->setForm($form->createView())
                    ->setCancelPath($cancelPath);
            return array('abmManager' => $abmManager , 'plantilla'=>$plantilla);
        }catch(CheckPermissionsExcepton $e){
            $this->get('session')->getFlashBag()->add('danger', 'Plantilla invalida');
            return $this->redirectToRoute('plantilla_list', array(),301);
        }catch(EditException $e){
            $this->get('session')->getFlashBag()->add('danger', 'La plantilla '.$this->get('translator')->trans('edit_error'));
            return $this->redirectToRoute('plantilla_show', array('id'=>$plantilla->getId()), 301);
        }
    }
    /**
     * @Route("/show/{id}", name="plantilla_show")
     * @Template()
     */
    public function showAction(Plantilla $plantilla)
    {
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions($plantilla);
            $form = $templateManager->getForm($plantilla,true,array('fileEnabled'=>false));
            $cancelPath = $this->generateUrl('plantilla_show', array('id' => $plantilla->getid()));
            $editPath = $this->generateUrl('plantilla_edit', array('id' => $plantilla->getid()));
            $abmManager = $this->get('ABM_AbmManager')
                    ->setForm($form->createView())
                    ->setCancelPath($cancelPath)
                    ->setEditPath($editPath);
            return array('abmManager' => $abmManager);
        }catch(CheckPermissionsException $e){
            $this->get('session')->getFlashBag()->add('danger', 'Plantilla invalida');
            return $this->redirectToRoute('plantilla_list', array(),301);
        }
    }
    /**
     * @Route("/new", name="plantilla_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions();
            $form = $templateManager->getForm(new Plantilla());
            $form->handleRequest($request);   
            if($form->isValid()) {
                $plantilla = $templateManager->doNew($form->getData());
                if ($request->request->has('modificar')) {
                    return $this->redirectToRoute('plantilla_show', array('id'=>$plantilla->getId()), 301);
                }else{
                    $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('plantilla_show', array('id' => $plantilla->getId())) . '">' . $plantilla->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
                    return $this->redirectToRoute('plantilla_list', array(), 301);
                }
            }
            $cancelPath = $this->generateUrl('plantilla_list', array());
            $abmManager = $this->get('ABM_AbmManager')
                ->setForm($form->createView())
                ->setCancelPath($cancelPath)
                ->setShowButtonModify(false);
            return array('abmManager' => $abmManager);
        
        }catch(CheckPermissionsExcepton $e){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene permisos para esa operacion');
            return $this->redirectToRoute('plantilla_list', array(),301);    
        }catch(NewException $e){
            $this->get('session')->getFlashBag()->add('danger', 'La plantilla '.$this->get('translator')->trans('create_error'));                
            return $this->redirectToRoute('plantilla_list', array(), 301);
        }
    }
    /**
     * @Route("/delete/{id}", name="plantilla_delete")
     * @Template()
     */
    public function deleteAction(Plantilla $plantilla){
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions($plantilla)
                            ->doDelete($plantilla);
            $this->get('session')->getFlashBag()->add('success', '<a href="'.$this->generateUrl('plantilla_undodelete', array('id' => $plantilla->getId())).'">'.'La plantilla '.$plantilla->getNombre()." ".$this->get('translator')->trans('eliminado_ok')  .'</a>');                
            return $this->redirectToRoute('plantilla_list', array(), 301);
        }catch(CheckPermissionsExcepton $e){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene permisos para esa operacion');
            return $this->redirectToRoute('plantilla_list', array(),301);    
        }catch(DeleteException $e){
            $this->get('session')->getFlashBag()->add('danger', 'la plantilla '.$this->get('translator')->trans('eliminado_error'));                
            return $this->redirectToRoute('plantilla_list', array(), 301);
        }
    }
    /**
     * @Route("/undodelete/{id}", name="plantilla_undodelete")
     * @Template()
     */
    public function undoDeleteAction(Plantilla $plantilla){
        try{
            $templateManager = $this->get('lp_TemplateManager');
            $templateManager->doCheckPermissions($plantilla, $templateManager::DO_UNDODELETE)
                            ->doUndoDelete($plantilla);
            $this->get('session')->getFlashBag()->add('success', '<a href="'.$this->generateUrl('plantilla_show', array('id' => $plantilla->getId())).'">'.'La plantilla '.$plantilla->getNombre()." ".$this->get('translator')->trans('undelete_ok')  .'</a>');                
            return $this->redirectToRoute('plantilla_list', array(), 301);    
        }catch(CheckPermissionsExcepton $e){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene permisos para esa operacion');
            return $this->redirectToRoute('plantilla_list', array(),301);    
        }catch(UndoDeleteException $e){
            $this->get('session')->getFlashBag()->add('danger', 'la plantilla '.$this->get('translator')->trans('undelete_error'));                
            return $this->redirectToRoute('plantilla_list', array(), 301);
        }
    }
    
    
    
    //Provisorio
    /**
     * @Route("/newDocument/{id_plantilla}/{id}", name="plantilla_newDocument")
     * @Template()
     */
    public function newDocumentAction(Request $request, $id_plantilla, Expediente $expediente){

        $repository = $this->getDoctrine()->getRepository('AppBundle:Plantilla');
        $plantilla = $repository->find($id_plantilla);
        $estudio = $this->getUser()->getEstudio();
        //HACER: agregar el servicio de permisos
        if($estudio != $plantilla->getEstudio()){
            throw new \Exception("Estudio incorrecto");
        }
//        $data = array();
        $form = $this->generateFormBuilder($plantilla->getVariables())
                ->add('generar','submit')
                ->getForm();
        $form->handleRequest($request);
        if($form->isValid()) {
            $data = $form->getData();
            $tm = $this->get('lp_TemplateManager');
            $documento = $tm->generateDocument($expediente->getId(), $plantilla->getFilename(), $data);

            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('documento_show', array('id' => $documento->getId())) . '">' . $documento->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
            return $this->redirectToRoute('documento_list', array('idExpediente'=>$expediente->getId()), 301);
            
            
        }
        return array('form'=> $form->createView(), 'expediente'=>$expediente);
    }
    
    private function generateFormBuilder($variables){
        
        $formBuilder = $this->createFormBuilder(array());
        if(isset($variables)){
            foreach ($variables as $value) {
                $formBuilder->add($value , 'text');
            }
        }
        return $formBuilder;
    }
}

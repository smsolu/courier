<?php

namespace AppBundle\Controller\Expediente;

use ABMBundle\Services\AbmManager;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteActuacion;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Exception\ValidateException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\Exception;

/**
 * @Route("/expediente/")
 */
class ActuacionController extends Controller
{
    
    /**
     * @Route("{expedienteid}/actuaciones/undodelete/{id}",  name="expediente_actuaciones_undodelete")
     * @Template()
     */
    public function undodeleteAction(Request $request,ExpedienteActuacion $actuacion,$expedienteid){
        try{
            $expedienteActuacionesManager = $this->get('lp_ExpedienteActuacionManager');
            $expedienteActuacionesManager->doUndoDelete($actuacion);
            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_actuaciones_show', array('id' => $actuacion->getId(), 'expedienteid'=>$expedienteid)) . '"><span class="glyphicon glyphicon-eye-open"></span>  ' . ' ' . $this->get('translator')->trans('undelete_ok')  . '</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La Actuacion no es valida');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para restaurar la actuacion');
        }catch(UndoDeleteException $exud){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al restaurar la actuacion');
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expedienteid), 301);   
        }
    }
    /**
     * @Route("{expedienteid}/actuaciones/delete/{id}",  name="expediente_actuaciones_delete")
     * @Template()
     */
    public function deleteAction(Request $request,ExpedienteActuacion $actuacion,$expedienteid){
        try{
            $expedienteActuacionManager = $this->get('lp_ExpedienteActuacionManager');
            $expedienteActuacionManager->doCheckPermissions($actuacion);
            $expedienteActuacionManager->doDelete($actuacion);
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_actuaciones_undodelete', array('id' => $actuacion->getId(), 'expedienteid'=> $expedienteid)) . '"><span class="glyphicon glyphicon-trash"></span>   ' .  ' ' . $this->get('translator')->trans('eliminado_ok')  . '</a>');   
            $expediente = $actuacion->getExpediente();
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La actuación no es valida');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar la actuación');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar la actuación');
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expedienteid), 301);  
        }
    }
    /**
     * @Route("{expedienteid}/actuaciones/edit/{id}",  name="expediente_actuaciones_edit")
     * @Template()
     */
    public function editAction(Request $request,ExpedienteActuacion $actuacion,$expedienteid){
        try{
            $expedienteActuacionManager = $this->get('lp_ExpedienteActuacionManager');
            $expedienteActuacionManager->doCheckPermissions($actuacion);
            $expediente = $actuacion->getExpediente();
            $form = $expedienteActuacionManager->getForm($expediente,$actuacion,false);
            $form->handleRequest($request);
            if($form->isValid()) {
                $actuacion = $expedienteActuacionManager->doEdit($form->getData());
                $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_actuaciones_show', array('expedienteid' => $expediente->getId(),'id'=>$actuacion->getId())) . '">' . $this->get('translator')->trans('edit_ok')  .'</a>');                                
                return $this->redirectToRoute('expediente_actuaciones_show', array('id'=>$actuacion->getId(), 'expedienteid'=>$expediente->getId()), 301);
                
            }
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($expediente->getNumeroCompleto())
                    ->setForm($form->createView())
                    ->setCancelPath($this->generateUrl('expediente_actuaciones_show', array('id' => $actuacion->getId(), 'expedienteid'=> $expediente->getId())))
                    ->setOperation(AbmManager::abm_ope_modify);
            return array('abmManager' => $abmManager , 'expediente'=>$expediente,'actuacion' => $actuacion,
                         'section'=>'Actuaciones');
        }catch(ValidateException $exv){
            
        }catch(CheckPermissionsException $exp){
            
        } catch (Exception $ex) {

        }
    }
    
    /**
     * @Route("{expedienteid}/actuaciones/show/{id}",  name="expediente_actuaciones_show")
     * @Template()
     */    
    public function showAction(Request $request, $id,  ExpedienteActuacion $actuacion){
        try{
            $expediente = $actuacion->getExpediente();
            $expedienteActuacionManager = $this->get('lp_ExpedienteActuacionManager');
            $expedienteActuacionManager->doCheckPermissions($actuacion);        
            $form = $expedienteActuacionManager->getForm($expediente,$actuacion, true);
            
            $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($expediente->getNumeroCompleto())
                ->setEditPath($this->generateUrl('expediente_actuaciones_edit', array('id'=> $actuacion->getId(), "expedienteid"=>$expediente->getId())))
                ->setCancelPath($this->generateUrl('expediente_actuaciones_list', array('id' => $expediente->getid(), 'seccion' => "Actuaciones")))
                ->setOperation(AbmManager::abm_ope_show)
                ->setForm($form->createView());
            $route = $this->generateUrl('expediente_actuaciones_list', array('id'=> $expediente->getId()));
            $abmManager->addButton("actuaciones", "Volver al listado de Actuaciones", true, AbmManager::button_custom, $route,true);  
            return array('abmManager' => $abmManager, 'expediente'=>$expediente,'actuacion'=>$actuacion, 'section'=>'Actuaciones');
        }catch(ValidateException $exv){
            throw new Exception ("Error en Validate: " . $exv->getMessage(), 404,$exv);
        }catch(CheckPermissionsException $exp){
            throw new Exception ("Error en los permisos: " . $exp->getMessage(), 404,$exp);
        }
    }
    
    
    /**
     * @Route("{id}/actuaciones/new",  name="expediente_actuaciones_new")
     * @Template()
     */
    public function newAction(Request $request,Expediente $expediente){
        try{
            $expedienteActuacionManager = $this->get('lp_ExpedienteActuacionManager');      
            $form = $expedienteActuacionManager->getForm($expediente,new ExpedienteActuacion(), false);
            $form->handleRequest($request);   
            if($form->isValid()) {
                $actuacion = $expedienteActuacionManager->doNew($form->getData(),$expediente);
                $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_actuaciones_show', array('id' => $actuacion->getId(), 'expedienteid'=>$expediente->getId())) . '">' .  $this->get('translator')->trans('create_ok')  .'</a>');                
                return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expediente->getId()), 301);
            }        

            $cancelPath = $this->generateUrl('expediente_actuaciones_list', array('id' => $expediente->getid(), 'seccion' => "Actuaciones"));        
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle("Actuaciones")
                    ->setCancelPath($cancelPath)
                    ->setForm($form->createView())
                    ->setShowButtonModify(false);

            return array("expediente"=>$expediente,"section"=>"Actuaciones",
                         "abmManager"=>$abmManager);
        }catch(ValidateException $exv){
            
        }catch(CheckPermissionsException $exp){
            
        }catch(NewException $expn){
            
        }
        
    }
    /* SECCIONES */
     /**
     * @Route("{id}/actuaciones/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="descripcion","order_status"=1, "id" = -1}, name="expediente_actuaciones_list")
     * @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status)
    {
        
        try{
            $expedienteActuacionManager = $this->get('lp_ExpedienteActuacionManager');
            $list = $expedienteActuacionManager->getList($expediente, $order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'Actuaciones');
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }        
        
    }
  
}
    
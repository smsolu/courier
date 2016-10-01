<?php

namespace AppBundle\Controller\Expediente;

use ABMBundle\Services\AbmManager;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteVinculado;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Exception\ValidateException;
use AppBundle\Form\Type\Expediente\ExpedienteVinculadoType;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\Exception;

/**
 * @Route("/expediente/")
 */
class VinculadoController extends Controller
{
    
    
    /**
     * @Route("{expedienteid}/vinculados/delete/{id}",  name="expediente_vinculados_delete")
     * @Template()
     */
    public function deleteAction(Request $request,ExpedienteVinculado $vinculado,$expedienteid){
        try{
            $expedienteActuacionManager = $this->get('lp_ExpedienteVinculadoManager');
            $expedienteActuacionManager->doDelete($vinculado);
            $this->get('session')->getFlashBag()->add('danger', 'Se ha eliminado el vinculo correctamente ');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'El vinculo no es valido');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar el vinculo');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar el vinculo ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_vinculados_list', array('id'=>$expedienteid), 301);  
        }
    }
  
    
    /**
     * @Route("{id}/vinculados/new",  name="expediente_vinculados_new")
     * @Template()
     */
    public function newAction(Request $request,Expediente $expediente){
        try{
            $expedienteVinculadoManager = $this->get('lp_ExpedienteVinculadoManager');      
            $form = $expedienteVinculadoManager->getForm(new ExpedienteVinculado(), false);
            $form->handleRequest($request);   
            if($form->isValid()) {
                $vinculado = $expedienteVinculadoManager->doNew($form->getData(),$expediente);
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('create_ok')  .'</a>');                
                return $this->redirectToRoute('expediente_vinculados_list', array('id'=>$expediente->getId()), 301);
            }        
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger',$exv->getMessage() );
            return $this->redirectToRoute('expediente_vinculados_list', array('id'=>$expediente->getId()), 301);   
        }catch(CheckPermissionsException $exp){
            
        }catch(NewException $exn){
            $this->get('session')->getFlashBag()->add('danger',$exn->getMessage() );
            return $this->redirectToRoute('expediente_vinculados_list', array('id'=>$expediente->getId()), 301);   
        }catch(Exception $ex){
            $this->get('session')->getFlashBag()->add('danger',$ex->getMessage() );
            return $this->redirectToRoute('expediente_vinculados_list', array('id'=>$expediente->getId()), 301);   
        }
        
        $cancelPath = $this->generateUrl('expediente_vinculados_list', array('id' => $expediente->getId()));        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle("Vinculados")
                ->setCancelPath($cancelPath)
                ->setForm($form->createView())
                ->setShowButtonModify(false);
        return array("expediente"=>$expediente,"section"=>"Vinculados",
         "abmManager"=>$abmManager);
    }
        
        
    

    /* SECCIONES */
     /**
     * @Route("{id}/vinculados/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="descripcion","order_status"=1, "id" = -1}, name="expediente_vinculados_list")
     * @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status)
    {
        try{
            $expedienteVinculadoManager = $this->get('lp_ExpedienteVinculadoManager');
            $list = $expedienteVinculadoManager->getList($expediente, $order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'Vinculados');
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }           
        
    }
}
    
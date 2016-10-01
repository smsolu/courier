<?php

namespace AppBundle\Controller\Expediente;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteEntidad;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\ValidateException;
use AppBundle\Form\Type\Expediente\EntidadType;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Route("/expediente")
     */
class ExpedienteEntidadController extends Controller
{
    

     /**
     * @Route("/{id}/abogados/new", name="expediente_abogado_new")
       @Template()
     */
    public function newAction(Request $request,Expediente $expediente){
        try{
            $expedienteEntidadManager = $this->get('lp_ExpedienteEntidadManager');      
            $form = $expedienteEntidadManager->getForm(new ExpedienteEntidad(), false);
            $form->handleRequest($request);   
            if($form->isValid()) {
                $entidad = $expedienteEntidadManager->doNew($form->getData(),$expediente);
                $this->get('session')->getFlashBag()->add('success',' Se ha agregado : ' . $entidad->getEntidad()->getNombre());
                return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);
            }        
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger',$exv->getMessage() );
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);   
        }catch(CheckPermissionsException $exp){
            
        }catch(NewException $exn){
            $this->get('session')->getFlashBag()->add('danger',$exn->getMessage() );
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);   
        }catch(Exception $ex){
            $this->get('session')->getFlashBag()->add('danger',$ex->getMessage() );
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);   
        }
        
        $cancelPath = $this->generateUrl('expediente_abogados_list', array('id' => $expediente->getId()));        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle("Abogados")
                ->setCancelPath($cancelPath)
                ->setForm($form->createView())
                ->setShowButtonModify(false);
        return array("expediente"=>$expediente,"section"=>"Abogados",
         "abmManager"=>$abmManager);        
    }
     
    
    /**
     * @Route("/{expedienteid}/abogados/undo_delete/{id}",defaults={"id"="-1"}, name="expediente_abogado_undodelete")
     * @Template()
     */    
    public function undodeleteAbogadoExpAction(ExpedienteEntidad $expedienteEntidad,$expedienteid){    
         try{
            $expedienteEntidadManager = $this->get('lp_ExpedienteEntidadManager');
            $expedienteEntidadManager->doUndoDelete($expedienteEntidad);
            $this->get('session')->getFlashBag()->add('success', "Se ha restaurado a " .  $expedienteEntidad->getEntidad()->getNombre());   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La entidad asociada no es valida');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para restaurar el registro');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al restaurar la entidad asociada ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expedienteid), 301);  
        }   
    }
    /**
     * @Route("/{expedienteid}/abogados/delete/{id}",defaults={"id"="-1"}, name="expediente_abogado_delete")
       @Template()
     */    
    public function deleteAbogadoExpAction(ExpedienteEntidad $expedienteEntidad, $expedienteid){
        try{
            $expedienteEntidadManager = $this->get('lp_ExpedienteEntidadManager');
            $expedienteEntidadManager->doDelete($expedienteEntidad);
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_abogado_undodelete', array('id' => $expedienteEntidad->getId(), "expedienteid"=>$expedienteEntidad->getExpediente()->getId())) . '"><span class="glyphicon glyphicon-trash"></span> ' . $expedienteEntidad->getEntidad()->getNombre() . ' ' . $this->get('translator')->trans('eliminado_ok')  .'</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La entidad asocida no es valida');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar la Entidad');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar la entidad ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expedienteid), 301);  
        }        
    }
    
     /**
     * @Route("/{id}/abogados/list/{page}/{resultpage}/{order_col}/{order_status}",defaults={"page" = 1, "resultpage" = 10,"order_col"="descripcion","order_status"=1, "id" = -1}, name="expediente_abogados_list")
       @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status)
    {
        try{
            $expedienteEntidadManager = $this->get('lp_ExpedienteEntidadManager');
            $list = $expedienteEntidadManager->getList($expediente, $order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'Abogados');
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }   
        
        
        return array("request" => $request, "list" => $list, "expediente"=>$expediente, "section"=>"abogados");
    }
    /**
     * @Route("/{expedienteid}/abogados/responsable/{id}",defaults={"id"="-1"}, name="expediente_abogado_responsable")
       @Template()
     */    
    public function setAbogadoResponsableAction(ExpedienteEntidad $expedienteEntidad,$expedienteid){
        try{
            switch($expedienteEntidad->getResponsable()){
                case ExpedienteEntidad::RESPONSABLE_NO_RESPONSABLE:
                    $responsabilidad = ExpedienteEntidad::RESPONSABLE_RESPONSABLE;
                    $msg = $expedienteEntidad->getEntidad()->getNombre() . ' es responsable';
                    break;
                case ExpedienteEntidad::RESPONSABLE_RESPONSABLE:
                    $responsabilidad = ExpedienteEntidad::RESPONSABLE_NO_RESPONSABLE;
                    $msg =  $expedienteEntidad->getEntidad()->getNombre() . ' no es mas responsable';
                    break;
            }            
            
            $expedienteEntidadManager = $this->get('lp_ExpedienteEntidadManager');
            $expedienteEntidadManager->doEntidadResponsable($expedienteEntidad,$responsabilidad);
            $this->get('session')->getFlashBag()->add('danger', $msg);   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La entidad asocida no es valida');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar la Entidad');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar la entidad ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expedienteid), 301);  
        }           
    }
}

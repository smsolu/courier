<?php
namespace AppBundle\Controller\Expediente;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteInterviniente;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\ValidateException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
 
    /**
     * @Route("/expediente/")
     */
class ExpedienteIntervinienteController extends Controller
{
     /**
     * @Route("{id}/intervinientes/new", name="expediente_intervinientes_new")
       @Template()
      * Template("ExpedienteIntervinienteBundle:Frontend:new.html.twig")
     */
    public function newAction(Request $request,Expediente $expediente){
        try{
            $expedienteIntervinienteManager = $this->get('lp_ExpedienteIntervinienteManager');      
            $form = $expedienteIntervinienteManager->getForm(new ExpedienteInterviniente(), false);
            $form->handleRequest($request);   
            if($form->isValid()) {
                $entidad = $expedienteIntervinienteManager->doNew($form->getData(),$expediente);
                $this->get('session')->getFlashBag()->add('success',' Se ha agregado la parte: ' . $entidad->getEntidad());
                return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expediente->getId()), 301);
            }        
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger',$exv->getMessage() );
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expediente->getId()), 301);   
        }catch(CheckPermissionsException $exp){
            
        }catch(NewException $exn){
            $this->get('session')->getFlashBag()->add('danger',$exn->getMessage() );
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expediente->getId()), 301);   
        }catch(Exception $ex){
            $this->get('session')->getFlashBag()->add('danger',$ex->getMessage() );
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expediente->getId()), 301);   
        }
        
        $cancelPath = $this->generateUrl('expediente_intervinientes_list', array('id' => $expediente->getId()));        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle("Intervinientes")
                ->setCancelPath($cancelPath)
                ->setForm($form->createView())
                ->setShowButtonModify(false);
        return array("expediente"=>$expediente,"section"=>"Intervinientes",
         "abmManager"=>$abmManager);
    }

    
    /**
     * @Route("{expedienteid}/intervinientes/undo_delete/{id}",defaults={"id"="-1"}, name="expediente_intervinientes_undodelete")
     */    
    public function undodeleteIntervinienteExpAction(ExpedienteInterviniente $intervinienteExp, $expedienteid){    
         try{
            $expedienteIntervinienteManager = $this->get('lp_ExpedienteIntervinienteManager');
            $expedienteIntervinienteManager->doUndoDelete($intervinienteExp);
            $this->get('session')->getFlashBag()->add('success', "Se ha restaurado al interviniente " .  $intervinienteExp->getEntidad()->getNombre());   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'El Interviniente no es valido');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para restaurar el registro');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al restaurar el interviniente ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expedienteid), 301);  
        }        
    }
    /**
     * @Route("{expedienteid}/intervinientes/delete/{id}", name="expediente_intervinientes_delete")
     */    
    public function deleteIntervinienteExpAction(ExpedienteInterviniente $intervinienteExp,$expedienteid){
        try{
            $expedienteIntervinienteManager = $this->get('lp_ExpedienteIntervinienteManager');
            $expedienteIntervinienteManager->doDelete($intervinienteExp);
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_intervinientes_undodelete', array('id' => $intervinienteExp->getId(), "expedienteid"=>$intervinienteExp->getExpediente()->getId())) . '"><span class="glyphicon glyphicon-trash"></span> ' . $intervinienteExp->getEntidad()->getNombre() . ' ' . $this->get('translator')->trans('eliminado_ok')  .'</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'El Interviniente no es valido');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar el registro');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar el interviniente ' . $exd->getMessage());
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expedienteid), 301);  
        }
    }
    
    
     /**
     * @Route("{id}/intervinientes/list/{page}/{resultpage}/{order_col}/{order_status}",defaults={"page" = 1, "resultpage" = 10,"order_col"="descripcion","order_status"=1, "id" = -1}, name="expediente_intervinientes_list")
       @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status)
    {
        try{
            $expedienteIntervinienteManager = $this->get('lp_ExpedienteIntervinienteManager');
            $list = $expedienteIntervinienteManager->getList($expediente, $order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'Intervinientes');
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }            
    }
}

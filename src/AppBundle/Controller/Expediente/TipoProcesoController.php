<?php

namespace AppBundle\Controller\Expediente;

use ABMBundle\Services\AbmManager;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteTipoProceso;
use AppBundle\Entity\TipoProceso;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Exception\ValidateException;
use AppBundle\Form\Type\Expediente\ExpedienteFindType;
use AppBundle\Form\Type\Expediente\ExpedienteTipoProcesoType;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Route("/expediente")
     */
class TipoProcesoController extends Controller
{
    
     /**
     * @Route("/deleteproceso/{idExpedienteTipoProc}/{id}",defaults={"idExpedienteTipoProc" = -1,"id" =-1}, name="expediente_tipoproceso_delete")
     */
    public function tipoProcesoDeleteAction($idExpedienteTipoProc,Expediente $expediente)
    {
        if(!$expediente){
            throw new Exception('No existe el expediente');
        }
        $em = $this->getDoctrine()->getManager();
        if($idExpedienteTipoProc == "all"){
            $qb = $em->createQueryBuilder();
            $qb->delete('AppBundle:ExpedienteTipoProceso', 'e')
                    ->where('e.Expediente = :expediente')
                    ->setParameter('expediente', $expediente)
                    ->getQuery()
                    ->execute();
            $this->get('session')->getFlashBag()->add('success', 'Se eliminaron todos los tipos de proceso vinculado al caso');
        }else{
            $repository = $em->getRepository('AppBundle:ExpedienteTipoProceso');
            $tipoproc = $repository->find($idExpedienteTipoProc);
            if($tipoproc){
                $em->remove($tipoproc);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Se elimino el tipo de proceso vinculado al caso');
            }else{
                $this->get('session')->getFlashBag()->add('danger', 'No se pudo eliminar el proceso');  
            }
        }
        return $this->redirectToRoute('expediente_tipodeproceso_showedit', array('id'=>$expediente->getId()), 301);
    }
    
     /**
     * @Route("/{id}/tipoproceso/list/{page}/{resultpage}",defaults={"page" = 1, "resultpage" = 10}, name="expediente_tipodeproceso_list")
       @Template()
     */
    public function listAction(Request $request,$page,$resultpage,Expediente $expediente)
    {
        try{
            $expedienteTipoProcesoManager = $this->get('lp_ExpedienteTipoProcesoManager');
            $list = $expedienteTipoProcesoManager->getList($expediente, "", "", $page, $resultpage);
            return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'TipoProceso',"procesoprincipal"=>$expediente->getTipoProceso()->getNombre());
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }   
        
        
        return array("request" => $request, "list" => $list, "expediente"=>$expediente, "section"=>"abogados");
    }
     
    /**
     * @Route("/edit/{id}", name="expediente_edit")
     * Route("/edit/{id}/{seccion}",defaults={"seccion"="General"}, name="expediente_edit")
     * @Template()
     */
    public function editAction(Request $request,Expediente $expediente, $seccion= "General")
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $expedienteManager->doCheckPermissions($expediente);
            $form = $expedienteManager->getForm($expediente,false,$seccion);
            $form->handleRequest($request);
            if($form->isValid()) {
                $expediente = $expedienteManager->doEdit($form->getData());
                return $this->redirectToRoute('expediente_show', array('id'=>$expediente->getId()), 301);
            }
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($expediente->getNumeroCompleto())
                    ->setForm($form->createView())
                    ->setCancelPath($this->generateUrl('expediente_show', array('id' => $expediente->getId())))
                    ->setOperation(AbmManager::abm_ope_modify);
            return array('abmManager' => $abmManager , 'expediente'=>$expediente, 'section'=>'General');
        }catch(ValidateException $exv){
            
        }catch(CheckPermissionsException $exp){
            
        } catch (Exception $ex) {

        }
    }

    
    /**
     * @Route("/show/{id}", name="expediente_show")
     * Route("/show/{id}/{seccion}",defaults={"seccion"="General"}, name="expediente_show")
     * @Template()
     */
    public function showAction(Expediente $expediente,$seccion="General")
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $expedienteManager->doCheckPermissions($expediente);        
            $form = $expedienteManager->getForm($expediente, true,$seccion);
            $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($expediente->getNumeroCompleto())
                ->setEditPath($this->generateUrl('expediente_edit', array('id'=> $expediente->getId())))
                ->setCancelPath($this->generateUrl('expediente_list', array()))
                ->setOperation(AbmManager::abm_ope_show)
                ->setForm($form->createView());
            return array('abmManager' => $abmManager, 'expediente'=>$expediente, 'section'=>'General');
        }catch(ValidateException $exv){
            throw new Exception ("Error en Validate: " . $exv->getMessage(), 404,$exv);
        }catch(CheckPermissionsException $exp){
            throw new Exception ("Error en los permisos: " . $exp->getMessage(), 404,$exp);
        }
    }
    
   
}
    
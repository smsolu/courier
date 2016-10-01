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
class ExpedienteController extends Controller
{
    /**
     * @Route("/new/", name="expediente_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $form = $expedienteManager->getForm(new Expediente(),false, "NEW");
            $form->handleRequest($request);   
            if($form->isValid()) {
                $expediente = $expedienteManager->doNew($form->getData());
                //Presiono el boton de Modificar y Continuar
                if ($request->request->has('modificar')) {
                    return $this->redirectToRoute('expediente_show', array('id'=>$expediente->getId()), 301);                
                }else{
                    $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_show', array('id' => $expediente->getId())) . '">' . $expediente->getNumeroyCaratula() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
                    return $this->redirectToRoute('expediente_list', array(), 301);
                }               
            }

            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($this->get('translator')->trans('title_new')  . ' ')
                    ->setCancelPath($this->generateUrl('expediente_list', array()))
                    ->setForm($form->createView())
                    ->setOperation(AbmManager::abm_ope_new);
            return array('abmManager' => $abmManager);
        }catch(ValidateException $exv){
            
        }catch(CheckPermissionsException $exp){
            
        }catch(NewException $expn){
            
        }
    }
    
     /**
     * @Route("/delete/{id}", name="expediente_delete")
     * @Template()
     */
    public function deleteAction(Expediente $expediente)
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $expedienteManager->doCheckPermissions($expediente);
            $expedienteManager->doDelete($expediente);
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_undodelete', array('id' => $expediente->getId())) . '"><span class="glyphicon glyphicon-trash"></span>   ' . $expediente->getNumeroyCaratula() . ' ' . $this->get('translator')->trans('delete_ok')  . '</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'El expediente no es valido');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para eliminar el expediente');
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al eliminar el expediente');
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_list', array(), 301);  
        }
    }    

    /**
     * @Route("/undodelete/{id}", name="expediente_undodelete")
     * @Template()
     */
    public function undodeleteAction(Expediente $expediente)
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $expedienteManager->doUndoDelete($expediente);
            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_show', array('id' => $expediente->getId())) . '"><span class="glyphicon glyphicon-eye-open"></span>  ' . $expediente->getNumeroyCaratula() . ' ' . $this->get('translator')->trans('undelete_ok')  . '</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'El expediente no es valido');
        }catch(CheckPermissionsException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No tiene los permisos para restaurar el expediente');
        }catch(UndoDeleteException $exud){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al restaurar el expediente');
        } catch (Exception $ex) {
        }finally{
            return $this->redirectToRoute('expediente_list', array(), 301);  
        }

    }    

    
     /**
     * @Route("/findOne/{search}", defaults={"search_word" = ""}, name="expediente_findone")
     * @Template()
     */    
    public function findoneAction(Request $request, $search){
        /* Recibe del legalpro_search que es el conmutador central de búqueda 
         * Crea el formulario de búsqueda y se lo manda al list!
         * Tipo de Búsquedas permitidas:
         * 1. Búsqueda por nro/año/subexpediente
         * 2. Búsqueda por caratula.
        */
        
        // ERROR: NO PUEDO PROPAGAR AL LIST!
        
        
//        $search = trim(urldecode($search));
//         // SI ES VACIO ENTONCES DIGIRISE AL CUADRO DE BÚSQUEDA
//        if($search == ""){
//            return $this->redirectToRoute('expediente_find', array(), 301);
//        }
//
//        if(strpos($search,'/')!=FALSE){
//            // Encontro un '/', entonces se esta mandando un expediente x/2015
//            $tokens = explode("/", $search);
//            if(count($tokens) >= 1){
////                $expediente->setNumero($tokens[0]);
//                $request->query->set("numero", $tokens[1]);
//            }
//            if(count($tokens) >= 2){
////                $expediente->setAnio($tokens[1]);
//                $request->query->set("anio", $tokens[1]);
//            }
//            if(count($tokens) >= 3){
////                $expediente->setNroincidente($tokens[2]);
//                $request->query->set("nroincidente", $tokens[2]);
//            }            
//        }else{
//            // se esta buscando una caratula por que no tiene '/'
////            $expediente->setCaratula($search);
//            $request->query->set("caratula", $search);
//        }
//  
//        $request->query->set('numero',array("1"));
//        $request->query->set('anio',array("1"));
//        $request->query->set("nroincidente", "23");
//        
////        $request->query->add('numero',"1");
//
//        return $this->redirectToRoute('expediente_list',array("request"=>$request), 301);
    }
   
    
    /**
     * @Route("/find/", name="expediente_find")
     * @Template()
     */
    public function findAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = new Expediente();
  
        $findform = new ExpedienteFindType();
        $form = $this->createForm($findform, $expediente);
        $form->add('find', 'submit',array('label'=>'Buscar'));
        $form->handleRequest($request);
        $findManager = $this->get('legalPro_commonBundle_FindManager')
                ->setTitle($this->get('translator')->trans('sec_exp_buscar'))
                ->setForm($form->createView())
                ->setMethod('GET')
                ->setAction($this->generateUrl('expediente_list'));
                
        
        
        
        
        
        if($form->isValid()) {
//            $expediente = $form->getData();
//            return $this->redirectToRoute('expediente_list',array(), 301);
        }
        return array('findManager' => $findManager);
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
    
    /**
     * @Route("/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Expediente","order_status"=1}, name="expediente_list")
     * @Template()
     */
    public function listAction(Request $request, $page,$resultpage,$order_col,$order_status)
    {
        try{
            $expedienteManager = $this->get('lp_ExpedienteManager');
            $list = $expedienteManager->getList($order_col, $order_status, $page, $resultpage);
            return array('list' => $list,'request'=>$request,'parameters'=>$this->getRequest()->query->all());
        }catch(ListException $exl){
            
        } catch (Exception $ex) {

        }
    }    
    /**
     * @Route("/showwidget" , name="expediente_showwidget")
     * @Template()
     */
    public function showWidgetAction()
    {
        /* OBTENER EL ULTIMO EXPEDIENTE CREADO EN EL ESTUDIO */
//        $em = $this->getDoctrine()->getManager();
//
//        $user = $this->getUser();
//        $estudio =$user->getEstudio();
//        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
//        
//        $repo = $em->getRepository('CommonBundle:Expediente');
//        
//        $expedientes = $repo->findBy(
//             array('Estudio'=> $estudio,'status' => 0) 
//             ,array('id' => 'DESC'),3
//        );
//        
//        $nroExpedientes = $em->createQuery('SELECT COUNT(e.id) '
//                                         . 'FROM CommonBundle:Expediente e '
//                                         . 'WHERE e.Estudio = :id_Estudio and e.status = 0')
//                         ->setParameter('id_Estudio',$estudio)
//                         ->getSingleScalarResult();
//        if(!$nroExpedientes){
//            $nroExpedientes = 0;
//        }
//        
//        
//        return array("expedientes"=> $expedientes,"nroExpedientes"=> $nroExpedientes);
        
    }
}
    
<?php

namespace AppBundle\Controller\Expediente;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteTipoProceso;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;

use AppBundle\Form\Type\Expediente\ExpedienteFindType;

use AppBundle\Form\Type\Expediente\ExpedienteTipoProcesoType;

use AppBundle\Entity\TipoProceso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $form = $expedienteManager->getForm(new Expediente());
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
                ->setForm($form->createView());
        return array('abmManager' => $abmManager);
    }
    
     /**
     * @Route("/delete/{id}", name="expediente_delete")
     * @Template()
     */
    public function deleteAction(Expediente $expediente)
    {
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $expedienteManager->doCheckPermissions($expediente);
        $expedienteManager->doDelete($expediente);
        $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_undodelete', array('id' => $expediente->getId())) . '"><span class="glyphicon glyphicon-trash"></span>   ' . $expediente->getNumeroyCaratula() . ' ' . $this->get('translator')->trans('delete_ok')  . '</a>');   
        return $this->redirectToRoute('expediente_list', array(), 301);
    }    

    /**
     * @Route("/undodelete/{id}", name="expediente_undodelete")
     * @Template()
     */
    public function undodeleteAction(Expediente $expediente)
    {
        //HACER: chequear si el expediente es del estudio
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $expedienteManager->doCheckPermissions($expediente);
        $expedienteManager->doUndoDelete($expediente);
        $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('expediente_show', array('id' => $expediente->getId())) . '"><span class="glyphicon glyphicon-eye-open"></span>  ' . $expediente->getNumeroyCaratula() . ' ' . $this->get('translator')->trans('undelete_ok')  . '</a>');   
        return $this->redirectToRoute('expediente_list', array(), 301);
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
     * @Route("/deleteproceso/{idExpedienteTipoProc}/{id}",defaults={"idExpedienteTipoProc" = -1,"id" =-1}, name="expediente_tipoproceso_delete")
     */
    public function tipoProcesoDeleteAction($idExpedienteTipoProc,Expediente $expediente)
    {
        if(!$expediente){
            throw new \Exception('No existe el expediente');
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
     * @Route("/tipoproceso/edit/{id}/{page}/{resultpage}",defaults={"page" = 1, "resultpage" = 10,"ope"="show"}, name="expediente_tipodeproceso_showedit")
       @Template("AppBundle:Expediente:Expediente/tipoproceso.html.twig")
     */
    public function tipodeProcesoShowEditAction(Request $request,$page,$resultpage,Expediente $expediente)
    {
        if(!$expediente){
            throw new \Exception('No existe el expediente');
        }
        $em = $this->getDoctrine()->getManager();
        $estudio =$this->getUser()->getEstudio();
        $tipoProcesos = $em->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1)")
            ->setParameters(array("status"=> TipoProceso::STATUS_NO_DELETED, "estudio"=>$estudio))
            ->from('AppBundle:TipoProceso','e')
                ->getQuery()->getResult();
        //Se hace asi cuando hay multiples formularios en la pagina de la misma clase
        $formPrincipal = $this->get('form.factory')->createNamedBuilder("principal",ExpedienteTipoProcesoType::class,$expediente,array('tipoProcesos'=> $tipoProcesos))->getForm()
            ->add('submit', SubmitType::class,array('label' => 'Definir'));
        //Se hace asi cuando hay multiples formularios en la pagina de la misma clase
        $formSecundario = $this->get('form.factory')->createNamedBuilder("secundario",ExpedienteTipoProcesoType::class,null,array('tipoProcesos'=> $tipoProcesos))->getForm()
            ->add('submit', SubmitType::class, array('label' => 'Agregar'));
        $formPrincipal->handleRequest($request);
        if($formPrincipal->isValid()) {
            $expediente = $formPrincipal->getData();
            $em->flush();
        }
        $formSecundario->handleRequest($request);
        if($formSecundario->isValid()) {
            $tipoProceso = $formSecundario->getData()->getTipoProceso();
            $repository = $this->getDoctrine()->getRepository('AppBundle:ExpedienteTipoProceso');

            if(!$this->getDoctrine()->getRepository('AppBundle:Expediente')->getEntityTipoProceso($estudio,$expediente,$tipoProceso)){
                $this->get('session')->getFlashBag()->add('success', 'El tipo de proceso ' . $tipoProceso->getNombre() . ' se asocio al expediente');                                
                $procesoAsociado = new ExpedienteTipoProceso();
                $procesoAsociado->setEstudio($estudio)
                    ->setExpediente($expediente)
                    ->setTipoProceso($tipoProceso);
                $em->persist($procesoAsociado);
                $em->flush();
            }else{
                $this->get('session')->getFlashBag()->add('warning', 'El tipo de proceso ya esta asociado al expediente');                                                
            }
        }
        $queryBuilder = $this->getDoctrine()->getRepository('AppBundle:Expediente')->getTipoProcesodeExpediente($estudio,$expediente);
        $list = new ListView();
        $list
            ->setTitle("Tipos de Proceso")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('expediente_tipoproceso_delete', array('idExpedienteTipoProc'=> 'getId','id'=>'getExpedienteid')),
                'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
            ))          
            ->addColumn("Otros Procesos Asociados", 'NombreProceso',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol("", "");
        return array(
                    "request" => $request, 
                    "list" => $list, 
                    "formPrincipal" => $formPrincipal->createView(), 
                    "formSecundario" => $formSecundario->createView(), 
                    "expediente"=>$expediente, 
                    "section"=>"TipodeProceso"
                );
    }
     /**
     * @Route("/edit/{id}", name="expediente_edit")
     * Route("/edit/{id}/{seccion}", name="expediente_edit")
     * @Template()
     */
    public function editAction(Request $request,Expediente $expediente)
    {
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $expedienteManager->doCheckPermissions($expediente);
        $form = $expedienteManager->getForm($expediente);
        $form->handleRequest($request);
        if($form->isValid()) {
            $expediente = $expedienteManager->doEdit($form->getData());
            return $this->redirectToRoute('expediente_show', array('id'=>$expediente->getId()), 301);
        }
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($expediente->getNumeroCompleto())
                ->setForm($form->createView())
                ->setCancelPath($this->generateUrl('expediente_show', array('id' => $expediente->getId())));
        
        return array('abmManager' => $abmManager , 'expediente'=>$expediente, 'section'=>'General');
//        return array('form' => $form->createView(), 'titulo'=>$titulo,'subtitulo' => $subtitulo, 'expediente'=> $expediente, 'seccion'=> 'General');
    }

    
    /**
     * @Route("/show/{id}", name="expediente_show")
     * Route("/show/{id}/{seccion}",defaults={"seccion"="General"}, name="expediente_show")
     * @Template()
     */
    public function showAction(Expediente $expediente)
    {
        if(!$expediente || $expediente->getStatus() == Expediente::STATUS_DELETED){
            throw new \Exception('No existe el expediente');
        }
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $expedienteManager->doCheckPermissions($expediente);        
        $form = $expedienteManager->getForm($expediente, true);
        $abmManager = $this->get('ABM_AbmManager')
            ->setTitle($expediente->getNumeroCompleto())
            ->setForm($form->createView())
            ->setEditPath($this->generateUrl('expediente_edit', array('id'=> $expediente->getId())));
        return array('abmManager' => $abmManager, 'expediente'=>$expediente, 'section'=>'General');
    }
    
    /**
     * @Route("/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Expediente","order_status"=1}, name="expediente_list")
     * @Template()
     */
    public function listAction(Request $request, $page,$resultpage,$order_col,$order_status)
    {
        $expedienteManager = $this->get('lp_ExpedienteManager');
        $list = $expedienteManager->getList($order_col, $order_status, $page, $resultpage);
        return array('list' => $list,'request'=>$request,'parameters'=>$this->getRequest()->query->all());
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
    
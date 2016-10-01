<?php

namespace AppBundle\Controller\Entidad;

use ABMBundle\Services\AbmManager;
use AppBundle\Entity\DatosAdicionales;
use AppBundle\Entity\Entidad;
use AppBundle\Exception\CheckPermissionException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Exception\ValidateException;
use AppBundle\Services\EntidadManager\EntidadManager;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Route("/entidad")
     */
class EntidadController extends Controller
{
    /**
     * @Route("/new/{codigoTipoEntidad}", name="entidad_new")
     * @Template()
     */
    public function newAction(Request $request,$codigoTipoEntidad)
    {
        try{
            $entidadManager = $this->get('lp_EntidadManager');
            $tipoentidad = $entidadManager->getTipoEntidad($codigoTipoEntidad); 
            $form = $entidadManager->getForm(new Entidad(),"NEW"); 
            $form->handleRequest($request);   
            if($form->isValid()) {
                $entidad = $entidadManager->doNew($form->getData(),$tipoentidad);
                if ($request->request->has('modificar')) { //Presiono el boton de Modificar y Continuar
                    return $this->redirectToRoute('entidad_show', array('id'=>$entidad->getId()), 301);                
                }else{
                    $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('entidad_show', array('id' => $entidad->getId())) . '">' . $entidad->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
                    return $this->redirectToRoute('entidad_list', array("codigoTipoEntidad"=>$codigoTipoEntidad), 301);
                }               
            }
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($this->get('translator')->trans('title_new')  . ' ')
                    ->setForm($form->createView())
                    ->setCancelPath($this->generateUrl('entidad_list', array("codigoTipoEntidad"=>$codigoTipoEntidad)));
            return array('abmManager' => $abmManager);  
        }catch(ValidateException $ex){
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al intentar crear una entidad: ' . $ex->getMessage());
            return $this->redirectToRoute('entidad_list', array("codigoTipoEntidad"=>$codigoTipoEntidad), 301);
        }catch(CheckPermissionException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No Tiene los permisos para poder visualizar el listado de: ' . $codigoTipoEntidad);
            throw new Exception('Error: No Tiene los permisos para poder visualizar el listado de: ' . $codigoTipoEntidad, 404, $exp);
        }
              
    }
    
     /**
     * @Route("/find/{tipo}",defaults={"tipo" = "cliente"}, name="entidad_find")
     * @Template()
     */
    public function findAction(Request $request, $tipo)
    {
//        $em = $this->getDoctrine()->getManager();
//        $user = $this->getUser();
//        $estudio =$user->getEstudio();
//        $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
//        $entidad = new Entidad();
//        $tipo = strtoupper($tipo);
//        $repository = $this->getDoctrine()->getRepository('AppBundle:EntidadTipoEntidad');
//        $tipoentidad = $repository->findOneBy(array('codigo' => $tipo, 'Estudio' => $estudio->getId()));
//        
//        // PARA TENER EN CUENTA
//        //$builder = $app['form.factory']->createNamedBuilder(null, 'form', $data, array('validation_constraint' => $constraint));
//        
//        $findform = new EntidadFindType();
//        $form = $this->createForm($findform, $entidad);
//
//        $findManager = $this->get('legalPro_commonBundle_FindManager')
//                ->setTitle($this->get('translator')->trans('sec_exp_buscar'))
//                ->setForm($form->createView())
//                ->setMethod('GET')
//                ->setAction($this->generateUrl('entidad_list', array("tipo"=> $tipo)));
//
//        $form->handleRequest($request);
//        
//        
//        if($form->isValid()) {
//            return $this->redirectToRoute('entidad_list',array("tipo"=>$tipo), 301);
//        }
//        return array('findManager' => $findManager,'tipoEntidad'=>$tipoentidad);
    }    
    

    /**
     * @Route("/{id}/editda/{section}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Nombre","order_status"=1}, name="entidad_datosadicionales")
     * @Template()
     */
    public function datosadicionalesAction(Request $request,Entidad $entidad,$section, $page,$resultpage,$order_col,$order_status)
    {
        // Cargar Variables Iniciales
        $usuario = $this->getUser();
        //$section = "DatosAdicionales";
        $em = $this->getDoctrine()->getManager();
        $estudio = $usuario->getEstudio();
       // $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
       // $entidad = $repository->find($id);        
        if(!$entidad){
            echo "No hay entidad";
            //die();
        }
        
        // ALGUIEN HIZO CLIC EN EL BOTÓN GUARDAR!
        $nombre = $request->request->get("nombre","");
        $valor = $request->request->get("valor","");
        if($nombre != "" && $valor != ""){
            $data = new DatosAdicionales();
            $data->setEntidad($entidad);
            $data->setExpediente(null);
            $data->setEstudio($estudio);
            $data->setNombre($nombre );
            $data->setValor($valor);
            $em->persist($data);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('save_ok') );
        }elseif($nombre!="" || $valor!=""){
            $this->get('session')->getFlashBag()->add('alert', "Faltan datos para completar la operación" );
        }
        
        
        // 1. Crear el Query del Listado.
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :id_estudio and e.Entidad = :entidad")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio, "entidad"=>$entidad))
            ->from('AppBundle:DatosAdicionales','e');
        
        
        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("Datos Adicionales")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('entidad_datosadicionales_delete', array('id'=> 'getId')),
                        'value' => '<span class="glyphicon glyphicon-trash"></span>'
                        )
            )
            ->addColumn('Nombre', 'nombre',array('allow_order'=>'1'))
            ->addColumn('Valor', 'valor',array('allow_order'=>'0'))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);
        $parameters = json_encode(array('id' => $entidad->getId(), "section"=>$section));
        

        
//      3. Muestra de los datos
        return array('list' => $list,'request'=>$request,'codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo(),
            'section' => $section,'entidad'=>$entidad->getId(), 'entidad' => $entidad, 'parameters'=>$parameters, 'tipoEntidad'=>$entidad->getTipoEntidad());
        
    }
    
    
/**
     * @Route("/casosrelacionados/{id}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Entidad","order_status"=1}, name="entidad_casosrelacionados_list")
     * @Template()
     */
    public function casosrelacionadoslistAction($id, Request $request, $page,$resultpage,$order_col,$order_status)
    {
        // Cargar Variables Iniciales
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
        $entidad = new Entidad();
        $section = "CasosRelacionados";
        $entidad = $repository->find($id);
        $tipo = $entidad->getTipoEntidad();
        $tipoCodigo = $tipo->getCodigo();
        //$tipo = strtoupper($entidad->getTipo()->getCodigo());

        
        
        // 1. Crear el Query del Listado.
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :id_estudio and e.Entidad = :Entidad")
            ->groupBy('e.Expediente')
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio, "Entidad"=>$entidad));
            
        
        if($tipoCodigo == "ABOGADO" && $tipo->getEsp() == 1){
            $queryBuilder->from('AppBundle:ExpedienteAbogado','e');
        }else{
            $queryBuilder->from('AppBundle:ExpedienteInterviniente','e');
        }
        
//        // 2. Usar los filtros y la búsqueda
//        $findManager = $this->get('legalPro_commonBundle_FindManager');
//        $entityfind = new EntidadFindType;
//        $findManager = $entityfind->getParameters($request, $queryBuilder,$findManager);
//        $findManager->showFilters($this,$queryBuilder,true);
        

        
        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('expediente_show', array('id'=> 'getExpedienteId')),
                         'value' => '<span style="color:blue" class="glyphicon glyphicon-eye-open"></span></a>',
                        )
            )
            ->addColumn('Expediente', 'expedientenumerocompleto',array('allow_order'=>'0'))
            ->addColumn('Caratula', 'expedientecaratula',array('allow_order'=>'0'))

            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);
        
        
//      3. Muestra de los datos
        //return array('list' => $list,'request'=>$request, "entidad");
        return array('list' => $list,'request'=>$request,'tipoEntidad' => $entidad->getTipoEntidad(), 'parameters' => null, "entidad"=>$entidad, "section"=>$section);
    }    
    
    
    /**
     * @Route("/list/{codigoTipoEntidad}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Entidad","order_status"=1}, name="entidad_list")
     * @Template()
     */
    public function listAction($codigoTipoEntidad,Request $request, $page,$resultpage,$order_col,$order_status)
    {
        try{
            $entidadManager = $this->get('lp_EntidadManager');
            $tipoentidad = $entidadManager->getTipoEntidad($codigoTipoEntidad); 
            $list = $entidadManager->getList($tipoentidad, $order_col, $order_status, $page, $resultpage);
            $parameters = json_encode(array('codigoTipoEntidad' => $codigoTipoEntidad));        
            return array('list' => $list,'request'=>$request,"codigoTipoEntidad" => $codigoTipoEntidad, 'tipoEntidad'=>$tipoentidad,
                         'parameters' => $parameters);            
        }catch(NoExisteEntidadException $ex){
            throw new \Exception("No existe el tipo de entidad", 404,$ex);
        }catch(CheckPermissionException $exp){
            throw new \Exception("No tiene los permisos para ver el listado", 404,$exp);
        }        
    }
    
    /**
     * @Route("/datosadicionales/delete/{id}", name="entidad_datosadicionales_delete")
     * @Template()
     */
    public function deletedatosadicionalesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosAdicionales');
        $datosAdicionales = $repository->find($id);      
        $entidad = $datosAdicionales->getEntidad();
        
        $sql = "delete from dato_adicional where id = " . $id;
        $em->getConnection()->exec($sql);
                
        $this->get('session')->getFlashBag()->add('success', 'Se ha eliminado el dato adicional');   
        return $this->redirectToRoute('entidad_datosadicionales', array("id"=>$entidad->getId(),"section"=>"DatosAdicionales"), 301);
    }    
    
    /**
     * @Route("/{id}/delete/", name="entidad_delete")
     * @Template()
     */
    public function deleteAction(Entidad $entidad)
    {
        try{
            $entidadManager = $this->get('lp_EntidadManager');        
            $entidadManager->doDelete($entidad);
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('entidad_undodelete', array('id' => $entidad->getId())) . '"><span class="glyphicon glyphicon-trash"></span> ' . $entidad->getNombre() . ' ' . $this->get('translator')->trans('eliminado_ok')  .'</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede eliminar la entidad: La entidad no es valida');   
        }catch(CheckPermissionException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede eliminar la entidad: No tiene los permisos');               
        }catch(DeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede eliminar la entidad');               
        }finally{
            return $this->redirectToRoute('entidad_list', array('codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo()), 301);
        }
    }    

    /**
     * @Route("{id}/undodelete/", name="entidad_undodelete")
     * @Template()
     */
    public function undodeleteAction(Entidad $entidad)
    {
       try{
            $entidadManager = $this->get('lp_EntidadManager');        
            $entidadManager->doUndoDelete($entidad);
            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('entidad_show', array('id' => $entidad->getId())) . '"><span class="glyphicon glyphicon-eye-open"></span>  ' . $entidad->getNombre() . ' ' . $this->get('translator')->trans('undelete_ok') .'</a>');   
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede restaurar la entidad: La entidad no es valida');   
        }catch(CheckPermissionException $exp){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede restaurar la entidad: No tiene los permisos');               
        }catch(UndoDeleteException $exd){
            $this->get('session')->getFlashBag()->add('danger', 'No se puede restaurar la entidad');               
        }finally{
            return $this->redirectToRoute('entidad_list', array('codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo()), 301);
        }
    }        
    
    /**
     * @Route("/{id}/show/{section}",defaults={"section" = "General"}, name="entidad_show")
     * @Template()
     */
    public function showAction(Entidad $entidad,$section)
    {
        try{
            if(!$entidad){ throw new NoExisteEntidadException('No existe la entidad'); }
            $entidadManager = $this->get('lp_EntidadManager');
            $form = $entidadManager->getForm($entidad,$section,true,$entidad->getProfesion(),$entidad->getEmpresa());
            switch($section){
                case "DatosAdicionales":
                    return $this->redirectToRoute('entidad_datosadicionales', array('id'=>$entidad->getId(), 'section'=>$section), 301);
                break;
                case "CasosRelacionados":
                    return $this->redirectToRoute('entidad_casosrelacionados_list', array('id'=>$entidad->getId(), 'section'=>$section), 301);
                break;   
            }
            $cancelPath = $this->generateUrl('entidad_show', array('id' => $entidad->getid(), 'section' => $section));
            $editPath = $this->generateUrl('entidad_edit', array('id' => $entidad->getid(), 'section' => $section));
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($entidad->getNombre())
                    ->setForm($form->createView())
                    ->setCancelPath($cancelPath)
                    ->setEditPath($editPath)
                    ->setOperation(AbmManager::abm_ope_show);
            return array('abmManager' => $abmManager, "section"=>$section, 'entidad'=>$entidad,
                'codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo());
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La entidad es invalida');   
            return $this->redirectToRoute('entidad_list', array('codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo()), 301);
        }catch(CheckPermissionException $exp){
            throw new \Exception("No tiene los permisos para mostrar esta entidad", 404,$exp);
        }
    }
    
    
         
    /**
     * @Route("/{id}/edit/{section}",defaults={"section" = "General"}, name="entidad_edit")
     * @Template()
     */
    public function editAction(Request $request,Entidad $entidad,$section)
    {
        try{
            if(!$entidad){ throw new NoExisteEntidadException('No existe la entidad');}
            $entidadManager = $this->get('lp_EntidadManager');
            $section = strtoupper($section);
            $form = $entidadManager->getForm($entidad,$section,false,$entidad->getProfesion(),$entidad->getEmpresa());
            switch($section){
                case "DatosAdicionales":
                    return $this->redirectToRoute('entidad_datosadicionales', array('id'=>$entidad->getId(), 'section'=>$section), 301);
                break;
            }
            $form->handleRequest($request);
            if($form->isValid()) {
                $entidad = $entidadManager->doEdit($form, $section);
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('save_ok') );
                return $this->redirectToRoute('entidad_show', array('id'=>$entidad->getId(), 'section'=>$section), 301);
            }
            $cancelPath = $this->generateUrl('entidad_show', array('id' => $entidad->getid(), 'section' => $section));        
            $abmManager = $this->get('ABM_AbmManager')
                    ->setTitle($entidad->getNombre())
                    ->setForm($form->createView())
                    ->setCancelPath($cancelPath)
                    ->setOperation(AbmManager::abm_ope_modify);
            return array('abmManager' => $abmManager , 'entidad'=>$entidad,'codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo(),
                         'section'=>$section);
        }catch(ValidateException $exv){
            $this->get('session')->getFlashBag()->add('danger', 'La entidad es invalida');   
            return $this->redirectToRoute('entidad_list', array('codigoTipoEntidad'=>$entidad->getTipoEntidad()->getCodigo()), 301);
        }catch(CheckPermissionException $exp){
            throw new \Exception("No tiene los permisos para mostrar esta entidad", 404,$exp);
        }
    }
}

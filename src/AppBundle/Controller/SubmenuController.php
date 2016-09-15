<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entidad;
use AppBundle\Entity\Expediente;
use AppBundle\Services\MenuGenerator\MenuGenerator;
use AppBundle\Services\MenuGenerator\MenuParent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;





class SubmenuController extends Controller
{   
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVestudioCuentaAction()
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading('Estudio')
                ->addSection('general', $this->generateUrl('estudio_show',array("section"=>"general")),$this->get('translator')->trans('sec_estudio_general'))
                ->addSection('direcciones', $this->generateUrl('estudio_show',array("section"=>"direcciones")),$this->get('translator')->trans('sec_estudio_direcciones'))
                ->addSection('cuenta', $this->generateUrl('estudio_cuenta',array()),$this->get('translator')->trans('sec_estudio_cuenta')) 
                ->setActive("cuenta");
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function estudioCuentaAction($section ='',$estudio=null)
    {
//        $submenu = new MenuGenerator();
        return array();
    }
    
    /**********************ESTUDIO****************************/
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVestudioShowAction($section ='')
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading('Estudio')
                ->addSection('general', $this->generateUrl('estudio_show',array("section"=>"general")),$this->get('translator')->trans('sec_estudio_general'))
                ->addSection('direcciones', $this->generateUrl('estudio_show',array("section"=>"direcciones")),$this->get('translator')->trans('sec_estudio_direcciones'))
                ->addSection('cuenta', $this->generateUrl('estudio_cuenta',array("section"=>"cuenta")),$this->get('translator')->trans('sec_estudio_cuenta'))                 
                ->setActive($section);
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function estudioShowAction($section ='')
    {
//        $submenu = new MenuGenerator();
        return array();
    }
    /**********************USER_LIST****************************/
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVuserListAction($active ='')
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading('Listado de Usuarios');
        return array('submenu' => $submenu);
    }
    
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function userListAction($active ='')
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading('Usuarios')
//                ->addSection('datos_de_estudio', $this->generateUrl('estudio_show'), /*'<span class="glyphicon glyphicon-pencil"></span>*/' Datos del estudio')
                ->addSection('nuevo', $this->generateUrl('user_new'),$this->get('translator')->trans('boton_new'))
                ->setActive($active);
        return array('submenu' => $submenu);
    }
    
    /**********************USER_SHOW****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVuserShowAction($active ='', $user=null)
    {
        
        $submenu = new MenuGenerator();
        if($user){
            $submenu->setHeading($user->getNombre())
                    ->setCategory("Usuarios")
                    ->addSection('general', $this->generateUrl('user_show', array('id' => $user->getId(),'section' => 'general')),$this->get('translator')->trans('sec_user_general'))
                    ->addSection('grupos', $this->generateUrl('user_show', array('id' => $user->getId(),'section' => 'grupos')),$this->get('translator')->trans('sec_user_rolesygrupos'))
                    ->setActive($active);
        }
        return array('submenu' => $submenu);
    }    
    
    /**********************USER_SHOW****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function userShowAction($active ='', $user=null)
    {
        
        $submenu = new MenuGenerator();
        if($user){
            $submenu->setHeading('Acciones')
                    ->addSection('list_entidad', $this->generateUrl('user_list'), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado') )
                    ->setActive($active);
        }
        return array('submenu' => $submenu);
    }

       /**********************USER_NEW****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVuserNewAction()
    {
        
        $submenu = new MenuGenerator();      
        $submenu->setHeading("Nuevo Usuario")
                ->setCategory("Usuarios");
        return array('submenu' => $submenu);
    }    
    
    /**********************USER_NEW****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function userNewAction()
    {
        
        $submenu = new MenuGenerator();
        $submenu->setHeading('Acciones')
                ->addSection('list_entidad', $this->generateUrl('user_list'), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado') );

        return array('submenu' => $submenu);
    }
    

    /**********************USER_SHOW_GROUPS****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVuserShowGroupsAction($active ='', $user=null)
    {
        
        $submenu = new MenuGenerator();
        if($user){
            $submenu->setHeading($user->getNombre())
                    ->setCategory("Usuarios")
                    ->addSection('general', $this->generateUrl('user_show', array('id' => $user->getId(),'section' => 'general')),$this->get('translator')->trans('sec_user_general'))
                    ->addSection('grupos', $this->generateUrl('user_show', array('id' => $user->getId(),'section' => 'grupos')),$this->get('translator')->trans('sec_user_rolesygrupos'))
                    ->setActive("grupos");
        }
        return array('submenu' => $submenu);
    }
    
    /**********************USER_SHOW_GROUPS****************************/    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function userShowGroupsAction($active ='', $user=null)
    {
        
        $submenu = new MenuGenerator();
        if($user){
            $submenu->setHeading($this->get('translator')->trans('sec_acciones'))
                    ->addSection('copiarGrupos', $this->generateUrl('user_show', array('id' => $user->getId(),'section' => 'grupos')),$this->get('translator')->trans('sec_user_copiargrupos'))
                    ->setActive($active);
        }
        return array('submenu' => $submenu);
    }
    
    /************************PROFILE******************************/
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function profileAction($active ='')
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading($this->get('translator')->trans('sec_miperfil'))
                ->addSection('datos_de_cuenta', $this->generateUrl('fos_user_profile_show'), $this->get('translator')->trans('sec_user_datoscuenta'))
                ->addSection('roles_grupos', '', $this->get('translator')->trans('sec_user_rolesgrupos'))
                ->setActive($active);
        return array('submenu' => $submenu);
    }
    
    
    /**********************ENTIDADES****************************/
    

    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVentidadListAction($active ='', $tipoEntidad = null)
    {
        
        $submenu = new MenuGenerator();
        $submenu->setHeading("Listado");
        return array('submenu' => $submenu);
    }        
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */    
    public function entidadAction($section,$entidad=null,$tipoEntidad = null,$buttons=null){
        $parentmenu = new MenuParent();
        $submenu2 = null;$submenu3 = null;
        
        $submenu = new MenuGenerator();
        $submenu->setHeading($tipoEntidad->getNombre());
        
        //AGREGAR VOLVER AL LISTADO
        if(strtoupper($section)!="LIST"){
            $submenu->addSection('list_entidad', $this->generateUrl('entidad_list', array('tipo'=> $tipoEntidad->getCodigo())), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
        }        
        switch(strtoupper($section)){
            case "LIST":
                $submenu->addSection('nuevo', $this->generateUrl('entidad_new', array('tipo' => $tipoEntidad->getCodigo())),'<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));
                $submenu->setHeading($this->get('translator')->trans('sec_acciones'))
                    ->addSection('find', $this->generateUrl('entidad_find', array('tipo' => $tipoEntidad->getCodigo())),'<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find'));               
            break;
            case "FIND":
            break;
            case "NEW":
            break;
            case "SHOW":
            break;
            case "DATOSADICIONALES":
            break;
        }
        
        if($entidad!=null){
            $submenu->addSection('eliminar_entidad', $this->generateUrl('entidad_delete', array('id'=> $entidad->getId(),'action'=>1,  'section'=> 1)), '<span class="glyphicon glyphicon-trash" style="color:red"></span> ' . $this->get('translator')->trans('boton_eliminar'));
        }

        $submenu3 = $this->AddButtonsToMenu($buttons);
        
        if($submenu!=null) {$parentmenu->addMenu(0, $tipoEntidad->getNombre(), $submenu);}
        if($submenu2!=null){$parentmenu->addMenu(1, "Operaciones", $submenu2);}
        if($submenu3!=null){$parentmenu->addMenu(1, "Acciones", $submenu3);}
        
        return array('parentMenu' =>$parentmenu);        
    }
    
    function AddButtonsToMenu($buttons){
        $submenu3 = null;
        if($buttons!=null){
            if($submenu3== null){
                $submenu3 = new MenuGenerator();
                $submenu3->setHeading("Acciones");
            }
            $cant = 0;
            foreach($buttons as $button){
                if($button->getMenuVisible()){
                    $submenu3->addSection($button->getName(), $button->getRoute(),  $button->getLabel());
                    $cant = $cant +1;
                }
            }
        }else{
            return $submenu3;
        }
        if($cant == 0){return null;}
        return $submenu3;
    }
    
    /* ENTIDAD FIND */
    
/**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVentidadFindAction($tipoEntidad)
    {
        if($tipoEntidad){
            $submenu = new MenuGenerator();
            $submenu->setHeading("Búsqueda de " . $tipoEntidad->getNombre());
            $submenu->setCategory($tipoEntidad->getNombre());
        }
        return array('submenu'=>$submenu);
    }
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVentidadNewAction($tipoEntidad)
    {
        if($tipoEntidad){
            $submenu = new MenuGenerator();
            $submenu->setHeading("Nuevo");
            $submenu->setCategory($tipoEntidad->getNombre());
        }
        return array('submenu'=>$submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVentidadDatosAdicionalesAction($entidad)
    {
        $tipoEntidad= $entidad->getTipoEntidad();
        $id = $entidad->getId();
        $section = "datosadicionales";
        
        if($tipoEntidad){
            $submenu = $this->generateNavMenuEntidad($id,$section,$entidad,$tipoEntidad);
            $submenu->setActive($section);
        }
        return array('submenu'=>$submenu);
    }
    
    
    public function generateNavMenuEntidad($id,$section,$entidad, $tipoEntidad){
        $submenu = new MenuGenerator();
        $submenu->setHeading($entidad->getNombre());
        $submenu->addSection("general", $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'General')), $this->get('translator')->trans('sec_entidad_general'));
        $submenu->addSection('contacto', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Contacto')), $this->get('translator')->trans('sec_entidad_contacto'));
        $submenu->addSection('direccion', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Direccion')), $this->get('translator')->trans('sec_entidad_direccion'));
        if($tipoEntidad->getCodigo() != "ABOGADO"){
            $submenu->addSection('laboral', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Laboral')), $this->get('translator')->trans('sec_entidad_laboral'));
        }    

        $submenu->addSection('observaciones', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Observaciones')), $this->get('translator')->trans('sec_entidad_observaciones'));
        $submenu->addSection('datosadicionales', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'DatosAdicionales')), $this->get('translator')->trans('sec_entidad_datosadicionales'));
        $submenu->addSection('movimientos', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Movimientos')), $this->get('translator')->trans('sec_entidad_movimientos'));
        $submenu->addSection('documentos', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'Documentos')), $this->get('translator')->trans('sec_entidad_documentos'));
        if($tipoEntidad->getCodigo() != "ABOGADO"){
            $submenu->addSection('cc', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'CuentaCorriente')), $this->get('translator')->trans('sec_entidad_cuentacorriente'));
        }
        $submenu->addSection('casos_relacionados', $this->generateUrl('entidad_show', array('id'=> $id, 'section' => 'CasosRelacionados')), $this->get('translator')->trans('sec_entidad_casosrelacionados'));
        $submenu->setCategory($entidad->getTipoEntidad()->getNombre());

        switch(strtolower ($section)){
            case "casosrelacionados":
                $submenu->setActive("casos_relacionados");
            break;
        }
        
        
        return $submenu;
    }
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVentidadEditAction($active ='', Entidad $entidad = null,$section = "General",$subtitulo = "")
    {
        $id = $entidad->getId();
        $tipoEntidad = $entidad->getTipoEntidad();
        $submenu = new MenuGenerator();
        switch ($section){
            case "General":
                $active = 'general';
            break;
            case "Contacto":
                $active = "contacto";
            break;
            case "Direccion":
                $active = 'direccion';
            break;
            case "Laboral":
                $active = 'laboral';
                break;
            case "Observaciones":
                $active = 'observaciones';
                break;
            case "DatosAdicionales":
                $active = 'datosadicionales';
                break;
            case "CasosRelacionados":
                $active = "casos_relacionados";
                break;
        }
        
        if($tipoEntidad){
            $submenu = $this->generateNavMenuEntidad($id,$section,$entidad,$tipoEntidad);
            $submenu->setActive($active);
        }
        return array('submenu' => $submenu);
    }     
    
    /**********************AGENDA****************************/
    
     /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function agendaAction($seccion = "Agenda", $seccion2="", $buttons = null,$request = null)
    {
        $parentmenu = new MenuParent();
        $submenu = new MenuGenerator(); $submenu2 = null;$submenu3=null;
        $submenu->setHeading('<span class="glyphicon glyphicon-calendar"></span>   ' . 'Agenda');
        // Cargar los defaults
        switch (strtoupper($seccion)){
            case "FIND":
                $submenu->addSection('agenda_list', $this->generateUrl('agenda_list', array("tipo"=>2)), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
            break;
            case "NEW":
                $submenu->addSection('agenda_list', $this->generateUrl('agenda_list', array("tipo"=>2)), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
            break;
            DEFAULT:
                $submenu->addSection('agenda_nuevo', $this->generateUrl('agenda_new'),'<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));                    
                $submenu->addSection('expediente_find', $this->generateUrl('expediente_find'), '<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find'));        
            break;
        }
        
        
//        $submenu3 = $this->AddButtonsToMenu($buttons);
        
        if($submenu!=null){$parentmenu->addMenu(0, "Caso", $submenu);}
        if($submenu2!=null){$parentmenu->addMenu(1, "Operaciones", $submenu2);}
        if($submenu3!=null){$parentmenu->addMenu(2, "Acciones", $submenu3);}
        
        
        return array('parentMenu' =>$parentmenu);
    }
    
    
    
    /**********************EXPEDIENTES****************************/

    // NAV--- MENU
    
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVExpedienteAction($active ='', $expediente = null,$seccion = "General", $route = "",$route_params="")
    {
        if($expediente == null){
            $submenu = new MenuGenerator();
            $submenu->setHeading($this->get('translator')->trans('expedientes'));
        }else{
            $id = $expediente->getId();
            $submenu = $this->getExpedienteMenu($expediente,$seccion, $route,$route_params);
        }
        return array('submenu' => $submenu);
    }
    

    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function expedienteAction($expediente = null,$seccion = "General", $seccion2="", $buttons = null,$request = null)
    {
        $parentmenu = new MenuParent();
        $submenu = new MenuGenerator(); $submenu2 = null;$submenu3=null;
        $submenu->setHeading('<span class="glyphicon glyphicon-file"></span>   ' . 'Caso');
        
        // Cargar los defaults
        switch (strtoupper($seccion)){
            case "FIND":
                $submenu->addSection('expediente_list', $this->generateUrl('expediente_list', array()), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
            break;
            case "NEW":
                $submenu->addSection('expediente_list', $this->generateUrl('expediente_list', array()), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
            break;
            DEFAULT:
                if($expediente==null){
                    $submenu->addSection('expediente_nuevo', $this->generateUrl('expediente_new'),'<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));            
                    $submenu->addSection('expediente_find', $this->generateUrl('expediente_find', $request->query->all()), '<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find'));
                }else{
                    $submenu->addSection('expediente_list', $this->generateUrl('expediente_list', array()), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
                    $submenu->addSection('eliminar_expediente', $this->generateUrl('expediente_delete', array('id'=> $expediente->getId())),'<span class="glyphicon glyphicon-trash" style="color:red"></span> ' . $this->get('translator')->trans('boton_eliminar'));
                }                
            break;
        }
        
        if($expediente!=null){
            $submenu2 = new MenuGenerator();
            $submenu2->setHeading($seccion);
            switch (strtoupper($seccion)){
                case "GENERAL"; default:
                break;
                case "TIPODEPROCESO":
                    
                break;
                case "ABOGADOS":
                    if(strtoupper($seccion2)=="LIST"){
                        $submenu2->addSection('expediente_abogados_new', $this->generateUrl('expediente_abogados_new', array("id"=>$expediente->getId())), '<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));
                    }
                break;
                case "ACTUACIONES":
                    if(strtoupper($seccion2)=="LIST"){
                        $submenu2->addSection('expediente_abogados_new', $this->generateUrl('expediente_actuaciones_new', array("id"=>$expediente->getId())), '<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));
                        $submenu2->addSection('expediente_find_actu', $this->generateUrl('expediente_find', array()), '<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find') . ' ' .  $this->get('translator')->trans('sec_exp_actuaciones'));
                    }
                break;
                case "INTERVINIENTES":
                    if(strtoupper($seccion2)=="LIST"){
                        $submenu2->addSection('expediente_intervinientes_new', $this->generateUrl('expediente_intervinientes_new', array("id"=>$expediente->getId())), '<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));
                        $submenu2->addSection('expediente_find_exp', $this->generateUrl('expediente_find', array()), '<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find'));
                    }
                break;
                case "VINCULADOS":
                    if(strtoupper($seccion2)=="LIST"){
                        $submenu2->addSection('expediente_vinculados_new', $this->generateUrl('expediente_vinculados_new', array("id"=>$expediente->getId())), '<span class="glyphicon glyphicon-plus"></span> ' . $this->get('translator')->trans('boton_new'));
                        $submenu2->addSection('expediente_find_exp', $this->generateUrl('expediente_find', array()), '<span class="glyphicon glyphicon-search"></span> ' . $this->get('translator')->trans('boton_find'));
                    }                    
                break;
                case "DOCUMENTOS":
                break;
            }
        }else{
            switch (strtoupper($seccion)){
                case "FIND":
                    $submenu->addSection('expediente_list', $this->generateUrl('expediente_list', array()), '<span class="glyphicon glyphicon-th"></span> ' . $this->get('translator')->trans('boton_listado'));
                break;
            }
        }
        
        $submenu3 = $this->AddButtonsToMenu($buttons);
        
        if($submenu!=null){$parentmenu->addMenu(0, "Caso", $submenu);}
        if($submenu2!=null){$parentmenu->addMenu(1, "Operaciones", $submenu2);}
        if($submenu3!=null){$parentmenu->addMenu(2, "Acciones", $submenu3);}
        
        
        return array('parentMenu' =>$parentmenu);
    }
    
    // Se crea de esta forma para poder reutilizarlo, devuelve un MenuGenerator
    public function getExpedienteMenu(Expediente $expediente, $seccion,$route = "", $route_params=null){
        $id = $expediente->getId();
        $submenu = new MenuGenerator();
        $submenu->setHeading($this->get('translator')->trans('expediente'))
                ->addSection('datos_expediente', $this->generateUrl('expediente_show', array('id'=> $id,  'seccion'=> 'General')), '<span class="glyphicon glyphicon-th-large"></span>   ' . $this->get('translator')->trans('sec_exp_general'))
                ->addSection('tipodeproceso', $this->generateUrl('expediente_tipodeproceso_showedit', array('id'=> $id,'ope'=>'show')),'<span class="glyphicon glyphicon-text-width"></span>   ' . $this->get('translator')->trans('sec_exp_tipoproceso'));
//                ->addSection('actuaciones_expediente', $this->generateUrl('expediente_show', array('id'=> $id, 'seccion'=> 'Actuaciones')),'<span class="glyphicon glyphicon-list"></span>   ' . $this->get('translator')->trans('sec_exp_actuaciones'))
//                ->addSection('intervinientes_expediente', $this->generateUrl('expediente_show', array('id'=> $id, 'seccion'=> 'Intervinientes')),'<span class="glyphicon glyphicon-user"></span>   ' . $this->get('translator')->trans('sec_exp_intervinientes'))                    
//                ->addSection('documentos_expediente', $this->generateUrl('expediente_documentos_list', array('expedienteid'=> $id)), '<span class="glyphicon glyphicon-save-file"></span>   ' . $this->get('translator')->trans('sec_exp_documentos'))                    
//                ->addSection('abogados_expediente', $this->generateUrl('expediente_show', array('id'=> $id, 'seccion'=> 'Abogados')), '<span class="glyphicon glyphicon-education"></span>   ' . $this->get('translator')->trans('sec_exp_abogados_asociados'))
//                ->addSection('vinculado_expediente', $this->generateUrl('expediente_show', array('id'=> $id, 'seccion'=> 'Vinculados')), '<span class="glyphicon glyphicon-pushpin"></span>   ' . $this->get('translator')->trans('sec_exp_vinculado'))
//                ->addSection('calendario_expediente', $this->generateUrl('agenda_exp_list', array('id'=> $id)), '<span class="glyphicon glyphicon-calendar"></span>   ' .$this->get('translator')->trans('sec_exp_calendario'));
                
                if (strtoupper($seccion) == "GENERAL"){
                    $maximized = 1; 
                }else{
                    $maximized = 0;
                }
               $submenu->setRichFormat("AppBundle:Expediente:Expediente\cabecera.html.twig", array("obj"=>$expediente, "maximized"=>$maximized, "route"=>$route,"route_params"=>$route_params)); 
//               $submenu->setRichFormat("ExpedienteBundle:Frontend:cabecera.html.twig", array("obj"=>$expediente, "maximized"=>$maximized, "route"=>$route,"route_params"=>$route_params));
//                ->setHeading($expediente->getNumeroCompleto())
//                ->setSubHeading($expediente->getCaratula())
//                ->setCategory($this->get('translator')->trans('expediente'));
        
        
        switch (strtoupper($seccion)){
            case "GENERAL"; default:
                $submenu->setActive("datos_expediente");
            break;
            case "ACTUACIONES":
                $submenu->setActive("actuaciones_expediente");
            break;
            case "INTERVINIENTES":
                $submenu->setActive("intervinientes_expediente");
            break;
            case "DOCUMENTOS":
                $submenu->setActive("documentos_expediente");
            break;
            case "TIPODEPROCESO":
                $submenu->setActive("tipodeproceso");
            break;
            case "ABOGADOS":
                $submenu->setActive("abogados_expediente");
            break;        
            case "VINCULADOS":
                $submenu->setActive("vinculado_expediente");
            break;
            case "AGENDA":
                $submenu->setActive("calendario_expediente");
            break;                
        }        
        
        
        return $submenu;
    }
    

    /***** EXPEDIENTE FAVORITOS!!
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function ExpedienteFavoritoAction()
    {
        $parentmenu = new MenuParent();
        $submenu = new MenuGenerator();
        $submenu->setHeading("Acciones")
                ->addSection('tipoentidad_list', $this->generateUrl('alerta_todovisto', array()), '' . ' ' . $this->get('translator')->trans('boton_visto'))
                ->setActive("");
        $parentmenu->addMenu(0, "Favoritos", $submenu);
        return array('parentMenu'=>$parentmenu);
    }    
    
    
    
    
    /**********************TIPO DE ENTIDADES****************************/
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVtipoEntidadesAction($active ='')
    {
        
        $submenu = new MenuGenerator();
        $submenu->setHeading($this->get('translator')->trans('sec_tipoentidades_otrascategorias'));
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function tipoEntidadesAction($active ='')
    {
        
        $submenu = new MenuGenerator();

        $submenu->setHeading($this->get('translator')->trans('sec_tipoentidades_otrascategorias'))
                ->addSection('nueva_categoria', $this->generateUrl('tipoentidad_new'), $this->get('translator')->trans('boton_new'))
                ->setActive($active);

        return array('submenu' => $submenu);
    }
 
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVtipoEntidadesNewAction()
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading("Nuevo");
        $submenu->setCategory("Tipo de Entidad");
        return array('submenu'=>$submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function tipoEntidadesNewAction()
    {
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('tipoentidad_list', $this->generateUrl('tipoentidad_list', array()), '<span class="glyphicon glyphicon-th"></span>' . $this->get('translator')->trans('boton_listado'))
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVtipoEntidadesEditAction($active ='', $tipoEntidad = null,$section = 1)
    {
        $id = $tipoEntidad->getId();
        $submenu = new MenuGenerator();
        switch ($section){
            case "General"; default:
                $active = "General";
            break;
        }
        
        $submenu->setHeading($tipoEntidad->getNombre())
                ->addSection('General', $this->generateUrl('tipoentidad_show', array('id'=> $id, 'section'=> 'General')),  $this->get('translator')->trans('sec_tipoentidades_general'))
                ->setActive($active);
        $submenu->setCategory("Tipo de Entidad");         
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function tipoEntidadesEditAction($active ='', $tipoEntidad = null,$section = 1)
    {
        $id = $tipoEntidad->getId();
        
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('tipoentidad_list', $this->generateUrl('tipoentidad_list', array()), '<span class="glyphicon glyphicon-th"></span>' .' ' . $this->get('translator')->trans('boton_listado'))
                ->addSection('eliminar_entidad', $this->generateUrl('tipoentidad_delete', array('id'=> $id,'action'=>1,  'section'=> 1)), '<span class="glyphicon glyphicon-trash"></span>' . ' ' . $this->get('translator')->trans('boton_eliminar'))
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }
    
    
    /**************************************************************************/
    /* ALERTAS */
    /**************************************************************************/

    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVAlertaListAction()
    {
        $submenu = new MenuGenerator();
        $submenu->setHeading("Listado de Alertas");
        return array('submenu'=>$submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function AlertaListAction()
    {
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('tipoentidad_list', $this->generateUrl('alerta_todovisto', array()), '' . ' ' . $this->get('translator')->trans('boton_visto'))
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }

    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVAlertaEditAction($alerta)
    {
        $id = $alerta->getId();
        $submenu = new MenuGenerator();
        $submenu->setHeading($alerta->getNombre());
        $submenu->setCategory("Ver Alerta");
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function AlertaEditAction($alerta)
    {
        $id = $alerta->getId();
        $submenu = new MenuGenerator();
        $submenu->setHeading($this->get('translator')->trans('sec_alertas'));        
        $submenu->addSection('list_alerta', $this->generateUrl('alerta_list', array()), '<span class="glyphicon glyphicon-th"></span>' . ' ' .  $this->get('translator')->trans('boton_listado'));
                        
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))

                ->addSection('eliminar_alerta', $this->generateUrl('alerta_delete', array('id'=> $id)), '<span class="glyphicon glyphicon-trash"></span>' . ' ' .  $this->get('translator')->trans('boton_eliminar'))
                ->setActive("");            
        return array('submenu' => $submenu,'submenu2'=>$submenu2);
    }
    
    
    /**************************************************************************/
    /* EXPEDIENTE ACTUACIONES
    /**************************************************************************/
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVExpedienteActuacionesListAction($expediente)
    {
        $submenu = $this->getExpedienteMenu($expediente,"Actuaciones");
        return array('submenu'=>$submenu);
    }

    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function ExpedienteActuacionesListAction($expediente)
    {
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('documento_nuevodocumento', $this->generateUrl('expediente_documentos_new_file', array("expedienteid"=>$expediente->getId(), "tipo"=>"pc")), '<span class="glyphicon glyphicon-plus"></span>' . ' ' . "Nuevo Documento")
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }

    
    
    
    
    /**************************************************************************/
    /* DOCUMENTOS */
    /**************************************************************************/

    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVDocumentoListAction($expediente)
    {
        $submenu = $this->getExpedienteMenu($expediente,"Documentos");
        $submenu->setCategory("Listado de Documentos");
        return array('submenu'=>$submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function DocumentoListAction($expediente)
    {
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('documento_nuevodocumento', $this->generateUrl('expediente_documentos_new_file', array("expedienteid"=>$expediente->getId(), "tipo"=>"pc")), '<span class="glyphicon glyphicon-plus"></span>' . ' ' . "Nuevo Documento")
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }

    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVDocumentoNewAction($expediente)
    {
        $submenu = $this->getExpedienteMenu($expediente,"documentos_expediente");
        $submenu->setCategory("Crear Nuevo Documento");

        return array('submenu'=>$submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function DocumentoNewAction($expediente)
    {
        //$submenu = $this->getExpedienteMenu($expediente);
        //$submenu->setActive("documentos_expediente");
        
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('listado_file', $this->generateUrl('expediente_documentos_list', array('expedienteid'=> $expediente->getId())), '<span class="glyphicon glyphicon-th"></span>' . ' ' .  "Documentos")
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }

    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVDocumentoUploadAction($expediente)
    {
        $submenu = $this->getExpedienteMenu($expediente,"documentos_expediente");
        $submenu->setCategory("Subir Cambios realizados");
        return array('submenu'=>$submenu);
    }
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function DocumentoUploadAction($expediente)
    {
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
                ->addSection('listado_file', $this->generateUrl('expediente_documentos_list', array('expedienteid'=> $expediente->getId())), '<span class="glyphicon glyphicon-th"></span>' . ' ' .  "Documentos")
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }
    
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVDocumentoEditAction($documento,$expediente)
    {
        $id = $documento->getId();
        $submenu = $this->getExpedienteMenu($expediente,"documentos_expediente");
        $submenu->setCategory("Editar Documento");
        
        
        return array('submenu' => $submenu);
    }
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function DocumentoEditAction($documento,$expediente)
    {
        $id = $documento->getId();
        
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_documento'))
                ->addSection('listado_file', $this->generateUrl('expediente_documentos_list', array('expedienteid'=> $expediente->getId())), '<span class="glyphicon glyphicon-th"></span>' . ' ' .  "Documentos")
                ->addSection('download_file', $this->generateUrl('expediente_documentos_download_file', array('documentoid'=> $id)), '<span class="glyphicon glyphicon-floppy-save"></span>' . ' ' .  $this->get('translator')->trans('boton_descargar'))
                ->addSection('versiones_file', $this->generateUrl('expediente_documentos_listversion', array('documentoid'=> $id)), '<span class="glyphicon glyphicon-tasks"></span>' . ' ' .  $this->get('translator')->trans('boton_versiones'))
//                ->addSection('auditoria_file', $this->generateUrl('expediente_documentos_auditoria', array('documentoid'=> $id)), '<span class="glyphicon glyphicon-list-alt"></span>' . ' ' .  $this->get('translator')->trans('boton_auditoria'))
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }
    
    
    /**
    * @Template("CommonBundle:MenuGenerator:subnav.html.twig")
    */
    public function NAVDocumentoVersionesListAction($documento,$expediente)
    {
        $id = $documento->getId();
        $submenu = $this->getExpedienteMenu($expediente,"documentos_expediente");
        $submenu->setCategory("Versiones de " . $documento->getNombre());
                
        return array('submenu' => $submenu);
    }  
    
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function DocumentoVersionesListAction($documento,$expediente)
    {
        $id = $documento->getId();
        $submenu2 = new MenuGenerator();
        $submenu2->setHeading($this->get('translator')->trans('sec_documento'))
                ->addSection('volver_file', $this->generateUrl('expediente_documentos_show', array('documentoid'=> $id)), '<span class="glyphicon glyphicon-file"></span>' . ' ' .  $this->get('translator')->trans('boton_volverdocumento'))
                ->setActive("");            
        return array('submenu2'=>$submenu2);
    }
    /**
    * @Template("CommonBundle:MenuGenerator:submenu.html.twig")
    */
    public function plantillaAction($active ='')
    {
        
        $submenu = new MenuGenerator();
            $submenu->setHeading('Plantillas')
                    ->addSection('nuevo', $this->generateUrl('plantilla_new'),$this->get('translator')->trans('boton_new'))
                    ->setActive($active);
//            $submenu2 = new MenuGenerator();
//            $submenu2->setHeading($this->get('translator')->trans('sec_acciones'))
//                    ->addSection('find', $this->generateUrl('entidad_find', array('tipo' => $tipoEntidad->getCodigo())),$this->get('translator')->trans('boton_find'))
//                    ->setActive("");              
//        }
//        return array('submenu' => $submenu,'submenu2'=>$submenu2);
        return array('submenu' => $submenu);
    }    
}

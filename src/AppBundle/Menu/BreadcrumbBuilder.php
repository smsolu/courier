<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
//HACER: poner bien las rutas
class BreadcrumbBuilder extends ContainerAware{
    private $map;
    public function __construct() {
//        HACER: Meter esto en algun config y usarlo para el menu tambien
        $this->map = array(
            'entidades' => null,
            'clientes' => 'entidades',
            'entidadList' => 'entidades',
            'entidadShow' => 'entidadList',
            'tipoEntidadList' => 'entidades',
            'tipoEntidadShow' => 'tipoEntidadList',
            'configuracion' => null,
            'usuarios' => 'estudio',
            'usuarioShow' => 'usuarios',
            'estudio' => null,
            'profile' => null,
            'expediente' => null,
            'expedienteShow' => 'expediente',
            'alerta' => null,
            'alertaShow' => 'alerta',
            'agenda' => null,
            'agendaShow' => 'agenda',
            'plantilla' => null,
            'tipoCuentasContables' => null,
        );
//        HACER: que se ejecute siempre si esta en debug
//        $this->isMapOk();
        
    }
    public function homeMenu(FactoryInterface $factory, array $options){
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'breadcrumb'));
        $menu->addChild('Home', array(
            'route' => 'user_list', 
            'label'=>'<span class="glyphicon glyphicon-home"></span>', 
            'extras'=>array(
                'safe_label'=>true
                )
        ));
        return $menu;
    }
  
    public function tipoCuentasContablesMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('tipoCuentasContables');
        $menu = $this->$func($factory, $options);
        $menu->addChild('tipoCuentasContables', array(
            'route' => 'contabilidad_tipocuentas_list',
            'label' => 'Cuentas Contables'
        ));
        return $menu;
    }
     
    public function agendaMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('agenda');
        $menu = $this->$func($factory, $options);
        $menu->addChild('agenda', array(
            'route' => 'agenda_list',
            'routeParameters' => array('tipo' => $options['tipo'], 'fecha1' => $options['fecha1'],'fecha2' => $options['fecha2']),
            'label' => 'Agenda'
        ));
        return $menu;
    }    
    public function agendaShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('agendaShow');
        $menu = $this->$func($factory, $options);
        $menu->addChild('agendaShow', array(
            'route' => 'agenda_show',
            //CONTINUAR
            'routeParameters' => array('tipo' => $options['tipo'], 'fecha1' => $options['fecha1'],'fecha2' => $options['fecha2']),
            'label' => 'Nuevo Evento' 
        ));        
        return $menu;
    }    
    
    public function entidadesMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('entidades');
        $menu = $this->$func($factory, $options);
        $menu->addChild('entidades', array(
            'route' => 'user_list',
            'label' => 'Entidades'
        ));
        return $menu;
    }
    public function tipoEntidadListMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('tipoEntidadList');
        $menu = $this->$func($factory, $options);
        $menu->addChild('tipoEntidadList', array(
            'route' => 'tipoentidad_list',
            'label' => 'Otras categorias'
        ));
        return $menu;
    }
    public function tipoEntidadShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('tipoEntidadShow');
        $menu = $this->$func($factory, $options);
        $menu->addChild('tipoEntidadShow', array(
            'route' => 'tipoentidad_show',
            'routeParameters' => array('id' => $options['tipoEntidad']->getId()),
            'label' => $options['tipoEntidad']->getNombre()
        ));
        
        return $menu;
     }
    public function clientesMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('clientes');
        $menu = $this->$func($factory, $options);
        $menu->addChild('clientes', array(
            'route' => 'entidad_list',
            'routeParameters' => array('codigoTipoEntidad' => 'cliente'),
            'label' => 'Clientes'
        ));
        
        return $menu;
    } 
    public function entidadListMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('entidadList');
        $menu = $this->$func($factory, $options);
        $menu->addChild('entidadList', array(
            'route' => 'entidad_list',
            'routeParameters' => array('codigoTipoEntidad' => $options['tipoEntidad']->getCodigo()),
            'label' => $options['tipoEntidad']->getNombre()
        ));
        
        return $menu;
     }
     public function entidadShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('entidadShow');
        $menu = $this->$func($factory, $options);
        $menu->addChild('entidadShow', array(
            'route' => 'entidad_show',
            'routeParameters' => array('id' => $options['entidad']->getId()),
            'label' => $options['entidad']->getNombre()
        ));
        
        return $menu;
     }
    public function configuracionMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('configuracion');
        $menu = $this->$func($factory, $options);
        $menu->addChild('configuracion', array(
            'route' => 'user_list',
            'label' => 'Configuracion'
        ));
        
        return $menu;
    } 
    public function usuariosMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('usuarios');
        $menu = $this->$func($factory, $options);
        $menu->addChild('usuarios', array(
            'route' => 'user_list',
            'label' => 'Usuarios'
        ));
        
        return $menu;
     }
    public function usuarioShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('usuarioShow');
        $menu = $this->$func($factory, $options);
        $menu->addChild('usuarioShow', array(
            'route' => 'user_show',
            'routeParameters' => array('id' => $options['user']->getId()),
            'label' => $options['user']->getUsername()
        ));
        
        return $menu;
     }
     public function estudioMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('estudio');
        $menu = $this->$func($factory, $options);
        $menu->addChild('estudio', array(
            'route' => 'estudio_show',
            'label' => 'Estudio'
        ));
        
        return $menu;
     }
     public function expedienteMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('expediente');
        $menu = $this->$func($factory, $options);
        $menu->addChild('expediente', array(
            'route' => 'expediente_list',
            'label' => 'Casos'
        ));
        
        return $menu;
     }
     public function expedienteShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('expedienteShow');
        $menu = $this->$func($factory, $options);
        $str = ($options['expediente']->getCaratula());
        $menu->addChild('expedienteShow', array(
            'route' => 'expediente_show',
            'routeParameters' => array('id' => $options['expediente']->getId()),
            //HACER: parametrizar la cantidad de caracteres a mostrar
            'label' => (strlen($str)>50)? substr($str,0, 48)."..": $str
        ));
        
        return $menu;
     }
     public function profileMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('profile');
        $menu = $this->$func($factory, $options);
        $menu->addChild('profile', array(
            'route' => 'fos_user_profile_show',
            'label' => 'Mi Perfil'
        ));
        
        return $menu;
     }
     
     private function getParentMenu($menu){
         if(!$menu){
             return "homeMenu";
         }
         $parent = $this->map[$menu];
         if(!$parent || $parent == $menu){
             return "homeMenu";
         }
         return $this->map[$menu].'Menu';
     }
     private function isMapOk(){
         foreach($this->map as $item){
             if (!$this->checkLoops($item,array())){
                 return false;
             }
         }
         return true;
         
     }
     private function checkLoops($item, $items){
         if(!$item){
             return true;
         }
         if(in_array($item,$items)){
             return false;
         }
         $items[] = $item;
         return $this->checkLoops($this->map[$item], $items);
     }
     public function alertaMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('alerta');
        $menu = $this->$func($factory, $options);
        $menu->addChild('alerta', array(
            'route' => 'alerta_list',
            'label' => 'Alertas'
        ));
        
        return $menu;
     }
     public function alertaShowMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('alertaShow');
        $menu = $this->$func($factory, $options);
//        $str = ($options['alerta']->getNombre());
        $menu->addChild('expedienteShow', array(
            'route' => 'alerta_show',
            'routeParameters' => array('id' => $options['alerta']->getId()),
            'label' => $options['alerta']->getNombre()
        ));
        
        return $menu;
     }
     public function plantillaMenu(FactoryInterface $factory, array $options){
        $func = $this->getParentMenu('plantilla');
        $menu = $this->$func($factory, $options);
        $menu->addChild('plantilla', array(
            'route' => 'plantilla_list',
            'label' => 'Plantillas'
        ));
        
        return $menu;
     }
}

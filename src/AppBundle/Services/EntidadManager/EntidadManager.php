<?php
namespace AppBundle\Services\EntidadManager;

use AppBundle\Entity\Entidad;
use AppBundle\Entity\EntidadEmpresa;
use AppBundle\Entity\EntidadProfesion;
use AppBundle\Entity\LP_Entity;
use AppBundle\Exception\CheckPermissionException;
use AppBundle\Exception\CodigoNombreRepetidoException;
use AppBundle\Exception\EditException;
use AppBundle\Exception\EsEspecialException;
use AppBundle\Exception\EstaBorradoException;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Form\Type\Entidad\EntidadContactoType;
use AppBundle\Form\Type\Entidad\EntidadDomicilioType;
use AppBundle\Form\Type\Entidad\EntidadGeneralType;
use AppBundle\Form\Type\Entidad\EntidadLaboralType;
use AppBundle\Form\Type\Entidad\EntidadObservacionesType;
use AppBundle\Form\Type\Entidad\EntidadType;
use AppBundle\Services\Manager;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class EntidadManager extends Manager {
    
    private $estudio;
    private $user;
    private $em;
    private $formFactory;
    
    public function __construct($entityManager,  TokenStorage $tokenStorage, $formFactory/*, $list*/) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
    }
    
    public function getTipoEntidad($codigoTipoEntidad){
        try{
            $tipoEntidad = $this->em->getRepository('AppBundle:Entidad')
                        ->getTipoEntidadbyCodigo($this->estudio,$codigoTipoEntidad);
            if(!$tipoEntidad){
                throw new NoExisteEntidadException('No existe el tipo de entidad');
            }else{
                return $tipoEntidad;
            }
        }catch(Exception $ex){
            throw new NoExisteEntidadException('No existe el tipo de entidad: ' . $codigoTipoEntidad);
        }
    }
    //HACER: aplicar filtros para los search list
    public function getList($tipoentidad, $order_col, $order_status, $page = 1, $resultpage= 10,  $filtro = array()){
        try{
            $queryBuilder = $this->em->getRepository('AppBundle:Entidad')
                            ->getEntidadesbyTipo($this->estudio,$tipoentidad);
            $list = new ListView();
            $list
                ->setTitle("")
                ->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn('entidad_show', array('id'=> 'getId')),
                            'value' => '<span class="glyphicon glyphicon-pencil"></span>'
                            )
                )
                ->addColumn('Nombre', 'nombre',array('allow_order'=>'1'))
                ->addColumn('Documento', 'nroCuit',array('allow_order'=>'1'))
                ->addColumn('Telefono', 'telefono',array('allow_order'=>'1'))                
                ->setPage($page)
                ->setResultPage($resultpage)
                ->setQueryBuilder($queryBuilder)
                ->setOrderCol($order_col, $order_status);
            return $list;
        } catch (Exception $ex) {
            throw new ListException($ex->getMessage(),404,$ex);
        }
    }
    public function getForm($entidad,$section,$disabled=false,$EntidadProfesion = null,$EntidadEmpresa = null){
        $section= strtoupper($section);
        $formType = $this->getFormType($section);
        if($section == "LABORAL"){
            if(!$EntidadProfesion){ $profesion = ""; }else{ $profesion = $EntidadProfesion->getNombre(); }
            if(!$EntidadEmpresa){ $empresa = ""; }else{ $empresa = $EntidadEmpresa->getNombre(); }
            $form = $this->formFactory->create($formType,$entidad,array('disabled' => $disabled, 'profesion' => $profesion, 'empresa'=> $empresa ));
        }else{
            $form = $this->formFactory->create($formType,$entidad,array('disabled' => $disabled));
        }
        return $form;
    }
    
    private function getFormType($section){
        switch ($section){
            case "NEW":
                $entidadform = EntidadType::class;
                break;
            case "GENERAL";default:
                $entidadform = EntidadGeneralType::class;
                break;
            case "CONTACTO":
                $entidadform = EntidadContactoType::class;
                break;
            case "DIRECCION":
                $entidadform = EntidadDomicilioType::class;
                break; 
            case "LABORAL":
                $entidadform = EntidadLaboralType::class;
                break;
            case "OBSERVACIONES":
                $entidadform = EntidadObservacionesType::class;
                break;
            case "DATOSADICIONALES":
                $entidadform = EntidadObservacionesType::class;
                break;
        }
        return $entidadform;
    }
    
   
            
    public function doNew(Entidad $entidad,$tipoEntidad){
        
        $this->doCheckPermissions($entidad, EntidadManager::DO_NEW);
        
        try{
            $entidad->setEstudio($this->estudio);
            $entidad->setTipoEntidad($tipoEntidad);

            $this->em->persist($entidad);
            $this->em->flush();        
            return $entidad;
        }catch(CheckPermissionException $exp){
            throw $exp;            
        }catch(Exception $ex){
            throw new newException("",404,$ex);
        }
    }
    
    public function doEdit($form,$section){
        try{
            $section = strtoupper($section);
            $entidad = $form->getData();        
            if($section == "LABORAL"){
                $strprofesion = trim(strtoupper ($form->get("profesion")->getData()));
                $strempresa = trim(strtoupper($form->get("empresa")->getData()));
                $profesion = $this->em->getRepository("AppBundle:Entidad")->getEntidadProfesionbyNombre($strprofesion);
                if (!$profesion){ //Si escribio una nueva profesion, se agrega
                    $profesion = new EntidadProfesion();
                    $profesion->setEstudio($this->estudio);
                    $profesion->setNombre($strprofesion);
                    $profesion->setCodigo($strprofesion);
                    $this->em->persist($profesion);
                }
                $empresa = $this->em->getRepository("AppBundle:Entidad")->getEntidadEmpresabyNombre($strempresa);
                if(!$empresa){ //Si escribio una nueva empresa, se agrega
                    $empresa = new EntidadEmpresa();
                    $empresa->setEstudio($this->estudio);
                    $empresa->setNombre($strempresa);
                    $empresa->setCodigo($strempresa);
                    $this->em->persist($empresa);
                }                    
                $entidad->setProfesion($profesion);
                $entidad->setEmpresa($empresa);
             }
            $this->em->persist($entidad);
            $this->em->flush();        
            return $entidad;
        }catch(CheckPermissionException $exp){
            throw $exp;                  
        }catch(Exception $ex){
            throw new EditException("",404,$ex);
        }
    }
    
    public function doDelete(Entidad $entidad){
        try{
            $this->doCheckPermissions($entidad);
            $entidad->setStatus(LP_Entity::STATUS_DELETED);
            $this->em->persist($entidad);
            $this->em->flush();
            return $entidad;
        }catch(CheckPermissionException $exp){
            throw $exp;
        } catch (Exception $ex) {
            throw new DeleteException("",404,$exp);
        }
    }
    public function doUndoDelete(Entidad $entidad){
        try{
            $this->doCheckPermissions($entidad);
            $entidad->setStatus(LP_Entity::STATUS_NO_DELETED);
            $this->em->persist($entidad);
            $this->em->flush();
            return $this;
        }catch(CheckPermissionException $exp){
            throw $exp;
        } catch (Exception $ex) {
            throw new UndoDeleteException("",404,$exp);
        }
    }
    public function doCheckPermissions(Entidad $entidad,$tipoOperacion = EntidadManager::DO_NEW){
        try{
            $this->Validate($entidad, $tipoOperacion);
        }catch(Exception $ex){
            throw  $ex;
        }
        
        //Hacer el tema de los permisos y privilegios del usuaris
        return $this;
    }
    
    private function Validate(Entidad $entidad, $tipoOperacion = EntidadManager::DO_NEW){
        
        if(!$entidad){
            throw new NoExisteEntidadException('No existe el tipo de cuenta contable');
        }
        
        if ($entidad->getStatus() == LP_Entity::STATUS_DELETED){
            throw new EstaBorradoException("La entidad esta eliminada");
        }
        
        if($tipoOperacion!=EntidadManager::DO_NEW){
            if($entidad->getEstudio() != $this->estudio && $entidad->getEsp() == 0 ){
                throw new EstudioInvalidoException('La Entidad no esta asociada al estudio');
            }
        }
        if($entidad->getEsp() == 1 ){
            throw new EsEspecialException('La Entidad es especial y no puede ser editada o eliminada');
        }
        

        // Revisar que el codigo ni el nombre este repetido.
        $entidadx = $this->em->getRepository('AppBundle:Entidad')->getEntidadByCodigoONombre($this->estudio, $entidad->getCodigo(), $entidad->getNombre(), $entidad->getId());

        if($entidadx){
            throw new CodigoNombreRepetidoException("La entidad tiene el mismo nombre o código que la entidad: " . $entidadx->getCodigo() . ' - ' . $entidadx->getNombre() . ' - ' . $entidadx->getTipoEntidad()->getNombre() );
        }
    }
}

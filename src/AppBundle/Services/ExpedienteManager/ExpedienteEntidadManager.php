<?php
namespace AppBundle\Services\ExpedienteManager;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteEntidad;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\CodigoNombreRepetidoException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\EditException;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Form\Type\Expediente\ExpedienteEntidadType;
use AppBundle\Services\Manager;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExpedienteEntidadManager extends Manager{
    
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
    //HACER: aplicar filtros para los search list
    public function getList(Expediente $expediente, $order_col, $order_status, $page = 1, $resultpage= 10, $filtro = array()){
        try{
            $tipoEntidad = $this->em->getRepository('AppBundle:Entidad')->getEntityAbogado();
            $queryBuilder = $this->em->getRepository('AppBundle:Entidad')->getEntidadExpediente($this->estudio,$expediente,$tipoEntidad);
            $list = new ListView();
            $list
                ->setTitle("Abogados")
                ->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn("expediente_abogado_delete", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                            'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                            )
                )
                ->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn("expediente_abogado_responsable", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                            'value' => '<span class="glyphicon glyphicon-briefcase"></span>',
                            )
                )                          
                ->addColumn("Nombre", 'Entidad.nombre',array(
                    'type' => 'object',
                    'allow_order'=>'0',
                    ))
                ->addColumn("Observaciones", 'descripcion',array(
                    'type' => 'string',
                    'allow_order'=>'0',
                    ))                
                ->addColumn("Responsable", 'responsable',array(
                    'type' => 'boolean',
                    'allow_order'=>'0',
                    ))
                ->setPage($page)
                ->setResultPage($resultpage)
                ->setQueryBuilder($queryBuilder)
                ->setOrderCol("", "");
                return $list;
        }catch(Exception $ex){
            throw new ListException($ex->getMessage(), 404, $ex);
        }
    }
    
    public function getForm(ExpedienteEntidad $entidad, $disabled = false){
        // Si esta en modo lectura no hace falta cargar todos los resultados
        // Solo tiene que mostrar el texto
        if($disabled == false){
            $tipoEntidad = $this->em->getRepository('AppBundle:Entidad')->getEntityAbogado();
            $abogados = $this->em->getRepository('AppBundle:Entidad')
                           ->getEntidadesbyTipo($this->estudio,$tipoEntidad)
                           ->getQuery()->getResult();
        }else{
            $abogados[] = $entidad->getEntidad();
        }
        return $this->formFactory->create(ExpedienteEntidadType::class, $entidad,array('disabled' => $disabled,
            'entidades'=>$abogados));
    }
    
    public function doNew(ExpedienteEntidad $entidad,$expediente){
        try{
            $entidad->setEstudio($this->estudio);
            $entidad->setExpediente($expediente);
            $this->doCheckPermissions($entidad,Manager::DO_NEW,$expediente);
            
            $this->em->persist($entidad);
            $this->em->flush();        
            return $entidad;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new NewException($ex->getMessage(),404,$ex);
        }
    }
    
    public function doEntidadResponsable(ExpedienteEntidad $entidad,$responsable){
        try{
            
            $this->doCheckPermissions($entidad,Manager::DO_EDIT,$entidad->getExpediente());
            
            $entidad->setResponsable($responsable);

            $this->em->flush();        
            return $entidad;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new EditException($ex->getMessage(),404,$ex);
        }
    }
    
    
    public function doEdit($entidad){
        //No hay edit, se elimina y se vuelve a crear
    }
    public function doDelete($entidad){
        try{
            $this->doCheckPermissions($entidad,Manager::DO_DELETE);
            $entidad->setStatus(ExpedienteEntidad::STATUS_DELETED);
            $this->em->persist($entidad);
            $this->em->flush();
        }catch(ValidationException $exv){
            throw $exv;
        }catch(CheckPermissionsException $exp) {
            throw $exp;
        }catch(Exception $ex){
            throw new DeleteException($ex->getMessage(),404,$ex);
        }
        return $this;
    }
    public function doUndoDelete($entidad){
        try{
            $this->doCheckPermissions($entidad,Manager::DO_UNDODELETE);
            $entidad->setStatus(ExpedienteEntidad::STATUS_NO_DELETED);
            $this->em->persist($entidad);
            $this->em->flush();
        }catch(ValidationException $exv){
            throw $exv;
        }catch(CheckPermissionsException $exp) {
            throw $exp;
        }catch(Exception $ex){
            throw new UndoDeleteException($ex->getMessage(),404,$ex);
        }
        return $this;
    }    
   
    public function doCheckPermissions($entidad, $ope = Manager::DO_NEW, $expediente = null){
        if($entidad != null){
            $this->Validate($entidad,$ope,$expediente);
        }
        
        return $this;
    }

    private function Validate($entidad, $ope = Manager::DO_NEW, $expediente=null){
        //Revisar que ese mismo interviniente no exista ya...
        if($ope != Manager::DO_DELETE){
            $entidadid = $entidad->getId();
            if($entidadid == null){ $entidadid = -1; }

            $entidadx = $this->em->getRepository("AppBundle:Expediente")
                ->getEntityEntidad($this->estudio,$expediente,$entidad->getEntidad(), $entidadid);
            if(count($entidadx) > 0){
                throw new CodigoNombreRepetidoException($entidad->getEntidad()->getNombre() . ' ya esta asociado al expediente.' );
            }
        }
        
        if($this->estudio != $entidad->getEstudio() ){
            throw new EstudioInvalidoException("El estudio es invalido");
        }
        if($entidad->getStatus() == ExpedienteEntidad::STATUS_DELETED && $ope != Manager::DO_UNDODELETE){
            throw new NoExisteEntidadException("No existe la entidad");
        }        
    }
}

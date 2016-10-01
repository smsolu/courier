<?php
namespace AppBundle\Services\ExpedienteManager;

#Entity

#Exception

#Type

#Otros


use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteInterviniente;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\CodigoNombreRepetidoException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Exception\UndoDeleteException;
use AppBundle\Form\Type\Expediente\ExpedienteIntervinienteType;
use AppBundle\Services\Manager;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExpedienteIntervinienteManager extends Manager{
    
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
            $this->doCheckPermissions(null,Manager::DO_LIST, $expediente);
            $queryBuilder = $this->em->getRepository('AppBundle:Entidad')
                                ->getIntervinientesExpediente($this->estudio,$expediente);

            $list = new ListView();
            $list
                ->setTitle("Partes");
                $list->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn("expediente_intervinientes_delete", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                            'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                            )
                );          
                $list->addColumn("Nombre", 'getIntervinienteNombre',array(
                    'type' => 'raw',
                    'allow_order'=>'0',
                    ));
                $list->addColumn("Caracter", 'caracterNombre',array(
                    'type' => 'string',
                    'allow_order'=>'0',
                    ));
                $list->addColumn("Observaciones", 'descripcion',array(
                    'type' => 'string',
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
    public function getForm(ExpedienteInterviniente $interviniente, $disabled = false){
        // Si esta en modo lectura no hace falta cargar todos los resultados
        // Solo tiene que mostrar el texto
        if($disabled == false){
            $intervinientes =   $this->em->getRepository("AppBundle:Entidad")
                                         ->getEntidades($this->estudio)
                                         ->getQuery()->getResult();
            $caracterIntervinientes = $this->em->getRepository("AppBundle:Expediente")
                                          ->getCaracterIntervinientes($this->estudio)
                                          ->getQuery()->getResult();
        }else{
            $intervinientes[] = $interviniente->getEntidad();
            $caracterIntervinientes[]= $interviniente->getCaracter();
        }
        return $this->formFactory->create(ExpedienteIntervinienteType::class, $interviniente,array('disabled' => $disabled,
            'intervinientes'=>$intervinientes, 'caracterInterviniente'=> $caracterIntervinientes));
    }
    
    public function doNew(ExpedienteInterviniente $interviniente,$expediente){
        try{
            $interviniente->setEstudio($this->estudio);
            $interviniente->setExpediente($expediente);
            $this->doCheckPermissions($interviniente,Manager::DO_NEW);
            
            $this->em->persist($interviniente);
            $this->em->flush();        
            return $interviniente;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new NewException($ex->getMessage(),404,$ex);
        }
    }
    
    public function doEdit($interviniente){
        //No hay edit, se elimina y se vuelve a crear
    }
    public function doDelete($interviniente){
        try{
            $this->doCheckPermissions($interviniente,Manager::DO_DELETE);
            $interviniente->setStatus(ExpedienteInterviniente::STATUS_DELETED);
            $this->em->persist($interviniente);
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
    public function doUndoDelete($interviniente){
        try{
            $this->doCheckPermissions($interviniente,Manager::DO_UNDODELETE);
            $interviniente->setStatus(ExpedienteInterviniente::STATUS_NO_DELETED);
            $this->em->persist($interviniente);
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
   
    public function doCheckPermissions($interviniente, $ope = Manager::DO_NEW, $expediente = null){
        if($interviniente != null){
            $this->Validate($interviniente,$ope,$expediente);
        }
        
        return $this;
    }

    private function Validate(ExpedienteInterviniente $interviniente, $ope = Manager::DO_NEW, $expediente){
        //Revisar que ese mismo interviniente no exista ya...
        $intervinienteid = $interviniente->getId();
        if($interviniente == null){ $intervinienteid = -1; }
        $intervinientex = $this->em->getRepository("AppBundle:Expediente")
                ->getEntityInterviniente($this->estudio,$expediente,$interviniente->getEntidad(), $intervinienteid);
        if($intervinientex){
            throw new CodigoNombreRepetidoException("Ya existe una entidad " . $interviniente->getEntidad()->getNombre() . ' asociada como parte.' );
        }
        if($this->estudio != $interviniente->getEstudio() ){
            throw new EstudioInvalidoException("El estudio es invalido");
        }
        if($interviniente->getStatus() == ExpedienteInterviniente::STATUS_DELETED && $ope != Manager::DO_UNDODELETE){
            throw new NoExisteEntidadException("No existe la entidad");
        }        
    }
}

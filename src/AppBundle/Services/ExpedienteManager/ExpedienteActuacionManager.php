<?php
namespace AppBundle\Services\ExpedienteManager;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteActuacion;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Form\Type\Expediente\ExpedienteActuacionType;
use AppBundle\Services\Manager;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExpedienteActuacionManager extends Manager{
    
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
        $queryBuilder = $this->em->getRepository("AppBundle:Expediente")->getExpedienteActuacionList($this->estudio,$expediente,  ExpedienteActuacion::STATUS_NO_DELETED);
        $list = new ListView();
        $list
            ->setTitle("Actuacion")
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('expediente_actuaciones_show', array('id'=> 'getId','expedienteid'=>'getExpedienteId')),
                        'value' => '<span class="glyphicon glyphicon-pencil"></span>'
                        )
            )
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("expediente_actuaciones_delete", array("id"=>"getId",'expedienteid'=>'getExpedienteId')),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
            )                
            ->addColumn("Fecha y Hora", 'fechayhora',array(
                'type' => 'datetime',
                'allow_order'=>'0',
                ))
            ->addColumn("Tipo", 'Tipoactuacion.nombre',array(
                'type' => 'object',
                'allow_order'=>'0',
                ))                  
            ->addColumn("Fojas", 'fojas',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                     
            ->addColumn("Descripcion", 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status); 
        return $list;
        }catch(Exception $ex){
            throw new ListException($ex->getMessage(), 404, $ex);
        }
    }
    public function getForm(Expediente $expediente,$actuacion, $disabled = false){
        // Si esta en modo lectura no hace falta cargar todos los resultados
        // Solo tiene que mostrar el texto
        if($disabled == false){
            $TipoActuaciones = $this->em->getRepository("AppBundle:Expediente")
                                        ->getTipoActuaciones($this->estudio,$expediente)
                                        ->getQuery()->getResult();     
        }else{
            $TipoActuaciones[] = $actuacion->getTipoactuacion();
        }
        $formtype = ExpedienteActuacionType::class;
        return $this->formFactory->create($formtype, $actuacion,array('disabled' => $disabled));
    }
    
    public function doNew(ExpedienteActuacion $actuacion,$expediente){
        try{
            $actuacion->setEstudio($this->estudio);
            $actuacion->setExpediente($expediente);
            $this->doCheckPermissions($actuacion,expedienteActuacionManager::DO_NEW);

            $this->em->persist($actuacion);
            $this->em->flush();        
            return $actuacion;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new NewException($ex->getMessage(),404,$ex);
        }
    }
    
    public function doEdit($actuacion){
        $this->em->persist($actuacion);
        $this->em->flush();        
        return $actuacion;
    }
    public function doDelete($actuacion){
        $this->doCheckPermissions($actuacion,Manager::DO_DELETE);
        $actuacion->setStatus(ExpedienteActuacion::STATUS_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doUndoDelete($actuacion){
        $actuacion->setStatus(Expediente::STATUS_NO_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doCheckPermissions($actuacion, $ope = Manager::DO_NEW){
        $this->Validate($actuacion,$ope);
        return $this;
    }

    private function Validate(ExpedienteActuacion $actuacion, $ope = Manager::DO_NEW){
        if($this->estudio != $actuacion->getEstudio() ){
            throw new EstudioInvalidoException("El estudio es invalido");
        }
        if($actuacion->getStatus() == ExpedienteActuacion::STATUS_DELETED){
            throw new NoExisteEntidadException("No existe la entidad");
        }        
    }
}

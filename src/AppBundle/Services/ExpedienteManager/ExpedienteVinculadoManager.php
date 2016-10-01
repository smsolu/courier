<?php
namespace AppBundle\Services\ExpedienteManager;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteVinculado;
use AppBundle\Exception\CheckPermissionsException;
use AppBundle\Exception\DeleteException;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Exception\ValidateException;
use AppBundle\Form\Type\Expediente\ExpedienteVinculadoType;
use AppBundle\Services\Manager;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExpedienteVinculadoManager extends Manager{
    
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
            $queryBuilder = $this->em->getRepository("AppBundle:Expediente")
                                  ->getExpedienteVinculadoList($this->estudio,$expediente);
              $list = new ListView();
              $list
                ->setTitle("Abogados")
                ->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn("expediente_show", array("id"=>"getExpedienteVinculadoId")),
                            'value' => '<span style="color:blue" class="glyphicon glyphicon-eye-open"></span></a>',
                            )
                );              
                $list->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn("expediente_vinculados_delete", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                            'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                            )
                );          
                $list->addColumn("Tipo", 'getTipoVinculacionNombre',array(
                    'type' => 'string',
                    'allow_order'=>'0',
                    ));  
                $list->addColumn("Número", 'getExpedienteVinculadoNumeroCompleto',array(
                    'type' => 'raw',
                    'allow_order'=>'0',
                    ));
                $list->addColumn("Caratula", 'getExpedienteVinculadoCaratula',array(
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
    public function getForm(ExpedienteVinculado $vinculado, $disabled = false){
        // Si esta en modo lectura no hace falta cargar todos los resultados
        // Solo tiene que mostrar el texto
        if($disabled == false){
            $expedientes = $this->em->getRepository("AppBundle:Expediente")
                                        ->getExpedientes($this->estudio)
                                        ->getQuery()->getResult();
            $tipoVinculacion = $this->em->getRepository("AppBundle:Expediente")
                                        ->getTipoVinculacion($this->estudio)
                                        ->getQuery()->getResult();                
        }else{
            $expedientes[] = $vinculado->getExpedienteVinculado();
            $tipoVinculacion[]= $vinculado->getTipoVinculacion();
        }
        //$formtype = ExpedienteVinculadoType::class;
        return $this->formFactory->create(ExpedienteVinculadoType::class, $vinculado,array('disabled' => $disabled,
            'expedientes'=>$expedientes, 'tipovinculacion'=> $tipoVinculacion));
    }
    
    public function doNew(ExpedienteVinculado $vinculado,$expediente){
        try{
            $vinculado->setEstudio($this->estudio);
            $vinculado->setExpediente($expediente);
            $this->doCheckPermissions($vinculado,Manager::DO_NEW);
            
            $expvinc2 = new ExpedienteVinculado();
            $expvinc2->setEstudio($vinculado->getEstudio());
            $expvinc2->setExpediente($vinculado->getExpedienteVinculado());
            $expvinc2->setExpedienteVinculado($expediente);
            $expvinc2->setDescripcion($vinculado->getDescripcion());
            $expvinc2->setTipoVinculacion($vinculado->getTipoVinculacion());            
            
            $this->em->persist($expvinc2);
            $this->em->persist($vinculado);
            $this->em->flush();        
            return $vinculado;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new NewException($ex->getMessage(),404,$ex);
        }
    }
    
    public function doEdit($vinculado){
        //En los vinculados no hay edit, se elimina y se vuelve a crear
    }
    public function doDelete($vinculado){
        try{
            $this->doCheckPermissions($vinculado,Manager::DO_DELETE);
            $vinculado->setStatus(ExpedienteVinculado::STATUS_DELETED);

            // Eliminar el otro vinculo!

            $vinculado2 = $this->em->getRepository("AppBundle:Expediente")
                                        ->getEntityVinculado($this->estudio,
                                                             $vinculado->getExpedienteVinculado(), 
                                                             $vinculado->getExpediente());
            $vinculado2->setStatus(ExpedienteVinculado::STATUS_DELETED);
            $this->em->persist($vinculado);
            $this->em->persist($vinculado2);        
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
    
   
    public function doCheckPermissions($vinculado, $ope = Manager::DO_NEW, $expediente = null){
        if($vinculado != null){
            $this->Validate($vinculado,$ope);
        }
        
        return $this;
    }

    private function Validate(ExpedienteVinculado $vinculado, $ope = Manager::DO_NEW){
        
        
        // No tiene que ser igual al expediente vinculado
        if ($vinculado->getExpediente() == $vinculado->getExpedienteVinculado()){
            throw new ValidateException("El expediente no puede vincularse asimismo");
        }
        
        if($this->estudio != $vinculado->getEstudio() ){
            throw new EstudioInvalidoException("El estudio es invalido");
        }
        if($vinculado->getStatus() == ExpedienteVinculado::STATUS_DELETED){
            throw new NoExisteEntidadException("No existe la entidad");
        }        
    }
}

<?php
namespace AppBundle\Services\ExpedienteManager;

use AppBundle\Entity\Expediente;
use AppBundle\Exception\EstudioInvalidoException;
use AppBundle\Exception\ListException;
use AppBundle\Exception\NewException;
use AppBundle\Exception\NoExisteEntidadException;
use AppBundle\Form\Type\Expediente\ExpedienteGeneralType;
use AppBundle\Form\Type\Expediente\ExpedienteType;
use AppBundle\Services\Manager;
use DateTime;
use Exception;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExpedienteManager extends Manager{
    
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
    public function getList($order_col, $order_status, $page = 1, $resultpage= 10, $filtro = array()){
        try{
            
            $queryBuilder = $this->em->getRepository("AppBundle:Expediente")
                            ->getExpedienteList($this->estudio,Expediente::STATUS_NO_DELETED);
            $list = new ListView();
            $list
                ->setTitle("Expedientes")
                ->addColumn('', 'id',array(
                            'type' => 'link',
                            'route' => new LinkColumn('expediente_show', array('id'=> 'getId')),
                            'value' => '<span class="glyphicon glyphicon-pencil"></span>'
                            )
                )
                ->addColumn('Expediente', 'identificador',array(
                    'type' => 'string',
                    'allow_order'=>'1',
                    ))
                ->addColumn("Caratula", 'caratula',array(
                    'type' => 'string',
                    'allow_order'=>'1',
                    ))
                ->addColumn('Cámara', 'camaranombre',array(
                    'type' => 'string',
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
    public function getForm(Expediente $expediente, $disabled = false, $seccion="GENERAL"){

        if($disabled == false){
            $clientes = $this->em->getRepository("AppBundle:Entidad")
                        ->getEntidadesByCodigoTipoEntidad($this->estudio,"CLIENTE")
                        ->getQuery()->getResult();
        }else{
            $clientes[] = $expediente->getClientePrincipal();
        }
        switch(strtoupper($seccion)){
            case "NEW":
                $formtype = ExpedienteType::class;
            break;
            case "GENERAL";default:
                $formtype = ExpedienteGeneralType::class;
            break;
        }
        
        return $this->formFactory->create($formtype, $expediente,
                array('disabled' => $disabled, 'clientes'=>$clientes));        
        
    }
    
    public function doNew(Expediente $expediente){
        try{
            $expediente->setEstudio($this->estudio);
            $expediente->setNaturaleza($this->em->getRepository("AppBundle:Expediente")->getExpedienteNaturalezaEntity("JUDICIAL"));
            $this->doCheckPermissions($expediente,expedienteManager::DO_NEW);
            
            $this->em->persist($expediente);
            $this->em->flush();        
            return $expediente;
        }catch(PermissionsCheckException $exp ){
            throw $exp;
        }catch(Exception $ex){
            throw new NewException($ex->getMessage(),404,$ex);
        }
    }
    
    public function doEdit($expediente){
        $this->em->persist($expediente);
        $this->em->flush();        
        return $expediente;
    }
    public function doDelete($expediente){
        $this->doCheckPermissions($expediente,Manager::DO_DELETE);
        $expediente->setStatus(Expediente::STATUS_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doUndoDelete($expediente){
        $expediente->setStatus(Expediente::STATUS_NO_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doCheckPermissions($expediente, $ope = Manager::DO_NEW){
        
        $this->Validate($expediente,$ope);
        
        $this->setUltimoIngreso($expediente);
        return $this;
    }

    private function Validate(Expediente $expediente, $ope = Manager::DO_NEW){
        if($this->estudio->getId() != $expediente->getEstudio()->getId() ){
            throw new EstudioInvalidoException("El estudio es invalido: {" . $this->estudio->getId() . '} != {' . $expediente->getEstudio()->getId() . '}');
        }
        if($expediente->getStatus() == Expediente::STATUS_DELETED){
            throw new NoExisteEntidadException("No existe la entidad");
        }        
    }
    
    /**
     * Guarda el estado del ultimo ingreso del expediente
     * Si esta favorito, esta fecha se utiliza para ordenar los favoritos, para
     * que el usuario pueda ver los ultimos expedientes visitados.
     * Se utiliza desde el doCheckPermissions porque es la funcion que se 
     * ejecuta frnete a cualquier operacion con el expediente.
     * @param type $expediente
     */
    private function setUltimoIngreso($expediente){
        $repoUsuarioExpediente = $repo = $this->em->getRepository('AppBundle:UsuarioExpediente');
        $usuarioExpediente = $repoUsuarioExpediente->findOneBy(
             array('Estudio'=> $this->estudio,'Usuario' => $this->user, 
                   "Expediente"=>$expediente) 
        );
        if($usuarioExpediente){
           $usuarioExpediente->setFechaultimoingreso(new DateTime());
           $this->em->persist($usuarioExpediente);
           $this->em->flush();
        }
        return $this;
    }
}

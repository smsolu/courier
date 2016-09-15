<?php
namespace AppBundle\Services\ExpedienteManager;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\Expediente;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use AppBundle\Form\Type\Expediente\ExpedienteType;

class ExpedienteManager {
    
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
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.idEstudio = :id_estudio")
//                 HACER:Agregar una clase para poner constantes generales onda status en todas las entities
            ->setParameters(array("status"=> Expediente::STATUS_NO_DELETED, "id_estudio"=>$this->estudio))
            ->from('AppBundle:Expediente_v','e');
//      HACER: invocar desde service y no con new
        $list = new ListView();
        $list
            ->setTitle("Expedientes")
//            HACER: esto se setea para el translator, inyectarlo desde el service
//            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
//                      HACER: invocar desde service y no desde new
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
    }
    public function getForm($expediente, $disabled = false){
        return $this->formFactory->create(ExpedienteType::class, $expediente,array('disabled' => $disabled));
    }
    
    public function doNew($expediente){
        $expediente->setEstudio($this->estudio);
        $this->em->persist($expediente);
        $this->em->flush();        
        return $expediente;
    }
    
    public function doEdit($expediente){
        $this->em->persist($expediente);
        $this->em->flush();        
        return $expediente;
    }
    public function doDelete($expediente){
        $expediente->setStatus(Expediente::STATUS_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doUndoDelete($expediente){
        $expediente->setStatus(Expediente::STATUS_NO_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doCheckPermissions($expediente){
        if(!$this->isVisible($expediente)){
            throw new \Exception("No tiene permisos para este expediente");
        }
        $this->setUltimoIngreso($expediente);
        return $this;
    }
    private function isVisible($expediente){
        return( $expediente->getStatus() == Expediente::STATUS_NO_DELETED);
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
           $usuarioExpediente->setFechaultimoingreso(new \DateTime());
           $this->em->persist($usuarioExpediente);
           $this->em->flush();
        }
        return $this;
    }
}

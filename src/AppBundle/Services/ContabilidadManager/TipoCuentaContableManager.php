<?php
namespace AppBundle\Services\ContabilidadManager;

use AppBundle\Entity\LP_Entity;
use AppBundle\Entity\TipoCuentaContable;
use AppBundle\Exception\RegEspException;
use AppBundle\Form\Type\Contabilidad\TipoCuentaContableType;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Exception\ValidatorException;

class TipoCuentaContableManager {
    
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
        $queryBuilder = $this->em->getRepository("AppBundle:TipoCuentaContable")
                             ->getTipoCuentasContables($this->estudio);
        $list = new ListView();
        $list
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("contabilidad_tipocuentas_delete", array("tipoCuentaContable"=>"getId")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
            )
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("contabilidad_tipocuentas_edit", array("tipoCuentaContable"=>"getId")),
                        'value' => '<span class="glyphicon glyphicon-pencil"></span>',
                        )
            )                    
            ->addColumn("", 'getImgEsp',array(
                'type' => 'raw',
                'allow_order'=>'0',
                ))                   
            ->addColumn("Código", 'codigo',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                   
            ->addColumn("Nombre", 'nombre',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                      
            ->addColumn("Decripción", 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))     
            ->addColumn("Tipo", 'getStrIngresoEgreso',array(
                'type' => 'raw',
                'allow_order'=>'0',
                ))                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);
        return $list;
    }
    public function getForm($tipoCuentaContable, $edit = false){
        return $this->formFactory->create(TipoCuentaContableType::class, $tipoCuentaContable,array("edit"=>$edit));
    }
    
    public function doNew($expediente){
        $expediente->setEstudio($this->estudio);
        $this->em->persist($expediente);
        $this->em->flush();        
        return $expediente;
    }
    
    public function doEdit($tipoCuentaContable){
        $this->em->persist($tipoCuentaContable);
        $this->em->flush();        
        return $tipoCuentaContable;
    }
    public function doDelete($tipoCuentaContable){
        $tipoCuentaContable->setStatus(LP_Entity::STATUS_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doUndoDelete($tipoCuentaContable){
        $tipoCuentaContable->setStatus(LP_Entity::STATUS_NO_DELETED);
        $this->em->flush();
        return $this;
    }
    public function doCheckPermissions($tipoCuentaContable){
        if(!$this->isVisible($tipoCuentaContable)){
            throw new ValidatorException("No tiene permisos para visualizar esta Tipo de Cuenta");
        }
        return $this;
    }
    
    public function doValidate($tipoCuentaContable){
        if(!$tipoCuentaContable){
            throw new ValidatorException('No existe el tipo de cuenta contable');
        }
        if($tipoCuentaContable->getEstudio() != $this->estudio && $tipoCuentaContable->getEsp() == 0 ){
            throw new ValidatorException('El tipo de cuenta contable no esta asociada al estudio');
        }
        if($tipoCuentaContable->getEsp() == 1 ){
            throw new RegEspException('El tipo de Cuenta Contable es especial y no puede ser editada o eliminada');
        }
    }
            
    private function isVisible($tipoCuentaContable){
        return( $tipoCuentaContable->getStatus() == LP_Entity::STATUS_NO_DELETED);
    }
    
}

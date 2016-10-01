<?php

namespace AppBundle\Repository;
use AppBundle\Entity\LP_Entity;
use Doctrine\ORM\EntityRepository;


class EntidadRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Entidad', 'e');
    }
    
    
    // Usada para saber si se esta repitiendo el codigo o el nombre al crear o modificar
    public function getEntidadByCodigoONombre($estudio,$codigo,$nombre,$id=-1){
        if(is_null($id)){
            $id = -1;
        }
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("(e.codigo like :codigo or e.nombre like :nombre) and e.status =:status and (e.Estudio = :estudio or e.esp = 1) and e.id !=:id")
            ->setParameters(array("codigo"=>$codigo, "status"=> 0, "nombre"=>$nombre, "estudio"=>$estudio, "id"=>$id))
            ->from('AppBundle:Entidad','e')
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();        
    }
    
    public function getTipoEntidadbyCodigo($estudio,$codigo, $status = LP_Entity::STATUS_NO_DELETED){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.codigo = :codigo and e.status =:status and (e.Estudio = :estudio or e.esp = 1)")
            ->setParameters(array("codigo"=>$codigo, "status"=> $status, "estudio"=>$estudio))
            ->from('AppBundle:EntidadTipoEntidad','e')
             ->getQuery()->getOneOrNullResult();
    }
     
    public function getEntidadEmpresabyNombre($empresa){
        return  $this->getEntityManager()->getRepository("AppBundle:EntidadEmpresa")
                ->findOneBy(array("nombre"=> $empresa));;
    }
    
    public function getEntidadProfesionbyNombre($profesion){
        return  $this->getEntityManager()->getRepository("AppBundle:EntidadProfesion")
                ->findOneBy(array("nombre"=> $profesion));
    }
    
    
    public function getEntidadesByCodigoTipoEntidad($estudio, $codigoTipoEntidad, $status = LP_Entity::STATUS_NO_DELETED){
        $tipoEntidad = $this->getTipoEntidadbyCodigo($estudio, $codigoTipoEntidad);
        return $this->getEntidadesbyTipo($estudio, $tipoEntidad,$status);
    }
    
    public function getEntidadesbyTipo($estudio, $tipoentidad, $status = LP_Entity::STATUS_NO_DELETED){
        return $this->getQueryBuilder()
            ->where("e.tipoentidad = :tipoentidad and e.Estudio = :estudio AND e.status = :status")
            ->setParameters(array(
                                    "tipoentidad"=>$tipoentidad,
                                    "estudio" =>$estudio,
                                    "status" => $status));
    }
    public function getEntidadExpediente($estudio,$expediente,$tipoentidad, $status = LP_Entity::STATUS_NO_DELETED){
        return  $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :id_estudio and e.Expediente =:expediente and ent.tipoentidad = :tipoentidad")
            ->setParameters(array("status"=> $status, "id_estudio"=>$estudio, "expediente"=>$expediente, "tipoentidad"=>$tipoentidad))
            ->from('AppBundle:ExpedienteEntidad','e')
            ->innerJoin('e.Entidad','ent');        
    }
    public function getEntityAbogado(){
         return $this->getEntityManager()->getRepository('AppBundle:EntidadTipoEntidad')
                ->findOneBy(array("codigo"=>"ABOGADO", "esp" => 1));
    }
    public function getEntidades($estudio,$status = 0){
        return $this->getQueryBuilder()
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1)")
            ->setParameters(array(
                                    "estudio" =>$estudio,
                                    "status" => $status));
    }
    
    public function getIntervinientesExpediente($estudio, $expediente, $status = LP_Entity::STATUS_NO_DELETED){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente =:expediente")
            ->setParameters(array("status"=>$status, 
                                  "estudio"=>$estudio, 
                                  "expediente"=>$expediente))
            ->from('AppBundle:ExpedienteInterviniente','e');  
    }
    
    
}
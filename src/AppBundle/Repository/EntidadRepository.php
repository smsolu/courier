<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class EntidadRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Entidad', 'e');
    }
    
    public function getEntidadbyTipo($estudio, $tipoentidad, $status = 0){
        return $this->getQueryBuilder()
            ->where("e.tipoentidad = :tipoentidad and e.Estudio = :estudio AND e.status = :status")
            ->setParameters(array(
                                    "tipoentidad"=>$tipoentidad,
                                    "estudio" =>$estudio,
                                    "status" => $status))//hardcodeo para probar
                ->getQuery()->getResult();
    }
    public function getEntidadExpediente($estudio,$expediente,$tipoentidad, $status = 0){
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
    
    public function getIntervinientesExpediente($estudio, $expediente, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente =:expediente")
            ->setParameters(array("status"=>$status, 
                                  "estudio"=>$estudio, 
                                  "expediente"=>$expediente))
            ->from('AppBundle:ExpedienteInterviniente','e');  
    }
}
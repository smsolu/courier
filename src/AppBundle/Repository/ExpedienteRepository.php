<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ExpedienteRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Expediente', 'e');
    }
    public function getExpedienteNaturalezaEntity($codigo){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.codigo like :codigo")
            ->setParameters(array("codigo"=> $codigo))
            ->from('AppBundle:ExpedienteNaturaleza','e')
            ->getQuery()->getOneOrNullResult();
    }
    
    public function getDocumentos($estudio, $expediente){
        return $this->getQueryBuilder()
                ->andWhere("e.estudio = :id_estudio and e.expediente = :expediente")
                ->setParameters(array("id_estudio"=>$estudio, "expediente"=>$expediente));
    }
    public function getEntityTipoProceso($estudio, $expediente, $tipoproceso, $status = 0){
        return $this->getEntityManager()->getRepository('AppBundle:ExpedienteTipoProceso')
                ->findOneBy(array("Estudio"=> $estudio,
                                  "Expediente"=>$expediente, 
                                  "status"=>  $status, 
                                  "TipoProceso"=>$tipoproceso));
    }
    public function getDcoumentoVersion($estudio,$documento){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.estudio = :id_estudio and e.documento = :documento")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio, "documento"=>$documento))
            ->from('AppBundle:DocumentoVersion','e');
    }
    
    
    // Apunta al view
    public function getExpedienteList($estudio, $status = 0){
        return  $this->getEntityManager()->createQueryBuilder()
                ->select('e')
                ->where("e.status =:status and e.idEstudio = :estudio")
                ->setParameters(array("status"=> $status, "estudio"=>$estudio))
                ->from('AppBundle:Expediente_v','e');
    }

    public function getExpedientes($estudio, $status = 0){
        return  $this->getEntityManager()->createQueryBuilder()
                ->select('e')
                ->where("e.status =:status and e.Estudio = :estudio")
                ->setParameters(array("status"=> $status, "estudio"=>$estudio))
                ->from('AppBundle:Expediente','e');
    }
   
    public function getTipoProcesodeExpediente($estudio,$expediente, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente =:expediente")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio, "expediente"=>$expediente))
            ->from('AppBundle:ExpedienteTipoProceso','e');    
    }
 

// Actuaciones    
    public function getExpedienteActuacionList($estudio, $expediente, $status = 0){
        return  $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "expediente"=> $expediente))
            ->from('AppBundle:ExpedienteActuacion','e');
    }    
    
    public function getTipoActuaciones($estudio,$expediente,$status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1) ")
            ->addOrderBy("e.esp","DESC")
            ->addOrderBy("e.nombre","ASC")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio))
            ->from('AppBundle:ActuacionTipoactuacion','e');             
    }
        
    
    
//   Expediente Vinculado
    public function getExpedienteVinculadoList($estudio, $expediente, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :id_estudio and e.Expediente =:expediente")
            ->setParameters(array("status"=> $status, "id_estudio"=>$estudio, "expediente"=>$expediente))
            ->from('AppBundle:ExpedienteVinculado','e');          
    }
    public function getTipoVinculacion($estudio, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :id_estudio or e.esp = 1) ")
            ->setParameters(array("status"=> $status, "id_estudio"=>$estudio))
            ->from('AppBundle:TipoVinculacion','e');          
    }
    public function getEntityVinculado($estudio,$expediente, $expedientevinculado,$status = 0){
        return 
               $this->getEntityManager()->getRepository("AppBundle:ExpedienteVinculado")
                    ->findOneBy(array("ExpedienteVinculado"=>$expedientevinculado,
                                     "status" => $status, 
                                     "Estudio"=>$estudio, 
                                     "Expediente"=>$expediente));        
    }

    // Partes / Intervinientes
    public function getCaracterIntervinientes($estudio, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1) ")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio))
            ->from('AppBundle:CaracterInterviniente','e');          
    }
    //Devuelve los interviniente que sean de la entidad correspondiente y que no sean igual
    // a interviniente.. Sirve para comprobar que no esta repetida una entidad en un expediente
    public function getEntityInterviniente($estudio, $expediente, $entidad, $intervinienteid, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio "
                    . " and e.Expediente = :expediente and e.Entidad = :entidad "
                    . " and e.id != :interviniente")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio, 
                                  "entidad"=>$entidad, "interviniente"=>$intervinienteid,
                                  "expediente"=> $expediente))
            ->from('AppBundle:ExpedienteInterviniente','e')
            ->getQuery()->getOneOrNullResult();
    }
    
    // Abugados
    //Devuelve los interviniente que sean de la entidad correspondiente y que no sean igual
    // a Entidad.. Sirve para comprobar que no esta repetida una entidad en un expediente
    public function getEntityEntidad($estudio, $expediente, $entidad, $entidadid, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio "
                    . " and e.Expediente = :expediente and e.Entidad = :entidad "
                    . " and e.id != :interviniente")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio, 
                                  "entidad"=>$entidad, "interviniente"=>$entidadid,
                                  "expediente"=> $expediente))
            ->from('AppBundle:ExpedienteEntidad','e')
            ->getQuery()->getResult();
    }    
}
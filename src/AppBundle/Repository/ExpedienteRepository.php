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
    
    public function getTipoProcesodeExpediente($estudio,$expediente, $status = 0){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente =:expediente")
            ->setParameters(array("status"=> $status, "estudio"=>$estudio, "expediente"=>$expediente))
            ->from('AppBundle:ExpedienteTipoProceso','e');    
    }
 
}
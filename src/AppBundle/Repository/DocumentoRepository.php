<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class DocumentoRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Documento', 'e')
                    ->where('e.status = 0');
    }
    
    public function getDocumentos($estudio, $expediente){
        return $this->getQueryBuilder()
                ->andWhere("e.estudio = :id_estudio and e.expediente = :expediente")
                ->setParameters(array("id_estudio"=>$estudio, "expediente"=>$expediente));
    }
    public function getDcoumentoVersion($estudio,$documento){
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->where("e.status =:status and e.estudio = :id_estudio and e.documento = :documento")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio, "documento"=>$documento))
            ->from('AppBundle:DocumentoVersion','e');
    }
 
}
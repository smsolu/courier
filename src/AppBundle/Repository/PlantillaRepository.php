<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Plantilla;


class PlantillaRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Plantilla', 'e');
    }
    
    public function getPlantillas($estudio, Plantilla $plantillaPadre = null, $status = Plantilla::STATUS_NO_DELETED){
        $qb = $this->getQueryBuilder()
            ->where("e.status =:status and e.Estudio =:estudio")
            ->setParameters(array("status"=> $status, "estudio" => $estudio))
            ->OrderBy("e.tipo", "ASC");
        if(!is_null($plantillaPadre)){
            $qb->andWhere("e.plantillaPadre = :plantillaPadre")
                ->setParameter("plantillaPadre", $plantillaPadre);
        }
        return $qb;
    }
  
}
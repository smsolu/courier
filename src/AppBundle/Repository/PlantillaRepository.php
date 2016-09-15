<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;



class PlantillaRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:Plantilla', 'e');
    }
    
    public function getPlantillas($estudio,$status = 0){
        return $this->getQueryBuilder()
            ->where("e.status =:status and e.Estudio =:estudio")
            ->setParameters(array("status"=> $status, "estudio" => $estudio))
            ->OrderBy("e.tipo", "ASC");
    }
  
}
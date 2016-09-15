<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class TipoCuentaContableRepository extends EntityRepository
{
    private function getQueryBuilder() {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:TipoCuentaContable', 'e');
    }
    public function getTipoCuentasContables($estudio,$status = 0) {
        return $this->getEntityManager()->createQueryBuilder()
                    ->select('e')
                    ->from('AppBundle:TipoCuentaContable', 'e')
                    ->where('e.status = :status and (e.esp = 1 or e.Estudio = :estudio)')
                    ->setParameters(array("estudio"=>$estudio, "status"=>$status));
    }
    
    public function getCobros($estudio){
        return $this->getQueryBuilder()
                    ->andWhere("e.egresoingreso = 1 and (e.esp = 1 or e.Estudio = :estudio)")
                    ->setParameters(array("estudio"=>$estudio));
    }
    public function getDeudas($estudio){
        return $this->getQueryBuilder()
                    ->andWhere("e.egresoingreso = 0 and (e.esp = 1 or e.Estudio = :estudio)")
                    ->setParameters(array("estudio"=>$estudio));
    }    
    
    public function getExistTipoCuentaContable($estudio, $codigo, $nombre, $tipoCuentaContableId = -1){
        //1. Buscar si existe entre los especiales
        $cant = $this->getQueryBuilder()
                    ->select('count(e.id)')
                    ->andWhere("e.esp = 1 and ((e.codigo like :codigo or e.nombre like :nombre) and e.id != :id) ")
                    ->setParameters(array("codigo"=>$codigo,
                                          "nombre"=> $nombre, 
                                          "id"=> $tipoCuentaContableId
                                    ))
                    ->getQuery()->getSingleScalarResult();
        if($cant > 0){ return true; }
        
        //2. Buscar si existe entre los del mismo estudio
        $cant = $this->getQueryBuilder()
                    ->select('count(e.id)')
                    ->andWhere("e.esp = 0 and e.Estudio = :estudio and ((e.codigo like :codigo or e.nombre like :nombre) and e.id != :id)")
                    ->setParameters(array("codigo"=>$codigo,
                                          "nombre"=> $nombre,  
                                          "estudio"=> $estudio, 
                                          "id"=> $tipoCuentaContableId
                                         ))
                    ->getQuery()->getSingleScalarResult();
        if($cant > 0){ return true; }        
        
        
        return false;
    }
}
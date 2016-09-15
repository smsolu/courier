<?php

namespace AppBundle\Controller\Expediente;

//use LegalPro\Bundles\CommonBundle\Entity\Entidad;
//use LegalPro\Bundles\CommonBundle\Entity\Expediente;
//use LegalPro\Bundles\CommonBundle\Services\MenuGenerator\MenuGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControlsController extends Controller
{   
    /**
    * @Template("AppBundle:Controls:Expediente/Combobox.html.twig")
    */
    public function CreateComboBoxAction($tipo,$controlName, $disabled = false)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio = $user->getEstudio();        

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and ((e.Estudio = :id_estudio) or e.esp =1)");
        
        switch ($tipo){
            case "tipo_proceso":
                $queryBuilder->setParameters(array("status"=> 0, "id_estudio"=>$estudio));
                $queryBuilder->from('AppBundle:TipoProceso','e');
                $queryBuilder->addOrderBy('e.esp','DESC'); 
                $queryBuilder->addOrderBy('e.nombre','ASC'); 
            break;
        }
        $result = $queryBuilder->getQuery()->getResult();

            
                
        
        return array("usuario"=>$user,"disabled" => $disabled, "tipo"=>$tipo,"controlName"=>$controlName, "estudio"=>$estudio,"result"=>$result);
    }
    
}

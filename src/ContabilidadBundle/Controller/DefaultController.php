<?php

namespace ContabilidadBundle\Controller;

use LegalPro\Bundles\CommonBundle\Services\ListView\LinkColumn;
use LegalPro\Bundles\CommonBundle\Services\ListView\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LegalPro\Bundles\ContabilidadBundle\Entity\CobroCC;
use LegalPro\Bundles\ContabilidadBundle\Entity\DeudaCC;
use LegalPro\Bundles\ContabilidadBundle\Entity\DeudaCobroCC;


/**
 * @Route("/cc")
 * @Template()
 */
class DefaultController extends Controller
{
    
    /**
     * @Route("/reset",name="cc_reset")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function resetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        
        
        
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   


        $cc = $this->get('ContabilidadCCManager');
        $cc->TEST_ResetearMontosCobrados($expediente);
        $mensaje = "SE RESETEARON LAS DEUDAS";
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }
    
    
    
    /**
     * @Route("/cc_deuda_delete/{deudaid}",name="cc_deuda_delete")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function deleteDeudaAction($deudaid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        
        
        
        $repository = $this->getDoctrine()->getRepository('ContabilidadBundle:DeudaCC');
        $deuda = $repository->find($deudaid);   


        $cc = $this->get('ContabilidadCCManager');
        $cc->EliminarDeuda($deuda);
        
        $mensaje = "Se elimino la deuda: " . $deuda->getId();
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }    
    
    
    /**
     * @Route("/cc_clear/{logical}",name="cc_clear")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function clearAction($logical)
    {
        
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   
        
        if($logical == "true"){$logical = true;}else{$logical = false;}

        $cc = $this->get('ContabilidadCCManager');
        $cc->EliminarCuentaCorriente($expediente,$logical);
        
        $mensaje = "Se elimino la cuenta corriente del cliente";
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }    
    
    
/**
     * @Route("/cc_cobro_delete/{id}",name="cc_cobro_delete")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function deleteCobroAction(CobroCC $cobro)
    {

        
        //$repository = $this->getDoctrine()->getRepository('ContabilidadBundle:CobroCC');
        //$cobro = $repository->find($cobroid);   


        $cc = $this->get('ContabilidadCCManager');
        $cc->EliminarCobro($cobro);
        
        
        
        $mensaje = "Se elimino el cobro: " . $cobro->getId() .  "TIEMPO: " . $cc->getTimeFunction("EliminarCobro");
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }        
    
    
    /**
     * @Route("/creardeuda",name="cc_creardeuda")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        
        
        
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   


        $cc = $this->get('ContabilidadCCManager');
        $deuda = $cc->NuevaDeuda($expediente, "creacion de la deuda", $this->RandNumber(), "descripcion de la deuda",'now',false);
        $em->persist($deuda);
        $em->flush();
        $cc->calculateExpedienteCC($expediente);
        $mensaje = "Deuda Creada {ID = " . $deuda->getId() . "}";
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }
    
    /**
     * @Route("/list/{mensaje}",name="cc_list")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function listAction(Request $request, $mensaje){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();         
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   
        
        $cc = $this->get('ContabilidadCCManager');
        
        
        $saldocc = $cc->getSaldoCC($expediente);
        $mpa = $cc->getMPA($expediente);
        
        $saldocc_sincalcular = $cc->getSaldoCC($expediente,false);
        $mpa_sincalcular = $cc->getMPA($expediente,false);        
        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('d')
            ->where("d.status =:status and d.Estudio = :id_estudio")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio))
            ->from('ContabilidadBundle:DeudaCC','d');        
        
        $Abogados = $queryBuilder->getQuery()->getResult();         
        $list = new ListView();
        $list
            ->setTitle("Deuda")
            ->setControllerParent($this);
            $list->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("cc_deuda_delete", array("deudaid"=>"getId")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
                );  
            $list->addColumn("ID", 'id',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Fecha", 'fechayhora',array(
                'type' => 'datetime',
                'allow_order'=>'0',
                ));

             $list->addColumn("Monto", 'montodeuda',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Cobrado", 'montocobrado',array(
                'type' => 'string',
                'allow_order'=>'0',
                )); 
             $list->addColumn("Restante", 'montorestante',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Cancelado", 'cancelado',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));                  
            $list->setPage(1);
            $list->setResultPage(1000);
            $list->setQueryBuilder($queryBuilder);
            $list->setOrderCol("", "");
   
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('c')
            ->where("c.status =:status and c.Estudio = :id_estudio")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio))
            ->from('ContabilidadBundle:CobroCC','c');        
        
        $Abogados = $queryBuilder->getQuery()->getResult();         
        $list2 = new ListView();
        $list2
            ->setTitle("Cobro")
            ->setControllerParent($this);
            $list2->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("cc_cobro_delete", array("id"=>"getId")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
                );              
            $list2->addColumn("ID", 'id',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list2->addColumn("Fecha", 'fechayhora',array(
                'type' => 'datetime',
                'allow_order'=>'0',
                ));

             $list2->addColumn("Monto", 'montocobro',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list2->addColumn("Asignado", 'montoasignado',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));  
             $list2->addColumn("Restante", 'montorestante',array(
                'type' => 'string',
                'allow_order'=>'0',
                )); 
             $list2->addColumn("Cancelado", 'cancelado',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));                  
            $list2->setPage(1);
            $list2->setResultPage(1000);
            $list2->setQueryBuilder($queryBuilder);
            $list2->setOrderCol("", "");            
            
            
            $parameters = null;
        return array("list" => $list,"list2" => $list2,"request"=>$request,"parameters"=>$parameters,"mensaje"=>$mensaje,
                     "SaldoCC" =>$saldocc, "MPA"=>$mpa,"saldocc_sincalcular"=>$saldocc_sincalcular, "mpa_sincalcular"=>$mpa_sincalcular);
    }
    
    /**
     * @Route("/crearcobro",name="cc_crearcobro")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function crearCobroAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
    
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   

        $cc = $this->get('ContabilidadCCManager');
        $cobro = $cc->NuevoCobro($expediente, "titulo 1", $this->RandNumber(), "cobro x",'now',false);
        $em->persist($cobro);
        $em->flush();
        $cc->calculateExpedienteCC($expediente);
        
        $mensaje = "Cobro Creado {ID = " . $cobro->getId() . "}";
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
    }    

    function float_rand($Min, $Max, $round=0){
        //validate input
        if ($Min>$Max) { $min=$Max; $max=$Min; }
            else { $min=$Min; $max=$Max; }
        $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        if($round>0)
            $randomfloat = round($randomfloat,$round);

        return $randomfloat;
    }
    public function RandNumber(){
        return $this->float_rand(1, 1000,2);
    }
    /**
     * @Route("/AutoAsignarMPA/{algoritmo}",name="cc_autoasignarmpa")
     * @Template("ContabilidadBundle:Default:index.html.twig")
     */
    public function AutoAsignarMPAAction($algoritmo)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        
        
        
        $repository = $this->getDoctrine()->getRepository('CommonBundle:Expediente');
        $expediente = $repository->find("1");   


        $cc = $this->get('ContabilidadCCManager');
        $mpaAnt = $cc->getMPA($expediente);
        $cantdeudasmodificadas = $cc->AutoAsignarMPA($expediente,$algoritmo);
        $mpaDesp = $cc->getMPA($expediente);
        
        
        $mensaje = "AUTOASIGNAR MONTO PENDIENTE DEUDAS MODIFICADAS = " . $cantdeudasmodificadas . " MPA ANTES = " . $mpaAnt . " MPA DESPUES = " . $mpaDesp;
        return $this->redirectToRoute("cc_list", array("mensaje"=>$mensaje),301);
        
    }   
}

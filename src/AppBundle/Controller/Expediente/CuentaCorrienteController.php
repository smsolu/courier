<?php

namespace AppBundle\Controller\Expediente;;;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\TipoCuentaContable;
use ContabilidadBundle\Entity\CobroCC;
use ContabilidadBundle\Entity\DeudaCC;
use ContabilidadBundle\Form\Type\CobroCCType;
use ContabilidadBundle\Form\Type\DeudaCCType;
use DateTime;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\Exception;

    /**
     * @Route("/expediente/")
     */
class CuentaCorrienteController extends Controller
{
    private function getSaldoAcumulado($fechayhora_desde,$estudio, $expediente,$em){
        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('cc')
            ->from('AppBundle:vOperacionCC','cc')
            ->where("cc.Expediente =:expediente and cc.Estudio = :estudio "
                    . "and cc.fechayhora < :fecha1" )
            ->setParameters(array("estudio"=>$estudio, "expediente"=>$expediente,
                            "fecha1"=> $fechayhora_desde)); 
        $operaciones = $queryBuilder->getQuery()->getResult();
        $saldo_acumulado = 0;
        foreach($operaciones as $ope){
            switch($ope->getTipo()){
                case 0:
                    $saldo_acumulado = $saldo_acumulado + $ope->getMonto();
                break;
                case 1:
                    $saldo_acumulado = $saldo_acumulado - $ope->getMonto();
                break;
            }
        }
        return $saldo_acumulado;
    }
    
    
    
    
    /**
     * @Route("{expediente}/cc/new/{tipo}",defaults={"tipo"= "gasto"}, name="expediente_cc_new")
     * @Template()
     */
    public function newAction(Request $request,Expediente $expediente,$tipo = "gasto"){
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
        $seccion = "Cuenta Corriente";
        
        if (!($tipo == "cobro"||$tipo == "deuda")){
            throw new \InvalidArgumentException(sprintf('Tipo de Gasto inesperado {%s}', $tipo));
        }
        // Para filtrar los tipos de cuenta contable
        $em = $this->getDoctrine()->getEntityManager();

//        $queryBuilder =  $em->createQueryBuilder()
//                                  ->select('t')
//                                  ->from('AppBundle\Entity\TipoCuentaContable','t')
//                                  ->where('t.status = 0 and (t.esp = 1 or t.Estudio = :estudio)')
//                                  ->setParameters(array('estudio'=> $estudio));
        
        
                    
        if($tipo == "cobro"){
            $obj = new CobroCC();
            //$queryBuilder->andWhere("t.egresoingreso = 1");
            $clase = CobroCCType::class;
            $queryBuilder = $em->getRepository('AppBundle:TipoCuentaContable')->getCobros($estudio);
            //$formtype = new CobroCCType();
//            $formtype->buildForm($builder, $options)
        }else{
            $obj = new DeudaCC();
            $queryBuilder = $em->getRepository('AppBundle:TipoCuentaContable')->getDeudas($estudio);
            //$queryBuilder->andWhere("t.egresoingreso = 0");
            //$formtype = new DeudaCCType();
            $clase = DeudaCCType::class;
            
        }
        

        $tipoCuenta = $queryBuilder->getQuery()->getResult();
        
        $obj->setEstudio($estudio);
        $obj->setExpediente($expediente);
        $obj->setContabilizar(1);
        $form = $this->createForm($clase, $obj,array('tipoCuenta'=> $tipoCuenta));
        
        //$form = $this->createForm($formtype, $obj,array('TipoCuenta'=>$tipoCuenta)); 
        $form->handleRequest($request);        
  
        if($form->isValid()) {
            $obj = $form->getData();
            $em->persist($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Se ha registrado correctamente");                
            return $this->redirectToRoute('expediente_cc_list', array('expediente'=>$expediente->getId()), 301); 
        }
        
        // TODO: Hay que guardar la fecha desde y hasta
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($this->get('translator')->trans('title_new')  . ' ')
                ->setForm($form->createView())
                ->setShowButtonModify(false)
                ->setCancelPath($this->generateUrl('expediente_cc_list', array('expediente' => $expediente->getId())));
        return array('abmManager' => $abmManager,'expediente'=>$expediente,'section'=>$seccion);        
    }    
    
    /**
     * @Route("{expediente}/cc/list/{fecha_desde}/{fecha_hasta}/{page}/{order_col}/{order_status}",defaults={"fecha_desde"= "", "fecha_hasta"="", "page"="1", "resultpage"="10","order_col"="","order_status"="0"},  name="expediente_cc_list")
     * @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status,$fecha_desde,$fecha_hasta)
    {
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
        // Buscar el expediente con el ID
        $seccion = "Cuenta Corriente";
        
        // Listar las operaciones asociadas al expediente!
        // Fecha desde y hasta (por defecto siempre ver este mes)
        // Combo -> Ver Movimientos de este mes
        //       -> Ver Movimientos de este año
        //       -> Ver Todos los movimientos
        
        
        //Saldo Anterior a la fecha->
        //Fecha y hora
        //Tipo de Cuenta
        //Descripcion Breve (Titulo)
        //Monto
        //Saldo
        
        if($fecha_desde==""||$is_null($fecha_desde) ){ $fecha_desde = "01-01-2000 00:01"; }
        if($fecha_hasta==""||$is_null($fecha_hasta)){ $fecha_hasta = "01-01-2100 23:59"; }
        
        $fecha1 =DateTime::createFromFormat('d-m-Y H:i', $fecha_desde);
        if(!$fecha1){
            $fecha1 = DateTime::createFromFormat('d-m-Y', "1-1-1900");
        }
        $fecha2 =DateTime::createFromFormat('d-m-Y H:i', $fecha_hasta);
        if(!$fecha2){
            $fecha2 = DateTime::createFromFormat('d-m-Y', "1-1-2100");
        }              

        $saldo_ant = $this->getSaldoAcumulado($fecha1,$estudio,$expediente,$em);
        
        $cc = $this->get('cc_ContabilidadCCManager'); 
        $saldoCC = $cc->getSaldoCCExpediente($expediente);

        
        
 // 1. Crear el Query del Listado.
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('cc')
            ->from('AppBundle:vOperacionCC','cc')
            ->where("cc.Expediente =:expediente and cc.Estudio = :estudio ")
            ->setParameters(array("estudio"=>$estudio, "expediente"=>$expediente));


        //$opes = $queryBuilder->getQuery()->getResult();

        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("Expedientes Favoritos")
            ->setControllerParent($this)
            ->addColumn("Fecha y Hora", 'Fechayhora',array(
                'type' => 'datetime',
                'allow_order'=>'0',
                ))
            ->addColumn("Tipo", 'TipoCuentaContable.nombre',array(
                'type' => 'object',
                'allow_order'=>'0',
                ))                
            ->addColumn("Descripción", 'titulo',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))
            ->addColumn("Monto", 'monto',array(
                'type' => 'money',
                'allow_order'=>'0',
                ))
            ->addColumn("Saldo", 'acumulado',array(
                'type' => 'money',
                'allow_order'=>'0',
                'sum_start'=>$saldo_ant,
                'sum_field'=>"monto"
                ))
                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status)        
            ->setSendObjects(true);
    
        
        
        
        return array("request" => $request, "list" => $list, "expediente"=>$expediente, "section"=>$seccion,
                    "saldocc" => $saldoCC, "fecha1"=> $fecha1, "fecha2"=> $fecha2);        
    }
}
    
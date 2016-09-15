<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\Services\ContabilidadCCManager;
use ContabilidadBundle\Services\cc_ContabilidadCCManager;
use DateTime;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/cc")
 * @Template()
 */
class TestController extends Controller
{
    
    private function addOpe($nombre, $parameters, $result, $result_expected,$cc){
        $ope["name"] = $nombre;
        $ope["parameters"] = $parameters;
        $ope["result"] = $result;
        $ope["time"] = $cc->getTimeFunction($ope["name"]);
        $ope["exception"] = $cc->getLastErrException($ope["name"]);
        $ope["result_expected"] = $result_expected;
        if($ope["result"]==$ope["result_expected"]){
            $ope["isok"] = "<span class='glyphicon glyphicon-ok' style = 'color:green'></span>";
        }else{
            $ope["isok"] = "<span class='glyphicon glyphicon-remove' style = 'color:red'></span>";
        }
        return $ope;
    }
    
    private function addOpeAutoAsignarMPA($ope,$cc,$expediente){
            $cc->EliminarCuentaCorrienteExpediente(true);
            $datetime = new DateTime();
            $fecha1 = $datetime->createFromFormat('d/m/Y', '23/05/2013');
            $fecha2 = $datetime->createFromFormat('d/m/Y', '23/05/2016');
            $fecha3 = $datetime->createFromFormat('d/m/Y', '23/05/2015');
            
            $cc->NuevaDeuda($expediente, "Deuda 1", 100, "descripcion de la deuda", $fecha1,true);
            $deuda1 = $cc->getLastDeuda();
            $cc->NuevaDeuda($expediente, "Deuda 2", 150, "descripcion de la deuda",$fecha2,true);
            $deuda2 = $cc->getLastDeuda();
            $cc->NuevaDeuda($expediente, "Deuda 3", 200, "descripcion de la deuda",$fecha3,true);
            $deuda3 = $cc->getLastDeuda();
            
            // ASIGNAR_MPA_DEUDASVIEJASPRIMERO:
            $cobro = $cc->NuevoCobro($expediente, "titulo 1",150, "cobro x",'now',true);
            // SE CANCELARIA LA DEUDA 1 Y LUEGO LA DEUDA 3 SE REGISTRARIAN 50.

            $result_expected = true;
            $result = $cc->AutoAsignarMPA($expediente, $ope);
            
            //Check
            $repository = $this->getDoctrine()->getRepository('ContabilidadBundle:DeudaCC');
            $deuda1 = $repository->find($deuda1->getId());  //23/05/2013
            $deuda2 = $repository->find($deuda2->getId());  //23/05/2016
            $deuda3 = $repository->find($deuda3->getId());  //23/05/2015
            
        switch($ope){
            case ContabilidadCCManager::ASIGNAR_MPA_DeudasNuevasPrimero:
                // Deuda 2 - CANCELADA 
                $parametros ="AutoAsignar MPA - Las mas Nuevas Primero";
                //cantidad de deudas que modifico
                if($result == 1 && $deuda2->getMontoRestante() == 0 && $deuda2->getCancelado() == 1 && $deuda1->getMontoRestante() == $deuda1->getMontoDeuda() && $deuda3->getMontoRestante() == $deuda3->getMontoDeuda()){
                    $result = true;
                }else{
                    $result = false;
                }                
            break;
            case ContabilidadCCManager::ASIGNAR_MPA_DeudasViejasPrimero:
                // Deuda 1 - CANCELADA + DEUDA 3 - MONTO RESTANTE = 150
                $parametros ="AutoAsignar MPA - Las mas Viejas Primero";
                //cantidad de deudas que modifico
                if($result == 2 && $deuda1->getMontoRestante() == 0 && $deuda1->getCancelado() == 1 && $deuda2->getMontoRestante() == 150){
                    $result = true;
                }else{
                    $result = false;
                }                      
            break;
            case ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoGrandePrimero:
                // Deuda 3 - SIN CANCELAR MONTO RESTANTE = 50 
                $parametros ="AutoAsignar MPA - Con el Monto mas Grande Primero";
                //cantidad de deudas que modifico
                if($result == 1 && $deuda3->getMontoRestante() == 50 && $deuda3->getCancelado() == 0 && $deuda1->getMontoRestante() == $deuda1->getMontoDeuda() && $deuda2->getMontoRestante() == $deuda2->getMontoDeuda()){
                    $result = true;
                }else{
                    $result = false;
                } 
            break;
            case ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoChicoPrimero:
                // Deuda 1 - CANCELADO + DEUDA 2 -> MONTO RESTANTE 100
                $parametros ="AutoAsignar MPA - Con el Monto mas Chico Primero";
                //cantidad de deudas que modifico
                if($result == 2 && $deuda1->getMontoRestante() == 0 && $deuda1->getCancelado() == 1 && $deuda2->getMontoRestante() == 100 && $deuda3->getMontoRestante() == $deuda3->getMontoDeuda()){
                    $result = true;
                }else{
                    $result = false;
                } 
            break;
        }
        
        return $this->addOpe("AutoAsignarMPA", $parametros,$result, $result_expected,$cc);        
    }
    
     private function addOpeNuevoCobroGeneral($cc,$expediente,$entidad){
            $cc->EliminarCuentaCorrienteExpediente(true);
            $cant = 3;
            $montoCobros = 0;
            
            for ($j = 0;$j<$cant;$j++){
                $monto =  $this->RandNumber();
                $montoCobros = $montoCobros + $monto;
                $cobros[] =  $cc->NuevoCobro($expediente, "titulo ". $j,$monto, "cobro x",'now',false);
            }
            $result = $cc->NuevoCobroGeneral($entidad, "COBRO GENERAL", $cobros, "DESCX", 'now');
            $parametros = "3 DEUDAS - MONTO TOTAL: " . $montoCobros . " ENTIDAD: " . $entidad->getNombre();
            $result_expected = true;
            
            return $this->addOpe("NuevoCobroGeneral", $parametros,$result, $result_expected,$cc);  
     }
     private function addOpeEliminarCobroGeneral($cc,$expediente,$entidad){
            $this->addOpeNuevoCobroGeneral($cc,$expediente,$entidad);
            $cobroGen = $cc->getLastCobroGeneral();
            $result = $cc->EliminarCobroGeneral($cobroGen);
            $result_expected = true;
            $parametros = "";
            return $this->addOpe("EliminarCobroGeneral", $parametros,$result, $result_expected,$cc);  
     }    
     
     private function addOpeGetSaldoEntidad($cc,$expediente,$entidad, $em){
         // Exp 1 -  Saldo $ 20.-
         // Exp 2 -  Saldo $ 40.-
         // Exp 3 -  Saldo $ 50.-
         
         $cobrosEntidad = 0;
         $cc->EliminarCuentaCorrienteEntidad($entidad,true);
         
         // Buscar 3 expedientes y agregarle cobros a esos 3 expedientes
        $repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente1 = $repository->find("1");   
        $expediente2 = $repository->find("2");   
        $expediente3 = $repository->find("2");   
        
        $expedientes[] = $expediente1;
        $expedientes[] = $expediente2;
        $expedientes[] = $expediente3;
        
        
        foreach($expedientes as $expediente){
            $expediente->setClientePrincipal($entidad);
            $em->persist($expediente);
            $em->flush();
             
            $cc->EliminarCuentaCorrienteExpediente($expediente);
            $montoCobros = 0;
            $cant = 3;
            for ($j = 1;$j<$cant;$j++){
                $monto =  $this->RandNumber();
                $montoCobros = $montoCobros + $monto;
                $cobros[] =  $cc->NuevoCobro($expediente, "titulo ". $j,$monto, "cobro x",'now',false);
            }         
            $result = $cc->NuevoCobroGeneral($entidad, "COBRO GENERAL", $cobros, "DESCX", 'now');
            $cobrosEntidad = $cobrosEntidad + $montoCobros;
        }
            $parametros = "";
            $result_expected = $cobrosEntidad;
            $result = $cc->getSaldoCCEntidad($entidad);

            return $this->addOpe("getSaldoCCEntidad", $parametros,$result, $result_expected,$cc);  
    }
     
    /**
     * @Route("/test",name="cc_test_list")
     * @Template("ContabilidadBundle:Test:testList.html.twig")
     */
    public function testListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente = $repository->find("1");   
        $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
        $entidad = $repository->find("1");
        
        $cc = $this->get('cc_ContabilidadCCManager');        
        $tiempo = round(microtime(true) * 1000);
        
        //1. Eliminar Cuenta Corriente!
        $operaciones[] = $this->addOpe("EliminarCuentaCorrienteExpediente", "Logical = True", $cc->EliminarCuentaCorrienteExpediente(true), true,$cc);
        
        //2. Crear Cobro
        $monto =  $this->RandNumber();
        $result = $cc->NuevoCobro($expediente, "titulo 1",$monto, "cobro x",'now',true);
        $parametros ="Titulo: titulo 1 - Monto: " . $monto . ",desc: cobro x,fechayhora: 'now', auto-persist: true";
        $operaciones[] = $this->addOpe("NuevoCobro", $parametros,$result, true,$cc);

        //3. Borrar el Cobro
        $cobro = $cc->getLastCobro();
        $result =  $cobro = $cc->EliminarCobro($cobro);
        $parametros ="";
        $operaciones[] = $this->addOpe("EliminarCobro", $parametros,$result, true,$cc);
        
        //4. Nueva Deuda        
        $monto =  $this->RandNumber();
        $result = $cc->NuevaDeuda($expediente, "creacion de la deuda", $monto, "descripcion de la deuda",'now',true);
        $result_requested = true;
        $parametros = "titulo: creacion de la deuda  - monto: $monto  descripcion:  descripcion de la deuda - fechayhora: now - autopersist: . true";
        $operaciones[] = $this->addOpe("NuevaDeuda", $parametros,$result, true,$cc);        
        
        //5. Eliminar Deuda     
        $monto =  $this->RandNumber();
        $result = $cc->EliminarDeuda($cc->getLastDeuda());
        $result_requested = true;
        $parametros = "";
        $operaciones[] = $this->addOpe("EliminarDeuda", $parametros,$result, true,$cc);           
        
        //5. SaldoCuentaCorriente
            //4.a: Eliminar Cuenta Corriente
            $cc->EliminarCuentaCorrienteExpediente(true);
            
            $cant = 3;
            //4.b: Crear Deudas
            $montoDeudas = 0;
            for ($j = 0;$j<$cant;$j++){
                $monto =  $this->RandNumber();
                $result = $cc->NuevaDeuda($expediente, "creacion de la deuda", $monto, "descripcion de la deuda",'now',true);
                if($result){
                    $montoDeudas = $montoDeudas + $monto;
                }else{
                    $montoDeudas = -1000; // para que falle
                }
            }            
            
            //4.c: Crear Cobros
            $montoCobros = 0;
            for ($j = 0;$j<$cant;$j++){
                $monto =  $this->RandNumber();
                $result =  $cc->NuevoCobro($expediente, "titulo ". $j,$monto, "cobro x",'now',true);
                if($result){
                    $montoCobros = $montoCobros + $monto;
                }else{
                    $montoCobros = -1; // para que falle
                }
            }
            $parametros ="calculate = true";
            $result_expected = $montoDeudas - $montoCobros;
            $result = $cc->getSaldoCCExpediente($expediente,true);
            $operaciones[] = $this->addOpe("getSaldoCCExpediente", $parametros,$result, $result_expected,$cc);
            
        //6. SaldoCuentaCorriente
            $parametros ="calculate = false [cache]";
            $result_expected = $montoDeudas - $montoCobros;
            $result = $cc->getSaldoCCExpediente($expediente,false);
            $operaciones[] = $this->addOpe("getSaldoCCExpediente", $parametros,$result, $result_expected,$cc);
            
            
        //7. Asignar Monto Pendiente de Aplicacion
            $operaciones[] = $this->addOpeAutoAsignarMPA(ContabilidadCCManager::ASIGNAR_MPA_DeudasViejasPrimero,$cc,$expediente);
            $operaciones[] = $this->addOpeAutoAsignarMPA(ContabilidadCCManager::ASIGNAR_MPA_DeudasNuevasPrimero,$cc,$expediente);
            $operaciones[] = $this->addOpeAutoAsignarMPA(ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoGrandePrimero,$cc,$expediente);
            $operaciones[] = $this->addOpeAutoAsignarMPA(ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoChicoPrimero,$cc,$expediente);
        
        // 8. Nuevo Cobro General
            $operaciones[] = $this->addOpeNuevoCobroGeneral($cc,$expediente,$entidad);
        // 9. Eliminar Cobro General
            $operaciones[] = $this->addOpeEliminarCobroGeneral($cc,$expediente,$entidad);
        
        // 10. GetSaldoEntidad    
            $operaciones[] = $this->addOpeGetSaldoEntidad($cc,$expediente,$entidad,$em);
            
        $tiempo = round(microtime(true) * 1000) - $tiempo;
        
        $list = new ListView();
        $list
            ->setTitle("Cobro")
            ->setControllerParent($this);
            $list->addColumn("", 'isok',array(
                'type' => 'raw',
                'allow_order'=>'0',
                ));            
            $list->addColumn("Nombre", 'name',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Parametros", 'parameters',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Tiempo", 'time',array(
                'type' => 'string',
                'allow_order'=>'0',
                )); 
             $list->addColumn("Res. Esperado", 'result_expected',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
             $list->addColumn("Resultado", 'result',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));  
            $list->setData($operaciones); 

        
        $titulo = "Test - Cuenta Corriente";
        return array("titulo" => $titulo, "tiempo"=> $tiempo, "operaciones" =>$operaciones, 
                     "expediente" => $expediente, "entidad"=>$entidad, "request"=>$request,
                     "list"=>$list,"parameters"=>null);
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


        $cc = $this->get('cc_ContabilidadCCManager');
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
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente = $repository->find("1");   
        
        if($logical == "true"){$logical = true;}else{$logical = false;}

        $cc = $this->get('cc_ContabilidadCCManager');
        $cc->EliminarCuentaCorrienteExpediente($expediente,$logical);
        
        $mensaje = "Se elimino la cuenta corriente del cliente";
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
    
}

<?php
namespace ContabilidadBundle\Services;

use DateTime;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\Estudio;

use ContabilidadBundle\Entity\CobroCC;
use ContabilidadBundle\Entity\CobroGeneralCC;
use ContabilidadBundle\Entity\DeudaCC;
use ContabilidadBundle\Entity\DeudaCobroCC;
use ContabilidadBundle\Entity\SaldoExpedienteCC;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Serializer\Exception\Exception;


class ContabilidadCCManager {
    
    const ASIGNAR_MPA_DeudasViejasPrimero = 0;
    const ASIGNAR_MPA_DeudasNuevasPrimero = 1;
    const ASIGNAR_MPA_DeudasMontoGrandePrimero = 2;
    const ASIGNAR_MPA_DeudasMontoChicoPrimero = 3;
    
    const AsignarEnlacePago_montorestante_insuficiente = -101;
    const AsignarEnlacePago_registros_borrados = -102;
    const AsignarEnlacePago_expediente_diferente = -103;
    const AsignarEnlacePago_ok = true;
    
    const getTotalDeudas_MontoDeuda = 0;
    const getTotalDeudas_MontoCobrado = 1;
    const getTotalDeudas_MontoRestante = 2;
    
    const getTotalCobros_MontoCobro = 0;
    const getTotalCobros_MontoAsignado = 1;
    const getTotalCobros_MontoRestante = 2;
    
    
    const validarExpedienteCC_Ok = true;
    const validarExpedienteCC_NoPermiteCC = -101;
    const validarExpedienteCC_SuperaMaxPermitido = -102;
    const validarExpedienteCC_NoExiste = -103;
    
    private $estudio;
    private $user;
    private $em;
    private $last_cobro;
    private $last_deuda;
    private $last_cobroGen;
    
    private $last_err_Exception=null;
    private $last_err_Function='';
    private $time_functions;
    
    public function getLastErrException(){
        return $this->last_err_Exception;
    }
    public function getLastErrFunction(){
        return $this->last_err_Function;
    }
    private function setLastErrException($ex,$function){
        $this->last_err_Exception = $ex;
        $this->last_err_Function = $function;
        $this->timeEndTime($function);
    }
    public function timeStartTime($function){
        $this->time_functions[$function]= round(microtime(true) * 1000);
    }
    public function timeEndTime($function){
        $this->time_functions[$function]= round(microtime(true) * 1000) - $this->time_functions[$function];
    }
    public function getTimeFunction($function){
        return $this->time_functions[$function];
    }
    
    
    public function __construct($entityManager,  TokenStorage $tokenStorage) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
    }

    public function setEstudio(Estudio $estudio){
        $this->estudio = $estudio;
    }
    public function getEstudio(){
        return $this->estudio;
    }    
    
    private function setLastCobro($cobro){
        $this->last_cobro = $cobro;
    }    
    public function getLastCobro(){
        return $this->last_cobro;
    }
    private function setLastDeuda($deuda){
        $this->last_deuda = $deuda;
    }    
    public function getLastDeuda(){
        return $this->last_deuda;
    }
    private function setLastCobroGeneral($cobroGen){
        $this->last_cobroGen = $cobroGen;
    }    
    public function getLastCobroGeneral(){
        return $this->last_cobroGen;
    }
    
    /**
     * Obtiene el Monto Pendiente de Aplicación
     * MPA = SUM(COBROSNOASIGNADOS)
     * @param type $Expediente Expediente a la que se le desea obtener el MPA
     * @param type $calculate =FALSE, calcula los montos
     */
    public function getMPA($Expediente, $calculate = true){
        if($calculate == true){
            $montonoasignado = $this->getTotalCobros($Expediente,ContabilidadCCManager::getTotalCobros_MontoRestante);
        }else{
            $saldoExpedienteCC = $this->getExpedienteCC($Expediente);
            return $saldoExpedienteCC->getMpa();            
        }
        
        return ($montonoasignado);
    }
    
    /**
     * Obtiene el Saldo de la Cuenta Corriente: (Total de Deudas - Total de Cobros)
     * @param type $Expediente
     */
    public function getSaldoCCExpediente($Expediente, $calculate = true){
        $this->timeStartTime("getSaldoCCExpediente");
        if($calculate == true){
            $montodeudas =  $this->getTotalDeuda($Expediente,ContabilidadCCManager::getTotalDeudas_MontoDeuda);
            $montocobros = $this->getTotalCobros($Expediente,ContabilidadCCManager::getTotalCobros_MontoCobro);
            $this->timeEndTime("getSaldoCCExpediente");
            return ($montodeudas - $montocobros);
        }else{
            $saldoExpedienteCC = $this->getExpedienteCC($Expediente);
            $this->timeEndTime("getSaldoCCExpediente");
            return $saldoExpedienteCC->getSaldoCC();                   
        }
    }

    
    
    /***************************************************************************
     * COMIENZO - SALDO ENTIDAD CC
     * ADMINISTRA EL REGISTRO DE SALDO DE ENTIDAD, QUE SE USA PARA GUARDAR
     * LOS PARAMETROS DE LA CUENTA CORRIENTE DE ENTIDAD, COMO MAXIMO DE CC 
     * PERMITIDO, Y TAMBIEN SIRVE PARA GUARDAR ALGUNOS REGISTROS A FIN DE 
     * REALIZAR CACHE DE LA INFORMACIÓN Y NO TENER QUE RECALCULARLO TODO EL
     * TIEMPO.
     **************************************************************************/
    
    
    /**
     * Devuelve la expediente para poder cargar el registro.
     * @param type $Expediente
     * @return Expediente
     */
    private function getExpedienteCC($Expediente){
        $repo = $this->em->getRepository('ContabilidadBundle:SaldoExpedienteCC');
        $saldoExpedienteCC = $repo->findOneby(array("Expediente"=>$Expediente));
        // Si no existe, crear uno!
        if($saldoExpedienteCC==null){
            $this->newExpedienteCC($Expediente,1,0,true);
            $repo = $this->em->getRepository('ContabilidadBundle:SaldoExpedienteCC');
            $saldoExpedienteCC = $repo->findOneby(array("Expediente"=>$Expediente));
        }        
        
        return $saldoExpedienteCC;
    }        
    
    /**
     * Genera un registro de Expediente para poder guardar el maximo de cc Permitido, y si permite CC
     * @param type $Expediente
     * @param type $cc_permitecc
     * @param type $cc_max
     */
    public function newExpedienteCC($Expediente,$cc_permitecc = 1, $cc_max = 0,$force_create = false){
        
        if($force_create == false){
            $saldoCC = getExpedienteCC($Expediente); //Lo busca y sino lo crea
        }else{
            $saldoCC = new SaldoExpedienteCC();   // Lo crea
        }
        
        $saldoCC->setEstudio($this->estudio);
        $saldoCC->setExpediente($Expediente);
        $saldoCC->setStatus(0);
        $saldoCC->setCCmax($cc_max);
        $saldoCC->setPermiteCC($cc_permitecc);
        
        $this->em->persist($saldoCC);
        $this->em->flush();
    }
    
    /**
     * Recalcula la información que esta guardada en el registro de ExpedienteCC
     * @param Expediente $expediente
     */
    public function calculateExpedienteCC($expediente){
        $saldoExpedienteCC = $this->getExpedienteCC($expediente);
        
        //1. Actualizar el SALDO DE CC
        $saldoExpedienteCC->setSaldoCC($this->getSaldoCCExpediente($expediente));
        //2. Actualizar el MPA
        $saldoExpedienteCC->setMpa($this->getMpa($expediente));
        
        $this->em->persist($saldoExpedienteCC);
        $this->em->flush();

    }
    
    /***************************************************************************
     * FIN SALDO ENTIDAD CC
     **************************************************************************/
    
    
    /**
     * Valida la expediente si puede realizar movimientos
     * @param type $Expediente
     * return Error
     */
    public function validarExpedienteCC($Expediente,$montoNuevaDeuda = 0){
        $saldoExpedientecc = $this->getExpedienteCC($Expediente);
        
        //1. Validar si existe la expediente
        if(!$saldoExpedientecc){
            return ContabilidadCCManager::validarExpedienteCC_NoExiste;
        }
        
        //2. Validar si permite un movimiento en cuenta corriente
        if($saldoExpedientecc->getPermiteCC() == 0){
            return ContabilidadCCManager::validarExpedienteCC_NoPermiteCC;
        }
        
        //3. Validar si la nueva deuda va a ser mayor al maximo de la CC.
        if($saldoExpedientecc->getCCMax() != 0 && $montoNuevaDeuda > 0 ){
            $ccActual = $this->getSaldoCCExpediente($Expediente);
            if ($montoNuevaDeuda+$ccActual  > $saldoExpedientecc->getCCMax() ){
                return ContabilidadCCManager::validarExpedienteCC_NoPermiteCC;
            }
        }
        
        return ContabilidadCCManager::validarExpedienteCC_Ok;
    }
    
    

    
    public function TEST_ResetearMontosCobrados($Expediente){
        
        //Resetear los cobros
        $sql = "update cc_cobro set monto_asignado = 0, monto_restante = monto_cobro,cancelado = 0 where id_expediente = " . $Expediente->getId();
        $this->em->getConnection()->exec($sql);

        //Resetear las deudas
        $sql = "update cc_deuda set monto_cobrado = 0, monto_restante = monto_deuda,cancelado = 0 where id_expediente = " . $Expediente->getId();
        $this->em->getConnection()->exec($sql);
        
        //Eliminar los enlaces
        $sql = "delete from cc_deuda_cobro where id_expediente = " . $Expediente->getId();
        $this->em->getConnection()->exec($sql);
        
    }
    
    
    public function getTotalCobros($Expediente, $fieldSum=  ContabilidadCCManager::getTotalCobros_MontoCobro){
        $fieldName = "montocobro";
        switch ($fieldSum){
            case ContabilidadCCManager::getTotalCobros_MontoCobro;DEFAULT:
                $fieldName="montocobro";
            break;
            case ContabilidadCCManager::getTotalCobros_MontoAsignado;
                $fieldName="montoasignado";
            break;
            case ContabilidadCCManager::getTotalCobros_MontoRestante;
                $fieldName="montorestante";
            break;
        }
        
        $queryBuilder = $this->em->createQueryBuilder('d');
        $queryBuilder
            ->select('sum(c.' . $fieldName . ') as total')
            ->where("c.status =:status and c.Estudio = :estudio and c.Expediente = :expediente "
                    . "and c.contabilizar = :contabilizar")
            ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "expediente"=>$Expediente,
                                  "contabilizar"=> 1))
            ->from('ContabilidadBundle:CobroCC','c');
        $total = $queryBuilder->getQuery()->getOneOrNullResult()["total"];
        if($total== null){$total = 0;}
        return $total;
    }
    
    
    /**
     * Devuelve la sumatoria de las deudas según el parametro fieldSUM
     * @param type $Expediente
     * @param type $fieldSum
     * @return double
     */
    public function getTotalDeuda($Expediente,$fieldSum=ContabilidadCCManager::getTotalDeudas_MontoDeuda){
        
        $fieldName = "montodeuda";
        switch ($fieldSum){
            case ContabilidadCCManager::getTotalDeudas_MontoDeuda;DEFAULT:
                $fieldName="montodeuda";
            break;
            case ContabilidadCCManager::getTotalDeudas_MontoCobrado;
                $fieldName="montocobrado";
            break;
            case ContabilidadCCManager::getTotalDeudas_MontoRestante;
                $fieldName="montorestante";
            break;
        }
        $queryBuilder = $this->em->createQueryBuilder('d');
        $queryBuilder
            ->select('sum(d.' . $fieldName . ') as total')
            ->where("d.status =:status and d.Estudio = :estudio and d.Expediente = :expediente "
                    . "and d.contabilizar = :contabilizar")
            ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "expediente"=>$Expediente,
                                  "contabilizar"=> 1))
            ->from('ContabilidadBundle:DeudaCC','d');
        $total = $queryBuilder->getQuery()->getOneOrNullResult()["total"];
        if($total== null){$total = 0;}
        return $total;
    }

    
    /**
     * Elimina el cobro, eliminando tambien los enlaces y actualizando las deudas
     * a las que se registro
     * @param type cobro
     */
    public function EliminarCobro(CobroCC $cobro,$calculateExpediente = true,$btrans =true){
        $bComenzoTrans = false;$this->timeStartTime("EliminarCobro");
        //1. Buscar Enlaces en la que participo la deuda:
        try{
            $queryBuilder = $this->em->createQueryBuilder('e');
            $queryBuilder
                ->select('e')
                ->where("e.status =:status and e.Estudio = :estudio "
                        . "and e.Cobro = :cobro")
                ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "cobro"=>$cobro))
                ->from('ContabilidadBundle:DeudaCobroCC','e');
            $enlaces = $queryBuilder->getQuery()->getResult();

            if($btrans){
                $this->em->getConnection()->beginTransaction();
                $bComenzoTrans = true;
            }

            foreach($enlaces as $enlace){
                if(! $this->EliminarEnlace($enlace,true,false)) {
                    if($btrans){$this->em->getConnection()->rollBack();}
                    return false;
                }
            }

            $cobro->setStatus(-1);
            $this->em->persist($cobro);
            $this->em->flush();

            if($btrans){$this->em->getConnection()->commit();}        

            if($calculateExpediente){
                $this->calculateExpedienteCC($cobro->getExpediente());
            }
            $this->timeEndTime("EliminarCobro");
            return true;
        } catch (Exception $ex) {
            $this->setLastErrException($ex,'EliminarCobro');
            if($bComenzoTrans()){ $this->em->getConnection()->rollBack(); }
            return false;
        }

    }
            
    /**
     * Elimina la deuda, eliminando tambien los enlaces y actualizando las deudas
     * a las que se registro
     * @param type $deuda
     */
    public function EliminarDeuda(DeudaCC $deuda,$calculateExpediente = true,$bTrans = true){
        $this->timeStartTime("EliminarDeuda");$bComenzoTrans = false;
  
        try{
            //1. Buscar Enlaces en la que participo la deuda:
            $queryBuilder = $this->em->createQueryBuilder('e');
            $queryBuilder
                ->select('e')
                ->where("e.status =:status and e.Estudio = :estudio "
                        . "and e.Deuda = :deuda")
                ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "deuda"=>$deuda))
                ->from('ContabilidadBundle:DeudaCobroCC','e');
            $enlaces = $queryBuilder->getQuery()->getResult();
            if($bTrans){
                $this->em->getConnection()->beginTransaction();
                $bComenzoTrans = true;
            }          
            foreach($enlaces as $enlace){
                $this->EliminarEnlace($enlace,false,true);
            }
            $deuda->setStatus(-1);

            $this->em->persist($deuda);
            $this->em->flush();
            if($calculateExpediente){
                $this->calculateExpedienteCC($deuda->getExpediente());
            }
            if($bComenzoTrans) {$this->em->getConnection()->commit(); }
            $this->timeEndTime("EliminarDeuda");
            return true;            
        }catch(Exception $ex){
            if($bComenzoTrans) {$this->em->getConnection()->rollBack(); }                   
            $this->setLastErrException($ex, "EliminarDeuda");
            return false;
        }

    }
    
    
    /**
     * AutoAsigna el monto pendiente de aplicación para cancelar las deudas 
     * dependiendo del algoritmo a usar.
     * @param type $Expediente
     * @param type $algoritmo 
     */
    public function AutoAsignarMPA($Expediente,$algoritmo = ContabilidadCCManager::ASIGNAR_MPA_DeudasViejasPrimero,$bTrans = true){
        $this->timeStartTime("AutoAsignarMPA");$bComenzoTrans = false;
        $mpa = $this->getMPA($Expediente);
        if($mpa <= 0){
            $this->timeEndTime("AutoAsignarMPA");
            return 0;
        }
        
        
        try{
            // 1. Obtener las deudas que no se han cancelado y que tienen un restante
            $queryBuilder = $this->em->createQueryBuilder('d');
            $queryBuilder
                ->select('d')
                ->where("d.status =:status and d.Estudio = :estudio and d.Expediente = :expediente "
                        . "and d.contabilizar = :contabilizar and d.cancelado = :cancelado and d.montorestante > 0")
                ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "expediente"=>$Expediente,
                                      "contabilizar"=> 1, "cancelado"=>0))
                ->from('ContabilidadBundle:DeudaCC','d');

            switch ($algoritmo){
                case ContabilidadCCManager::ASIGNAR_MPA_DeudasViejasPrimero;
                    $queryBuilder->addOrderBy('d.fechayhora','ASC');
                break;
                case ContabilidadCCManager::ASIGNAR_MPA_DeudasNuevasPrimero;
                    $queryBuilder->addOrderBy('d.fechayhora','DESC');
                break;
                case ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoGrandePrimero;
                    $queryBuilder->addOrderBy('d.montodeuda','DESC');
                break;
                case ContabilidadCCManager::ASIGNAR_MPA_DeudasMontoChicoPrimero;
                    $queryBuilder->addOrderBy('d.montodeuda','ASC');
                break;
            }

            $deudas = $queryBuilder->getQuery()->getResult();
            if (count($deudas) == 0){
                $this->timeEndTime("AutoAsignarMPA");
                return 0;
            }

            //2. Cargar los cobros que no han sido asignados aun
            $queryBuilder = $this->em->createQueryBuilder('d');
            $queryBuilder
                ->select('c')
                ->where("c.status =:status and c.Estudio = :estudio and c.Expediente = :expediente "
                        . "and c.contabilizar = :contabilizar and c.montorestante > 0")
                ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "expediente"=>$Expediente,
                                      "contabilizar"=> 1))
                ->from('ContabilidadBundle:CobroCC','c');        
                $queryBuilder->addOrderBy('c.fechayhora','ASC');

            $cobros = $queryBuilder->getQuery()->getResult();
            if (count($cobros) == 0){
                $this->timeEndTime("AutoAsignarMPA");
                return 0;
            }


            // Por cada deuda en la lista, recorrer todos los cobros y tratar de saldarla
            // el mpa se usa como un doble control ya que deberia ser el total de todos
            // los cobros que no se asignaron a ninguna deuda.
            if($bTrans){
                $this->em->getConnection()->beginTransaction();
                $bComenzoTrans = true;
            }            

            $cantdeudasmodificadas = 0;
            foreach( $deudas as $deuda )
            {
                if($mpa<=0){break;}
                foreach($cobros as $cobro){
                    if($mpa<=0){break;}
                    if($deuda->getMontoRestante() > 0 && $cobro->getMontoRestante() > 0 ){
                        $montoasignado = $cobro->getMontoRestante();
                        if($montoasignado > $deuda->getMontoRestante()){
                            $montoasignado = $deuda->getMontoRestante();
                        }

                        // En esta funcion se actualizan el monto restante y cobrado de la
                        // deuda y del cobro.
                        $rpta = $this->AsignarEnlacePago($deuda,$cobro,'now',$montoasignado,false);
                        if ($rpta == ContabilidadCCManager::AsignarEnlacePago_ok){
                            $mpa = $mpa - $montoasignado;
                            $cantdeudasmodificadas = $cantdeudasmodificadas +1;
                            $this->em->persist($cobro);
                            $this->em->flush($cobro);                        
                        }
                    }
                }

                if($deuda->getMontoRestante() == 0){
                    $deuda->setCancelado(1);
                    $deuda->setFechaCancelacion(new DateTime());
                }

                $this->em->persist($deuda);
                $this->em->flush();
            }
           if($bTrans){ $this->em->getConnection()->commit(); }

            // Actualiza la información de la Expediente
            $this->calculateExpedienteCC($Expediente);
            $this->timeEndTime("AutoAsignarMPA");

            return $cantdeudasmodificadas;
        } catch (Exception $ex) {
            $this->setLastErrException($ex, "AutoAsignarMPA");
            if($bComenzoTrans) { $this->em->getConnection()->rollBack(); }
        }
    }
    
    
    
    /**
     * Elimina la cuenta corriente del cliente y sus registros.
     * @param type $Expediente
     * @param type $bLogical = Si blogical = True, elimina todas poniendo el status = -1. Sino elimina todas fisicamente.
     */
    public function EliminarCuentaCorrienteExpediente($Expediente, $bLogical=true, $bTrans = true){
        $this->timeStartTime("EliminarCuentaCorrienteExpediente");
        $bComenzoTrans = false;
        
        if($bLogical == false){ // fisica
            // LOGICAL=> Elimina los registros logicamente.
            try{
                if($bTrans){
                    $this->em->getConnection()->beginTransaction();
                    $bComenzoTrans = true;
                }
                $qb = $this->em->createQueryBuilder();
                $qb->delete('ContabilidadBundle:DeudaCobroCC', 'd')
                            ->where('d.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                $qb = $this->em->createQueryBuilder();
                $qb->delete('ContabilidadBundle:CobroCC', 'c')
                              ->where('c.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                $qb = $this->em->createQueryBuilder();
                $qb->delete('ContabilidadBundle:DeudaCC', 'd')
                            ->where('d.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                $qb = $this->em->createQueryBuilder();

                if($bTrans){ $this->em->getConnection()->commit(); }
                $this->timeEndTime("EliminarCuentaCorrienteExpediente");
                return true;
            } catch (Exception $ex) {
                if($bComenzoTrans){ $this->em->getConnection()->rollBack(); }
                $this->setLastErrException($ex,"EliminarCuentaCorrienteExpediente");
                return false;
            }                
        }else{ 
            // LOGICAL=> Elimina los registros logicamente.
            if($bTrans){ 
             $this->em->getConnection()->beginTransaction(); 
             $bComenzoTrans = true;
            }
            try{
                $qb = $this->em->createQueryBuilder();
                $query = $qb->update('ContabilidadBundle:CobroCC', 'c')
                            ->set('c.status', -1)
                            ->where('c.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                $qb = $this->em->createQueryBuilder();
                $query = $qb->update('ContabilidadBundle:DeudaCC', 'd')
                            ->set('d.status', -1)
                            ->where('d.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                $qb = $this->em->createQueryBuilder();
                $qb->update('ContabilidadBundle:DeudaCobroCC', 'd')
                            ->set('d.status', -1)
                            ->where('d.Expediente = :expediente')
                            ->setParameters(array('expediente'=> $Expediente))            
                            ->getQuery()->execute();    
                
                if($bTrans){ $this->em->getConnection()->commit();}
                $this->timeEndTime("EliminarCuentaCorrienteExpediente");
                return true;
            } catch (Exception $e) {
                if($bComenzoTrans){ $this->em->getConnection()->rollBack(); }
                $this->setLastErrException($ex,"EliminarCuentaCorrienteExpediente");
                return false;
            }
        }
        return true;
    }
    /**
     * Elimina un enlace de pago, actualizando la deuda y el cobro
     * @param DeudaCobroCC $enlace
     * @param type $persist_deuda
     * @param type $persist_cobro
     * @return boolean
     */
     private function EliminarEnlace(DeudaCobroCC $enlace,$persist_deuda =true, $persist_cobro = true){
         $this->timeStartTime("EliminarEnlace");
         try{
            $deuda = $enlace->getDeuda();
            $cobro = $enlace->getCobro();

            $deuda->setMontoCobrado($deuda->getMontoCobrado() - $enlace->getMontoasignado());
            $deuda->setMontoRestante($deuda->getMontoRestante() + $enlace->getMontoasignado());

            $cobro->setMontoAsignado($cobro->getMontoAsignado() - $enlace->getMontoasignado());
            $cobro->setMontoRestante($cobro->getMontoRestante() + $enlace->getMontoasignado());

            if($persist_deuda ==true){
                $this->em->persist($deuda);
                $this->em->flush($deuda);
            }
            if($persist_cobro ==true){
                $this->em->persist($cobro);
                $this->em->flush($cobro);
            } 
            
           $enlace->setStatus(-1);
           $this->em->persist($enlace);
           $this->em->flush($enlace);         
           
           $this->timeEndTime("EliminarEnlace");
           return true;
         } catch (Exception $ex) {
            $this->setLastErrFunction($ex,"EliminarEnlace");
            return false;
         }
     }
    
    
    /**
     * Genera un enlace entre una deuda y un Pago, restando sus montos restantes
     * @param DeudaCC $deuda 
     * @param CobroCC $cobro
     * @param DateTime $fechayhora
     * @param type $persistdeudaycobro Define si se desea persistir los datos de
     *             la deuda y el cobro
     * @return boolean
     */
    public function AsignarEnlacePago(DeudaCC $deuda, CobroCC $cobro, $fechayhora='now',$montoasignado = 0, $persistdeudaycobro = true){
        if($fechayhora == 'now'){$fechayhora = new DateTime();}
        
        //1. Validar que ambas tengan un monto restante
        if ( ! ($cobro->getMontoRestante() > 0 and $deuda->getMontoRestante()>0)){
            return ContabilidadCCManager::AsignarEnlacePago_montorestante_insuficiente;
        }
        //2. Que la deuda y el cobro no esten borrados
        if ( ! ($cobro->getStatus() == 0 and $deuda->getStatus()==0)){
            return ContabilidadCCManager::AsignarEnlacePago_registros_borrados;
        }
        //3. Que la deuda y el cobro pertenezcan a la misma expediente
        if ( ! ($cobro->getExpediente() == $deuda->getExpediente())){
            return ContabilidadCCManager::AsignarEnlacePago_expediente_diferente;
        }       

        //4. El monto asignado no debe superar el restante de la deuda ni el
        //   restante del cobro. SI EL MONTO ASIGNADO = 0->OBTENER EL MAXIMO
        //   que se pueda cancelar.
        if($montoasignado==0){
            $montoasignado = $cobro->getMontoRestante();
            if($montoasignado > $deuda->getMontoRestante()){
                $montoasignado = $deuda->getMontoRestante();
            }
        }
        
        //5. Crear el registro del enlace
        $enlace = new DeudaCobroCC();
        $enlace->setExpediente($deuda->getExpediente());
        $enlace->setFechayhora($fechayhora);
        $enlace->setEstudio($this->estudio);
        $enlace->setDeuda($deuda);
        $enlace->setCobro($cobro);
        $enlace->setMontoasignado($montoasignado);
        $this->em->persist($enlace);
        $this->em->flush();

        //6. Actualizar información de la deuda y del enlace
        $deuda->setMontoRestante($deuda->getMontoRestante() - $montoasignado);
        $deuda->setMontoCobrado($deuda->getMontoCobrado() + $montoasignado);
        $cobro->setMontoRestante($cobro->getMontoRestante() - $montoasignado);
        $cobro->setMontoAsignado($cobro->getMontoAsignado() + $montoasignado);

        
        if($persistdeudaycobro){
            $this->em->persist($deuda);
            $this->em->persist($cobro);
            $this->em->flush();
        }
        return ContabilidadCCManager::AsignarEnlacePago_ok;
    }
    
    
    /**
     * Crea una nueva deuda usando los datos básicos, acordarse de ejecutar el calculateExpedienteCC
     * @param type $Expediente : Expediente a la que se crea la deuda
     * @param type $titulo : Titulo o descripcion breve de la deuda.
     * @param type $montodeuda : Monto por el que se crea la deuda
     * @param type $descripcion : Descripcion completa de la deuda
     * @param type $fechayhora : Fecha y hora de la deuda. Si se deja 'now' es la fecha y hora actual.
     * @param type $autosave : Fecha y hora de la deuda. Si se deja 'now' es la fecha y hora actual.
     */
    public function NuevaDeuda($Expediente, $titulo, $montodeuda, $descripcion,$fechayhora = 'now',$autosave =true){
        $this->timeStartTime("NuevaDeuda");
        if($fechayhora == 'now'){$fechayhora = new DateTime();}
        
        $deuda = new DeudaCC();
        $deuda->setEstudio($this->estudio);
        $deuda->setMontodeuda($montodeuda);
        $deuda->setTitulo($titulo);
        $deuda->setDescripcion($descripcion);
        $deuda->setFechayhora($fechayhora);
        $deuda->setExpediente($Expediente);
        $deuda->setContabilizar(1);
        $deuda->setMontoCobrado(0);
        $deuda->setMontoRestante($montodeuda);
        
        $this->setLastDeuda($deuda);
        if($autosave){
            try{
                $this->em->persist($deuda);
                $this->em->flush();
                
                // Actualiza la información de la Expediente
                $this->calculateExpedienteCC($Expediente);
                $this->timeEndTime("NuevaDeuda");
                return true;
            }  catch (Exception $ex){
                $this->setLastErrException($ex, "NuevaDeuda");
                return false;
            }
        }else{
            $this->timeEndTime("NuevaDeuda");
            return $deuda;
        }
    }
    
     public function NuevoCobro($Expediente, $titulo, $monto, $descripcion, $fechayhora = 'now',$autosave = true, $CobroGeneral = null){
        $this->timeStartTime("NuevoCobro");
        if($fechayhora == 'now'){
            $fechayhora = new DateTime();
        }
        
        $cobro = new CobroCC();
        $cobro->setEstudio($this->estudio);
        $cobro->setExpediente($Expediente);
        $cobro->setTitulo($titulo);
        $cobro->setMontoCobro($monto);
        $cobro->setMontoAsignado(0);
        $cobro->setMontoRestante($monto);
        $cobro->setDescripcion($descripcion);
        $cobro->setFechayhora($fechayhora);
        $cobro->setContabilizar(1);
        $cobro->setCobroGeneralCC($CobroGeneral);
        
        $this->setLastCobro($cobro);
        if($autosave){
            try{
                $this->em->persist($cobro);
                $this->em->flush();
                // Actualiza la información de la Expediente
                $this->calculateExpedienteCC($Expediente);
                $this->timeEndTime("NuevoCobro");
                return true;
            }  catch (Exception $ex){
                $this->setLastErrException($ex, "NuevoCobro");
                return false;
            }
    }else{
        $this->timeEndTime("NuevoCobro");
        return $cobro;
    }

            
    }
    
    
    /***************************************************************************
     * [COMIENZO] CC - ENTIDAD
     * LA CC DE LA ENTIDAD ES LA SUMATORIA DE LAS CC DE TODOS LOS EXPEDIENTES
     * QUE ESTAN VINCULADOS A LA ENTIDAD.
     **************************************************************************/
    public function getSaldoCCEntidad($Entidad, $calculate = true){
        $this->timeStartTime("getSaldoCCEntidad");

        $expedientes = $this->getExpedientesFromEntidad($Entidad);
        if (count($expedientes) == 0){
            $this->timeEndTime("getSaldoCCEntidad");
            return 0;
        }        
        
        $cc_entidad = 0;
        foreach($expedientes as $Expediente){
            $cc_entidad += $this->getSaldoCCExpediente($Expediente, $calculate);
        }
        
        $this->timeEndTime("getSaldoCCEntidad");
        return $cc_entidad;        
    }
    public function getExpedientesFromEntidad($Entidad){
        $this->timeStartTime("getExpedientesFromEntidad");
        
        $queryBuilder = $this->em->createQueryBuilder('e');
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.ClientePrincipal = :entidad ")
            ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "entidad"=>$Entidad))
            ->from('AppBundle:Expediente','e');        

        $this->timeEndTime("getExpedientesFromEntidad");
        
        return $queryBuilder->getQuery()->getResult();        
    }
    public function EliminarCuentaCorrienteEntidad($Entidad,$bLogical, $bTrans = true){
        $this->timeStartTime("EliminarCuentaCorrienteEntidad");
        
        $expedientes = $this->getExpedientesFromEntidad($Entidad);
        if($bTrans){ $this->em->getConnection()->beginTransaction(); }
        foreach($expedientes as $Expediente){
            $result = $this->EliminarCuentaCorrienteExpediente($Expediente, $bLogical, false);
            if($result == false){
                $this->em->getConnection()->rollBack();
                return false;
            }
        }
        if($bTrans){ $this->em->getConnection()->commit(); }
        $this->timeEndTime("EliminarCuentaCorrienteEntidad");
        
        return true;      
    }    
    /***************************************************************************
     * [FIN] CC - ENTIDAD
     **************************************************************************/
    

    
    
    /***************************************************************************
     * [COMIENZO] COBRO GENERAL
     **************************************************************************/
    
    /**
     * Elimina el Cobro General y todos los cobros relacionados.
     * @param type $cobroGeneral
     * @return boolean
     */
    public function EliminarCobroGeneral($cobroGeneral, $btrans = true){
        $this->timeStartTime("EliminarCobroGeneral");        
        //1. Busca todos los cobros asociados
        $cobros = $this->getCobrosDesdeCobroGeneral($cobroGeneral);

        if($cobros){
            if($btrans){$this->em->getConnection()->beginTransaction();}
            //2. Elimina todos los Cobros
            foreach($cobros as $cobro){
                if (! $this->EliminarCobro($cobro)){
                    if($btrans){$this->em->getConnection()->rollBack();}
                    $this->timeEndTime("EliminarCobroGeneral"); 
                    return false;
                } 
            }
            if($btrans){$this->em->getConnection()->commit();}
        }
        $cobroGeneral->setStatus(-1);
        $this->em->persist($cobroGeneral);
        $this->em->flush();
        
        
        $this->timeEndTime("EliminarCobroGeneral");        
        return true;
    }
    
    public function getCobrosDesdeCobroGeneral($CobroGeneral,$contabilizar = 1){
        $queryBuilder = $this->em->createQueryBuilder('d');
        $queryBuilder
            ->select('c')
            ->where("c.status =:status and c.Estudio = :estudio and c.CobroGeneralCC = :cobrogeneral")
            ->setParameters(array("status"=> 0, "estudio"=>$this->estudio, "cobrogeneral"=>$CobroGeneral))
            ->from('ContabilidadBundle:CobroCC','c');        
            $queryBuilder->addOrderBy('c.fechayhora','ASC');
         
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    
    /**
     * Genera un Cobro general que permite crear varios cobros a diferentes 
     * expedientes. 
     * @param type $Expediente
     * @param type $Entidad
     * @param type $monto
     * @param type $titulo
     * @param type $cobros
     * @param type $descripcion
     * @param DateTime $fechayhora
     * @param type $autosave
     * @return boolean|CobroGeneralCC
     */
    public function NuevoCobroGeneral($Entidad, $titulo, $cobros, $descripcion = '', $fechayhora='now',$bTrans = true){
        $this->timeStartTime("NuevoCobroGeneral");
        if($fechayhora == 'now'){
            $fechayhora = new DateTime();
        }
           
        try{
            if ($bTrans){
                $bComenzoTrans = true;
                if($bTrans){$this->em->getConnection()->beginTransaction();}
            }
            $cobroGen = new CobroGeneralCC();
            $cobroGen->setEstudio($this->estudio);
            $cobroGen->setEntidad($Entidad);
            $cobroGen->setTitulo($titulo);
            $cobroGen->setDescripcion($descripcion);
            $cobroGen->setFechayhora($fechayhora);
            $this->em->persist($cobroGen);

            $monto = 0;
            foreach ($cobros as $cobro){
                $cobro->setCobroGeneralCC($cobroGen);
                $monto = $monto + ($cobro->getMontoCobro());
                $this->em->persist($cobro);
            }
            $cobroGen->setMonto($monto);
            $this->em->flush();

            if($bTrans){$this->em->getConnection()->commit();}
            $this->timeEndTime("NuevoCobroGeneral");
            $this->setLastCobroGeneral($cobroGen);
            return true; 
            
        }  catch (Exception $ex){
            if($bComenzoTrans){$this->em->getConnection()->rollBack();}
            $this->setLastErrException($ex, "NuevoCobroGeneral");
            return false;
        }


    }
    
    /***************************************************************************
     * [FIN] COBRO GENERAL
     **************************************************************************/
   

}

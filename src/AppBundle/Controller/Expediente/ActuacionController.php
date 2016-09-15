<?php

namespace AppBundle\Controller\Expediente;

use DateTime;
use AppBundle\Entity\ExpedienteActuacion;
use AppBundle\Entity\ExpedienteInterviniente;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use LegalPro\Bundles\ExpedienteActuacionesBundle\Form\Type\ExpedienteActuacionType;
use LegalPro\Bundles\ExpedienteBundle\Form\Type\ExpedienteFindType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\Exception;
use AppBundle\Entity\Expediente;
    /**
     * @Route("/expediente/")
     */
class ActuacionController extends Controller
{
    /**
     * @Route("{expedienteid}/actuaciones/delete/{id}",  name="expediente_actuaciones_delete")
     * @Template("")
     */
    public function deleteAction(Request $request,$id,$expedienteid){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('AppBundle:ExpedienteActuacion');
        $actuacion = $repository->find($id);   
        $expediente = $actuacion->getExpediente();
        
        if(!$actuacion){
            throw new Exception('No existe la actuacion');
        } 

        $actuacion->setStatus(-1);
        $em->persist($actuacion);
        $em->flush();
        $this->get('session')->getFlashBag()->add('warning', "Se ha eliminado correctamente la actuación");   
        return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expediente->getId(), 'seccion'=>"Actuaciones"), 301);
    }
    /**
     * @Route("{expedienteid}/actuaciones/edit/{id}",  name="expediente_actuaciones_edit")
     * @Template("ExpedienteActuacionesBundle:Frontend:edit.html.twig")
     */
    public function editAction(Request $request,$id,$expedienteid){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('AppBundle:ExpedienteActuacion');
        $actuacion = $repository->find($id);   
        $expediente = $actuacion->getExpediente();
        
        if(!$actuacion){
            throw new Exception('No existe la actuacion');
        }        
        
        // Tipos de Actuaciones
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1) ")
            ->addOrderBy("e.esp","DESC")
            ->addOrderBy("e.nombre","ASC")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio))
            ->from('AppBundle:ActuacionTipoactuacion','e');         
        $TipoActuaciones = $queryBuilder->getQuery()->getArrayResult();           
        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio,"expediente"=>$expediente))
            ->from('AppBundle:ExpedienteInterviniente','e');         
        $Intervinientes = $queryBuilder->getQuery()->getResult();      

        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio,"expediente"=>$expediente))
            ->from('AppBundle:ExpedienteAbogado','e');         
        $Abogados = $queryBuilder->getQuery()->getResult();         
        
        $AbogadoEsp = new ExpedienteInterviniente();  
        $AbogadoEsp->setEntidad(null);
        $AbogadoEsp->setIntervinientenombre("No asociar Abogado"); 
        $AbogadoEsp->setEntidadid(-2);
        array_unshift($Abogados,$AbogadoEsp);
        
        
        $intervinienteEsp = new ExpedienteInterviniente();  
        $intervinienteEsp->setEntidad(null);
        $intervinienteEsp->setIntervinientenombre("No asociar interviniente"); 
        $intervinienteEsp->setEntidadid(-2);
        array_unshift($Intervinientes,$intervinienteEsp);
        

        $actuacion->setExpediente($expediente);
        $actuacion->setEstudio($estudio);
        
        $actuacionform = new ExpedienteActuacionType($em);
        $form = $this->createForm($actuacionform, $actuacion); 
  
//        
        $cancelPath = $this->generateUrl('expediente_actuaciones_list', array('id' => $expediente->getid()));        
        $abmManager = $this->get('legalPro_commonBundle_AbmManager')
                ->setTitle("Actuaciones")
                ->setCancelPath($cancelPath)
                ->setForm($form->createView())
                ->setShowButtonModify(false);
//        
        //por alguna razon el form->valid no funciona, y comparo por un campo obligatorio si este devuelve diferente de vacio
        //es que se esta haciendo clic en el submit
        if($request->request->get("descripcion","") != ""){
            
            $bAdd = true;
            $actuacion = $form->getData();
            
            if($actuacion->getFechayhora()==null){
                $actuacion->setFechayhora(new DateTime());
            }
            $abogadoid = $request->request->get("cboAbogado","-1"); 

            if($abogadoid >= 0){
                $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
                $entidad = $repository->findOneBy(array("Estudio"=>$estudio, "status"=>0, "id"=>$abogadoid));            
                $actuacion->setAbogadoResponsable($entidad);
            }else{
                $actuacion->setAbogadoResponsable(null);
            }
            
            
            $entidadid = $request->request->get("cboInterviniente","-1"); 
            if($entidadid > 0){
                $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
                $entidad = $repository->findOneBy(array("Estudio"=>$estudio, "status"=>0, "id"=>$entidadid));            
                $actuacion->setInterviniente($entidad);
            }else{
                $actuacion->setInterviniente(null);
            }
            $tipoactuacionid = $request->request->get("cboTipoActuacion","-1"); 
            if($tipoactuacionid<= 0){
                $this->get('session')->getFlashBag()->add('danger', "No se ha seleccionado un Tipo de Actuacion valido" );   
                $bAdd =false;
            }else{
                $repository = $this->getDoctrine()->getRepository('AppBundle:ActuacionTipoactuacion');

                $tipoActuacion = $repository->findOneBy(array("status"=>0, "id"=>$tipoactuacionid));                     

                if($tipoActuacion==null){
                    $this->get('session')->getFlashBag()->add('danger', "No existe el tipo de Actuacion" );   
                    $bAdd=false;
                }else{
                    $actuacion->setTipoActuacion($tipoActuacion);
                }
            }
            if($bAdd==true){
                
                $actuacion->setDescripcion($request->request->get("descripcion","") );
                $actuacion->setFojas($request->request->get("fojas","") );
                
                $em->persist($actuacion);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Se ha creado la actuación: ' . $actuacion->getDescripcion() );                
                return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expediente->getId(), 'seccion'=>"Actuaciones"), 301);
            }

        }
        
        return array("expediente"=>$expediente,"seccion"=>"Actuaciones",
                     "TipoActuaciones"=>$TipoActuaciones, "abmManager"=>$abmManager,
                     "Intervinientes"=>$Intervinientes,"Abogados"=>$Abogados, "actuacion"=>$actuacion);
        
    }
    
    /**
     * @Route("{expedienteid}/actuaciones/show/{id}",  name="expediente_actuaciones_show")
     * @Template("ExpedienteActuacionesBundle:Frontend:show.html.twig")
     */    
    public function showAction(Request $request, $id,$expedienteid){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $repository = $this->getDoctrine()->getRepository('AppBundle:ExpedienteActuacion');
        $actuacion = $repository->find($id);
        
        if(!$actuacion){
            throw new Exception('No existe la actuacion');
        }   
        
        $expediente = $actuacion->getExpediente();
        $actuacionform = new ExpedienteActuacionType($em);
        $form = $this->createForm($actuacionform, $actuacion,array('disabled' => true));
        
        
        
        
        $editPath = $this->generateUrl('expediente_actuaciones_edit', array('id' => $actuacion->getid(),'expedienteid'=>$expediente->getId()));
        $abmManager = $this->get('legalPro_commonBundle_AbmManager')
                ->setTitle("")
                ->setForm($form->createView())
                ->setEditPath($editPath);        

        return array("expediente"=>$expediente,"seccion"=>"Actuaciones",
                     "abmManager"=>$abmManager,"actuacion"=>$actuacion);        
        
    }
    
    
    /**
     * @Route("{id}/actuaciones/new",  name="expediente_actuaciones_new")
     * @Template("ExpedienteActuacionesBundle:Frontend:new.html.twig")
     */
    public function newAction(Request $request,Expediente $expediente){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
//        $repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
//        $expediente = $repository->find($id);   
        
//        if(!$expediente){
//            throw new Exception('No existe el expediente');
//        }        
              
        

    
        
        // Tipos de Actuaciones
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and (e.Estudio = :estudio or e.esp = 1) ")
            ->addOrderBy("e.esp","DESC")
            ->addOrderBy("e.nombre","ASC")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio))
            ->from('AppBundle:ActuacionTipoactuacion','e');         
        $TipoActuaciones = $queryBuilder->getQuery()->getArrayResult();           
        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio,"expediente"=>$expediente))
            ->from('AppBundle:ExpedienteInterviniente','e');         
        $Intervinientes = $queryBuilder->getQuery()->getResult();      

        
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Estudio = :estudio and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "estudio"=>$estudio,"expediente"=>$expediente))
            ->from('AppBundle:ExpedienteAbogado','e');         
        $Abogados = $queryBuilder->getQuery()->getResult();         
        
        $AbogadoEsp = new ExpedienteInterviniente();  
        $AbogadoEsp->setEntidad(null);
        $AbogadoEsp->setIntervinientenombre("No asociar Abogado"); 
        $AbogadoEsp->setEntidadid(-2);
        array_unshift($Abogados,$AbogadoEsp);
        
        
        $intervinienteEsp = new ExpedienteInterviniente();  
        $intervinienteEsp->setEntidad(null);
        $intervinienteEsp->setIntervinientenombre("No asociar interviniente"); 
        $intervinienteEsp->setEntidadid(-2);
        array_unshift($Intervinientes,$intervinienteEsp);
        
        $actuacion = new ExpedienteActuacion();
        $actuacion->setExpediente($expediente);
        $actuacion->setEstudio($estudio);
        
        $actuacionform = new ExpedienteActuacionType($em);
        $form = $this->createForm($actuacionform, $actuacion); 
  
//        
        $cancelPath = $this->generateUrl('expediente_actuaciones_list', array('id' => $expediente->getid(), 'seccion' => "Actuaciones"));        
        $abmManager = $this->get('legalPro_commonBundle_AbmManager')
                ->setTitle("Actuaciones")
                ->setCancelPath($cancelPath)
                ->setForm($form->createView())
                ->setShowButtonModify(false);
//        
        //por alguna razon el form->valid no funciona, y comparo por un campo obligatorio si este devuelve diferente de vacio
        //es que se esta haciendo clic en el submit
        if($request->request->get("descripcion","") != ""){
            
            $bAdd = true;
            $actuacion = $form->getData();
            
            if($actuacion->getFechayhora()==null){
                $actuacion->setFechayhora(new DateTime());
            }
            $abogadoid = $request->request->get("cboAbogado","-1"); 
 
            if($abogadoid >= 0){
                $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
                $entidad = $repository->findOneBy(array("Estudio"=>$estudio, "status"=>0, "id"=>$abogadoid));            
                $actuacion->setAbogadoResponsable($entidad);
            }
            
            $entidadid = $request->request->get("cboInterviniente","-1"); 
            if($entidadid >= 0){
                $repository = $this->getDoctrine()->getRepository('AppBundle:Entidad');
                $entidad = $repository->findOneBy(array("Estudio"=>$estudio, "status"=>0, "id"=>$entidadid));            
                $actuacion->setInterviniente($entidad);
            }
            $tipoactuacionid = $request->request->get("cboTipoActuacion","-1"); 
            if($tipoactuacionid<= 0){
                $this->get('session')->getFlashBag()->add('danger', "No se ha seleccionado un Tipo de Actuacion valido" );   
                $bAdd =false;
            }else{
                $repository = $this->getDoctrine()->getRepository('AppBundle:ActuacionTipoactuacion');

                $tipoActuacion = $repository->findOneBy(array("status"=>0, "id"=>$tipoactuacionid));                     

                if($tipoActuacion==null){
                    $this->get('session')->getFlashBag()->add('danger', "No existe el tipo de Actuacion" );   
                    $bAdd=false;
                }else{
                    $actuacion->setTipoActuacion($tipoActuacion);
                }
            }
            if($bAdd==true){
                
                $actuacion->setDescripcion($request->request->get("descripcion","") );
                $actuacion->setFojas($request->request->get("fojas","") );
                
                $em->persist($actuacion);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Se ha creado la actuación: ' . $actuacion->getDescripcion() );                
                return $this->redirectToRoute('expediente_actuaciones_list', array('id'=>$expediente->getId(), 'seccion'=>"Actuaciones"), 301);
            }

        }
        
        return array("expediente"=>$expediente,"seccion"=>"Actuaciones",
                     "TipoActuaciones"=>$TipoActuaciones, "abmManager"=>$abmManager,
                     "Intervinientes"=>$Intervinientes,"Abogados"=>$Abogados);
        
    }
    /* SECCIONES */
     /**
     * @Route("{id}/actuaciones/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="descripcion","order_status"=1, "id" = -1}, name="expediente_actuaciones_list")
     * @Template()
     */
    public function listAction(Request $request,Expediente $expediente, $page,$resultpage,$order_col,$order_status)
    {
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
        // Buscar el expediente con el ID
//        $repository =   $em->getRepository('AppBundle:Expediente');
        //$repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
//        $expediente = $repository->find($id);   
//        $seccion = "Actuaciones";

        // 1. Crear el Query del Listado.
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.Expediente = :expediente")
            ->setParameters(array("status"=> 0, "expediente"=> $expediente))
            ->from('AppBundle:ExpedienteActuacion_v','e');
        
        // 2. Usar los filtros y la búsqueda
//        $findManager = $this->get('legalPro_commonBundle_FindManager');
//        $exp_find = new ExpedienteFindType;
//        $findManager = $exp_find->getParameters($request, $queryBuilder,$findManager);
//        $findManager->showFilters($this,$queryBuilder,true);

        
        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("Expedientes")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('expediente_actuaciones_show', array('id'=> 'getId','expedienteid'=>'getExpedienteid')),
                        'value' => '<span class="glyphicon glyphicon-eye-open"></span>'
                        )
            )
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("expediente_actuaciones_delete", array("id"=>"getId","expedienteid"=>"getExpedienteid")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
            )                
            ->addColumn("Fecha y Hora", 'fechayhora',array(
                'type' => 'datetime',
                'allow_order'=>'1',
                ))
            ->addColumn("Tipo", 'tipoactuacionnombre',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))                   
            ->addColumn("Fojas", 'fojas',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                     
            ->addColumn("Descripcion", 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);        
        
        
        return array('list' => $list,'request'=>$request, 'expediente'=>$expediente, 'section'=>'Actuaciones');
    }
  
}
    
<?php

namespace AppBundle\Controller\Expediente;

use Exception;
use AppBundle\Entity\ExpedienteAbogado;
use AppBundle\Entity\ExpedienteEntidad;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\Entidad;
use AppBundle\Entity\EntidadTipoEntidad;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use AppBundle\Form\Type\Expediente\ExpedienteAbogadoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use AppBundle\Form\Type\Expediente\AbogadosType;
use AppBundle\Form\Type\Expediente\EntidadType;


    /**
     * @Route("/expediente")
     */
class ExpedienteAbogadoController extends Controller
{
    

     /**
     * @Route("/{id}/abogados/new", name="expediente_abogado_new")
       @Template()
     */
    public function newAction(Request $request,Expediente $expediente){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();
        $tipoEntidad = $em->getRepository('AppBundle:Entidad')->getEntityAbogado();

        //HACER: deberia haber un servicio que escupa los abogados del estudio
        $abogados = $em->getRepository('AppBundle:Entidad')->getEntidadbyTipo($estudio,$tipoEntidad);

        $form = $this->createForm(EntidadType::class, null,array('entidades'=> $abogados));
        $form->handleRequest($request);   
        if($form->isValid()) {
                $expedienteEntidad = $form->getData();
                //1_Buscar si el abogado ya fue asociado
                $repo = $this->getDoctrine()->getRepository('AppBundle:ExpedienteEntidad');
                if($repo->findBy(array("Entidad"=>$expedienteEntidad->getEntidad(), "Expediente"=>$expediente, "status"=>  ExpedienteEntidad::STATUS_NO_DELETED))){
                    $this->get('session')->getFlashBag()->add('warning', "La entidad ya se encuentra asociada al expediente");                
                }else{
                //2_crear la entity ExpedienteEntidad y asociar exp y entidad
                    $expedienteEntidad  ->setExpediente($expediente)
                                        ->setEstudio($estudio);
                    $em->persist($expedienteEntidad);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', $expedienteEntidad->getEntidad()->getCodigo() . ' ' . $this->get('translator')->trans('create_ok'));                
                }
            return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);
        }
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($this->get('translator')->trans('title_new')  . ' ')
                ->setForm($form->createView());
        return array('abmManager' => $abmManager , 'expediente'=>$expediente, 'section'=>'abogados');
    }
     
    
    /**
     * @Route("/{expedienteid}/abogados/undo_delete/{id}",defaults={"id"="-1"}, name="expediente_abogado_undodelete")
     * @Template()
     */    
    public function undodeleteAbogadoExpAction(ExpedienteEntidad $expedienteEntidad){    
        //HACER: Service que controle la seguridad
        $em = $this->getDoctrine()->getManager();
        $expediente = $expedienteEntidad->getExpediente();
        //Hacer un metodo que sea para deshacer el borrar y ponga esto automaticamente
        $expedienteEntidad->setStatus(ExpedienteEntidad::STATUS_NO_DELETED);
        $em->flush();       
        $msg = $expedienteEntidad->getEntidad()->getCodigo().' se volvio a asociar con el expediente';
        $this->get('session')->getFlashBag()->add('success', $msg);                
        return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);            
    }
    /**
     * @Route("/{expedienteid}/abogados/delete/{id}",defaults={"id"="-1"}, name="expediente_abogado_delete")
       @Template()
     */    
    public function deleteAbogadoExpAction(ExpedienteEntidad $expedienteEntidad){
        //HACER: Service que controle la seguridad
        $em = $this->getDoctrine()->getManager();
        $expediente = $expedienteEntidad->getExpediente();
        //Hacer un metodo que sea para borra y ponga esto automaticamente
        $expedienteEntidad->setStatus(ExpedienteEntidad::STATUS_DELETED);
        $em->flush();
        $msg = $expedienteEntidad->getEntidad()->getCodigo().' fue desasociado del expediente. <a href="'. $this->generateUrl('expediente_abogado_undodelete', array('id' => $expedienteEntidad->getId(),'expedienteid' => $expediente->getId())) .'" >Deshacer</a>';
        $this->get('session')->getFlashBag()->add('success', $msg);                
        return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);        
    }
    
     /**
     * @Route("/{id}/abogados/list/{page}/{resultpage}",defaults={"page" = 1, "resultpage" = 10,"ope"="show"}, name="expediente_abogados_list")
       @Template()
     */
    public function listAction(Request $request,$page,$resultpage,Expediente $expediente)
    {
        $em = $this->getDoctrine()->getManager();
        $estudio =$this->getUser()->getEstudio();
        
        $tipoEntidad = $em->getRepository('AppBundle:Entidad')->getEntityAbogado();
        
        $queryBuilder =  $em->getRepository('AppBundle:Entidad')->getEntidadExpediente($estudio,$expediente,$tipoEntidad);
        $list = new ListView();
        $list
            ->setTitle("Abogados")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("expediente_abogado_delete", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
            )
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("expediente_abogado_responsable", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                        'value' => '<span class="glyphicon glyphicon-briefcase"></span>',
                        )
            )                          
            ->addColumn("Nombre", 'Entidad.nombre',array(
                'type' => 'object',
                'allow_order'=>'0',
                ))
            ->addColumn("Observaciones", 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                
            ->addColumn("Responsable", 'responsable',array(
                'type' => 'boolean',
                'allow_order'=>'0',
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol("", "");
        
        return array("request" => $request, "list" => $list, "expediente"=>$expediente, "section"=>"abogados");
    }
    /**
     * @Route("/{expedienteid}/abogados/responsable/{id}",defaults={"id"="-1"}, name="expediente_abogado_responsable")
       @Template()
     */    
    public function setAbogadoResponsableAction(ExpedienteEntidad $expedienteEntidad){
        //HACER: Service que controle la seguridad
        $em = $this->getDoctrine()->getManager();
        $expediente = $expedienteEntidad->getExpediente();
        //Hacer un metodo que sea para borra y ponga esto automaticamente
        
        switch($expedienteEntidad->getResponsable()){
            case ExpedienteEntidad::RESPONSABLE_NO_RESPONSABLE:
                $expedienteEntidad->setResponsable(ExpedienteEntidad::RESPONSABLE_RESPONSABLE);
                break;
            case ExpedienteEntidad::RESPONSABLE_RESPONSABLE:
                $expedienteEntidad->setResponsable(ExpedienteEntidad::RESPONSABLE_NO_RESPONSABLE);
                break;
        }
        $em->flush();
//        $msg = $expedienteEntidad->getEntidad()->getCodigo().' fue desasociado del expediente. <a href="'. $this->generateUrl('expediente_abogado_undodelete', array('id' => $expedienteEntidad->getId(),'expedienteid' => $expediente->getId())) .'" >Deshacer</a>';
//        $this->get('session')->getFlashBag()->add('success', $msg);                
        return $this->redirectToRoute('expediente_abogados_list', array('id'=>$expediente->getId()), 301);        
    }
}

<?php
namespace AppBundle\Controller\Expediente;

use Exception;
use AppBundle\Entity\ExpedienteInterviniente;
use AppBundle\Entity\Expediente;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use AppBundle\Form\Type\Expediente\ExpedienteIntervinienteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
 
    /**
     * @Route("/expediente/")
     */
class ExpedienteIntervinienteController extends Controller
{
     /**
     * @Route("{id}/intervinientes/new", name="expediente_intervinientes_new")
       @Template()
      * Template("ExpedienteIntervinienteBundle:Frontend:new.html.twig")
     */
    public function newAction(Request $request,Expediente $expediente){
        if(!$expediente){
            throw new Exception('No existe el expediente');
        }        
        $em = $this->getDoctrine()->getManager();
        $estudio =$this->getUser()->getEstudio();
        $expinterv = new ExpedienteInterviniente();
        $expinterv->setEstudio($estudio)
            ->setExpediente($expediente);
        $queryBuilder = $em->getRepository('AppBundle:Entidad')->getEntidades($estudio);
        $intervinientes = $queryBuilder->getQuery()->getResult();        
        $form = $this->createForm(ExpedienteIntervinienteType::class, $expinterv, array('intervinientes'=>$intervinientes)); 
        $form->handleRequest($request);
        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle("Asociar interviniente a la causa")
                ->setForm($form->createView())
                ->setCancelPath($this->generateUrl('expediente_intervinientes_list', array('id' => $expediente->getid(), 'section' => "Intervinientes")))
                ->setShowButtonModify(false);

        if($form->isValid()) {
            $expinterv = $form->getData();    
            $em->persist($expinterv);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se ha asociado correctamente el interviniente: ' . $expinterv->getIntervinienteNombre() );                
            return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$expediente->getId()), 301);
        }
        return array("expediente"=>$expediente,"section"=>"Intervinientes","abmManager"=>$abmManager);
    }
    
    /**
     * @Route("{expedienteid}/intervinientes/undo_delete/{id}",defaults={"id"="-1"}, name="expediente_intervinientes_undodelete")
     */    
    public function undodeleteIntervinienteExpAction(ExpedienteInterviniente $intervinienteExp){    
        if(!$intervinienteExp){
            throw new Exception('No existe el interviniente');
        }
        if($intervinienteExp->getEstudio() === $this->getUser()->getEstudio()){
            $this->get('session')->getFlashBag()->add('success', "Se ha restaurado al interviniente " .  $intervinienteExp->getEntidad()->getNombre());   
            $intervinienteExp->setStatus(ExpedienteInterviniente::STATUS_NO_DELETED);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$intervinienteExp->getExpediente()->getId()), 301);            
    }
    /**
     * @Route("{expedienteid}/intervinientes/delete/{id}",defaults={"id"="-1"}, name="expediente_intervinientes_delete")
     */    
    public function deleteIntervinienteExpAction(ExpedienteInterviniente $intervinienteExp){
        if(!$intervinienteExp){
            throw new Exception('No existe el interviniente');
        }
        if($intervinienteExp->getEstudio() === $this->getUser()->getEstudio() ){
            $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('expediente_intervinientes_undodelete', array('id' => $intervinienteExp->getId(), "expedienteid"=>$intervinienteExp->getExpediente()->getId())) . '"><span class="glyphicon glyphicon-trash"></span> ' . $intervinienteExp->getEntidad()->getNombre() . ' ' . $this->get('translator')->trans('eliminado_ok')  .'</a>');   
            $intervinienteExp->setStatus(-1);
            $this->getDoctrine()->getManager()->flush();   
        }
        return $this->redirectToRoute('expediente_intervinientes_list', array('id'=>$intervinienteExp->getExpediente()->getId()), 301);        
    }
    
    
     /**
     * @Route("{id}/intervinientes/list/{page}/{resultpage}",defaults={"page" = 1, "resultpage" = 10,"ope"="show"}, name="expediente_intervinientes_list")
       @Template()
     */
    public function listAction(Request $request,$page,$resultpage,Expediente $expediente)
    {
        if(!$expediente){
            throw new Exception('No existe el expediente');
        }
        $em = $this->getDoctrine()->getManager();
        $estudio =$this->getUser()->getEstudio();
        
        // 1. Crear el Query del Listado.
        $queryBuilder = $em->getRepository('AppBundle:Entidad')->getIntervinientesExpediente($estudio,$expediente);
        
        $list = new ListView();
        $list
            ->setTitle("Partes")
            ->setControllerParent($this);    
            $list->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn("expediente_intervinientes_delete", array("id"=>"getId","expedienteid"=>"getExpedienteId")),
                        'value' => '<span style="color:red" class="glyphicon glyphicon-trash"></span>',
                        )
            );          
            $list->addColumn("Nombre", 'getIntervinienteNombre',array(
                'type' => 'raw',
                'allow_order'=>'0',
                ));
            $list->addColumn("Caracter", 'caracterNombre',array(
                'type' => 'string',
                'allow_order'=>'0',
                ));
            $list->addColumn("Observaciones", 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'0',
                ))                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol("", "");
        return array("request" => $request, "list" => $list, "expediente"=>$expediente, "section"=>"Intervinientes");
    }
}

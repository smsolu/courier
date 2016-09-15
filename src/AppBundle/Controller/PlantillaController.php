<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use AppBundle\Form\Type\Plantilla\PlantillaType;
use AppBundle\Entity\Plantilla;
use AppBundle\Entity\Expediente;
//use PhpOffice\PhpWord\TemplateProcessor;

    /**
     * @Route("/plantilla")
     */
class PlantillaController extends Controller
{
    /**
     * @Route("/list/{id_folder}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"id_folder"=0, "page" = 1, "resultpage" = 10,"order_col"="tipo","order_status"=1}, name="plantilla_list")
     * @Template()
     */
    public function listAction(Request $request, $id_folder,$page,$resultpage,$order_col,$order_status)
    {
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
      
        $queryBuilder = $em->getRepository("AppBundle:Plantilla")->getPlantillas($estudio);
        $queryBuilder->OrderBy("e.tipo", "ASC");
//        $queryBuilder = $em->createQueryBuilder();
//        $queryBuilder
//            ->select('e')
//            ->where("e.status =:status and e.Estudio =:estudio")
//            ->setParameters(array("status"=> 0, "estudio" => $estudio))
//            ->from('AppBundle:Plantilla','e')
//            ->OrderBy("e.tipo", "ASC");

        if($id_folder != 0){
            $plantilla = $this->getDoctrine()
                ->getRepository('AppBundle:Plantilla')
                ->find($id_folder);
            if(!$plantilla){
                throw new \Exception('No existe la plantilla padre');
            }
            $queryBuilder->andWhere("e.plantillaPadre =:plantillaPadre")
                         ->setParameter("plantillaPadre", $plantilla);
        }else{
            $queryBuilder->andWhere("e.plantillaPadre is NULL");
        }
        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("Plantillas")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('plantilla_show', array('id'=> 'getId')),
                'value' => '<span class="glyphicon glyphicon-file"></span>'
                )
            )
//            ->addColumn('', 'id',array(
//                'type' => 'link',
//                'route' => new LinkColumn('plantilla_newDocument', array('id'=> 'getId')),
//                'value' => '<span class="glyphicon glyphicon-save-file"></span>'
//                )
//            )
            ->addColumn("Nombre", 'nombre',array(
                'type' => 'string',

                ))                
            ->addColumn("Descripcion", 'descripcion',array(
                'type' => 'string',
                
                ))
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);        
        
        //. Enviar la información a la vista
        return array('list' => $list,'request'=>$request);
    }
    /**
     * @Route("/edit/{id}/{section}",defaults={"section"="General"}, name="plantilla_edit")
     * @Template()
     */
    public function editAction(Request $request,Plantilla $plantilla,$section)
    {
        //HACER: cuando cambio el archivo debo borrar el viejo
        $em = $this->getDoctrine()->getManager();
        if($plantilla->getStatus() != Plantilla::STATUS_NO_DELETED){
            throw new Exception('No existe la plantilla');
        }

        $form = $this->createForm(PlantillaType::class, $plantilla, array('fileRequired' => false)); 
        $form->handleRequest($request);

        if($form->isValid()) {
            $plantilla = $form->getData();
            
            if($plantilla->getFile() != null){
                $fsm = $this->get('lp_FilesystemManager');
                $plantilla->setFilename($fsm->writeTemplate($plantilla->getFile()));
            }
            
            $em->persist($plantilla);
            try{
                $em->flush();
            } catch (Exception $e) {
                $fsm->delete($plantilla->getFilename());
                throw $e;
            }
            
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('save_ok') );
            return $this->redirectToRoute('plantilla_show', array('id'=>$plantilla->getId(), 'section'=>$section), 301);
        }
        $cancelPath = $this->generateUrl('plantilla_show', array('id' => $plantilla->getid(), 'section' => $section));        
        $abmManager = $this->get('ABM_AbmManager')
                ->setForm($form->createView())
                ->setCancelPath($cancelPath);
        
        return array('abmManager' => $abmManager , 'plantilla'=>$plantilla, 'section'=>$section);
    }
    /**
     * @Route("/show/{id}/{section}",defaults={"section"="General"}, name="plantilla_show")
     * @Template()
     */
    public function showAction($id,$section)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Plantilla');
        $plantilla = $repository->find($id);

        if(!$plantilla){
            throw new Exception('No existe la plantilla');
        }
        $form = $this->createForm(PlantillaType::class, $plantilla,array('disabled' => true));//($plantillaform,$plantilla,array('disabled' => true));
        $form->remove('file');
        $cancelPath = $this->generateUrl('plantilla_show', array('id' => $plantilla->getid(), 'section' => $section));
        $editPath = $this->generateUrl('plantilla_edit', array('id' => $plantilla->getid(), 'section' => $section));
        $abmManager = $this->get('ABM_AbmManager')
                ->setForm($form->createView())
                ->setCancelPath($cancelPath)
                ->setEditPath($editPath);
        
        return array('abmManager' => $abmManager, 'section'=>$section);

    }
    /**
     * @Route("/new", name="plantilla_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $estudio =$user->getEstudio();

        $form = $this->createForm(PlantillaType::class, new Plantilla()); 
        
        $form->handleRequest($request);
        if($form->isValid()) {
            
            $plantilla = $form->getData();
            $plantilla->setEstudio($estudio);
            
            $tm = $this->get('lp_TemplateManager');
            $tm->newTemplate($plantilla);

            //Presiono el boton de Modificar y Continuar
            if ($request->request->has('modificar')) {
                return $this->redirectToRoute('plantilla_show', array('id'=>$plantilla->getId()), 301);
            }else{
                $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('plantilla_show', array('id' => $plantilla->getId())) . '">' . $plantilla->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
                return $this->redirectToRoute('plantilla_list', array(), 301);
            }
        }
        $cancelPath = $this->generateUrl('plantilla_list', array());
        $abmManager = $this->get('ABM_AbmManager')
//            ->setTitle($this->get('translator')->trans('new') . ' Plantilla')
            ->setForm($form->createView())
            ->setCancelPath($cancelPath);
        return array('abmManager' => $abmManager);
    }
    //Provisorio
    /**
     * @Route("/newDocument/{id_plantilla}/{id}", name="plantilla_newDocument")
     * @Template()
     */
    public function newDocumentAction(Request $request, $id_plantilla, Expediente $expediente){

        $repository = $this->getDoctrine()->getRepository('AppBundle:Plantilla');
        $plantilla = $repository->find($id_plantilla);
        $estudio = $this->getUser()->getEstudio();
        //HACER: agregar el servicio de permisos
        if($estudio != $plantilla->getEstudio()){
            throw new \Exception("Estudio incorrecto");
        }
//        $data = array();
        $form = $this->generateFormBuilder($plantilla->getVariables())
                ->add('generar','submit')
                ->getForm();
        $form->handleRequest($request);
        if($form->isValid()) {
            $data = $form->getData();
            $tm = $this->get('lp_TemplateManager');
            $documento = $tm->generateDocument($expediente->getId(), $plantilla->getFilename(), $data);

            $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('documento_show', array('id' => $documento->getId())) . '">' . $documento->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
            return $this->redirectToRoute('documento_list', array('idExpediente'=>$expediente->getId()), 301);
            
            
        }
        return array('form'=> $form->createView(), 'expediente'=>$expediente);
    }
    
    private function generateFormBuilder($variables){
        
        $formBuilder = $this->createFormBuilder(array());
        if(isset($variables)){
            foreach ($variables as $value) {
                $formBuilder->add($value , 'text');
            }
        }
        return $formBuilder;
    }
}

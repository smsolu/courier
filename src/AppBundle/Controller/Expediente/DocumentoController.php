<?php

namespace AppBundle\Controller\Expediente;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use AppBundle\Form\Type\Expediente\Documento\DocumentoType;

use AppBundle\Entity\Expediente;
use AppBundle\Entity\Documento;
use AppBundle\Entity\DocumentoVersion;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/documento")
 */
class DocumentoController extends Controller
{
    /**
     * @Route("/list/{expediente}/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Expediente","order_status"=1}, name="documento_list")
     * @Template()
     */
    public function listAction(Request $request, Expediente $expediente, $page, $resultpage,$order_col,$order_status)
    {
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();

        //HACER: Chequear que el expediente sea del estudio y que el usuario tenga los permisos
        // 1. Crear el Query del Listado.
        $queryBuilder = $em->getRepository('AppBundle:Documento')->getDocumentos($estudio,$expediente);

        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list->setTitle("Documentos")
            ->setControllerParent($this)//INYECTAR TRANLATOR Y SACAR ESTO
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('documento_edit', array('id'=> 'getId')),
                        'value' => '<span class="glyphicon glyphicon-pencil"></span>'
                        ))
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('documento_version_list', array('id'=> 'getId')),
                'value' => '<span class="glyphicon glyphicon-duplicate"></span>'
                ))
            ->addColumn('Nombre', 'nombre',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))
            ->addColumn('Descripcion', 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))
            ->addColumn('Bloqueado', 'bloqueadoStr',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))
                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);
        $parameters = json_encode(array('expediente' => $expediente->getId()));
        //. Enviar la información a la vista
        return array('list' => $list,'request'=>$request, 'parameters' => $parameters, 'expediente' => $expediente, "section" => 'documentos');
    }
    /**
     * @Route("/versiones/{id}/{page}/{order_col}/{order_status}/{resultpage}", defaults={"page" = 1, "resultpage" = 10,"order_col"="Version","order_status"=1}, name="documento_version_list")
     * @Template()
     */
    public function versionListAction(Request $request ,Documento $documento, $page, $resultpage,$order_col,$order_status){
        
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
        
        $queryBuilder = $em->getRepository('AppBundle:Documento')->getDcoumentoVersion($estudio,$documento);
        /*
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->where("e.status =:status and e.estudio = :id_estudio and e.documento = :documento")
            ->setParameters(array("status"=> 0, "id_estudio"=>$estudio, "documento"=>$documento))
            ->from('AppBundle:DocumentoVersion','e');*/
        
        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list->setTitle("Versiones del documento")
            ->setControllerParent($this)//INYECTAR TRANLATOR Y SACAR ESTO
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('documento_version_file', array('id'=> 'getId')),
                'value' => '<span class="glyphicon glyphicon-download-alt"></span>'
                ))
            ->addColumn('', 'id',array(
                'type' => 'link',
                'route' => new LinkColumn('documento_version_delete', array('id'=> 'getId')),
                'value' => '<span class="glyphicon glyphicon-remove"></span>'
                ))
            ->addColumn('Version', 'version',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))
            ->addColumn('Descripcion', 'descripcion',array(
                'type' => 'string',
                'allow_order'=>'1',
                ))
            ->addColumn('Fecha', 'fechaModificacion',array(
                'type' => 'date',
                'allow_order'=>'1',
                ))                
                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);    
        
        $parameters = json_encode(array('id' => $documento->getId()));
        return array('list' => $list,'request'=>$request, 'parameters' => $parameters, 'expediente'=> $documento->getExpediente(), 'section'=>'documentos');
    }
    /**
     * @Route("/show/{id}", name="documento_show")
     * @Template()
     */
    public function showAction(Documento $documento = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documento)){
            throw new \Exception('No existe el documento');
        }
        $documentoForm = new DocumentoType();
        $form = $this->createForm($documentoForm,$documento,array('disabled' => true));
//        $cancelPath = $this->generateUrl('documento_list', array('expediente' => $documento->getExpediente()->getid()));
        $editPath = $this->generateUrl('documento_edit', array('id' => $documento->getid()));;
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($documento->getNombre())
                ->setForm($form->createView())
//                ->setCancelPath($cancelPath)
                ->setEditPath($editPath);
        
        return array('abmManager' => $abmManager, 'entidad'=>$documento);
    }

    /**
     * @Route("/new/{id}", name="documento_new")
     * @Template()
     */
    public function newAction(Request $request, Expediente $expediente)
    {
        
        $documento = new Documento();
        $form = $this->createForm(new DocumentoType(), $documento); 
//        Esta es una forma de setear datos al subform pero no es correcta porque
//        si cambia algo del form va a romper aca
//        $form->get('lastDocumentoVersion')->get('descripcion')->setData('Version Inicial');
        $form->handleRequest($request);
        if($form->isValid()) {
            $documento = $form->getData();
            $this->get('lp_DocumentManager')
                    ->newDocument($documento, $expediente);
            //Presiono el boton de Modificar y Continuar
            if ($request->request->has('modificar')) {
                return $this->redirectToRoute('documento_show', array('id'=>$documento->getId()), 301);
            }else{
                $this->get('session')->getFlashBag()->add('success', '<a href="' . $this->generateUrl('documento_show', array('id' => $documento->getId())) . '">' . $documento->getNombre() . ' ' . $this->get('translator')->trans('create_ok')  .'</a>');                
                return $this->redirectToRoute('documento_list', array('expediente'=>$expediente->getId()), 301);
            }
        }
        $abmManager = $this->get('ABM_AbmManager')
            ->setTitle($this->get('translator')->trans('new') . ' ' .  $documento->getNombre())
            ->setForm($form->createView())
            ->setCancelPath($this->generateUrl('documento_list', array('expediente'=>$expediente->getId())));
        return array('abmManager' => $abmManager, 'expediente' => $expediente, 'section'=>'documentos');
    }
    /**
     * @Route("/edit/{id}", name="documento_edit")
     * @Template()
     */
    public function editAction(Request $request, Documento $documento = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documento)){
            throw new \Exception('No existe el documento');
        }
        $dm = $this->get('lp_DocumentManager');
        
        if($documento->getBloqueado() == Documento::BLOQUEADO_BLOQUEADO){
            if(!$dm->canEdit($documento)){
                $this->get('session')->getFlashBag()->add('danger','El documento "'.$documento->getNombre().'" se encuentra bloqueado por el usuario '.$documento->getUsuarioBloqueo()->getUsername());                
                return $this->redirectToRoute('documento_list', array('expediente'=>$documento->getExpediente()->getId()), 301);
            }
        }
        $dm->lockDocument($documento);
        $documentoForm = new DocumentoType();
        $form = $this->createForm($documentoForm,$documento);
        $form->add('accion', 'choice', array(
            'choices'=> array(
                'Reemplazar ultima version' => 0,
                'Nueva version' => 1
                ),
            'label' => 'Accion',
            'mapped' =>false,
            'choices_as_values' => true,
            )
        );
        $form->handleRequest($request);
        if($form->isValid()) {
            $documento = $form->getData();
            $type = $request->request->get('documento_form')['accion'];
            $dm->editDocument($documento, $type);
            return $this->redirectToRoute('documento_list', array('expediente'=>$documento->getExpediente()->getId()), 301);
        }
        $cancelPath = $this->generateUrl('documento_list', array('expediente' => $documento->getExpediente()->getid()));        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle("Editando documento: ".$documento->getNombre())
                ->setForm($form->createView())
                ->setCancelPath($cancelPath);
        return array('abmManager' => $abmManager , 'documento'=>$documento, 'expediente' => $documento->getExpediente(), 'section' => 'documentos');
    }
    /**
     * @Route("/lock/{id}", name="documento_lock")
     * @Template()
     */
    public function lockAction(Documento $documento = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documento)){
            throw new \Exception('No existe el documento');
        }
        $this->get('lp_DocumentManager')
                ->lockDocument($documento);
        return $this->redirectToRoute('documento_list', array('expediente'=>$documento->getExpediente()->getId()), 301);
    }
    /**
     * @Route("/unlock/{id}", name="documento_unlock")
     * @Template()
     */
    public function unlockAction(Documento $documento = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documento)){
            throw new \Exception('No existe el documento');
        }
        $this->get('lp_DocumentManager')
                ->unlockDocument($documento);
        return $this->redirectToRoute('documento_list', array('expediente'=>$documento->getExpediente()->getId()), 301);
    }
    /**
     * @Route("/file/{id}", name="documento_file")
     * @Template()
     */
    public function fileAction(Documento $documento = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documento)){
            throw new \Exception('No existe el documento');
        }
        
        $documentoVersion = $documento->getLastDocumentoVersion();
        return $this->createFileResponse($documentoVersion);
    }
    /**
     * @Route("/versionFile/{id}", name="documento_version_file")
     * @Template()
     */
    public function versionFileAction(DocumentoVersion $documentoVersion = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documentoVersion)){
            throw new \Exception('No existe la verson del documento');
        }
        return $this->createFileResponse($documentoVersion);
    }
    private function createFileResponse(DocumentoVersion $documentoVersion){
        $documento = $documentoVersion->getDocumento();
        $fileContent = $this->get('lp_DocumentManager')
                ->getDocumentFileContent($documentoVersion);
        $extension = (new \SplFileInfo($documentoVersion->getFilename()))->getExtension();
        $response = new Response();
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$documento->getNombre()." (version ".$documentoVersion->getVersion().").".$extension);
        $response->setContent($fileContent);
        return $response;
    }
    /**
     * @Route("/versionFile/delete/{id}", name="documento_version_delete")
     * @Template()
     */
    public function versionDeleteAction(Request $request, DocumentoVersion $documentoVersion = null)
    {
        //HACER: control de seguridad por si el usuario puede ver el documento y
        //evitar que vean de otros estudios
        if(empty($documentoVersion)){
            throw new \Exception('No existe la verson del documento');
        }
        $documento = $documentoVersion->getDocumento();
        if($this->get('lp_DocumentManager')->deleteDocumentVersion($documentoVersion)){
            $this->get('session')->getFlashBag()->add('success','Version eliminada correctamente' );                
        }else{
            $this->get('session')->getFlashBag()->add('danger','No se puede eliminar la version' );                
        }
        return $this->redirectToRoute('documento_version_list', array('id'=>$documento->getId()), 301);
        
    }
    
}


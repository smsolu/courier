<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Estudio\EstudioType;

    /**
     * @Route("/estudio")
     */
class EstudioController extends Controller
{
     /**
     * @Route("/edit/{section}", defaults={"section" = "General"}, name="estudio_edit")
     * @Template()
     */
    public function editAction(Request $request, $section)
    {
        $user = $this->getUser();
        $estudio = $user->getEstudio();
        if(!$estudio){
            return $this->redirectToRoute('estudio_new', array(), 301);
        }
        $form = $this->createForm(new EstudioType(), $estudio); 
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $estudioForm = $form->getData();
            $estudio->setNombre($estudioForm->getNombre());
            $em->persist($estudio);
            $em->flush();
            /*HACER: Configurar para que vuelva a la pagina anterior*/
            return $this->redirectToRoute('estudio_show', array(), 301);
        }
        $cancelPath = $this->generateUrl('estudio_show', array('section' => $section));        
        $abmManager = $this->get('legalPro_commonBundle_AbmManager')
                ->setTitle($estudio->getNombre())
                ->setForm($form->createView())
                ->setCancelPath($cancelPath);
        
        return array('abmManager' => $abmManager , 'estudio'=>$estudio, 'section'=>$section);
    }

/**
     * @Route("/show/cuenta", defaults={"section" = "cuenta"}, name="estudio_cuenta")
     * @Template()
     */
    public function cuentaAction($section)
    {
        $user = $this->getUser();
        $id = $user->getEstudio()->getId();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Estudio');
        $estudio = $repository->findOneById($id);
        $cuenta = $estudio->getCuenta();
        
        
        
        /* Expedientes */
        $valores[] = $this->getPorc("Expedientes",
                                    $estudio->getCantExpedientes(),$cuenta->getMaxExpedientes()); 

        /*DOCUMENTOS*/
        $valores[] = $this->getPorc("Documentos",
                                    $estudio->getCantDocumentos(),$cuenta->getMaxDocumentos()); 
        
        /*USUARIOS*/
       $valores[] = $this->getPorc("Usuarios",
                                    $estudio->getCantUsuarios(),$cuenta->getMaxUsuarios());         

       /*Entidades*/
       $valores[] = $this->getPorc("Entidades",
                                    $estudio->getCantEntidades(),$cuenta->getMaxEntidades());       
       
       /*Tamaño total en Archivos*/
       $valores[] = $this->getPorc("Tamaño en Archivos",
                                    $estudio->getCantBytesFiles(),$cuenta->getMaxBytesFiles());              
       
        return array('estudio'=>$estudio, 'section'=>$section, 'cuenta'=>$cuenta, 'valores'=>$valores);
       
    }    
    
    public function getPorc($nombre, $cantidad,$max){
        $porc = round(($cantidad / $max)*100,2);
        if($porc <0){ $porc = 0;}
        if($porc > 100){ $porc = 100;}
        $porclabel = number_format($porc, 2, '.', '');  
        
        return array("nombre" => $nombre , "cantidad" => $cantidad, "max" => $max, "porc" => $porc, "porc_label" => $porclabel);
    }
    

    /**
     * @Route("/show/{section}", defaults={"section" = "general"}, name="estudio_show")
     * @Template()
     */
    public function showAction($section)
    {
        $user = $this->getUser();
        $id = $user->getEstudio()->getId();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Estudio');
        $estudio = $repository->findOneById($id);
        
        if (!$estudio){
            $mensaje = "El estudio no existe";
            return array('estudio' => $estudio, 'mensaje' => $mensaje, 'active' => 'datos_de_estudio', 'submenu' => $submenu);
        }
        
        $estudioform = $this->getFormType($section);
        $form = $this->createForm($estudioform,$estudio,array('disabled' => true));
        
        $cancelPath = $this->generateUrl('estudio_show', array('section' => $section));
        $editPath = $this->generateUrl('estudio_edit', array('section' => $section));
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($estudio->getNombre())
                ->setForm($form->createView())
                ->setCancelPath($cancelPath)
                ->setEditPath($editPath);
        
        return array('abmManager' => $abmManager, 'estudio'=>$estudio, 'section'=>$section);
//        return array('estudio' => $estudio, 'active' => 'datos_de_estudio');
        
    }
    private function getFormType($section){
        switch ($section){
            case "General";default:
                $entidadform = new EstudioType();
                break;
        }
        return $entidadform;
    }
}

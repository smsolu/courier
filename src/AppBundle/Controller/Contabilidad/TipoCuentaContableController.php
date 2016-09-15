<?php

namespace AppBundle\Controller\Contabilidad;

use AppBundle\Entity\TipoCuentaContable;
use AppBundle\Exception\RegEspException;
use AppBundle\Form\Type\Contabilidad\TipoCuentaContableType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\Exception;
use Symfony\Component\Validator\Exception\ValidatorException;

    /**
     * @Route("/contabilidad/tipocuenta/")
     */
class TipoCuentaContableController extends Controller
{
    /**
     * @Route("new", name="contabilidad_tipocuentas_new")
     * @Template()
     */
    public function newAction(Request $request){
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();
        $seccion = "Nuevo Tipo de Cuenta Contable";
        $em = $this->getDoctrine()->getEntityManager();

        
        $obj = new TipoCuentaContable();
        $obj->setEstudio($estudio);

        
        $form = $this->createForm(TipoCuentaContableType::class, $obj,array());
        $form->handleRequest($request);        
  
        if($form->isValid()) {
            $obj = $form->getData();
            // Validaciones: EL CODIGO Y EL NOMBRE NO TIENEN QUE SER REPETIDOS
            
            if($em->getRepository("AppBundle:TipoCuentaContable")
                    ->getExistTipoCuentaContable($estudio,$obj->getCodigo(), $obj->getNombre())){
                $this->get('session')->getFlashBag()->add('danger', "El código o nombre del tipo de cuenta no puede ser igual a uno existente");  
                return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301); 
            }
            
            $em->persist($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Se ha registrado correctamente");                
            return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301); 
        }
        
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($this->get('translator')->trans('title_new')  . ' ')
                ->setForm($form->createView())
                ->setShowButtonModify(false)
                ->setCancelPath($this->generateUrl('contabilidad_tipocuentas_list', array()));
        return array('abmManager' => $abmManager,'section'=>$seccion);        
    }    
    
    /**
     * @Route("edit/{tipoCuentaContable}", name="contabilidad_tipocuentas_edit")
     * @Template()
     */
    public function editAction(Request $request, TipoCuentaContable $tipoCuentaContable){    
        
        $tipoCuentaContableManager = $this->get('lp_TipoCuentaContableManager');
        try{
            $tipoCuentaContableManager->doCheckPermissions($tipoCuentaContable);
            $tipoCuentaContableManager->doValidate($tipoCuentaContable);
        }catch(RegEspException $regesp){
            $this->get('session')->getFlashBag()->add('info', 'El tipo de cuenta contable es especial y no puede ser modificada ni eliminada.');   
            return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);        
        }
        
        $form = $tipoCuentaContableManager->getForm($tipoCuentaContable,true);
        $form->handleRequest($request);
        if($form->isValid()) {
            $tipoCuentaContable = $tipoCuentaContableManager->doEdit($form->getData());
            if($this->getDoctrine()->getManager()->getRepository("AppBundle:TipoCuentaContable")
                    ->getExistTipoCuentaContable($this->getUser()->getEstudio(),$tipoCuentaContable->getCodigo(), $tipoCuentaContable->getNombre(), $tipoCuentaContable->getId())){
                $this->get('session')->getFlashBag()->add('danger', "El código o nombre del tipo de cuenta no puede ser igual a uno existente");  
                return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301); 
            }
            $this->get('session')->getFlashBag()->add('success', $tipoCuentaContable->getNombre() . " Se ha modificado correctamente");                
            return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);     
        }
        $abmManager = $this->get('ABM_AbmManager')
                ->setTitle($tipoCuentaContable->getNombre())
                ->setForm($form->createView())
                ->setCancelPath($this->generateUrl('contabilidad_tipocuentas_list', array()));
        
        return array('abmManager' => $abmManager , 'tipoCuentaContable'=>$tipoCuentaContable, 'section'=>'General');
    }
    
    /**
     * @Route("undo_delete/{tipoCuentaContable}", name="contabilidad_tipocuentas_undodelete")
     * @Template()
     */
    public function undodeleteAction(TipoCuentaContable $tipoCuentaContable){    
        $tipoCuentaContableManager = $this->get('lp_TipoCuentaContableManager');
        try{
            $tipoCuentaContableManager->doValidate($tipoCuentaContable);
        }catch(RegEspException $regesp){
            $this->get('session')->getFlashBag()->add('info', 'El tipo de cuenta contable es especial y no puede ser modificada ni eliminada.');   
            return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);        
        }
        $tipoCuentaContableManager->doUndoDelete($tipoCuentaContable);
        $this->get('session')->getFlashBag()->add('success', 'El tipo de cuenta: ' . $tipoCuentaContable->getNombre() . ' ha sido restaurada');   
        return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);  
    }
    
    /**
     * @Route("delete/{tipoCuentaContable}", name="contabilidad_tipocuentas_delete")
     * @Template()
     */
    public function deleteAction(TipoCuentaContable $tipoCuentaContable){    
        $tipoCuentaContableManager = $this->get('lp_TipoCuentaContableManager');
        try{
            $tipoCuentaContableManager->doCheckPermissions($tipoCuentaContable);
            $tipoCuentaContableManager->doValidate($tipoCuentaContable);
        }catch(RegEspException $regesp){
            $this->get('session')->getFlashBag()->add('info', 'El tipo de cuenta contable es especial y no puede ser modificada ni eliminada.');   
            return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);        
        }
        $tipoCuentaContableManager->doDelete($tipoCuentaContable);
        $this->get('session')->getFlashBag()->add('danger', '<a href="' . $this->generateUrl('contabilidad_tipocuentas_undodelete', array('tipoCuentaContable' => $tipoCuentaContable->getId())) . '"><span class="glyphicon glyphicon-trash"></span> ' . $tipoCuentaContable->getNombre() . ' ' . $this->get('translator')->trans('eliminado_ok')  .'</a>');   

        return $this->redirectToRoute('contabilidad_tipocuentas_list', array(), 301);        
    }
    
    /**
     * @Route("list/{page}/{order_col}/{order_status}",defaults={"page"="1", "resultpage"="10","order_col"="","order_status"="0"},  name="contabilidad_tipocuentas_list")
     * @Template()
     */
    public function listAction(Request $request, $page,$resultpage,$order_col,$order_status)
    {
        $tipoCuentaContableManager = $this->get('lp_TipoCuentaContableManager');
        $list = $tipoCuentaContableManager->getList($order_col, $order_status, $page, $resultpage);
        return array('list' => $list,'request'=>$request,'parameters'=>$this->getRequest()->query->all());
    }
}
    
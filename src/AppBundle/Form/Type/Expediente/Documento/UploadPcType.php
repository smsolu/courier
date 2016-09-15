<?php

namespace AppBundle\Form\Type\Expediente\Documento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\ExpedienteDocumentoFile;
use Symfony\Component\HttpFoundation\Request;



class UploadPcType extends AbstractType
{
    private $tipo=0;
    
     public function __construct($tipo=0) {
         $this->tipo = $tipo;
     } 
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion','text', array('required'=> true,'label' => 'Descripcion de la versión', 'max_length'=> '255'));
            

        switch ($this->tipo){
            case 0;default:
                $builder->add('file','file',array('required'=> false,'label'=>'Archivo'));
            break;
            case 1;
                $builder->add('filename','text',array('required'=> false,'label'=>'Archivo'));
            break;    
            }
            
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteDocumentoFile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'expediente_documento_file';
    }
}

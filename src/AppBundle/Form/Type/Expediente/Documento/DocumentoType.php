<?php

namespace AppBundle\Form\Type\Expediente\Documento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentoType extends AbstractType
{
    const ACTION_SHOW = 0;
    const ACTION_NEW = 1;
    
//    private $fileField;
    private $action = self::ACTION_SHOW;

     public function __construct($action = true) {
         $this->action = $action;
     } 
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch($this->action){
            case self::ACTION_SHOW:
                $this->buildShowForm($builder);
                break;
            case self::ACTION_NEW:
                $this->buildNewForm($builder);
                break;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Documento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'documento_form';
    }
    private function buildShowForm(FormBuilderInterface $builder){
        $builder
            ->add('nombre','text', array('required'=> true,'label' => 'Nombre', 'max_length'=> '255'))
            ->add('descripcion','text', array('required'=> false,'label' => 'Descripcion', 'max_length'=> '255'));
    }
    private function buildNewForm(FormBuilderInterface $builder){
        $builder
            ->add('nombre','text', array('required'=> true,'label' => 'Nombre', 'max_length'=> '255'))
            ->add('descripcion','text', array('required'=> false,'label' => 'Descripcion', 'max_length'=> '255'))
//            ->add('file','file',array('required'=> false,'label'=>'Archivo'))
            ->add('lastDocumentoVersion', new DocumentoVersionType(), array('label' => 'Datos de la version'))
            ;
    }
}

<?php

namespace AppBundle\Form\Type\Expediente\Documento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentoVersionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion','text', array('required'=> false,'label' => 'Descripcion', 'max_length'=> '255'))
            ->add('file','file',array('required'=> false,'label'=>'Archivo'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DocumentoVersion'
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
            ->add('file','file',array('required'=> false,'label'=>'Archivo'));
    }
}

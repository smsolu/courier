<?php

namespace AppBundle\Form\Type\Contabilidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TipoCuentaContableType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class, array(
                    'required'=> true,
                    'label' => 'Código', 
                    'max_length'=> '25'))
            ->add('nombre',TextType::class, array(
                    'required'=> true,
                    'label' => 'Nombre', 
                    'max_length'=> '50'))
            ->add('descripcion',TextType::class, array(
                    'required'=> false,
                    'label' => 'Descripción', 
                    'max_length'=> '255'));
        
            if( $options["edit"]==false ){
               $builder->add('egresoingreso',ChoiceType::class, array(
                        'choices' => array('0' => 'Egreso', '1'=>'Ingreso'),
                        'required'=> true,
                        'label' => 'Tipo'));                   
            }
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'edit' => false
        ));
    }
    

}

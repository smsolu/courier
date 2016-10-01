<?php

namespace AppBundle\Form\Type\Entidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class EntidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoPersona', 'choice', array(
                    'choices' => array(
                    '0'   => 'Fisica',
                    '1' => 'Jurídica',
            ),
                    'multiple' => false,
                    'label' => 'Tipo de Persona',
            ))
            ->add('codigo',TextType::class , array('required'=> true,'label' => 'Código', 'max_length'=> '40'))
            ->add('nombrePila',TextType::class ,array('required'=> true,'label'=>'Nombre','max_length'=> '100'))
            ->add('nombreApellido',TextType::class ,array('required'=> true,'label'=>'Apellido','max_length'=> '100'));
    }             
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Entidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Entidad';
    }
}

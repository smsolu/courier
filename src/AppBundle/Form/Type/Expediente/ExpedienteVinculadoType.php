<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ExpedienteVinculadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion',TextType::class, array('required'=> false,'label' => 'Observaciones', 'max_length'=> '255'))
            ->add('ExpedienteVinculado', EntityType::class, array(
                    'class' => 'AppBundle:Expediente',    
                    'choice_label' => 'getNumeroyCaratulaCompleto','mapped' => true, 
                    'label'=> 'Vinculado con',
                    'choices'=> $options['expedientes']
            ))
            ->add('TipoVinculacion', EntityType::class, array(
                    'class' => 'AppBundle:TipoVinculacion',    
                    'choice_label' => 'nombre','mapped' => true, 
                    'label'=> 'Tipo de Vinculación',
                    'choices'=> $options['tipovinculacion']
            ))                 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteVinculado',
            'expedientes' => 'null',
            'tipovinculacion' => 'null'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ExpedienteVinculadoType';
    }

    

}

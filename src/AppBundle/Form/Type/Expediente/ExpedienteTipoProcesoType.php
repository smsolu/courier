<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ExpedienteTipoProcesoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TipoProceso', EntityType::class, array(
                    'class' => 'AppBundle:TipoProceso',
                    'choices' => $options['tipoProcesos'],
                    'choice_label' => 'nombre',
                    'mapped' => true,
                    'label'=> 'Tipo de Proceso Principal'
                ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Expediente',
            'tipoProcesos' => null
        ));
    }
}

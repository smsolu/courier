<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ExpedienteEntidadType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entidad', EntityType::class, array(
                    'class' => 'AppBundle:Entidad',
                    'choices' => $options['entidades'],
                    'choice_label' => 'nombre',
                    'label'=> 'Abogados'
                ))
            ->add('descripcion',TextType::class, array(
                    'required'=> false,
                    'label' => 'Observaciones', 
                    'max_length'=> '255'))
            ->add('responsable', ChoiceType::class, array(
                  'choices' => array(0 => 'No responsable', 1 => 'Responsable'),
                  'required'=>true, 'mapped'=> true
            ))              
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteEntidad',
            'entidades' => null
        ));
    }
    

}

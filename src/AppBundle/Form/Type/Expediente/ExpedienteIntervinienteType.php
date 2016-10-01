<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ExpedienteIntervinienteType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //Caracter
            ->add('Caracter', EntityType::class, array(
                    'class' => 'AppBundle:CaracterInterviniente',
                    'choices' => $options['caracterInterviniente'],
                    'choice_label' => 'nombre',
                    'mapped' => true, 
                    'label'=> 'Caracter'
            ))
            ->add('descripcion', TextType::class, array('required'=> false,'label' => 'Observaciones', 'max_length'=> '255'))
            ->add('entidad', EntityType::class, array(
                    'class' => 'AppBundle:Entidad',
                    'choices' => $options['intervinientes'],
                    'choice_label' => 'nombre',
                    'label'=> 'Interviniente'
                ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteInterviniente',
            'intervinientes' => null,
            'caracterInterviniente' => null,
        ))
//                ->setRequired(array('intervinientes'))
                ;
    }
    

}

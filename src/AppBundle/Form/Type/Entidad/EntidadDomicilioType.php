<?php

namespace AppBundle\Form\Type\Entidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EntidadDomicilioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('direccion',TextType::class,array('required'=> false,'label'=>'Dirección','max_length'=> '255'))
            // LOCALIDAD
            ->add('localidad', EntityType::class, array(
                    'class' => 'AppBundle:EntidadLocalidad','label'=>'Localidad/Ciudad',
                    'choice_label' => 'nombre',
                    'mapped' => true,
            )) 
            //PROVINCIA -> ÚNICA PARA TODOS LOS ESTUDIOS
            ->add('provincia',EntityType::class, array(
                    'class' => 'AppBundle:EntidadProvincia','label'=>'Provincia',
                    'choice_label' => 'nombre','mapped' => true
            ))
                
            //NACIONALIDAD -> ÚNICA PARA TODOS LOS ESTUDIOS
            ->add('nacionalidad', EntityType::class, array(
                    'class' => 'AppBundle:EntidadNacionalidad','label'=>'Nacionalidad',
                    'choice_label' => 'nombre','mapped' => true
            ))                
           ->add('codPostal',TextType::class,array('required'=> false,'label'=>'Cod. Postal','max_length'=> '12'))
        ;
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

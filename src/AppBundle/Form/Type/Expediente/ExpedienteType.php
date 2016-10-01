<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ExpedienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caratula', TextType::class , array('required'=> true,'label' => 'Caratula', 'max_length'=> '255'))
            ->add('numero',NumberType::class,array('required'=> true,'label'=>'Número de Expediente','max_length'=> '9'))
            ->add('anio',NumberType::class,array('required'=> true,'label'=>'Año','max_length'=> '4'))
            ->add('nroincidente',NumberType::class,array('required'=> false,'label'=>'Nro. de Incidente','max_length'=> '4'))
            

            ->add('ClientePrincipal', EntityType::class, array(
                    'class' => 'AppBundle:Entidad',    
                    'choice_label' => 'nombre','mapped' => true, 
                    'label'=> 'Cliente Principal',
                    'choices'=> $options['clientes']
            ))   
            //CAMARA DEL EXPEDIENTE: ÚNICA PARA TODOS LOS ESTUDIOS
            ->add('ExpedienteCamara', EntityType::class, array(
                    'class' => 'AppBundle:ExpedienteCamara',    
                    'choice_label' => 'nombreCompleto','mapped' => true, 'label'=> 'Cámara'
            ))                
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Expediente',
            'clientes' => null
        ));
    }
}

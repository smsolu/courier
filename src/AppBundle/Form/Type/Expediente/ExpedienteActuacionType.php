<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpedienteActuacionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechayhora',DateType::class,array('required'=> false,'label'=>'Fecha (hay que poner datepicker)','format' => 'd-M-y','widget'=>'text'))
            ->add('descripcion',TextareaType::class,array('attr' => array('rows'=>10), 'required'=> true,'label'=>'Observaciones','max_length'=> '64000','mapped'=>true))
            ->add('fojas',TextType::class, array('required'=> false,'label' => 'Fojas', 'max_length'=> '15'))
            ->add('Tipoactuacion',EntityType::class, array(
                        'class' => 'AppBundle:ActuacionTipoactuacion',
                        'choices' => $options['tipo_actuaciones'],
                        'choice_label' => 'nombre',
                        'required'=> true,
                        'label' => 'Tipo de Actuación'));                     
            ;
       
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteActuacion',
            'tipo_actuaciones' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ExpedienteActuacion';
    }
}

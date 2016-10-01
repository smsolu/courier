<?php

namespace AppBundle\Form\Type\Entidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EntidadObservacionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observaciones',TextareaType::class,array('attr' => array('rows'=>10), 'required'=> false,'label'=>'Observaciones','max_length'=> '1000','mapped'=>true))
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
        return 'entidad';
    }
}

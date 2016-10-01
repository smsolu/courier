<?php

namespace AppBundle\Form\Type\Entidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EntidadLaboralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profesion',TextType::class,array('required'=> false,'label'=>'Profesión','max_length'=> '50','mapped'=>false, 'data' => $options["profesion"]))
            ->add('empresa',TextType::class,array('required'=> false,'label'=>'Empresa','max_length'=> '50','mapped'=>false, 'data' => $options["empresa"]))
            ->add('TipoResponsabilidadIva', EntityType::class, array(
                    'class' => 'AppBundle:EntidadTipoResponsabilidadIva','label'=>'Tipo de Contribuyente',
                    'choice_label' => 'nombre',
                    'mapped' => true,
            )) 
            ->add('nro_cuit',TextType::class,array('required'=> false,'label'=>'Cuit','max_length'=> '50'))
            ->add('nro_ingresosbrutos',TextType::class,array('required'=> false,'label'=>'Número de Ingresos Brutos','max_length'=> '50'))    
    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Entidad',
            'profesion' => '',
            'empresa' => ''
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

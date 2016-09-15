<?php

namespace ContabilidadBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CobroCCType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //var_dump($options);
        $builder
            ->add('fechayhora','date',array('required'=> true,'label'=>'Fecha y Hora','format' => 'dd-MM-yyyy','widget'=>'text'))
            ->add('TipoCuentaContable', EntityType::class, array(
                    'class' => 'AppBundle:TipoCuentaContable',
                    'choices' => $options['tipoCuenta'],
                    'choice_label' => 'nombre',
                    'label'=> 'Tipo de Cuenta'
                ))
            ->add('titulo',TextType::class, array('required'=> true,'label' => 'Titulo', 'max_length'=> '25'))
            ->add('descripcion',  TextareaType::class,array('attr' => array('rows'=>5), 'required'=> false,'label'=>'Detalle','max_length'=> '1000','mapped'=>true))
            ->add('monto_cobro',MoneyType::class, array('currency' =>'ARS', 'required'=> true,'label' => 'Monto', 'max_length'=> '10','scale'=>2));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\CobroCC',
            'tipoCuenta' => null
        ));
    }
    

}

<?php

namespace AppBundle\Form\Type\Entidad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EntidadContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('telefono',TextType::class ,array('required'=> false,'label'=>'Telefono','max_length'=> '50'))
            ->add('telefono2',TextType::class ,array('required'=> false,'label'=>'Telefono Laboral','max_length'=> '50'))
            ->add('celular',TextType::class ,array('required'=> false,'label'=>'Celular','max_length'=> '50'))
            ->add('fax',TextType::class ,array('required'=> false,'label'=>'Fax','max_length'=> '50'))
            ->add('email',EmailType::class,array('required'=> false,'label'=>'Email','max_length'=> '50'))
            ->add('web',TextType::class,array('required'=> false,'label'=>'Web','max_length'=> '50'))
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

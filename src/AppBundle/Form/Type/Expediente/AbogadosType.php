<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AbogadosType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                //HACER: PROBLEMA: EL NOMBRE ENTIDAD CAUSA PROBLEMAS PORQUE BUSCA ESE CAMPO EN LA ENTIDAD ASOCIADA
            ->add('entidad', EntityType::class, array(
                    'class' => 'AppBundle:Entidad',
                    'choices' => $options['abogados'],
                    'choice_label' => 'nombre',
                    'label'=> 'Abogados'
                ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Entidad',
            'abogados' => null
        ));
    }
    

}

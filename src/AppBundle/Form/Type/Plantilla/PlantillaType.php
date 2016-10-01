<?php
namespace AppBundle\Form\Type\Plantilla;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PlantillaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, array('required'=> true,'label' => 'Nombre', 'max_length'=> '255'))
            ->add('codigo',TextType::class, array('required'=> true,'label' => 'Codigo', 'max_length'=> '255'))
            ->add('descripcion',TextType::class, array('required'=> true,'label' => 'Descripcion', 'max_length'=> '255'))
            ->add('tipo', ChoiceType::class, array('choices' => array(
                                                                    'Plantilla' => 1,
                                                                    'Carpeta' => 0
                                                                    ), 
                                                    'label' => 'Tipo',
                                                    'choices_as_values' => true,));
        if($options['fileEnabled']){
            $builder->add('file', FileType::class, array('label' => 'Archivo', 'required'=> $options['fileRequired'] ));
        }
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Plantilla',
            'fileRequired' => true,
            'fileEnabled' => true
        ));
    }
}

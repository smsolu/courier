<?php
namespace UserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\Estudio\EstudioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estudio', EstudioType::class);
        $builder
            ->add('nombre', TextType::class);        
    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

//    public function getName()
//    {
//        return 'lp_user_registration';
//    }
}
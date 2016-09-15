<?php
namespace UserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('group', EntityType::class, array(
                'class' => 'AppBundle:Group',
                'property' => 'name',
            ));
    }
//    Solo si lo voy a linkear con la entidad
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'LegalPro\Bundles\CommonBundle\Entity\User',
//        ));
//    }
}
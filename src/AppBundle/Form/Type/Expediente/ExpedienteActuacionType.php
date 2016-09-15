<?php

namespace AppBundle\Form\Type\Expediente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class ExpedienteActuacionType extends AbstractType
{
    protected $em;
    protected $estudioid;
    
    public function ExpedienteActuacionType (EntityManager $em) {
         $this->setEm($em);
     } 
    public function setEm($em){
        $this->em = $em;
    }
    public function setEstudioId($estudioid){
        $this->estudioid = $estudioid;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechayhora','date',array('required'=> false,'label'=>'Fecha (hay que poner datepicker)','format' => 'd-M-y','widget'=>'text'))
            ->add('descripcion','textarea',array('attr' => array('rows'=>10), 'required'=> true,'label'=>'Observaciones','max_length'=> '64000','mapped'=>true))
            ->add('fojas','text', array('required'=> false,'label' => 'Fojas', 'max_length'=> '15'))
            //HAccer referencias a los diferentes elementos de las actuaciones
//            ->add('entidad', EntityType::class, array(
//                'class' => 'AppBundle:Entidad',
//                'choices' => $options['entidades'],
//                'choice_label' => 'nombre',
//                'label'=> 'Abogados'
//            ))
//            ->add('fechayhora', 'date', [
//                    'widget' => 'date_field',
//                    'format' => 'dd-MM-yyyy',
//                    'attr' => [
//                        'class' => 'form-control input-inline datepicker',
//                        'data-provide' => 'datepicker',
//                        'data-date-format' => 'dd-mm-yyyy'
//                    ]
//                ])
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LegalPro\Bundles\CommonBundle\Entity\ExpedienteActuacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}

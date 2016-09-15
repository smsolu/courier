<?php

namespace LegalPro\Bundles\ExpedienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use LegalPro\Bundles\CommonBundle\Entity\EntidadTipoentidad;



class AgendaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text', array('required'=> true,'label' => 'Titulo', 'max_length'=> '50'))
            ->add('detalle','textarea',array('attr' => array('rows'=>5), 'required'=> true,'label'=>'Detalle','max_length'=> '1000','mapped'=>true))
            ->add('fechainicio','date',array('required'=> true,'label'=>'Fecha de Inicio','format' => 'dd-MM-yyyy','widget'=>'text'))
//          Sin repeticiones
//            ->add('dias','text',array('required'=> false,'label'=>'dias','max_length'=> '1','mapped'=>false))
            ->add('TipoRepeticion', 'entity', array(
                    'class' => 'CommonBundle:AgendaTipoRepeticion',
                    'choice_label' => 'nombre','mapped' => true, 'label'=> 'Tipo de Repetición','required'=> true
            )) ;
        
    }             
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LegalPro\Bundles\CommonBundle\Entity\AgendaEvento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Agenda';
    }
}

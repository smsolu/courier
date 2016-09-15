<?php
namespace AppBundle\Form\Type\Expediente\Documento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpedienteDocumentoFileType extends AbstractType
{
    private $fileField;

     public function __construct($fileField = true) {
         $this->fileField = $fileField;
     } 
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion','text', array('required'=> true,'label' => 'Descripcion de la versión', 'max_length'=> '255'));
        if($this->fileField){
            $builder->add('file','file',array('required'=> false,'label'=>'Archivo'));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ExpedienteDocumentoFile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'expediente_documento_file';
    }
}
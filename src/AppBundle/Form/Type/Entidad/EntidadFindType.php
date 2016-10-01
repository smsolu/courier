<?php

namespace AppBundle\Form\Type\Entidad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntidadFindType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, array('required'=> true,'label' => 'Nombre', 'max_length'=> '100'));
        $builder->setMethod('GET');
    }             

    /**
     * Obtiene los parametros por metodo GET que son enviadas al formulario
     * Retorna un FindManager
     */
    public function getParameters(Request $request,&$queryBuilder,&$find){
        if(null != ($request->query->get('nombre'))){
            $nombre = $request->query->get('nombre');
            
            // REGLA DE NOMBRE: SI EL NOMBRE NO TIENE UN % entonces se le pone un % al final!
            if(!strpos($nombre,'%') !== false){
                $nombre = $nombre . '%';
            }
            $queryBuilder->andWhere('e.nombre like :nombre');
            $queryBuilder->setParameter("nombre",$nombre);
            $find->addFilter('','El Nombre es parecido a ' . $nombre);
        }

        return $find;
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
        return '';
    }
}

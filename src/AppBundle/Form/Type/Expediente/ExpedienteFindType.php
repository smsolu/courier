<?php

namespace LegalPro\Bundles\ExpedienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use LegalPro\Bundles\CommonBundle\Entity\Expediente;
use Symfony\Component\HttpFoundation\Request;



class ExpedienteFindType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caratula','text', array('required'=> false,'label' => 'Caratula', 'max_length'=> '255'))
            ->add('numero','number',array('required'=> false,'label'=>'Número de Expediente','max_length'=> '9'))
            ->add('anio','number',array('required'=> false,'label'=>'Año','max_length'=> '4'))
            ->add('nroincidente','number',array('required'=> false,'label'=>'Nro. de Incidente','max_length'=> '4'))
        ;
        $builder->setMethod('GET');
    }
    /**
     * Obtiene los parametros por metodo GET que son enviadas al formulario
     * Retorna un FindManager
     */
    public function getParameters(Request $request,&$queryBuilder,&$find){
        if(null != ($request->query->get('keywords'))){
            $search = $request->query->get('keywords');
            if(strpos($search,'/')!=FALSE){
                // Encontro un '/', entonces se esta mandando un expediente x/2015
                $tokens = explode("/", $search);
                if(count($tokens) >= 1){
                    $request->query->set('numero',$tokens[0]);
                }
                if(count($tokens) >= 2){
                    $request->query->set('anio',$tokens[1]);                    
                }
                if(count($tokens) >= 3){
                    $request->query->set('nroincidente',$tokens[2]);  
                }            
            }else{
                // se esta buscando una caratula por que no tiene '/'
                $request->query->set('caratula',$search);                 
            }                        
        }

        
        if(null != ($request->query->get('caratula'))){
            $caratula = $request->query->get('caratula');
            
            // REGLA DE CARATULA: SI LA CARATULA NO TIENE UN % entonces se le pone un % al final!
            if(!strpos($caratula,'%') !== false){
                $caratula = $caratula . '%';
            }
            $queryBuilder->andWhere('e.caratula like :caratula');
            $queryBuilder->setParameter("caratula",$caratula);
            $find->addFilter('','La Caratula es parecida a ' . $caratula);
        }

        if(null != ($request->query->get('numero'))){
            $numero = $request->query->get('numero');
            $queryBuilder->andWhere('e.numero = :numero');
            $queryBuilder->setParameter("numero",$numero);
            $find->addFilter('','El número sea igual a ' . $numero);     
        }

        if(null != ($request->query->get('anio'))){
            $anio = $request->query->get('anio');
            $queryBuilder->andWhere('e.anio = :anio');
            $queryBuilder->setParameter("anio",$anio);
            $find->addFilter('','El año del expediente sea igual a ' . $anio);   
        }
        if(null !=($request->query->get('nroincidente'))){
            $nroincidente = $request->query->get('nroincidente');
            $queryBuilder->andWhere('e.nroincidente = :nroincidente');
            $queryBuilder->setParameter("nroincidente",$nroincidente);
            $find->addFilter('','El número de Incidente del expediente sea igual a ' . $nroincidente);
        }
        
        
        
        
        if(count($find->getFilters()) > 0 ){
            $query = $queryBuilder->getQuery();
            $sql =$query->getSql();
            $parametros ="";
            foreach ($query->getParameters() as $param) { 
                try{
                    $name = $param->getName();
                    $value = $param->getValue();
                    $parametros .=  "{$name} = {$value}\n"; 
                }catch(\Exception $ex){
                    $parametros .= "{$name} = {_OBJETO_}\n";
                }
            }
            $find->addFilter('','[BORRAR] = > ' . $sql . " Parametros =>" . $parametros  );            
        }

        return $find;
    }
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LegalPro\Bundles\CommonBundle\Entity\Expediente',
            'csrf_protection'   => false,
            'allow_extra_fields' => true
    
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

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * Entidad
 *
 * @ORM\Table(name="expediente_camara")
 * @ORM\Entity
 */
class ExpedienteCamara extends LP_Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
 
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

     /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=false)
     */
    private $codigo;
    

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="abreviatura", type="string", length=50, nullable=false)
     */
    private $abreviatura;        
    
    
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Expediente
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get Codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
 
   /**
     * Set nombre
     *
     * @param string $nombre
     * @return Expediente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }    
    

   /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Expediente
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get Descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }    
    

    /**
     * Set Abreviatura
     *
     * @param string $abreviatura
     * @return Expediente
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get Abreviatura
     *
     * @return string 
     */
    public function getAbreviatura()
    {
        if(is_null($this->abreviatura)){
            return "";
        }else{
            return $this->abreviatura;
        }
            
    }    
    
       
    
       
/**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
  
    
    
     /**
     * Get NOMBRE COMPLETO
     *
     * @return string 
     */
    public function getNombreCompleto()
    {
        return '(' . $this->abreviatura . ') - ' . $this->nombre;
    }    
    
}

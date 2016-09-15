<?php

namespace ContabilidadBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CobroCC 
 *
 * @ORM\Table(name="cc_cobro_general")
 * @ORM\Entity
 */
class CobroGeneralCC
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
    * @var Estudio 
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estudio")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")})
    */
    private $Estudio;


    /**
    * @var Entidad 
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Entidad")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_entidad", referencedColumnName="id")})
    */
    private $Entidad;    
    

    /**
    * @var TipoCuentaContable
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoCuentaContable")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_tipocuenta", referencedColumnName="id")})
    */
    private $TipoCuentaContable;   
        
    
    /**
    * @var integer  
    * @ORM\Column(name="fechayhora", type="datetime", nullable=true )
    */
    private $fechayhora;


    /**
    * @var string  
    * @ORM\Column(name="titulo", type="string", nullable=true , length=255)
    */
    private $titulo;


    /**
    * @var string  
    * @ORM\Column(name="descripcion", type="string", nullable=true , length=255)
    */
    private $descripcion;

    /**
    * @var float
    * @ORM\Column(name="monto", type="float", nullable=false )
    */
    private $monto = '0';

        
    /**
    * @var integer  
    * @ORM\Column(name="status", type="integer", nullable=true )
    */
    private $status = '0';



//*************************GETTERS && SETTERS **********************************
    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Get Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }
    /**
     * Set Estudio
     */
    public function setEstudio($Estudio)
    {
        $this->Estudio = $Estudio;
        return $this;
    }

    public function setTipoCuentaContable(\AppBundle\Entity\TipoCuentaContable $tipoCuentaContable = null)
    {
        $this->TipoCuentaContable = $tipoCuentaContable;

        return $this;
    }

    public function getTipoCuentaContable()
    {
        return $this->TipoCuentaContable;
    }       
    
    /**
     * Get Entidad
     */
    public function getEntidad()
    {
        return $this->Entidad;
    }
    /**
     * Set Entidad
     */
    public function setEntidad($Entidad)
    {
        $this->Entidad = $Entidad;
        return $this;
    }
    
    
    /**
     * Get fechayhora
     */
    public function getFechayhora()
    {
        return $this->fechayhora;
    }
    /**
     * Set fechayhora
     */
    public function setFechayhora($fechayhora)
    {
        $this->fechayhora = $fechayhora;
        return $this;
    }


    /**
     * Get titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
    /**
     * Set titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }


    /**
     * Get descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    /**
     * Set descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get monto
     */
    public function getMonto()
    {
        return $this->monto;
    }
    /**
     * Set monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
        return $this;
    }

    

    /**
     * Get status
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    
    

//******************************************************************************
}



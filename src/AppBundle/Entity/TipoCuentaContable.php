<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * TipoCuentaContable
 *
 * @ORM\Table(name="tipo_cuentacontable")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoCuentaContableRepository")
 */
class TipoCuentaContable extends LP_Entity
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="esp", type="integer", nullable=false)
     */
    private $esp = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="egreso_ingreso", type="integer", nullable=false)
     */
    private $egresoingreso = '0';    

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=false)
     */
    private $descripcion = '';        
    
    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $Estudio;



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
     * Set id
     *
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return EntidadEmpresa
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
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
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

/**
     * Set Descripcion
     *
     * @param string $value
     */
    public function setDescripcion($value)
    {
        $this->descripcion = $value;
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
     * Set status
     *
     * @param integer $status
     * @return EntidadEmpresa
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set esp
     *
     * @param integer $esp
     * @return EntidadEmpresa
     */
    public function setEsp($esp)
    {
        $this->esp = $esp;

        return $this;
    }

    /**
     * Get esp
     *
     * @return integer 
     */
    public function getEsp()
    {
        return $this->esp;
    }

    
    /**
     * Set EgresoIngreso
     *
     * @param integer $value
     * @return EgresoIngreso
     */
    public function setEgresoIngreso($value)
    {
        $this->egresoingreso = $value;

        return $this;
    }

    /**
     * Get EgresoIngreso
     *
     * @return integer 
     */
    public function getEgresoIngreso()
    {
        return $this->egresoingreso;
    }    
    
    /**
     * Set Estudio
     *
     * @param \AppBundle\Entity\Estudio $estudio
     * @return this
     */
    public function setEstudio(\AppBundle\Entity\Estudio $estudio = null)
    {
        $this->Estudio = $estudio;

        return $this;
    }

    /**
     * Get Estudio
     *
     * @return \AppBundle\Entity\Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }
    
    public function getStrIngresoEgreso(){
        if($this->getEgresoIngreso()== 0){
            return "Egreso";
        }else{
            return "Ingreso";
        }
    }
    
    public function getImgEsp(){
        if($this->getEsp() == 0){
            return "";
        }else{
            return '<span style="color:GoldenRod" class="glyphicon glyphicon-lock"></span>';
        }
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosAdicionales
 *
 * @ORM\Table(name="dato_adicional")
 * @ORM\Entity
 */
class DatosAdicionales
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Entidad")
     * @ORM\JoinColumn(name="id_entidad", referencedColumnName="id")* 
     */
    private $Entidad;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")* 
     */
    private $Estudio;

    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")* 
     */
    private $Expediente;
  

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255, nullable=true)
     */
    private $valor;



    /**
     * @var integer
     *
     * @ORM\Column(name="esp", type="integer", nullable=true)
     */
    private $esp = '0';

     
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    
    
    
  

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
     * Set entidad
     *
     * @param Entidad
     * @return this
     */
    public function setEntidad($value)
    {
        $this->Entidad = $value;

        return $this;
    }

    /**
     * Get estudio
     *
     * @return Estudio 
     */
    public function getEntidad()
    {
        return $this->Entidad;
    }
    

    /**
     * Set expediente
     *
     * @param value
     * @return this
     */
    public function setExpediente($value)
    {
        $this->Expediente = $value;

        return $this;
    }

    /**
     * Get estudio
     *
     * @return Estudio 
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }
    
    /**
     * Set estudio
     *
     * @param Estudio $Estudio
     * @return Entidad
     */
    public function setEstudio($Estudio)
    {
        $this->Estudio = $Estudio;

        return $this;
    }

    /**
     * Get estudio
     *
     * @return Estudio 
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }

    

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Entidad
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
     * Set Valor
     *
     * @param string valor
     * @return Entidad
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    
    
    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    
    /**
     * Set esp
     *
     * @param integer $esp
     * @return Entidad
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
     * Set status
     *
     * @param integer $status
     * @return Entidad
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
    
}

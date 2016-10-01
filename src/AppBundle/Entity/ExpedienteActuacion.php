<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * ExpedienteActuacion
 *
 * @ORM\Table(name="expediente_actuacion", indexes={@ORM\Index(name="fk_expedienteactuaciones_tipoactuacion", columns={"id_tipoactuacion"}), @ORM\Index(name="fk_expedienteactuacion_usuario", columns={"id_usuario"}), @ORM\Index(name="fkexpedienteactuaciones_expediente", columns={"id_expediente"}), @ORM\Index(name="fk_expedienteactuaciones_estudio", columns={"id_estudio"})})
 * @ORM\Entity
 */
class ExpedienteActuacion extends LP_Entity
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechayhora", type="datetime", nullable=false)
     */
    private $fechayhora;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="fojas", type="string", length=20, nullable=true)
     */
    private $fojas;
    
    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default" = 0})
     */
    private $status = '0';


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
     * @var \ActuacionTipoactuacion
     *
     * @ORM\ManyToOne(targetEntity="ActuacionTipoactuacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipoactuacion", referencedColumnName="id")
     * })
     */
    private $Tipoactuacion;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $Expediente;

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
     * Set fechayhora
     *
     * @param \DateTime $fechayhora
     * @return DocumentoVersion
     */
    public function setFechayhora($fechayhora)
    {
        $this->fechayhora = $fechayhora;

        return $this;
    }

    /**
     * Get fechayhora
     *
     * @return \DateTime 
     */
    public function getFechayhora()
    {
        return $this->fechayhora;
    }

    
/**
     * Set fojas
     *
     * @param string $fojas
     * @return this
     */
    public function setFojas($fojas)
    {
        $this->fojas = $fojas;

        return $this;
    }

    /**
     * Get fojas
     *
     * @return string 
     */
    public function getFojas()
    {
        return $this->fojas;
    }    
    
    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DocumentoVersion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
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
     * @param boolean $status
     * @return DocumentoVersion
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    
    /**
     * Set idEstudio
     *
     * @param \AppBundle\Entity\Estudio $Estudio
     * @return DocumentoVersion
     */
    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

        return $this;
    }

    /**
     * Get idEstudio
     *
     * @return \AppBundle\Entity\Estudio 
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }

    /**
     * Set Tipoactuacion
     *
     * @param \AppBundle\Entity\ActuacionTipoactuacion $Tipoactuacion
     * @return DocumentoVersion
     */
    public function setTipoactuacion(\AppBundle\Entity\ActuacionTipoactuacion $Tipoactuacion = null)
    {
        $this->Tipoactuacion = $Tipoactuacion;

        return $this;
    }

    /**
     * Get idTipoactuacion
     *
     * @return \AppBundle\Entity\ActuacionTipoactuacion 
     */
    public function getTipoactuacion()
    {
        return $this->Tipoactuacion;
    }

    /**
     * Set idExpediente
     *
     * @param \AppBundle\Entity\Expediente $idExpediente
     * @return DocumentoVersion
     */
    public function setExpediente(\AppBundle\Entity\Expediente $Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }

    /**
     * Get idExpediente
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }

    /**
     * Get id Expediente
     *
     * @return id
     */
    public function getExpedienteId()
    {
        return $this->getExpediente()->getId();
    }
}
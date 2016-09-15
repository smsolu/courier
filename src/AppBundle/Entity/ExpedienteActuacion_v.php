<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * ExpedienteActuacion_v
 *
 * @ORM\Table(name="actuacion_v")
 * @ORM\Entity
 */
class ExpedienteActuacion_v extends LP_Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ExpedienteDocumento
     *
     * @ORM\ManyToOne(targetEntity="ExpedienteDocumento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_documento", referencedColumnName="id")
     * })
     */
    private $Documento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechayhora", type="datetime", nullable=false)
     */
    private $fechayhora;



     /**
     * @var string
     *
     * @ORM\Column(name="tipo_actuacion_nombre", type="string", length=255, nullable=true)
     */
    private $tipoactuacionnombre;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable_nombre", type="string", length=255, nullable=true)
     */
    private $responsablenombre;

    /**
     * @var string
     *
     * @ORM\Column(name="interviniente_nombre", type="string", length=255, nullable=true)
     */
    private $intervinientenombre;    

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;      
    /**
     * @var string
     *
     * @ORM\Column(name="fojas", type="string", length=255, nullable=true)
     */
    private $fojas;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="documento_nombre", type="string", length=255, nullable=true)
     */
    private $documentonombre;    
    
    
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
     * Set idDocumento
     *
     * @param \AppBundle\Entity\ExpedienteDocumento $Documento
     * @return \AppBundle\Entity\ExpedienteDocumento
     */
    public function setDocumento(\AppBundle\Entity\ExpedienteDocumento $Documento)
    {
        $this->Documento = $Documento;

        return $this;
    }

    /**
     * Get Documento
     *
     * @return \AppBundle\Entity\ExpedienteDocumento 
     */
    public function getDocumento()
    {
        return $this->Documento;
    }

    /**
     * Set fechayhora
     *
     * @param \DateTime $fechayhora
     * @return ExpedienteActuacion
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
     * Get DocumentoNombre
     *
     * @return string 
     */
    public function getDocumentonombre()
    {
        return $this->documentonombre;
    }
    /**
     * Get ResponsableNombre
     *
     * @return string 
     */
    public function getResponsableNombre()
    {
        return $this->responsablenombre;
    }
    /**
     * Get EntidadNombre
     *
     * @return string 
     */
    public function getIntervinienteNombre()
    {
        return $this->intervinientenombre;
    }
    /**
     * Get EntidadNombre
     *
     * @return string 
     */
    public function getFojas()
    {
        return $this->fojas;
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
     * Get TipoActuacionNombre
     *
     * @return string 
     */
    public function getTipoActuacionNombre()
    {
        return $this->tipoactuacionnombre;
    }

    
    /**
     * Set status
     *
     * @param boolean $status
     * @return ExpedienteActuacion
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
     * @return ExpedienteActuacion
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
     * Set idTipoactuacion
     *
     * @param \AppBundle\Entity\ActuacionTipoactuacion $Tipoactuacion
     * @return ExpedienteActuacion
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
     * @return ExpedienteActuacion
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
     * Get idExpediente
     *
     * @return integer
     */
    public function getExpedienteId()
    {
        if($this->Expediente){
            return $this->Expediente->getId();
        }else{
            return -1;
        }
    }
    
}

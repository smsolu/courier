<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * ExpedienteIntervinientes
 *
 * @ORM\Table(name="expediente_entidad", indexes={@ORM\Index(name="fk_expedienteabogado_expediente", columns={"id_expediente"}), @ORM\Index(name="fk_expedienteabogado_entidad", columns={"id_entidad"})})
 * @ORM\Entity
 */
class ExpedienteEntidad extends LP_Entity
{
    const RESPONSABLE_NO_RESPONSABLE = 0;
    const RESPONSABLE_RESPONSABLE = 1;
    // Propiedades virtuales para agregar en el combo
    private $intervinientenombre = "";
    private $entidadid = -1;
    
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
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status = '0';

    /**
     * @var \Entidad
     *
     * @ORM\ManyToOne(targetEntity="Entidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_entidad", referencedColumnName="id")
     * })
     */
    private $Entidad;

    
//    /**
//     * @var \Caracter
//     *
//     * @ORM\ManyToOne(targetEntity="CaracterInterviniente")
//     * @ORM\JoinColumns({
//     *   @ORM\JoinColumn(name="id_caracter", referencedColumnName="id")
//     * })
//     */
//    private $Caracter;
    
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
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $Estudio;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="responsable", type="boolean", nullable=false)
     */
    private $responsable = 0;
   
    
    

    
    
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
     * Set Estudio
     *
     * @param \AppBundle\Entity\Entidad $Entidad
     * @return Entidad
     */
    public function setEntidad(\AppBundle\Entity\Entidad $Entidad = null)
    {
        $this->Entidad = $Entidad;

        return $this;
    }

    /**
     * Get Entidad
     *
     * @return \AppBundle\Entity\Entidad 
     */
    public function getEntidad()
    {
        return $this->Entidad;
    }
    
    
    
    /**
     * Set idEstudio
     *
     * @param \AppBundle\Entity\Estudio $Estudio
     * @return ExpedienteINterviniente
     */
    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

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
    
    /**
     * Set Expediente
     *
     * @param \AppBundle\Entity\Expediente $Expediente
     * @return ExpedienteINterviniente
     */
    public function setExpediente(\AppBundle\Entity\Expediente $Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }

    /**
     * Get Expediente
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->Expediente;
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


    

    public function getExpedienteNumeroCompleto()
    {
        if($this->Expediente!=null){
            return $this->Expediente->getNumeroCompleto();
        }else{
            return "";
        }
    }
    
    public function getExpedienteCaratula()
    {
        if($this->Expediente!=null){
            return $this->Expediente->getCaratula();
        }else{
            return "";
        }
    }
    
    /**
     * Get intervinientenombre
     *
     * @return string 
     */  
    public function getIntervinientenombre(){
        if($this->getEntidad() != null){
            return $this->getEntidad()->getNombre();
        }else{
            return $this->intervinientenombre;
        }
    }
    
    public function setIntervinientenombre($value){
        $this->intervinientenombre = $value;
        return $this;
    }      

    public function getEntidadid(){
        if($this->getEntidad() != null){
            return $this->getEntidad()->getId();
        }else{
            return $this->entidadid;
        }
    }    
    public function setEntidadid($value){
        $this->entidadid = $value;
        return $this;
    }   
    
    
    public function getExpedienteId(){
        if($this->getExpediente() != null){
            return $this->getExpediente()->getId();
        }else{
            return -1;
        }
    }
    
    function getResponsable() {
        return $this->responsable;
    }

    function setResponsable($responsable) {
        $this->responsable = $responsable;
        return $this;
    }
    
}

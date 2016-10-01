<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Estudio;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteActuacion;
use AppBundle\Entity\LP_Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ExpedienteVinculado
 *
 * @ORM\Table(name="expediente_vinculado")
 * @ORM\Entity
 */
class ExpedienteVinculado extends LP_Entity
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
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $Expediente;
    
    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp_vinculado", referencedColumnName="id")
     * })
     */
    private $ExpedienteVinculado;    
    
    /**
     * @var \TipoVinculacion
     *
     * @ORM\ManyToOne(targetEntity="TipoVinculacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_vinculacion", referencedColumnName="id")
     * })
     */
    private $TipoVinculacion;       
    
     /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $Estudio;

    

    public function getId()
    {
        return $this->id;
    }
    
    

    public function setEstudio($Estudio = null)
    {
        $this->Estudio = $Estudio;

        return $this;
    }


    public function getEstudio()
    {
        return $this->Estudio;
    }
    

    public function setExpediente($Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }


    public function getExpediente()
    {
        return $this->Expediente;
    }


    public function setExpedienteVinculado($Expediente = null)
    {
        $this->ExpedienteVinculado = $Expediente;

        return $this;
    }


    public function getExpedienteVinculado()
    {
        return $this->ExpedienteVinculado;
    }
    
    
    
    
    

    public function setTipoVinculacion(TipoVinculacion $vinculacion = null)
    {
        $this->TipoVinculacion = $vinculacion;

        return $this;
    }


    public function getTipoVinculacion()
    {
        return $this->TipoVinculacion;
    }
    
    
    

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    public function getStatus()
    {
        return $this->status;
    }
    

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }


    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getExpedienteOrigenNumeroCompleto()
    {
        if($this->Expediente!=null){
            return $this->Expediente->getNumeroCompleto();
        }else{
            return "";
        }
    }
    
    public function getExpedienteOrigenCaratula()
    {
        if($this->Expediente!=null){
            return $this->Expediente->getCaratula();
        }else{
            return "";
        }
    }
    
    
    public function getExpedienteVinculadoNumeroCompleto()
    {
        if($this->ExpedienteVinculado!=null){
            return $this->ExpedienteVinculado->getNumeroCompleto();
        }else{
            return "";
        }
    }
    
    public function getExpedienteVinculadoCaratula()
    {
        if($this->ExpedienteVinculado!=null){
            return $this->ExpedienteVinculado->getCaratula();
        }else{
            return "";
        }
    }
    
    public function getExpedienteVinculadoId()
    {
        if($this->ExpedienteVinculado!=null){
            return $this->ExpedienteVinculado->getId();
        }else{
            return "-1";
        }
    }
    
    public function getExpedienteId()
    {
        if($this->Expediente!=null){
            return $this->Expediente->getId();
        }else{
            return "-1";
        }
    }
    
    
    public function getTipoVinculacionNombre()
    {
        if($this->getTipoVinculacion()!=null){
            return $this->getTipoVinculacion()->getNombre();
        }else{
            return "";
        }
    }
}

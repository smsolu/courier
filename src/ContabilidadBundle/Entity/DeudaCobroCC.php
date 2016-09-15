<?php

namespace ContabilidadBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ccdeudacobro 
 *
 * @ORM\Table(name="cc_deuda_cobro")
 * @ORM\Entity
 */
class DeudaCobroCC
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
    * @var Expediente 
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Expediente")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")})
    */
    private $Expediente;


    /**
    * @var CobroCC
    * @ORM\ManyToOne(targetEntity="CobroCC")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_cobrocc", referencedColumnName="id")})
    */
    private $Cobro;

    /**
    * @var DeudaCC
    * @ORM\ManyToOne(targetEntity="DeudaCC")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_deudacc", referencedColumnName="id")})
    */
    private $Deuda;
    
    /**
    * @var datetime  
    * @ORM\Column(name="fechayhora", type="datetime", nullable=false )
    */
    private $fechayhora;    

    /**
    * @var float  
    * @ORM\Column(name="monto_asignado", type="float", nullable=false )
    */
    private $montoasignado = '0';

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
     * Get Expediente
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }
    /**
     * Set Expediente
     */
    public function setExpediente($Expediente)
    {
        $this->Expediente = $Expediente;
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


    /**
     * Get DeudaCC
     */
    public function getDeuda()
    {
        return $this->Deuda;
    }
    /**
     * Set DeudaCC
     */
    public function setDeuda($deuda)
    {
        $this->Deuda = $deuda;
        return $this;
    }


    /**
     * Get CobroCC
     */
    public function getCobro()
    {
        return $this->Cobro;
    }
    /**
     * Set idcobro
     */
    public function setCobro($cobro)
    {
        $this->Cobro = $cobro;
        return $this;
    }


    /**
     * Get montoasignado
     */
    public function getMontoasignado()
    {
        return $this->montoasignado;
    }
    /**
     * Set montoasignado
     */
    public function setMontoasignado($montoasignado)
    {
        $this->montoasignado = $montoasignado;
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



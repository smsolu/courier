<?php

namespace ContabilidadBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ccsaldo 
 *
 * @ORM\Table(name="cc_expediente_saldo")
 * @ORM\Entity
 */
class SaldoExpedienteCC
{
    
    /**
    * @var integer  
    * @ORM\Column(name="id", type="integer", nullable=false )
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
    * @var float  
    * @ORM\Column(name="saldo", type="float", nullable=true )
    */
    private $saldo = '0';


    /**
    * @var float  
    * @ORM\Column(name="cc_max", type="float", nullable=true )
    */
    private $ccmax = '0';


    /**
    * @var integer  
    * @ORM\Column(name="permitecc", type="integer", nullable=false)
    */
    private $permitecc = '1';    
    
    /**
    * @var integer  
    * @ORM\Column(name="mpa", type="float", nullable=true )
    */
    private $mpa = '0';

    /**
    * @var integer  
    * @ORM\Column(name="status", type="integer", nullable=false )
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
     * Get PermiteCC
     */
    public function getPermiteCC()
    {
        return $this->permitecc;
    }
    /**
     * Set PermiteCC
     */
    public function setPermiteCC($permitecc)
    {
        $this->permitecc = $permitecc;
        return $this;
    }
    /**
     * Get saldo
     */
    public function getSaldoCC()
    {
        return $this->saldo;
    }
    /**
     * Set saldo
     */
    public function setSaldoCC($saldo)
    {
        $this->saldo = $saldo;
        return $this;
    }


    /**
     * Get ccmax
     */
    public function getCCMax()
    {
        return $this->ccmax;
    }
    /**
     * Set ccmax
     */
    public function setCCMax($ccmax)
    {
        $this->ccmax = $ccmax;
        return $this;
    }


    /**
     * Get mpa
     */
    public function getMpa()
    {
        return $this->mpa;
    }
    /**
     * Set mpa
     */
    public function setMpa($mpa)
    {
        $this->mpa = $mpa;
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




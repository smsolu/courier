<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * Entidad
 *
 * @ORM\Table(name="expediente_v")
 * @ORM\Entity
 */
class Expediente_v extends LP_Entity
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
     * @var string
     *
     * @ORM\Column(name="identificador", type="string", length=255, nullable=false)
     */
    private $identificador;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    private $anio;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nroincidente", type="integer", nullable=true)
     */
    private $nroincidente;    

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=false)
     */
    private $codigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="caratula", type="string", length=255, nullable=false)
     */
    private $caratula;

    
    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $idEstudio;

    
    /**
     * @var \ExpedienteCamara
     *
     * @ORM\ManyToOne(targetEntity="ExpedienteCamara")
     * 
     * @ORM\JoinColumn(name="id_expediente_camara", referencedColumnName="id")
     * 
     */
    private $expedienteCamara;
    
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status;    
    

    
    /**
     * Set numero
     *
     * @param integer $numero
     * @return Expediente
     */
    public function setNumero($numero)
    {
        $this->numero= $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }    
    
    
    
    
    
    
   /**
     * Set anio
     *
     * @param integer $anio
     * @return Expediente
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer 
     */
    public function getAnio()
    {
        return $this->anio;
    }    

/**
     * Set Codigo
     *
     * @param string $codigo
     * @return this
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
     * Set caratula
     *
     * @param string $caratula
     * @return Expediente
     */
    public function setCaratula($caratula)
    {
        $this->caratula = $caratula;

        return $this;
    }

    /**
     * Get caratula
     *
     * @return string 
     */
    public function getCaratula()
    {
        return $this->getNumeroCompleto() . " " . $this->caratula;
    }
    /**
     * Set identificador
     *
     * @param string $identificador
     * @return Expediente
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string 
     */
    public function getIdentificador()
    {
        return "{" . $this->getId() ."}"; // Para pruebas!
        // return $this->identificador;
    }
    
    /**
     * Set idEstudio
     *
     * @param \LegalPro\Bundles\CommonBundle\Entity\Estudio $idEstudio
     * @return Expediente
     */
    public function setIdEstudio(\LegalPro\Bundles\CommonBundle\Entity\Estudio $idEstudio = null)
    {
        $this->idEstudio = $idEstudio;

        return $this;
    }

    /**
     * Get idEstudio
     *
     * @return \LegalPro\Bundles\CommonBundle\Entity\Estudio
     */
    public function getIdEstudio()
    {
        return $this->idEstudio;
    }

    
/**
     * Set setIdExpedienteCamara
     *
     * @param \LegalPro\Bundles\CommonBundle\Entity\ExpedienteCamara $camara
     * @return Expediente
     */
    public function setExpedienteCamara(\LegalPro\Bundles\CommonBundle\Entity\ExpedienteCamara $camara = null)
    {
        $this->expedienteCamara = $camara;

        return $this;
    }

    /**
     * Get getIdExpedienteCamara
     *
     * @return \LegalPro\Bundles\CommonBundle\Entity\ExpedienteCamara
     */
    public function getExpedienteCamara()
    {
        return $this->expedienteCamara;
    }    
    
    
    
    
    /**
     * Set status
     *
     * @param boolean $status
     * @return Expediente
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
     * Set incidente
     *
     * @param boolean $status
     * @return Expediente
     */
    public function setNroincidente($nroincidente)
    {
        $this->nroincidente = $nroincidente;

        return $this;
    }

    /**
     * Get incidente
     *
     * @return integer 
     */
    public function getNroincidente()
    {
        return $this->nroincidente;
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
    
    public function getCamaraNombre(){
//        if($$this->expedienteCamara){
            return $this->expedienteCamara->getNombre();
//        }else{
//            return "";
//        }
    }
    public function getNumeroyAnio(){
        if ($this->nroincidente > 0){
            return $this->numero . '/' . $this->anio . '/' . $this->nroincidente;
        }else{
            return $this->numero . '/' . $this->anio;
        }
    }
    
    public function getNumeroyCaratula(){
        return $this->getNumeroyAnio() . ' - ' . $this->caratula;
    }
    
    public function getNumeroCompleto(){
        if(is_null($this->getExpedienteCamara()->getAbreviatura())){
            $camara = "";
        }else{
            $camara = '(' . $this->getExpedienteCamara()->getAbreviatura() . ') ';
        }
        
        return $camara . $this->getNumeroyAnio();
    }
    
}

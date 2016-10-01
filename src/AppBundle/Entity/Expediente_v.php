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
    

    

    public function setNumero($numero)
    {
        $this->numero= $numero;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }    
    
    
    
    
    

    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    public function getAnio()
    {
        return $this->anio;
    }    

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }    
    
    public function setCaratula($caratula)
    {
        $this->caratula = $caratula;

        return $this;
    }

    public function getCaratula()
    {
        return $this->getNumeroCompleto() . " " . $this->caratula;
    }

    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    public function getIdentificador()
    {
        return "{" . $this->getId() ."}"; // Para pruebas!
        // return $this->identificador;
    }
    
    public function setIdEstudio(\LegalPro\Bundles\CommonBundle\Entity\Estudio $idEstudio = null)
    {
        $this->idEstudio = $idEstudio;

        return $this;
    }

    public function getIdEstudio()
    {
        return $this->idEstudio;
    }

    
    public function setExpedienteCamara(\LegalPro\Bundles\CommonBundle\Entity\ExpedienteCamara $camara = null)
    {
        $this->expedienteCamara = $camara;

        return $this;
    }

    public function getExpedienteCamara()
    {
        return $this->expedienteCamara;
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
    
    public function setNroincidente($nroincidente)
    {
        $this->nroincidente = $nroincidente;

        return $this;
    }

    public function getNroincidente()
    {
        return $this->nroincidente;
    }
    
    
    
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

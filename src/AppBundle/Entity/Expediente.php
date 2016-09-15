<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use AppBundle\Entity\LP_Entity;

/**
 * Entidad
 *
 * @ORM\Table(name="expediente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpedienteRepository")
 * @Assert\Callback(methods={"Validate"})
 * @UniqueEntity(
 *     fields={"numero", "anio","expedienteCamara","nroincidente","Estudio","status"},
 *     errorPath="",
 *     message="Este expediente ya existe"
 * )
 */
class Expediente extends LP_Entity
{
//   const STATUS_NO_DELETED = 0;
//   const STATUS_DELETED = -1;
   
    public function __construct()
    {
        $this->UsuariosFavoritos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intervinientes = new \Doctrine\Common\Collections\ArrayCollection();
    }    
    
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
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    private $anio = 0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nroincidente", type="integer", nullable=true)
     */
    private $nroincidente = 0;    

    /**
     * @var date
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=true)
     */
    private $fechainicio;
    
    /**
     * @var string
     *
     * @ORM\Column(name="caratula", type="string", length=255, nullable=false, options={"default":""})
     */
    private $caratula = '';

    
    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $Estudio = null;

    
    /**
     * @var \ExpedienteCamara
     *
     * @ORM\ManyToOne(targetEntity="ExpedienteCamara")
     * 
     * @ORM\JoinColumn(name="id_expediente_camara", referencedColumnName="id")
     * 
     */
    private $expedienteCamara = null;
    
    /**
     * @var \AbogadoPrincipal
     *
     * @ORM\ManyToOne(targetEntity="Entidad")
     * 
     * @ORM\JoinColumn(name="id_abogadoprincipal", referencedColumnName="id")
     * 
     */
    private $AbogadoPrincipal = null;    
    
    /**
     * @var \ClientePrincipal
     *
     * @ORM\ManyToOne(targetEntity="Entidad")
     * 
     * @ORM\JoinColumn(name="id_clienteprincipal", referencedColumnName="id")
     * 
     */
    private $ClientePrincipal;    
    
    /**
     * @var \Naturaleza
     *
     * @ORM\ManyToOne(targetEntity="ExpedienteNaturaleza")
     * 
     * @ORM\JoinColumn(name="id_naturaleza", referencedColumnName="id")
     * 
     */
    private $Naturaleza = null;    

   /**
     * @var \TipoProceso
     *
     * @ORM\ManyToOne(targetEntity="TipoProceso")
     * 
     * @ORM\JoinColumn(name="id_tipoproceso", referencedColumnName="id")
     * 
     */
    private $TipoProceso = null;     
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status = self::STATUS_NO_DELETED;    
    

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="usuario_expediente",
     *      joinColumns={@ORM\JoinColumn(name="id_expediente", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_usuario", referencedColumnName="id", unique=false)}
     *      )
     */
    private $UsuariosFavoritos;    
    
    /**
     * @ORM\OneToMany(targetEntity="ExpedienteInterviniente", mappedBy="Expediente")
     */
    private $intervinientes;
    
    
    /**
     * Set numero
     *
     * @param integer $numero
     * @return this
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
    

    public function setFechaInicio($value)
    {
        $this->fechainicio = $value;

        return $this;
    }

    public function getFechaInicio()
    {
        return $this->fechainicio;
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
        return $this->caratula;
    }
    
    
  /**
     * Set ClientePrincipal
     *
     * @param Entidad ClientePrincipal
     * @return this
     */
    public function setClientePrincipal(Entidad $clientePrincipal = null)
    {
        $this->ClientePrincipal = $clientePrincipal;

        return $this;
    }

    /**
     * Get getClientePrincipal
     *
     * @return Entidad
     */
    public function getClientePrincipal()
    {
        return $this->ClientePrincipal;
    }       
    
    
    /**
     * Set AbogadoPrincipal
     *
     * @param Entidad AbogadoPrincipal
     * @return this
     */
    public function setAbogadoPrincipal(Entidad $abogadoPrincipal = null)
    {
        $this->AbogadoPrincipal = $abogadoPrincipal;

        return $this;
    }

    /**
     * Get getAbogadoPrincipal
     *
     * @return Entidad
     */
    public function getAbogadoPrincipal()
    {
        return $this->AbogadoPrincipal;
    }    
    
    
    /**
     * Set idEstudio
     *
     * @param Estudio $idEstudio
     * @return Expediente
     */
    public function setEstudio(Estudio $idEstudio = null)
    {
        $this->Estudio = $idEstudio;

        return $this;
    }

    /**
     * Get idEstudio
     *
     * @return Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }

    
    /**
     * Set TipoProceso
     *
     * @param TipoProceso $value
     * @return this
     */
    public function setTipoProceso(TipoProceso $value = null)
    {
        $this->TipoProceso = $value;

        return $this;
    }

    /**
     * Get getNaturaleza
     *
     * @return 
     */
    public function getTipoProceso()
    {
        return $this->TipoProceso;
    }    
    
    /**
     * Set Naturaleza
     *
     * @param ExpedienteCamara $naturaleza
     * @return Naturaleza
     */
    public function setNaturaleza(ExpedienteNaturaleza $naturaleza = null)
    {
        $this->Naturaleza = $naturaleza;

        return $this;
    }

    /**
     * Get getNaturaleza
     *
     * @return 
     */
    public function getNaturaleza()
    {
        return $this->Naturaleza;
    }    
    
    
    /**
     * Set setIdExpedienteCamara
     *
     * @param ExpedienteCamara $camara
     * @return Expediente
     */
    public function setExpedienteCamara(ExpedienteCamara $camara = null)
    {
        $this->expedienteCamara = $camara;

        return $this;
    }

    /**
     * Get getIdExpedienteCamara
     *
     * @return ExpedienteCamara
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
        return $this->getNumeroyAnio() . ' - ' . $this->getCaratula();
    }
    
    public function getNumeroyCaratulaCompleto(){
        return $this->getNumeroCompleto() . ' - ' . $this->getCaratula();
    }

    public function getNumeroyCaratulaMini(){
        $numeroycaratula = $this->getNumeroCompleto() . ' - ' . $this->getCaratula();
        if(strlen($numeroycaratula)> 100){
            $numeroycaratula = substr($numeroycaratula,0,100) . "...";
        }
        return $numeroycaratula;
    }
    
    public function getNumeroCompleto(){
        if(is_null($this->getExpedienteCamara()->getAbreviatura())){
            $camara = "";
        }else{
            $camara = '(' . $this->getExpedienteCamara()->getAbreviatura() . ') ';
        }
        
    return "{" . $this->getId() . "} - " . $camara . $this->getNumeroyAnio();
    }
    
    /*
     * Validar la entidad
     */
    public function Validate(ExecutionContextInterface $context)
    {
        
        
        //$context->addViolationAt('numero', 'El número esta repetido');
    }    
    

   
    public function isUsuarioFavorito($usuario){
        return $this->UsuariosFavoritos->contains($usuario);
    }
    
    function getUsuariosFavoritos() {
        return $this->UsuariosFavoritos;
    }


    function setUsuariosFavoritos($UsuariosFavoritos) {
        $this->UsuariosFavoritos = $UsuariosFavoritos;
    }
    
    public function getIntervinientes(){
        return $this->intervinientes;
    }

}

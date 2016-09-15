<?php
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThan;
namespace ContabilidadBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CobroCC 
 *
 * @ORM\Table(name="cc_cobro")
 * @ORM\Entity
 */
class CobroCC
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
    * @var CobroGeneralCC
    * @ORM\ManyToOne(targetEntity="CobroGeneralCC")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_cobro_general", referencedColumnName="id")})
    */
    private $CobroGeneralCC;    
    
    /**
    * @var TipoCuentaContable
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoCuentaContable")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_tipocuenta", referencedColumnName="id")})
    */
    private $TipoCuentaContable;   
    
    
    /**
    * @var integer  
    * @ORM\Column(name="fechayhora", type="datetime", nullable=true )
    */
    private $fechayhora;


    /**
    * @var string  
    * @ORM\Column(name="titulo", type="string", nullable=true , length=255)
    */
    private $titulo;


    /**
    * @var string  
    * @ORM\Column(name="descripcion", type="string", nullable=true , length=255)
    */
    private $descripcion;


    /**
    * @var integer  
    * @ORM\Column(name="contabilizar", type="integer", nullable=true )
    */
    private $contabilizar = '0';


    /**
    * @var float
    * @ORM\Column(name="monto_cobro", type="float", nullable=false )
    */
    private $montocobro = '0';

    /**
    * @var float
    * @ORM\Column(name="monto_restante", type="float", nullable=false )
    */
    private $montorestante = '0';
    
    /**
    * @var float
    * @ORM\Column(name="monto_asignado", type="float", nullable=false )
    */
    private $montoasignado = '0';    

    /**
    * @var integer  
    * @ORM\Column(name="cancelado", type="integer", nullable=false )
    */
    private $cancelado = '0';    

    
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

    public function setTipoCuentaContable(\AppBundle\Entity\TipoCuentaContable $tipoCuentaContable = null)
    {
        $this->TipoCuentaContable = $tipoCuentaContable;

        return $this;
    }

    public function getTipoCuentaContable()
    {
        return $this->TipoCuentaContable;
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
     * Get titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
    /**
     * Set titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }


    /**
     * Get descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    /**
     * Set descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }


    /**
     * Get CobroGeneralCC
     */
    public function getCobroGeneralCC()
    {
        return $this->CobroGeneralCC;
    }
    /**
     * Set CobroGeneralCC
     */
    public function setCobroGeneralCC($cobroGeneralCC)
    {
        $this->CobroGeneralCC = $cobroGeneralCC;
        return $this;
    }
    
    /**
     * Get contabilizar
     */
    public function getContabilizar()
    {
        return $this->contabilizar;
    }
    /**
     * Set contabilizar
     */
    public function setContabilizar($contabilizar)
    {
        $this->contabilizar = $contabilizar;
        return $this;
    }


    /**
     * Get montocobro
     */
    public function getMontoCobro()
    {
        return $this->montocobro;
    }
    /**
     * Set montocobro
     */
    public function setMontoCobro($monto)
    {
        $this->montocobro = $monto;
        return $this;
    }

    /**
     * Get cancelado
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }
    /**
     * Set cancelado
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
        return $this;
    }      
    
    
    /**
     * Get montorestante
     */
    public function getMontoRestante()
    {
        return $this->montorestante;
    }
    /**
     * Set montorestante
     */
    public function setMontoRestante($monto)
    {
        $this->montorestante = $monto;

        //Manejar el cancelado
        if($this->montorestante == 0 && $this->cancelado == 0){
            $this->cancelado = 1;
        }elseif($this->montorestante > 0 && $this->cancelado == 1){
            $this->cancelado = 0;
        }
        
        return $this;
    }    
    
    /**
     * Get montoasignado
     */
    public function getMontoAsignado()
    {
        return $this->montoasignado;
    }
    /**
     * Set montoasignado
     */
    public function setMontoAsignado($monto)
    {
        $this->montoasignado = $monto;
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



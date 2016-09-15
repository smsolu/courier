<?php

namespace ContabilidadBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ccdeudacliente 
 *
 * @ORM\Table(name="cc_deuda")
 * @ORM\Entity
 */
class DeudaCC
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
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
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
    * @var TipoCuentaContable
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoCuentaContable")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_tipocuenta", referencedColumnName="id")})
    */
    private $TipoCuentaContable;   
        
    
    /**
    * @var integer
    * @ORM\Column(name="id_deuda_repetitiva", type="integer", nullable=true )
    */
    private $iddeudarepetitiva;


    /**
    * @var datetime  
    * @ORM\Column(name="fechayhora", type="datetime", nullable=false )
    */
    private $fechayhora;

    /**
    * @var datetime  
    * @ORM\Column(name="fecha_cancelacion", type="datetime", nullable=false )
    */
    private $fechacancelacion;

    /**
    * @var datetime  
    * @ORM\Column(name="fechayhora_vencimiento", type="datetime", nullable=true )
    */
    private $fechayhoravencimiento;


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
    * @ORM\Column(name="contabilizar", type="integer", nullable=false )
    */
    private $contabilizar = '1';


    /**
    * @var float  
    * @ORM\Column(name="monto_deuda", type="float", nullable=false )
    */
    private $montodeuda = '0';


    /**
    * @var float  
    * @ORM\Column(name="monto_cobrado", type="float", nullable=false )
    */
    private $montocobrado = '0';


    /**
    * @var float  
    * @ORM\Column(name="monto_restante", type="float", nullable=false )
    */
    private $montorestante = '0';


    /**
    * @var integer  
    * @ORM\Column(name="cancelado", type="integer", nullable=false )
    */
    private $cancelado = '0';


    /**
    * @var integer  
    * @ORM\Column(name="admite_vencimiento", type="integer", nullable=false )
    */
    private $admitevencimiento = '0';


    /**
    * @var integer  
    * @ORM\Column(name="admite_punitorios", type="integer", nullable=false )
    */
    private $admitepunitorios = '0';

    
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


    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

        return $this;
    }

    public function getEstudio()
    {
        return $this->Estudio;
    }


    /**
     * Get expediente
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }
    /**
     * Set expediente
     */
    public function setExpediente($expediente)
    {
        $this->Expediente = $expediente;
        return $this;
    }


    /**
     * Get iddeudarepetitiva
     */
    public function getIdDeudaRepetitiva()
    {
        return $this->iddeudarepetitiva;
    }
    /**
     * Set iddeudarepetitiva
     */
    public function setIdDeudaRepetitiva($iddeudarepetitiva)
    {
        $this->iddeudarepetitiva = $iddeudarepetitiva;
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
     * Get fechayhoravencimiento
     */
    public function getFechayhoravencimiento()
    {
        return $this->fechayhoravencimiento;
    }
    /**
     * Set fechayhoravencimiento
     */
    public function setFechayhoravencimiento($fechayhoravencimiento)
    {
        $this->fechayhoravencimiento = $fechayhoravencimiento;
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
     * Get montodeuda
     */
    public function getMontoDeuda()
    {
        return $this->montodeuda;
    }
    /**
     * Set montodeuda
     */
    public function setMontoDeuda($montodeuda)
    {
        $this->montodeuda = $montodeuda;
        return $this;
    }


    /**
     * Get montocobrado
     */
    public function getMontoCobrado()
    {
        return $this->montocobrado;
    }
    /**
     * Set montocobrado
     */
    public function setMontoCobrado($montocobrado)
    {
        $this->montocobrado = $montocobrado;
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
    public function setMontoRestante($montorestante)
    {
        $this->montorestante = $montorestante;
        
        //Manejar el cancelado
        if($this->montorestante == 0 && $this->cancelado == 0){
            $this->cancelado = 1;
        }elseif($this->montorestante > 0 && $this->cancelado == 1){
            $this->cancelado = 0;
        }
        
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
     * Get fechacancelacion
     */
    public function getFechaCancelacion()
    {
        return $this->fechacancelacion;
    }
    /**
     * Set fechacancelacion
     */
    public function setFechaCancelacion($fechacancelacion)
    {
        $this->fechacancelacion= $fechacancelacion;
        return $this;
    }    


    /**
     * Get admitevencimiento
     */
    public function getAdmitevencimiento()
    {
        return $this->admitevencimiento;
    }
    /**
     * Set admitevencimiento
     */
    public function setAdmitevencimiento($admitevencimiento)
    {
        $this->admitevencimiento = $admitevencimiento;
        return $this;
    }


    /**
     * Get admitepunitorios
     */
    public function getAdmitepunitorios()
    {
        return $this->admitepunitorios;
    }
    /**
     * Set admitepunitorios
     */
    public function setAdmitepunitorios($admitepunitorios)
    {
        $this->admitepunitorios = $admitepunitorios;
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

    
    
    public function setTipoCuentaContable(\AppBundle\Entity\TipoCuentaContable $tipoCuentaContable = null)
    {
        $this->TipoCuentaContable = $tipoCuentaContable;

        return $this;
    }

    public function getTipoCuentaContable()
    {
        return $this->TipoCuentaContable;
    }    

//******************************************************************************
}



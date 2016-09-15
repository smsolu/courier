<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * vOperacionCC 
 *
 * @ORM\Table(name="v_operacion_cc")
 * @ORM\Entity
 */
class vOperacionCC extends LP_Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(name="identificador", type="string")
     */
    protected $id;    
    
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
    * @var TipoCuentaContable
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoCuentaContable")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_tipocuenta", referencedColumnName="id")})
    */
    private $TipoCuentaContable;       
    
    /**
    * @var CobroCC
    * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\CobroCC")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_cobro", referencedColumnName="id")})
    */
    private $CobroCC;    
    
    /**
    * @var DeudaCC
    * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\DeudaCC")
    * @ORM\JoinColumns({
    *      @ORM\JoinColumn(name="id_deuda", referencedColumnName="id")})
    */
    private $DeudaCC;    
    
    /**
    * @var datetime  
    * @ORM\Column(name="fechayhora", type="datetime", nullable=true )
    */
    private $fechayhora;


    /**
    * @var string  
    * @ORM\Column(name="titulo", type="string", nullable=true , length=255)
    */
    private $titulo;


    /**
    * @var integer  
    * @ORM\Column(name="contabilizar", type="integer", nullable=true )
    */
    private $contabilizar = '0';


    /**
    * @var float
    * @ORM\Column(name="monto", type="float", nullable=false )
    */
    private $monto = '0';

  
    
    /**
    * @var integer  
    * @ORM\Column(name="tipo", type="integer", nullable=true )
    */
    private $tipo = '0';


    private $acumulado = 0;
    private $vObjects=null;
    private $vPos = 0;
//*************************GETTERS && SETTERS **********************************
    /**
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }    
    
    /**
     * Get Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }

    /**
     * Get Expediente
     */
    public function getExpediente()
    {
        return $this->Expediente;
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
     * Get titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }


    /**
     * Get CobroCC
     */
    public function getCobroCC()
    {
        return $this->CobroCC;
    }

    /**
     * Get DeudaCC
     */
    public function getDeudaCC()
    {
        return $this->DeudaCC;
    }
    
    /**
     * Get contabilizar
     */
    public function getContabilizar()
    {
        return $this->contabilizar;
    }


    /**
     * Get monto
     */
    public function getMonto()
    {
        if(is_null($this->monto)){
            $this->monto = 0;
        }
                
            // Tipo = 0 => Deuda
        switch($this->tipo){
            case 0: // Deuda
                return $this->monto;
            case 1: // Cobro
                return -abs($this->monto);  //Los cobros los pone en negativo.
            case 2: // Anotacion o comentario en la lista
                return "0";
        }

            
        return $this->monto;
    }
    
    public function getAcumulado(){
        return $this->acumulado;
    }

    public function setObjects($objects, $pos){
        $this->vObjects = $objects;
        $this->vPos = $pos;

        // Calcular el acumulado
        $order = 0;$this->acumulado = 0;
        for($j = 0; $j<= $pos; $j++){
            $obj = $objects[$j];
            $this->acumulado = $this->acumulado + $obj->getMonto();
        }
    }

    
    
//******************************************************************************
}



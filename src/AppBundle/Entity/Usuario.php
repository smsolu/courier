<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use AppBundle\Entity\CourierEntity;
/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntidadRepository")
 * @Assert\Callback(methods={"Validate"})
   @UniqueEntity(
   fields={"nombrePila","nombreApellido","nro_cuit","status","Empresa","tipoentidad"},
   errorPath="nombrePila",
   message="Esta entidad ya existe")
 */
class Usuario extends CourierEntity
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Direccion")
     * @ORM\JoinColumn(name="id_direccion", referencedColumnName="id")* 
     */
    private $Direccion;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")* 
     */
    private $Empresa;


    /**
     * @var TipoResponsabilidadIva
     * @ORM\ManyToOne(targetEntity="EntidadTipoResponsabilidadIva")
     * @ORM\JoinColumn(name="id_tipo_responsabilidad_iva", referencedColumnName="id")* 
     */
    private $TipoResponsabilidadIva;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_pila", type="string", length=255, nullable=true)
     */
    private $nombrePila;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_apellido", type="string", length=255, nullable=true)
     */
    private $nombreApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="Observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_cuit", type="string", length=255, nullable=true)
     */
    private $nroCuit;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_ingresosbrutos", type="string", length=255, nullable=true)
     */
    private $nroIngresosBrutos;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="nro_documento", type="string", length=255, nullable=true)
     */
    private $nroDocumento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="EstadoCivil", type="smallint", nullable=true)
     */
    private $estadocivil = '0';

  
    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="TipoPersona", type="integer", nullable=true)
     */
    private $tipopersona = '0';

 
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    
    public function actualizarNombre(){
        // Es una persona fisica por lo que Nombre = NombrePila + <Espacio> + NombreApellido
        if($this->getTipopersona() == 0 ){
            $this->setNombre($this->getNombrePila() . ' ' . $this->getNombreApellido() );
        }else{
            // En el caso de que sea una empresa, se setea directamente y no se hace nada
            $this->setNombre($this->getNombrePila());
        }
    }


  
    public function getId()
    {
        return $this->id;
    }

  
    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;

        return $this;
    }

    
    public function getDireccion()
    {
        return $this->Direccion;
    }

   
    public function setEmpresa($Empresa)
    {
        $this->Empresa = $Empresa;

        return $this;
    }

  
    public function getEmpresa()
    {
        return $this->Empresa;
    }

   
   
    public function setTipoResponsabilidadIva(EntidadTipoResponsabilidadIva $value)
    {
        $this->TipoResponsabilidadIva = $value;

        return $this;
    }

  
    public function getTipoResponsabilidadIva()
    {
        return $this->TipoResponsabilidadIva;
    }

   
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

  
    public function getNombre()
    {
        return "{" . $this->getId() . "} - " . $this->nombre;
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

  
    public function setNombrePila($nombrePila)
    {
        $this->nombrePila = $nombrePila;
        $this->actualizarNombre();
        return $this;
    }

  
    public function getNombrePila()
    {
        return $this->nombrePila;
    }

 
    public function setNombreApellido($nombreApellido)
    {
        $this->nombreApellido = $nombreApellido;
        $this->actualizarNombre();

        return $this;
    }

 
    public function getNombreApellido()
    {
        return $this->nombreApellido;
    }

   
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

   
    public function getObservaciones()
    {
        return $this->observaciones;
    }

  
    public function setNroCuit($nroCuit)
    {
        $this->nroCuit = $nroCuit;

        return $this;
    }

  
    public function getNroCuit()
    {
        return $this->nroCuit;
    }


    public function setNroIngresosBrutos($value)
    {
        $this->nroIngresosBrutos = $value;

        return $this;
    }

   
    public function getNroIngresosBrutos()
    {
        return $this->nroIngresosBrutos;
    }    
    
    
    
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;

        return $this;
    }

   
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

   
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

  
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;

        return $this;
    }

   
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

   
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

   
    public function getEmail()
    {
        return $this->email;
    }

   
    public function setTipopersona($tipopersona)
    {
        $this->tipopersona = $tipopersona;

        return $this;
    }

    public function getTipopersona()
    {
        return $this->tipopersona;
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
    
}

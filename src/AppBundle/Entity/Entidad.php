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
 * @ORM\Table(name="entidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntidadRepository")
 * @Assert\Callback(methods={"Validate"})
   @UniqueEntity(
   fields={"nombrePila","nombreApellido","status","Estudio","tipoentidad"},
   errorPath="nombrePila",
   message="Esta entidad ya existe")
 */
class Entidad extends LP_Entity
{
    const STATUS_NO_DELETED = 0;
    const STATUS_DELETED = -1;
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
     * @ORM\ManyToOne(targetEntity="EntidadProfesion")
     * @ORM\JoinColumn(name="id_profesion", referencedColumnName="id")* 
     */
    private $profesion;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")* 
     */
    private $Estudio;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EntidadEmpresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")* 
     */
    private $empresa;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EntidadNacionalidad")
     * @ORM\JoinColumn(name="id_nacionalidad", referencedColumnName="id")* 
     */
    private $nacionalidad;

    
     /**
     * @var EntidadTipoEntidad 
     * @ORM\ManyToOne(targetEntity="EntidadTipoEntidad")
     * @ORM\JoinColumn(name="id_Tipoentidad", referencedColumnName="id")
     */
    private $tipoentidad;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EntidadLocalidad")
     * @ORM\JoinColumn(name="id_localidad", referencedColumnName="id")* 
     */
    private $localidad;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EntidadZona")
     * @ORM\JoinColumn(name="id_zona", referencedColumnName="id")* 
     */
    private $zona;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EntidadProvincia")
     * @ORM\JoinColumn(name="id_provincia", referencedColumnName="id")* 
     */
    private $provincia;

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
     * @ORM\Column(name="Direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="CodPostal", type="string", length=255, nullable=true)
     */
    private $codpostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Celular", type="string", length=255, nullable=true)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="Fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="Telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Telefono2", type="string", length=255, nullable=true)
     */
    private $telefono2;

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
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="esp", type="integer", nullable=true)
     */
    private $esp = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="fechainactividad", type="integer", nullable=true)
     */
    private $fechainactividad = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", nullable=true)
     */
    private $web = '';    
    
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


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    /**
     * Set Web
     *
     * @param  $value
     * @return this
     */
    public function setWeb($value)
    {
        $this->web = $value;

        return $this;
    }

    /**
     * Get Web
     *
     * @return this 
     */
    public function getWeb()
    {
        return $this->web;
    }
    
    /**
     * Set Profesion
     *
     * @param EntidadProfesion $Profesion
     * @return Entidad
     */
    public function setProfesion($Profesion)
    {
        $this->profesion = $Profesion;

        return $this;
    }

    /**
     * Get Profesion
     *
     * @return EntidadProfesion 
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * Set estudio
     *
     * @param Estudio $Estudio
     * @return Entidad
     */
    public function setEstudio($Estudio)
    {
        $this->Estudio = $Estudio;

        return $this;
    }

    /**
     * Get estudio
     *
     * @return Estudio 
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }

    /**
     * Set Empresa
     *
     * @param EntidadEmpresa $Empresa
     * @return Entidad
     */
    public function setEmpresa($Empresa)
    {
        $this->empresa = $Empresa;

        return $this;
    }

    /**
     * Get Empresa
     *
     * @return EntidadEmpresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set idNacionalidad
     *
     * @param EntidadNacionalidad $Nacionalidad
     * @return Entidad
     */
    public function setNacionalidad($Nacionalidad)
    {
        $this->nacionalidad = $Nacionalidad;

        return $this;
    }

    /**
     * Get Nacionalidad
     *
     * @return EntidadNacionalidad 
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set tipoEntidad
     *
     * @param entity $tipoEntidad
     * @return Entidad
     */
    public function setTipoEntidad($tipoEntidad)
    {
        $this->tipoentidad = $tipoEntidad;

        return $this;
    }

    /**
     * Get tipoEntidad
     *
     * @return EntidadTipoEntidad 
     */
    public function getTipoEntidad()
    {
        return $this->tipoentidad;
    }

    /**
     * Set setLocalidad
     *
     * @param EntidadLocalidad $Localidad
     * @return Entidad
     */
    public function setLocalidad($Localidad)
    {
        $this->localidad = $Localidad;

        return $this;
    }

    /**
     * Get getLocalidad
     *
     * @return EntidadLocalidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set Zona
     *
     * @param EntidadZona $Zona
     * @return Entidad
     */
    public function setZona($Zona)
    {
        $this->zona = $Zona;

        return $this;
    }

    /**
     * Get Zona
     *
     * @return EntidadZona 
     */
    public function geZona()
    {
        return $this->zona;
    }

    /**
     * Set Provincia
     *
     * @param EntidadProvincia $Provincia
     * @return Entidad
     */
    public function setProvincia($Provincia)
    {
        $this->provincia = $Provincia;

        return $this;
    }

    /**
     * Get Provincia
     *
     * @return EntidadProvincia; 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set TipoResponsabilidadIva
     *
     * @param EntidadTipoResponsabilidadIva $value
     * @return this
     */
    public function setTipoResponsabilidadIva(EntidadTipoResponsabilidadIva $value)
    {
        $this->TipoResponsabilidadIva = $value;

        return $this;
    }

    /**
     * Get TipoResponsabilidadIva
     *
     * @return EntidadTipoResponsabilidadIva 
     */
    public function getTipoResponsabilidadIva()
    {
        return $this->TipoResponsabilidadIva;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Entidad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return "{" . $this->getId() . "} - " . $this->nombre;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Entidad
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    
    
    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombrePila
     *
     * @param string $nombrePila
     * @return Entidad
     */
    public function setNombrePila($nombrePila)
    {
        $this->nombrePila = $nombrePila;
        $this->actualizarNombre();
        return $this;
    }

    /**
     * Get nombrePila
     *
     * @return string 
     */
    public function getNombrePila()
    {
        return $this->nombrePila;
    }

    /**
     * Set nombreApellido
     *
     * @param string $nombreApellido
     * @return Entidad
     */
    public function setNombreApellido($nombreApellido)
    {
        $this->nombreApellido = $nombreApellido;
        $this->actualizarNombre();

        return $this;
    }

    /**
     * Get nombreApellido
     *
     * @return string 
     */
    public function getNombreApellido()
    {
        return $this->nombreApellido;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Entidad
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set nroCuit
     *
     * @param string $nroCuit
     * @return Entidad
     */
    public function setNroCuit($nroCuit)
    {
        $this->nroCuit = $nroCuit;

        return $this;
    }

    /**
     * Get nroCuit
     *
     * @return string 
     */
    public function getNroCuit()
    {
        return $this->nroCuit;
    }

/**
     * Set nroingresosbrutos
     *
     * @param string 
     * @return this
     */
    public function setNroIngresosBrutos($value)
    {
        $this->nroIngresosBrutos = $value;

        return $this;
    }

    /**
     * Get nroCuit
     *
     * @return string 
     */
    public function getNroIngresosBrutos()
    {
        return $this->nroIngresosBrutos;
    }    
    
    
    /**
     * Set nroDocumento
     *
     * @param string $nroDocumento
     * @return Entidad
     */
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;

        return $this;
    }

    /**
     * Get nroDocumento
     *
     * @return string 
     */
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Entidad
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set estadocivil
     *
     * @param integer $estadocivil
     * @return Entidad
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;

        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return integer 
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Entidad
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set codpostal
     *
     * @param string $codpostal
     * @return Entidad
     */
    public function setCodpostal($codpostal)
    {
        $this->codpostal = $codpostal;

        return $this;
    }

    /**
     * Get codpostal
     *
     * @return string 
     */
    public function getCodpostal()
    {
        return $this->codpostal;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Entidad
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Entidad
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Entidad
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     * @return Entidad
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string 
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Entidad
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tipopersona
     *
     * @param integer $tipopersona
     * @return Entidad
     */
    public function setTipopersona($tipopersona)
    {
        $this->tipopersona = $tipopersona;

        return $this;
    }

    /**
     * Get tipopersona
     *
     * @return integer 
     */
    public function getTipopersona()
    {
        return $this->tipopersona;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Entidad
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set esp
     *
     * @param integer $esp
     * @return Entidad
     */
    public function setEsp($esp)
    {
        $this->esp = $esp;

        return $this;
    }

    /**
     * Get esp
     *
     * @return integer 
     */
    public function getEsp()
    {
        return $this->esp;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Entidad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechainactividad
     *
     * @param integer $fechainactividad
     * @return Entidad
     */
    public function setFechainactividad($fechainactividad)
    {
        $this->fechainactividad = $fechainactividad;

        return $this;
    }

    /**
     * Get fechainactividad
     *
     * @return integer 
     */
    public function getFechainactividad()
    {
        return $this->fechainactividad;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Entidad
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /*
     * Validar la entidad
     */
    public function Validate(ExecutionContextInterface $context)
    {
        
        
        //$context->addViolationAt('numero', 'El número esta repetido');
    }       
    
    // Para agregarle compatibilidad en la pantalla de abogados
    // de expedientes
    public function getEntidadId()
    {
        return $this->getId();
    }
}

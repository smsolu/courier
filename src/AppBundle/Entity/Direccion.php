<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use AppBundle\Entity\CourierEntity;
/**
 * Direccion
 *
 * @ORM\Table(name="direccion")
 */
class Direccion extends CourierEntity
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
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")* 
     */
    private $Empresa;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="id_pais", referencedColumnName="id")* 
     */
    private $Pais;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_zona", type="string", length=255, nullable=true)
     */
    private $barriozona;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="id_provincia", referencedColumnName="id")* 
     */
    private $Provincia;

  
    /**
     * @var string
     *
     * @ORM\Column(name="Observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

  
    /**
     * @var string
     *
     * @ORM\Column(name="Direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="Telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';


    public function getId()
    {
        return $this->id;
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


    public function setPais($Pais)
    {
        $this->Pais = $Pais;

        return $this;
    }

    public function getPais()
    {
        return $this->Pais;
    }

    public function setProvincia($Provincia)
    {
        $this->Provincia = $Provincia;

        return $this;
    }

    public function getProvincia()
    {
        return $this->Provincia;
    }

    

    public function setLocalidad($Localidad)
    {
        $this->localidad = $Localidad;

        return $this;
    }

 
    public function getLocalidad()
    {
        return $this->localidad;
    }


    public function setBarrioZona($Zona)
    {
        $this->barriozona = $Zona;

        return $this;
    }

    public function getBarrioZona()
    {
        return $this->barriozona;
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

  

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }


    public function getDireccion()
    {
        return $this->direccion;
    }


    public function setCodpostal($codpostal)
    {
        $this->codpostal = $codpostal;

        return $this;
    }


    public function getCodpostal()
    {
        return $this->codpostal;
    }


    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }


    public function getCelular()
    {
        return $this->celular;
    }

  

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }


    public function getTelefono()
    {
        return $this->telefono;
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

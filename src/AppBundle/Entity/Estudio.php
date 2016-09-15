<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\User;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\LP_Entity;
/**
 * Estudio
 *
 * @ORM\Table(name="estudio")
 * @ORM\Entity
 */
class Estudio extends LP_Entity
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cant_usuarios", type="integer", nullable=false, options={"default":0})
     */
    private $cantusuarios;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_expedientes", type="integer", nullable=false, options={"default":0})
     */
    private $cantexpedientes;       
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cant_documentos", type="integer", nullable=false, options={"default":0})
     */
    private $cantdocumentos; 

     /**
     * @var integer
     *
     * @ORM\Column(name="cant_bytes_files", type="integer", nullable=false, options={"default":0})
     */
    private $cantbytesfiles;

     /**
     * @var integer
     *
     * @ORM\Column(name="cant_entidades", type="integer", nullable=false, options={"default":0})
     */
    private $cantentidades;    
    
    
     /**
     * @var User
     * 
     * @ORM\OneToMany(targetEntity="User", mappedBy="estudio")
     */
    protected $usuarios;

    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Cuenta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cuenta", referencedColumnName="id")
     * })
     */
    private $Cuenta;
    
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->status = 0;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
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

    public function addUsuario(User $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    public function removeUsuario(User $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    public function getUsuarios()
    {
        return $this->usuarios;
    }

    public function setCuenta(Cuenta $cuenta = null)
    {
        $this->Cuenta = $cuenta;

        return $this;
    }

    public function getCuenta()
    {
        return $this->Cuenta;
    }
    
    public function setCantUsuarios($value)
    {
        $this->cantusuarios = $value;

        return $this;
    }

    public function getCantUsuarios()
    {
        return $this->cantusuarios;
    }
    
    public function setCantExpedientes($value)
    {
        $this->cantexpedientes = $value;

        return $this;
    }

    public function getCantExpedientes()
    {
        return $this->cantexpedientes;
    }        

    public function setCantDocumentos($value)
    {
        $this->cantdocumentos = $value;

        return $this;
    }
    
    public function getCantDocumentos()
    {
        return $this->cantdocumentos;
    }            

    public function setCantBytesFiles($value)
    {
        $this->cantbytesfiles = $value;

        return $this;
    }

    public function getCantBytesFiles()
    {
        return $this->cantbytesfiles;
    }

    public function setCantEntidades($value)
    {
        $this->cantentidades = $value;

        return $this;
    }

    public function getCantEntidades()
    {
        return $this->cantentidades;
    }      
}

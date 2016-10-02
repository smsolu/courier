<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CourierEntity;
/**
 * Provincia
 *
 * @ORM\Table(name="provincia", indexes={@ORM\Index(name="entidad_provincia_codigo", columns={"codigo"})})
 * @ORM\Entity
 */
class Provincia extends CourierEntity
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
     * @ORM\Column(name="codigo", type="string", length=50, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

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

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

 
    public function getCodigo()
    {
        return $this->codigo;
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
}

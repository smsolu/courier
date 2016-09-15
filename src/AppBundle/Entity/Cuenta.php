<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * Cuenta
 *
 * @ORM\Table(name="Cuenta")
 * @ORM\Entity
 */
class Cuenta extends LP_Entity
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;

     /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status;    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="max_usuarios", type="integer", nullable=false, options={"default":0})
     */
    private $maxusuarios;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_expedientes", type="integer", nullable=false, options={"default":0})
     */
    private $maxexpedientes;       
    
    /**
     * @var integer
     *
     * @ORM\Column(name="max_documentos", type="integer", nullable=false, options={"default":0})
     */
    private $maxdocumentos; 

     /**
     * @var integer
     *
     * @ORM\Column(name="max_bytes_files", type="integer", nullable=false, options={"default":0})
     */
    private $maxbytesfiles;

     /**
     * @var integer
     *
     * @ORM\Column(name="max_entidades", type="integer", nullable=false, options={"default":0})
     */
    private $maxentidades;       
    

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

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
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

    public function setMaxUsuarios($value)
    {
        $this->maxusuarios = $value;

        return $this;
    }

    public function getMaxUsuarios()
    {
        return $this->maxusuarios;
    }

    public function setMaxExpedientes($value)
    {
        $this->maxexpedientes = $value;

        return $this;
    }

    public function getMaxExpedientes()
    {
        return $this->maxexpedientes;
    }        

    public function setMaxDocumentos($value)
    {
        $this->maxdocumentos = $value;

        return $this;
    }

    public function getMaxDocumentos()
    {
        return $this->maxdocumentos;
    }            

    public function setMaxBytesFiles($value)
    {
        $this->maxbytesfiles = $value;

        return $this;
    }

    public function getMaxBytesFiles()
    {
        return $this->maxbytesfiles;
    }

    public function setMaxEntidades($value)
    {
        $this->maxentidades = $value;

        return $this;
    }

    public function getMaxEntidades()
    {
        return $this->maxentidades;
    }          
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * EntidadZona
 *
 * @ORM\Table(name="entidad_zona", indexes={@ORM\Index(name="entidad_zona_codigo", columns={"codigo"}), @ORM\Index(name="entidad_zona_idestudio", columns={"id_estudio"})})
 * @ORM\Entity
 */
class EntidadZona extends LP_Entity
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

    /**
     * @var integer
     *
     * @ORM\Column(name="esp", type="integer", nullable=true)
     */
    private $esp = '0';

    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $idEstudio;



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
     * Set codigo
     *
     * @param string $codigo
     * @return EntidadZona
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
     * Set nombre
     *
     * @param string $nombre
     * @return EntidadZona
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
        return $this->nombre;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return EntidadZona
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

    /**
     * Set esp
     *
     * @param integer $esp
     * @return EntidadZona
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
     * Set idEstudio
     *
     * @param \AppBundle\Entity\Estudio $idEstudio
     * @return EntidadZona
     */
    public function setIdEstudio(\AppBundle\Entity\Estudio $idEstudio = null)
    {
        $this->idEstudio = $idEstudio;

        return $this;
    }

    /**
     * Get idEstudio
     *
     * @return \AppBundle\Entity\Estudio 
     */
    public function getIdEstudio()
    {
        return $this->idEstudio;
    }
}
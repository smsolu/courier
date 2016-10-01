<?php

namespace AppBundle\Entity;

use AppBundle\Entity\EntidadEmpresa;
use AppBundle\Entity\Estudio;
use AppBundle\Entity\LP_Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CaracterInterviniente
 *
 * @ORM\Table(name="tipo_vinculacion")
 * @ORM\Entity
 */
class TipoVinculacion extends LP_Entity
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
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
    private $Estudio;



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
     * @return EntidadEmpresa
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
     * @return EntidadEmpresa
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
     * @return this
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
     * @return this
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
     * Set Estudio
     *
     * @param  $estudio
     * @return this
     */
    public function setEstudio($estudio = null)
    {
        $this->Estudio = $estudio;

        return $this;
    }

    /**
     * Get Estudio
     *
     * @return Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }
}

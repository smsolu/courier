<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * EntidadTipoEntidad
 *
 * @ORM\Table(name="entidad_tipoentidad", indexes={@ORM\Index(name="entidad_tipoentidad_codigo", columns={"codigo"}), @ORM\Index(name="entidad_tipoentidad_idestudio", columns={"id_estudio"})})
 * @ORM\Entity
 */
class EntidadTipoEntidad extends LP_Entity
{
    const CODIGO_ABOGADO = 'ABOGADO';
    const CODIGO_CLIENTE = 'CLIENTE';
    const CODIGO_EMPLEADO = 'EMPLEADO';
    const CODIGO_OPONENTE = 'OPONENTE';
    const CODIGO_TERCERO = 'TERCERO';
    
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
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo = '0';

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
     * @return EntidadTipoEntidad
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
     * @return EntidadTipoEntidad
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
     * @return EntidadTipoEntidad
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
     * @return EntidadTipoEntidad
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
     * Set tipo
     *
     * @param integer $tipo
     * @return EntidadTipoEntidad
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
     * Set Estudio
     *
     * @param \AppBundle\Entity\Estudio $idEstudio
     * @return EntidadTipoEntidad
     */
    public function setEstudio(\AppBundle\Entity\Estudio $estudio = null)
    {
        $this->Estudio = $estudio;

        return $this;
    }

    /**
     * Get Estudio
     *
     * @return \AppBundle\Entity\Estudio
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }
}

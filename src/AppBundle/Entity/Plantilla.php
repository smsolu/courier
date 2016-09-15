<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * Plantilla
 *
 * @ORM\Table(name="plantilla", indexes={@ORM\Index(name="fk_plantilla_estudio", columns={"id_estudio"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlantillaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Plantilla extends LP_Entity
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
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Plantilla")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plantilla_padre", referencedColumnName="id")
     * })
     */
    private $plantillaPadre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

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
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

     /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo;  
    
    /**
     * @var integer
     *
     * @ORM\Column(name="filesize", type="integer", nullable=false)
     */   
    private $filesize;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="variables", type="string", length=1024, nullable=true)
     */   
    private $variables;
    
    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=1024, nullable=true)
     */   
    private $codigo;

    private $file;
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Plantilla
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
     * Get filesize
     *
     * @return integer 
     */
    public function getFilesize()
    {
        return $this->filesize;
    }
    /**
     * Set filesize
     *
     * @return Plantilla
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
        return $this;
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
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }    
    
    /**
     * Set idEstudio
     *
     * @param \AppBundle\Entity\Estudio $Estudio
     * @return Plantilla
     */
    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

        return $this;
    }
    
    
    /**
     * Get idEstudio
     *
     * @return \AppBundle\Entity\Estudio 
     */
    public function getEstudio()
    {
        return $this->Estudio;
    }
    
     /**
     * Set Filename
     *
     * @param string $filename
     * @return Plantilla
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get Filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }    
    
     /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Plantilla
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Plantilla
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Plantilla
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get Tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * Get plantillaPadre
     *
     * @return Plantilla 
     */
    function getPlantillaPadre() {
        return $this->plantillaPadre;
    }
    
    /**
     * Set plantillaPadre
     *
     * @param Plantilla $plantillaPadre
     * @return Plantilla
     */
    function setPlantillaPadre(Plantilla $plantillaPadre) {
        $this->plantillaPadre = $plantillaPadre;
        return $this;
    }
    /**
     * Get Variables
     *
     * @return array 
     */
    function getVariables() {
        return json_decode($this->variables);
    }
    /**
     * Set variables
     *
     * @param array $variables
     * @return Plantilla
     */
    function setVariables($variables) {
        $this->variables = json_encode($variables);
        return $this;
    }
    
    function getFile() {
        return $this->file;
    }

    function setFile($file) {
        $this->filename = $file->getFilename();
        $this->filesize = filesize($file->getPathname());
        $this->file = $file;
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }





}

<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * DocumentoVersion
 *
 * @ORM\Table(name="documento_version", indexes={@ORM\Index(name="fk_documento_version_documento", columns={"id_documento"}), @ORM\Index(name="fk_documento_version_estudio", columns={"id_estudio"})})
 * @ORM\Entity
 */
class DocumentoVersion extends LP_Entity
{
    const VERSION_INICIAL_INTEGER = 0;
    const VERSION_INICIAL_STRING = "version inicial";
    
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
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $estudio;
    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var date
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;
    /**
     * @var date
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';
    /**
     * @var \Documento
     *
     * @ORM\ManyToOne(targetEntity="Documento")
     * @ORM\JoinColumn(name="id_documento", referencedColumnName="id")
     */
    private $documento;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version;
    /**
     * @var integer
     *
     * @ORM\Column(name="file_size", type="integer", nullable=false)
     */   
    private $filesize;
    
    
    private $file;
    
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
     * @param integer $id
     * @return DocumentoVersion
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DocumentoVersion
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
     * Set Estudio
     *
     * @param \AppBundle\Entity\Estudio $estudio
     * @return DocumentoVersion
     */
    public function setEstudio(\AppBundle\Entity\Estudio $estudio = null)
    {
        $this->estudio = $estudio;
        return $this;
    }
    /**
     * Get Estudio
     *
     * @return \AppBundle\Entity\Estudio 
     */
    public function getEstudio()
    {
        return $this->estudio;
    }
    /**
     * Set filename
     *
     * @param string $filename
     * @return this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }
    /**
     * Set fechaCreacion
     *
     * @param datetime $fechaCreacion
     * @return this
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
    }
    /**
     * Get fechaCreacion
     *
     * @return datetime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }
    /**
     * Set fechaModificacion
     *
     * @param datetime $fechaModificacion
     * @return this
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
        return $this;
    }
    /**
     * Get fechaModificacion
     *
     * @return datetime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }
    /**
     * Set status
     *
     * @param boolean $status
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
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set Documento
     *
     * @param \AppBundle\Entity\Documento $documento
     * @return this
     */
    public function setDocumento(\AppBundle\Entity\Documento $documento = null)
    {
        $this->documento = $documento;
        return $this;
    }
    /**
     * Get Documento
     *
     * @return \AppBundle\Entity\Documento
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set Version
     *
     * @param integer $version
     * @return this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    /**
     * Get version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Set filesize
     *
     * @return this 
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
        return $this;
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
    
    public function getFile(){
        return $this->file;
    }
    public function setFile($file){
        $this->file = $file;
        return $this;
    }
}

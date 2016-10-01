<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use AppBundle\Constant\ConstDocumento;
use Doctrine\Common\Collections\Criteria;
use AppBundle\Entity\LP_Entity;
/**
 * Documento
 *
 * @ORM\Table(name="documento", indexes={@ORM\Index(name="fk_documento_expediente", columns={"id_expediente"}), @ORM\Index(name="fk_documento_estudio", columns={"id_estudio"}),@ORM\Index(name="fk_documento_fos_user", columns={"id_usuario_modificando"})})
  *@ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 */
class Documento extends LP_Entity
{
    const BLOQUEADO_NO_BLOQUEADO = 0;
    const BLOQUEADO_BLOQUEADO = 1;
    const TIPO_FILESYSTEM = 0;
    const TIPO_EDITOR_WEB = 1;
    const TIPO_GOOGLE_DRIVE = 2;
    
    
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
     * @var \Estudio
     *
     * @ORM\ManyToOne(targetEntity="Estudio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estudio", referencedColumnName="id")
     * })
     */
    private $estudio;

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
     * @var date
     *
     * @ORM\Column(name="fecha_eliminacion", type="datetime", nullable=true)
     */
    private $fechaEliminacion;
    
    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $expediente;
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';
    /**
     * @var integer
     *
     * @ORM\Column(name="bloqueado", type="integer", nullable=false)
     */
    private $bloqueado = self::BLOQUEADO_NO_BLOQUEADO;
    /**
     * @var date
     *
     * @ORM\Column(name="fecha_bloqueo", type="datetime", nullable=true)
     */
    private $fechaBloqueo;
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_bloqueo", referencedColumnName="id")
     * })
     */
    private $usuarioBloqueo;
    /**
     * @var integer
     *
     * @ORM\Column(name="ultima_version", type="integer", nullable=false)
     */
    private $ultimaVersion;
    /**
     * @var integer
     *
     * @ORM\Column(name="total_size", type="integer", nullable=false)
     */   
    private $totalSize;
     /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo; 
    
    //Solo para recibir el archivo en el new
    private $file;
    
    /**
     * @ORM\OneToMany(targetEntity="DocumentoVersion", mappedBy="documento")
     */
    private $documentoVersiones;
    
    public function __construct()
    {
        $this->documentoVersiones = new ArrayCollection();
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
     * @param integer $id
     * @return Documento
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Documento
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
     * Set expediente
     *
     * @param \AppBundle\Entity\Expediente $expediente
     * @return Documento
     */
    public function setExpediente(\AppBundle\Entity\Expediente $expediente = null)
    {
        $this->expediente = $expediente;
        return $this;
    }
    /**
     * Get expediente
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->expediente;
    }
    /**
     * Set status
     *
     * @param boolean $status
     * @return Documento
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
     * Set bloqueado
     *
     * @param integer $bloqueado
     * @return this
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;
        return $this;
    }
    /**
     * Get bloqueado
     *
     * @return integer 
     */
    public function getBloqueado()
    {
        return $this->bloqueado;
    }
    /**
     * Get bloqueado in string
     *
     * @return String
     */
    public function getBloqueadoStr()
    {
        switch ($this->bloqueado){
            case self::BLOQUEADO_BLOQUEADO:
                return "bloqueado por ".$this->usuarioBloqueo->getUsername();
            case self::BLOQUEADO_NO_BLOQUEADO:
                return "desbloqueado";
        }
    }
        /**
     * Set fechaBloqueo
     *
     * @param datetime $fechaBloqueo
     * @return this
     */
    public function setFechaBloqueo($fechaBloqueo)
    {
        $this->fechaBloqueo = $fechaBloqueo;
        return $this;
    }
    /**
     * Get fechaBloqueo
     *
     * @return datetime 
     */
    public function getFechaBloqueo()
    {
        return $this->fechaBloqueo;
    }
    /**
     * Set usuarioBloqueo
     *
     * @param \AppBundle\Entity\User $usuarioBloqueo
     * @return this
     */
    public function setUsuarioBloqueo(\AppBundle\Entity\User $usuarioBloqueo = null)
    {
        $this->usuarioBloqueo = $usuarioBloqueo;
        return $this;
    }
    /**
     * Get usuarioBloqueo
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUsuarioBloqueo()
    {
        return $this->usuarioBloqueo;
    }
    /**
     * Set ultimaVersion
     *
     * @param integer $ultimaVersion
     * @return this
     */
    public function setUltimaVersion($ultimaVersion)
    {
        $this->ultimaVersion = $ultimaVersion;
        return $this;
    }
    /**
     * Get ultimaVersion
     *
     * @return integer 
     */
    public function getUltimaVersion()
    {
        return $this->ultimaVersion;
    }
    /**
     * Set totalSize
     *
     * @return this 
     */
    public function setTotalSize($totalSize)
    {
        $this->totalSize = $totalSize;
        return $this;
    }
    /**
     * Get totalSize
     *
     * @return integer 
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }
    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return this
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
    
//    function getFile() {
//        return $this->file;
//    }
//
//    function setFile($file) {
//        $this->file = $file;
//    }
    
    function getDocumentoVersiones() {
        
         $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('status', 0))
        ;

        return $this->documentoVersiones->matching($criteria);
        
//        return $this->documentoVersiones;
    }

    function setDocumentoVersiones($documentoVersiones) {
        $this->documentoVersiones = $documentoVersiones;
        return $this;
    }
    
    function addDocumentoVersion($documentoVersion) {
        $this->documentoVersiones->add($documentoVersion);
        $documentoVersion->setDocumento($this);
        return $this;
    }
    
    function removeDocumentoVersion($documentoVersion) {
        $index = $this->documentoVersiones->indexOf($documentoVersion);
        $this->documentoVersiones->remove($index);
        return $this;
    }
    
    function getLastDocumentoVersion(){
        $documentoVersion = $this->documentoVersiones->last();
        if($documentoVersion){
            return $documentoVersion;
        }
        return null;
    }
    /**
     * Agrega un DocumentoVersion a la coleccion
     * @param type $documentoVersion
     */
    function setLastDocumentoVersion($documentoVersion){
        return $this->addDocumentoVersion($documentoVersion);
    }
    public function calculateTotalSize(){
        $this->totalSize = 0;
        foreach($this->documentoVersiones as $version){
            $this->totalSize = $this->totalSize + $version->getFileSize();
        }
    }
    
    function getFechaEliminacion() {
        return $this->fechaEliminacion;
    }

    function setFechaEliminacion($fechaEliminacion) {
        $this->fechaEliminacion = $fechaEliminacion;
    }





}

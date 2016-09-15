<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;

// ATENCION: PARA QUE FUNCIONE SE TIENE QUE DESCOMENTAR ESTA LINEA EN PHP.INI
// extension=php_fileinfo.dll

/**
 * ExpedienteDocumento
 *
 * @ORM\Table(name="expediente_documento_file", indexes={@ORM\Index(name="fk_expedientedocumentofile_expediente", columns={"id_expediente"}), @ORM\Index(name="fk_expedientedocumentofile_estudio", columns={"id_estudio"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ExpedienteDocumentoFile extends LP_Entity
{
    const VERSION_INICIAL_INTEGER = 0;
    const VERSION_INICIAL_STRING = "Version inicial";
    const MODIFICANDO_NO_MODIFICANDO = 0;
    const MODIFICANDO_MODIFICANDO = 1;
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
     * @Assert\File(maxSize="1M")
     * ORM\Column(name="file", nullable=true)
     * @Assert\NotBlank(message="Por favor suba un archivo pdf o word")
     */
    private $file;

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
     * @var \Documento
     *
     * @ORM\ManyToOne(targetEntity="ExpedienteDocumento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_documento", referencedColumnName="id")
     * })
     */
    private $Documento;
    
    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $Expediente;
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $Usuario;

        /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario_modificacion", referencedColumnName="id")
     * })
     */
    private $UsuarioModifica;
    
     /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    
     /**
     * @var integer
     *
     * @ORM\Column(name="modificando", type="integer", nullable=false)
     */
    private $modificando;

     /**
     * @var date
     *
     * @ORM\Column(name="fechayhora", type="datetime", nullable=true)
     */
    private $fechayhora;
  
    /**
     * @var date
     *
     * @ORM\Column(name="delete_fecha", type="datetime", nullable=true)
     */
    private $deletefecha;
    
    /**
     * @var date
     *
     * @ORM\Column(name="modificando_fechayhora", type="datetime", nullable=true)
     */
    private $modificandofechayhora;    

     /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo;  
    
     /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version;    
    
    
      /**
     * @var integer
     *
     * @ORM\Column(name="filesize", type="integer", nullable=false)
     */   
    private $filesize;
        
    private $path="";
    /***************************************************************************/    
    /* VIRTUALES PARA LA VISTA O PARA LA OPERATORIA */
    /***************************************************************************/
    
    public function getStrFechayhora()
    {
        // LO RETORNO EN STRING
        if($this->fechayhora == null){
            return "";
        }
        return $this->fechayhora->format('d/m/Y H:i');
    }

    public function getStrFechayhoraModificacion()
    {
        // LO RETORNO EN STRING
        if($this->modificandofechayhora == null){
            return "";
        }
        return $this->modificandofechayhora->format('d/m/Y H:i');
    } 
    
    //Devuelve usuario y ultima modificacion si no tiene devuelve la fecha de creación.
    public function getUltimaModificacion(){
        
        $str = "";
        if ($this->UsuarioModifica == null){
            $str = $this->Usuario->getNombre();
        }else{
            $str = $this->UsuarioModifica->getNombre();
        }
        
        if($this->modificandofechayhora == null){
            $str = $str . "(" . $this->getStrFechayhora() . ")";
        }else{
            $str = $str . "(" . $this->getStrFechayhoraModificacion() . ")";
        }
        return $str;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return ExpedienteDocumento
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
     * @return this 
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
     * Set idUsuario
     *
     * @param \AppBundle\Entity\User $Usuario
     * @return this
     */
    public function setUsuario(\AppBundle\Entity\User $Usuario = null)
    {
        $this->Usuario = $Usuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

   /**
     * Set UsuarioModifica
     *
     * @param \AppBundle\Entity\User UsuarioModifica
     * @return this
     */
    public function setUsuarioModifica(\AppBundle\Entity\User $Usuario = null)
    {
        $this->UsuarioModifica = $Usuario;

        return $this;
    }

    /**
     * Get UsuarioModifica
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUsuarioModifica()
    {
        return $this->UsuarioModifica;
    }    
    
    /**
     * Set idEstudio
     *
     * @param \AppBundle\Entity\Estudio $Estudio
     * @return DocumentoVersion
     */
    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

        return $this;
    }

    
    
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }        
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile($file = null)
    {
        $this->file = $file;
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
     * Set Documento
     *
     * @param \AppBundle\Entity\ExpedienteDocumento $Documento
     * @return this
     */
    public function setDocumento(\AppBundle\Entity\ExpedienteDocumento $Documento = null)
    {
        $this->Documento = $Documento;

        return $this;
    }

    /**
     * Get idExpediente
     *
     * @return \AppBundle\Entity\ExpedienteDocumento 
     */
    public function getDocumento()
    {
        return $this->Documento;
    }
    
    /**
     * Set idExpediente
     *
     * @param \AppBundle\Entity\Expediente $Expediente
     * @return DocumentoVersion
     */
    public function setExpediente(\AppBundle\Entity\Expediente $Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }

    /**
     * Get idExpediente
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }
    
     /**
     * Set Filename
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
     * Set status
     *
     * @param boolean $status
     * @return DocumentoVersion
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
     * Get Version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    
    
    /**
     * Set modificando
     *
     * @param integer $modificando
     * @return this
     */
    public function setModificando($modificando)
    {
        $this->modificando = $modificando;

        return $this;
    }

    /**
     * Get modificando
     *
     * @return integer 
     */
    public function getModificando()
    {
        return $this->modificando;
    }
    

    /**
     * Set fechayhora
     *
     * @param datetime $fechayhora
     * @return this
     */
    public function setFechayhora($fechayhora)
    {
        $this->fechayhora = $fechayhora;

        return $this;
    }

    /**
     * Get fechayhora
     *
     * @return datetime 
     */
    public function getFechayhora()
    {
        return $this->fechayhora;
    }    

    
    public function ModificarAhora($usuario){
        $this->setModificando(1);
        $this->setUsuarioModifica($usuario);
        $this->setModificandoFechayhora(new \DateTime());
    }
    


    
    /**
     * Set modificandofechayhora
     *
     * @param datetime $fechayhora
     * @return this
     */
    public function setModificandoFechayhora($fechayhora)
    {
        $this->modificandofechayhora = $fechayhora;

        return $this;
    }

    /**
     * Get modificandofechayhora
     *
     * @return datetime 
     */
    public function getModificandoFechayhora()
    {
        return $this->modificandofechayhora;
    }    
    

    /**
     * Set deletefecha
     *
     * @param datetime $fechayhora
     * @return this
     */
    public function setDeleteFecha($fechayhora)
    {
        $this->deletefecha = $fechayhora;

        return $this;
    }

    /**
     * Get DeleteFecha
     *
     * @return datetime 
     */
    public function getDeleteFecha()
    {
        return $this->deletefecha;
    }    
    
    
    
    
    
    
    
    
    /**
     * SUBIR ARCHIVOS
     */

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
//        if (null !== $this->file && $this->path != "") {
//            // do whatever you want to generate a unique name
//            //$this->path = uniqid().'.'.$this->file->guessExtension();
//         $this->path = $this->getNombre().'.'.$this->file->guessExtension();
//        }

        if($this->getFile()){
//            $this->setFilename($this->getFile()->getClientOriginalName());
            $this->setFilesize($this->getFile()->getSize());
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
{

        if (null === $this->getFile()) {
            return;
        }
        //HACER sacar la logica de archivos fisicos de la entidad
        if(!($this->getPath() === null)){
//            $filename_dest = $this->getId() . ".dat";
//            $this->getFile()->move(
//                $this->getPath(),
//                $filename_dest
//            );
        }
        
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->file == $this->getPath()) {
            unlink($this->file);
        }
    }
    
}

<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;

/**
 * Documento_v
 *
 * @ORM\Table(name="documento_v")
 * @ORM\Entity
  */
class ExpedienteDocumento_v extends LP_Entity
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
     * @var integer
     *
     * @ORM\Column(name="modificando", type="integer", nullable=false)
     */
    private $modificando;

     /**
     * @var date
     *
     * @ORM\Column(name="creacion_fechayhora", type="datetime", nullable=true)
     */
    private $fechayhora;
    
    
    /**
     * @var date
     *
     * @ORM\Column(name="modificando_fechayhora", type="datetime", nullable=true)
     */
    private $modificandofechayhora;    

        
    private $path="";
    /***************************************************************************/    
    /* VIRTUALES PARA LA VISTA O PARA LA OPERATORIA */
    /***************************************************************************/
    
    /**
     * @var date
     *
     * @ORM\Column(name="usuario_nombre", type="string", nullable=true)
     */
    private $usuarionombre;      

    /*
     * @ORM\Column(type="string")
     */    
    private $creado;
    
    /**
     * Get usuarioNombre
     *
     * @return string 
     */
    public function getUsuarionombre()
    {
        return $this->usuarionombre;
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
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
     * Set modificando
     *
     * @param integer $modificando
     * @return this
     */
    public function setModifcando($modificando)
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
     * Get Creado
     *
     * @return string 
     */
    public function getCreado()
    {
        return $this->getUsuarionombre() . '(' . $this->getFechayhora() . ")";
    }
    


    /**
     * Get fechayhora
     *
     * @return string 
     */
    public function getFechayhora()
    {
        // LO RETORNO EN STRING
        if($this->fechayhora == null){
            return "";
        }
        return $this->fechayhora->format('d-m-Y H:i:s');
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

}

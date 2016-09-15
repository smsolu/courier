<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;

// ATENCION: PARA QUE FUNCIONE SE TIENE QUE DESCOMENTAR ESTA LINEA EN PHP.INI
// extension=php_fileinfo.dll

/**
 * ExpedienteDocumento
 *
 * @ORM\Table(name="expediente_documento", indexes={@ORM\Index(name="fk_expedientedocumento_expediente", columns={"id_expediente"}), @ORM\Index(name="fk_expedientedocumento_estudio", columns={"id_estudio"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ExpedienteDocumento extends LP_Entity
{
    const VERSION_INICIAL_INTEGER = 0;
    const VERSION_INICIAL_STRING = "Version inicial";
    const MODIFICANDO_NO_MODIFICANDO = 0;
    const MODIFICANDO_MODIFICANDO = 1;
    
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
     * @ORM\Column(name="maxversion", type="integer", nullable=false)
     */
    private $maxversion;      
    
    
    //private $creado;
    
    
    private $file;
    
 /**
     * Get Creado
     *
     * @return string 
     */
    public function getCreado()
    {
        //return "jaja";
        return $this->Usuario->getUsername() . '(' . $this->getStrFechayhora() . ")";
    }
    
    

    /**
     * Get fechayhora
     *
     * @return string 
     */
    public function getStrFechayhora()
    {
        // LO RETORNO EN STRING
        if($this->fechayhora == null){
            return "";
        }
        return $this->fechayhora->format('d/m/Y H:i');
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
     * Get maxversion
     *
     * @return integer 
     */
    public function getMaxVersion()
    {
        return $this->maxversion;
    }
    
    /**
     * Set maxversion
     *
     * @param string $maxversion
     * @return this
     */
    public function setMaxVersion($maxversion)
    {
        $this->maxversion = $maxversion;

        return $this;
    }

    /**
     * Get cantversiones
     *
     * @return Integer 
     */
    public function getCantVersiones()
    {
        return $this->cantversiones;
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
     * Set idUsuario
     *
     * @param \AppBundle\Entity\User $Usuario
     * @return this
     */
    public function setUsuarioModifica(\AppBundle\Entity\User $Usuario = null)
    {
        $this->UsuarioModifica = $Usuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUsuarioModifica()
    {
        return $this->UsuarioModifica;
    }
    
    
    /**
     * Set Estudio
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
    
    
    public function ModificarAhora($usuario){
        $this->setModificando(self::MODIFICANDO_MODIFICANDO);
        $this->setUsuarioModifica($usuario);
        $this->setModificandoFechayhora(new \DateTime());
    }
    
    //Devuelve la última versión 
    public function getLastVersion($em){
        //$em = $this->getDoctrine()->getEntityManager();
//        $query = $em->createQueryBuilder('s');
//        $query->select('s, MAX(s.version) AS max_score');
//        $query->where('s.status = 0 and documento=:documento')->setParameter('challenge', $challenge);
//        $query->groupBy('s.user');
//        $query->setMaxResults($limit);
//        $query->orderBy('max_score', 'DESC');
//        $query->setParameter("documento"=>$documento);
//
//    return $query->getQuery()->getResult();        
//        $query = $em->createQuery("select max(version) as 'maxversion' from ExpedienteDocumentoFile");
//        $result = $query->setMaxResults(1)->getOneOrNullResult();
//        //$result= $query->getResult();
//        
//        return result;
    }
    function getFile() {
        return $this->file;
    }
    
    function setFile($file) {
        $this->file = $file;
        return $this;
    }
    function strModificando(){
        if($this->modificando == 0){
            return "Nadie esta trabajando";
        }else{
            //('Y-m-d H:i') 
            return "Modificandolo por ".$this->UsuarioModifica->getUsername()." desde ".date_format($this->modificandofechayhora, 'Y-m-d H:i');
            
        }
    }


}

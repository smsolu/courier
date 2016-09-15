<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LP_Entity;
/**
 * UsuarioExpediente
 *
 * @ORM\Table(name="usuario_expediente")
 * @ORM\Entity
 */
class UsuarioExpediente extends LP_Entity
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
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente", referencedColumnName="id")
     * })
     */
    private $Expediente;
    
    
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $Usuario;    
    
    /**
     * @var date
     *
     * @ORM\Column(name="fecha_ultimoingreso", type="datetime", nullable=true)
     */
    private $fechaultimoingreso;      

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
     * Set Estudio
     *
     * @param \AppBundle\Entity\Estudio $Estudio
     * @return ExpedienteINterviniente
     */
    public function setEstudio(\AppBundle\Entity\Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

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
    
    /**
     * Set Expediente
     *
     * @param \AppBundle\Entity\Expediente $Expediente
     * @return ExpedienteINterviniente
     */
    public function setExpediente(\AppBundle\Entity\Expediente $Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }
    
   /**
     * Get Expediente
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }
        

    /**
     * Get User
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }


    
    /**
     * Set Usuario
     *
     * @param \AppBundle\Entity\User 
     * @return this
     */
    public function setUsuario(\AppBundle\Entity\User $usuario = null)
    {
        $this->Usuario = $usuario;

        return $this;
    }
    
    public function getFechaultimoingreso() {
        return $this->fechaultimoingreso;
    }

    public function setFechaultimoingreso($fechaultimoingreso) {
        $this->fechaultimoingreso = $fechaultimoingreso;
    }
    
    public function getExpedienteid()
    {
        return $this->Expediente->getId();
    }
}

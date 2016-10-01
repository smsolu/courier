<?php

namespace AppBundle\Entity;

use AppBundle\Entity\LP_Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * ExpedienteIntervinientes
 *
 * @ORM\Table(name="expediente_tipodeproceso")
 * @ORM\Entity
 */
class ExpedienteTipoProceso extends LP_Entity
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
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = self::STATUS_NO_DELETED;


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
     * @var \TipoProceso
     *
     * @ORM\ManyToOne(targetEntity="TipoProceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipoproceso", referencedColumnName="id")
     * })
     */
    private $TipoProceso;    
    
    
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
     * @param Estudio $Estudio
     * @return ExpedienteINterviniente
     */
    public function setEstudio(Estudio $Estudio = null)
    {
        $this->Estudio = $Estudio;

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
    
    /**
     * Set Expediente
     *
     * @param Expediente $Expediente
     * @return this
     */
    public function setExpediente(Expediente $Expediente = null)
    {
        $this->Expediente = $Expediente;

        return $this;
    }

    /**
     * Get Expediente
     *
     * @return Expediente 
     */
    public function getExpediente()
    {
        return $this->Expediente;
    }

    /**
     * Set TipoProceso
     *
     * @param TipoProceso $TipoProceso
     * @return this
     */
    public function setTipoProceso(TipoProceso $TipoProceso = null)
    {
        $this->TipoProceso = $TipoProceso;

        return $this;
    }

    /**
     * Get TipoProceso
     *
     * @return TipoProceso 
     */
    public function getTipoProceso()
    {
        return $this->TipoProceso;
    }    
    
    public function getExpedienteId(){
        return $this->Expediente->getId();
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
    public function getNombreProceso(){
        return $this->TipoProceso->getNombre();
    }
    
}

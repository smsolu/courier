<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\User;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\CourierEntity;
/**
 * Estudio
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity
 */
class Empresa extends CourierEntity
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status;
    
   
     /**
     * @var User
     * 
     * @ORM\OneToMany(targetEntity="User", mappedBy="estudio")
     */
    protected $usuarios;

    
    
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->status = 0;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function addUsuario(User $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    public function removeUsuario(User $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    public function getUsuarios()
    {
        return $this->usuarios;
    }

}

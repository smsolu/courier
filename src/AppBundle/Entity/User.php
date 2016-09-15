<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Estudio;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var Integer
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @var Estudio
      * 
     * @ORM\ManyToOne(targetEntity="Estudio", inversedBy="usuarios", cascade={"persist"})
     * @ORM\JoinColumn(name="estudio_id", referencedColumnName="id")
     */
    protected $estudio;

    /**
     * @var Group
     * 
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="fos_user_fos_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEstudio( Estudio $estudio = null)
    {
        $this->estudio = $estudio;
        return $this;
    }

    public function getEstudio()
    {
        return $this->estudio;
    }
    public function getRoles($allRoles= true){
        if($allRoles){
            return parent::getRoles();
        }
        return $this->roles;
    }
    
    public function getNombre(){
        return $this->getUsername();
    }
}

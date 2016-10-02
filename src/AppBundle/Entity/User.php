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
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="usuarios", cascade={"persist"})
     * @ORM\JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    protected $empresa;

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

    public function setEmpresa( Empresa $empresa = null)
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function getEmpresa()
    {
        return $this->empresa;
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

<?php
namespace AppBundle\Services;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Manager {
    
    protected $estudio;
    protected $user;
    protected $em;
    protected $list;
    
    public function __construct($entityManager,  TokenStorage $tokenStorage/*, $list*/) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
//        HACER: inyectar el listview
//        $this->list = $list;
    }
    public function getList($queryBuilder, $list){
        $list->setQueryBuilder($queryBuilder);
        return $list;
    }
}

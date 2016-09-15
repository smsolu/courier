<?php
namespace LegalPro\Bundles\CommonBundle\Services\ExpedienteManager;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use LegalPro\Bundles\CommonBundle\Entity\Expediente;
class ExpedienteManager {
    
    private $estudio;
    private $user;
    private $em;
    
    public function __construct($entityManager,  TokenStorage $tokenStorage) {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->estudio = $this->user->getEstudio();
        $this->em = $entityManager;
    }
    
    /**
     * Guarda el estado del ultimo ingreso del expediente
     * Si esta favorito, esta fecha se utiliza para ordenar los favoritos, para
     * que el usuario pueda ver los ultimos expedientes visitados.
     * @param type $expediente
     */
    public function DefinirUltimoIngresoExpediente(Expediente $expediente){
        $repoUsuarioExpediente = $repo = $this->em->getRepository('CommonBundle:UsuarioExpediente');
        $usuarioExpediente = $repoUsuarioExpediente->findOneBy(
             array('Estudio'=> $this->estudio,'Usuario' => $this->user, 
                   "Expediente"=>$expediente) 
        );
        if($usuarioExpediente){
           $usuarioExpediente->setFechaultimoingreso(new \DateTime());
           $this->em->persist($usuarioExpediente);
           $this->em->flush();
        }
        
    }
}

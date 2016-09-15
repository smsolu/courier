<?php
namespace UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Router;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }
    public function onRegistrationSuccess(FormEvent $event)
    {
        $rolesArr = array('ROLE_ADMINISTRADOR_ESTUDIO');     
        $user = $event->getForm()->getData();
        $user->setRoles($rolesArr);
//        $user->setUsername($user->getEmail());
    }
}
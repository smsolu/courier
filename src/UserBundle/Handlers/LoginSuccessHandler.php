<?php
namespace UserBundle\Handlers;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
//use Symfony\Component\Security\Core\SecurityContext;
//use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface{
    protected $router;
    protected $security;

    public function __construct(AuthorizationChecker $security, Router $router){
            $this->router = $router;
            $this->security = $security;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token){

            if ($this->security->isGranted('ROLE_ADMINISTRADOR_SIN_ESTUDIO'))
            {
                    $response = new RedirectResponse($this->router->generate('estudio_new'));			
            }
            elseif ($this->security->isGranted('ROLE_ADMINISTRADOR_ESTUDIO'))
            {
                    $response = new RedirectResponse($this->router->generate('user_list'));
            } 
            elseif ($this->security->isGranted('ROLE_USER'))
            {
                    // redirect the user to where they were before the login process begun.
                    $referer_url = $request->headers->get('referer');

                    $response = new RedirectResponse($referer_url);
            }

            return $response;
    }
}

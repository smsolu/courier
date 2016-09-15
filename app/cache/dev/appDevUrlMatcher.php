<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        if (0 === strpos($pathinfo, '/cc')) {
            // cc_reset
            if ($pathinfo === '/cc/reset') {
                return array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::resetAction',  '_route' => 'cc_reset',);
            }

            if (0 === strpos($pathinfo, '/cc/c')) {
                // cc_cobro_delete
                if (0 === strpos($pathinfo, '/cc/cc_cobro_delete') && preg_match('#^/cc/cc_cobro_delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'cc_cobro_delete')), array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::deleteCobroAction',));
                }

                // cc_creardeuda
                if ($pathinfo === '/cc/creardeuda') {
                    return array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::indexAction',  '_route' => 'cc_creardeuda',);
                }

            }

            // cc_list
            if (0 === strpos($pathinfo, '/cc/list') && preg_match('#^/cc/list/(?P<mensaje>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cc_list')), array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::listAction',));
            }

            // cc_crearcobro
            if ($pathinfo === '/cc/crearcobro') {
                return array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::crearCobroAction',  '_route' => 'cc_crearcobro',);
            }

            // cc_autoasignarmpa
            if (0 === strpos($pathinfo, '/cc/AutoAsignarMPA') && preg_match('#^/cc/AutoAsignarMPA/(?P<algoritmo>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cc_autoasignarmpa')), array (  '_controller' => 'ContabilidadBundle\\Controller\\DefaultController::AutoAsignarMPAAction',));
            }

            // cc_test_list
            if ($pathinfo === '/cc/test') {
                return array (  '_controller' => 'ContabilidadBundle\\Controller\\TestController::testListAction',  '_route' => 'cc_test_list',);
            }

            if (0 === strpos($pathinfo, '/cc/cc_')) {
                // cc_deuda_delete
                if (0 === strpos($pathinfo, '/cc/cc_deuda_delete') && preg_match('#^/cc/cc_deuda_delete/(?P<deudaid>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'cc_deuda_delete')), array (  '_controller' => 'ContabilidadBundle\\Controller\\TestController::deleteDeudaAction',));
                }

                // cc_clear
                if (0 === strpos($pathinfo, '/cc/cc_clear') && preg_match('#^/cc/cc_clear/(?P<logical>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'cc_clear')), array (  '_controller' => 'ContabilidadBundle\\Controller\\TestController::clearAction',));
                }

            }

        }

        // abm_default_index
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'abm_default_index');
            }

            return array (  '_controller' => 'ABMBundle\\Controller\\DefaultController::indexAction',  '_route' => 'abm_default_index',);
        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        if (0 === strpos($pathinfo, '/group')) {
            // fos_user_group_list
            if ($pathinfo === '/group/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_list;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::listAction',  '_route' => 'fos_user_group_list',);
            }
            not_fos_user_group_list:

            // fos_user_group_new
            if ($pathinfo === '/group/new') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_group_new;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::newAction',  '_route' => 'fos_user_group_new',);
            }
            not_fos_user_group_new:

            // fos_user_group_show
            if (preg_match('#^/group/(?P<groupName>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_show;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_show')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::showAction',));
            }
            not_fos_user_group_show:

            // fos_user_group_edit
            if (preg_match('#^/group/(?P<groupName>[^/]++)/edit$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_group_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_edit')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::editAction',));
            }
            not_fos_user_group_edit:

            // fos_user_group_delete
            if (preg_match('#^/group/(?P<groupName>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_delete')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::deleteAction',));
            }
            not_fos_user_group_delete:

        }

        if (0 === strpos($pathinfo, '/app/user')) {
            // user_add-group
            if (preg_match('#^/app/user/(?P<id>[^/]++)/add\\-group$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_add-group')), array (  '_controller' => 'UserBundle\\Controller\\UserController::userAddGroupAction',));
            }

            // user_remove-group
            if (preg_match('#^/app/user/(?P<id>[^/]++)/remove\\-group/(?P<idGroup>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_remove-group')), array (  '_controller' => 'UserBundle\\Controller\\UserController::userRemoveGroupAction',));
            }

            // user_list
            if (0 === strpos($pathinfo, '/app/user/list') && preg_match('#^/app/user/list(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_list')), array (  'page' => 1,  '_controller' => 'UserBundle\\Controller\\UserController::listAction',));
            }

            // user_show_groups
            if (preg_match('#^/app/user/(?P<id>[^/]++)/show/grupos$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_show_groups')), array (  '_controller' => 'UserBundle\\Controller\\UserController::userShowGroupsAction',));
            }

            // user_show
            if (preg_match('#^/app/user/(?P<id>[^/]++)/show(?:/(?P<section>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_show')), array (  'section' => 'general',  '_controller' => 'UserBundle\\Controller\\UserController::showAction',));
            }

            // user_new
            if ($pathinfo === '/app/user/new') {
                return array (  '_controller' => 'UserBundle\\Controller\\UserController::newAction',  '_route' => 'user_new',);
            }

        }

        if (0 === strpos($pathinfo, '/contabilidad/tipocuenta')) {
            // contabilidad_tipocuentas_new
            if ($pathinfo === '/contabilidad/tipocuenta/new') {
                return array (  '_controller' => 'AppBundle\\Controller\\Contabilidad\\TipoCuentaContableController::newAction',  '_route' => 'contabilidad_tipocuentas_new',);
            }

            // contabilidad_tipocuentas_edit
            if (0 === strpos($pathinfo, '/contabilidad/tipocuenta/edit') && preg_match('#^/contabilidad/tipocuenta/edit/(?P<tipoCuentaContable>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'contabilidad_tipocuentas_edit')), array (  '_controller' => 'AppBundle\\Controller\\Contabilidad\\TipoCuentaContableController::editAction',));
            }

            // contabilidad_tipocuentas_undodelete
            if (0 === strpos($pathinfo, '/contabilidad/tipocuenta/undo_delete') && preg_match('#^/contabilidad/tipocuenta/undo_delete/(?P<tipoCuentaContable>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'contabilidad_tipocuentas_undodelete')), array (  '_controller' => 'AppBundle\\Controller\\Contabilidad\\TipoCuentaContableController::undodeleteAction',));
            }

            // contabilidad_tipocuentas_delete
            if (0 === strpos($pathinfo, '/contabilidad/tipocuenta/delete') && preg_match('#^/contabilidad/tipocuenta/delete/(?P<tipoCuentaContable>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'contabilidad_tipocuentas_delete')), array (  '_controller' => 'AppBundle\\Controller\\Contabilidad\\TipoCuentaContableController::deleteAction',));
            }

            // contabilidad_tipocuentas_list
            if (0 === strpos($pathinfo, '/contabilidad/tipocuenta/list') && preg_match('#^/contabilidad/tipocuenta/list(?:/(?P<page>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'contabilidad_tipocuentas_list')), array (  'page' => '1',  'resultpage' => '10',  'order_col' => '',  'order_status' => '0',  '_controller' => 'AppBundle\\Controller\\Contabilidad\\TipoCuentaContableController::listAction',));
            }

        }

        // default_page
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'default_page');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'default_page',);
        }

        if (0 === strpos($pathinfo, '/e')) {
            if (0 === strpos($pathinfo, '/estudio')) {
                // estudio_edit
                if (0 === strpos($pathinfo, '/estudio/edit') && preg_match('#^/estudio/edit(?:/(?P<section>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'estudio_edit')), array (  'section' => 'General',  '_controller' => 'AppBundle\\Controller\\EstudioController::editAction',));
                }

                if (0 === strpos($pathinfo, '/estudio/show')) {
                    // estudio_cuenta
                    if ($pathinfo === '/estudio/show/cuenta') {
                        return array (  'section' => 'cuenta',  '_controller' => 'AppBundle\\Controller\\EstudioController::cuentaAction',  '_route' => 'estudio_cuenta',);
                    }

                    // estudio_show
                    if (preg_match('#^/estudio/show(?:/(?P<section>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'estudio_show')), array (  'section' => 'general',  '_controller' => 'AppBundle\\Controller\\EstudioController::showAction',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/expediente')) {
                // expediente_actuaciones_delete
                if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/actuaciones/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_actuaciones_delete')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ActuacionController::deleteAction',));
                }

                // expediente_actuaciones_edit
                if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/actuaciones/edit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_actuaciones_edit')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ActuacionController::editAction',));
                }

                // expediente_actuaciones_show
                if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/actuaciones/show/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_actuaciones_show')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ActuacionController::showAction',));
                }

                // expediente_actuaciones_new
                if (preg_match('#^/expediente/(?P<id>[^/]++)/actuaciones/new$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_actuaciones_new')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ActuacionController::newAction',));
                }

                // expediente_actuaciones_list
                if (preg_match('#^/expediente/(?P<id>[^/]++)/actuaciones/list(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_actuaciones_list')), array (  'page' => 1,  'resultpage' => 10,  'order_col' => 'descripcion',  'order_status' => 1,  'id' => -1,  '_controller' => 'AppBundle\\Controller\\Expediente\\ActuacionController::listAction',));
                }

                // expediente_cc_new
                if (preg_match('#^/expediente/(?P<expediente>[^/]++)/cc/new(?:/(?P<tipo>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_cc_new')), array (  'tipo' => 'gasto',  '_controller' => 'AppBundle\\Controller\\Expediente\\CuentaCorrienteController::newAction',));
                }

                // expediente_cc_list
                if (preg_match('#^/expediente/(?P<expediente>[^/]++)/cc/list(?:/(?P<fecha_desde>[^/]++)(?:/(?P<fecha_hasta>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?)?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_cc_list')), array (  'fecha_desde' => '',  'fecha_hasta' => '',  'page' => '1',  'resultpage' => '10',  'order_col' => '',  'order_status' => '0',  '_controller' => 'AppBundle\\Controller\\Expediente\\CuentaCorrienteController::listAction',));
                }

            }

        }

        if (0 === strpos($pathinfo, '/documento')) {
            // documento_list
            if (0 === strpos($pathinfo, '/documento/list') && preg_match('#^/documento/list/(?P<expediente>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_list')), array (  'page' => 1,  'resultpage' => 10,  'order_col' => 'Expediente',  'order_status' => 1,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::listAction',));
            }

            // documento_version_list
            if (0 === strpos($pathinfo, '/documento/versiones') && preg_match('#^/documento/versiones/(?P<id>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++)(?:/(?P<resultpage>[^/]++))?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_version_list')), array (  'page' => 1,  'resultpage' => 10,  'order_col' => 'Version',  'order_status' => 1,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::versionListAction',));
            }

            // documento_show
            if (0 === strpos($pathinfo, '/documento/show') && preg_match('#^/documento/show/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_show')), array (  'documento' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::showAction',));
            }

            // documento_new
            if (0 === strpos($pathinfo, '/documento/new') && preg_match('#^/documento/new/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_new')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::newAction',));
            }

            // documento_edit
            if (0 === strpos($pathinfo, '/documento/edit') && preg_match('#^/documento/edit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_edit')), array (  'documento' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::editAction',));
            }

            // documento_lock
            if (0 === strpos($pathinfo, '/documento/lock') && preg_match('#^/documento/lock/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_lock')), array (  'documento' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::lockAction',));
            }

            // documento_unlock
            if (0 === strpos($pathinfo, '/documento/unlock') && preg_match('#^/documento/unlock/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_unlock')), array (  'documento' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::unlockAction',));
            }

            // documento_file
            if (0 === strpos($pathinfo, '/documento/file') && preg_match('#^/documento/file/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_file')), array (  'documento' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::fileAction',));
            }

            if (0 === strpos($pathinfo, '/documento/versionFile')) {
                // documento_version_file
                if (preg_match('#^/documento/versionFile/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_version_file')), array (  'documentoVersion' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::versionFileAction',));
                }

                // documento_version_delete
                if (0 === strpos($pathinfo, '/documento/versionFile/delete') && preg_match('#^/documento/versionFile/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'documento_version_delete')), array (  'documentoVersion' => NULL,  '_controller' => 'AppBundle\\Controller\\Expediente\\DocumentoController::versionDeleteAction',));
                }

            }

        }

        if (0 === strpos($pathinfo, '/expediente')) {
            // expediente_abogado_new
            if (preg_match('#^/expediente/(?P<id>[^/]++)/abogados/new$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_abogado_new')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteAbogadoController::newAction',));
            }

            // expediente_abogado_undodelete
            if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/abogados/undo_delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_abogado_undodelete')), array (  'id' => '-1',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteAbogadoController::undodeleteAbogadoExpAction',));
            }

            // expediente_abogado_delete
            if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/abogados/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_abogado_delete')), array (  'id' => '-1',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteAbogadoController::deleteAbogadoExpAction',));
            }

            // expediente_abogados_list
            if (preg_match('#^/expediente/(?P<id>[^/]++)/abogados/list(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++))?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_abogados_list')), array (  'page' => 1,  'resultpage' => 10,  'ope' => 'show',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteAbogadoController::listAction',));
            }

            // expediente_abogado_responsable
            if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/abogados/responsable(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_abogado_responsable')), array (  'id' => '-1',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteAbogadoController::setAbogadoResponsableAction',));
            }

            // expediente_new
            if (rtrim($pathinfo, '/') === '/expediente/new') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'expediente_new');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::newAction',  '_route' => 'expediente_new',);
            }

            // expediente_delete
            if (0 === strpos($pathinfo, '/expediente/delete') && preg_match('#^/expediente/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_delete')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::deleteAction',));
            }

            // expediente_undodelete
            if (0 === strpos($pathinfo, '/expediente/undodelete') && preg_match('#^/expediente/undodelete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_undodelete')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::undodeleteAction',));
            }

            if (0 === strpos($pathinfo, '/expediente/find')) {
                // expediente_findone
                if (0 === strpos($pathinfo, '/expediente/findOne') && preg_match('#^/expediente/findOne/(?P<search>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_findone')), array (  'search_word' => '',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::findoneAction',));
                }

                // expediente_find
                if (rtrim($pathinfo, '/') === '/expediente/find') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'expediente_find');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::findAction',  '_route' => 'expediente_find',);
                }

            }

            // expediente_tipoproceso_delete
            if (0 === strpos($pathinfo, '/expediente/deleteproceso') && preg_match('#^/expediente/deleteproceso(?:/(?P<idExpedienteTipoProc>[^/]++)(?:/(?P<id>[^/]++))?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_tipoproceso_delete')), array (  'idExpedienteTipoProc' => -1,  'id' => -1,  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::tipoProcesoDeleteAction',));
            }

            // expediente_tipodeproceso_showedit
            if (0 === strpos($pathinfo, '/expediente/tipoproceso/edit') && preg_match('#^/expediente/tipoproceso/edit/(?P<id>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++))?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_tipodeproceso_showedit')), array (  'page' => 1,  'resultpage' => 10,  'ope' => 'show',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::tipodeProcesoShowEditAction',));
            }

            // expediente_edit
            if (0 === strpos($pathinfo, '/expediente/edit') && preg_match('#^/expediente/edit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_edit')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::editAction',));
            }

            // expediente_show
            if (0 === strpos($pathinfo, '/expediente/show') && preg_match('#^/expediente/show/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_show')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::showAction',));
            }

            // expediente_list
            if (0 === strpos($pathinfo, '/expediente/list') && preg_match('#^/expediente/list(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_list')), array (  'page' => 1,  'resultpage' => 10,  'order_col' => 'Expediente',  'order_status' => 1,  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::listAction',));
            }

            // expediente_showwidget
            if ($pathinfo === '/expediente/showwidget') {
                return array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteController::showWidgetAction',  '_route' => 'expediente_showwidget',);
            }

            // expedientefavoritos_list
            if (0 === strpos($pathinfo, '/expedientefavoritos/list') && preg_match('#^/expedientefavoritos/list(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expedientefavoritos_list')), array (  'page' => 1,  'resultpage' => 10,  'order_col' => '',  'order_status' => 1,  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteFavoritoController::listExpedienteFavoritoAction',));
            }

        }

        // agenda_widget
        if ($pathinfo === '/Agenda/widget') {
            return array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteFavoritoController::showWidgetAction',  '_route' => 'agenda_widget',);
        }

        if (0 === strpos($pathinfo, '/s')) {
            // set_expediente_favorito
            if (0 === strpos($pathinfo, '/setexpedientefavorito') && preg_match('#^/setexpedientefavorito/(?P<id>[^/]++)(?:/(?P<route>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_expediente_favorito')), array (  'route' => '',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteFavoritoController::setExpedienteFavoritoAction',));
            }

            // expedientefavorito_showmenu
            if ($pathinfo === '/showmenu') {
                return array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteFavoritoController::showMenuAction',  '_route' => 'expedientefavorito_showmenu',);
            }

        }

        if (0 === strpos($pathinfo, '/expediente')) {
            // expediente_intervinientes_new
            if (preg_match('#^/expediente/(?P<id>[^/]++)/intervinientes/new$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_intervinientes_new')), array (  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteIntervinienteController::newAction',));
            }

            // expediente_intervinientes_undodelete
            if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/intervinientes/undo_delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_intervinientes_undodelete')), array (  'id' => '-1',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteIntervinienteController::undodeleteIntervinienteExpAction',));
            }

            // expediente_intervinientes_delete
            if (preg_match('#^/expediente/(?P<expedienteid>[^/]++)/intervinientes/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_intervinientes_delete')), array (  'id' => '-1',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteIntervinienteController::deleteIntervinienteExpAction',));
            }

            // expediente_intervinientes_list
            if (preg_match('#^/expediente/(?P<id>[^/]++)/intervinientes/list(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++))?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'expediente_intervinientes_list')), array (  'page' => 1,  'resultpage' => 10,  'ope' => 'show',  '_controller' => 'AppBundle\\Controller\\Expediente\\ExpedienteIntervinienteController::listAction',));
            }

        }

        if (0 === strpos($pathinfo, '/p')) {
            if (0 === strpos($pathinfo, '/plantilla')) {
                // plantilla_list
                if (0 === strpos($pathinfo, '/plantilla/list') && preg_match('#^/plantilla/list(?:/(?P<id_folder>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<resultpage>[^/]++)(?:/(?P<order_col>[^/]++)(?:/(?P<order_status>[^/]++))?)?)?)?)?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'plantilla_list')), array (  'id_folder' => 0,  'page' => 1,  'resultpage' => 10,  'order_col' => 'tipo',  'order_status' => 1,  '_controller' => 'AppBundle\\Controller\\PlantillaController::listAction',));
                }

                // plantilla_edit
                if (0 === strpos($pathinfo, '/plantilla/edit') && preg_match('#^/plantilla/edit/(?P<id>[^/]++)(?:/(?P<section>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'plantilla_edit')), array (  'section' => 'General',  '_controller' => 'AppBundle\\Controller\\PlantillaController::editAction',));
                }

                // plantilla_show
                if (0 === strpos($pathinfo, '/plantilla/show') && preg_match('#^/plantilla/show/(?P<id>[^/]++)(?:/(?P<section>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'plantilla_show')), array (  'section' => 'General',  '_controller' => 'AppBundle\\Controller\\PlantillaController::showAction',));
                }

                if (0 === strpos($pathinfo, '/plantilla/new')) {
                    // plantilla_new
                    if ($pathinfo === '/plantilla/new') {
                        return array (  '_controller' => 'AppBundle\\Controller\\PlantillaController::newAction',  '_route' => 'plantilla_new',);
                    }

                    // plantilla_newDocument
                    if (0 === strpos($pathinfo, '/plantilla/newDocument') && preg_match('#^/plantilla/newDocument/(?P<id_plantilla>[^/]++)/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'plantilla_newDocument')), array (  '_controller' => 'AppBundle\\Controller\\PlantillaController::newDocumentAction',));
                    }

                }

            }

            // prueba_page
            if ($pathinfo === '/prueba/bla') {
                return array (  '_controller' => 'AppBundle\\Controller\\prueba\\PruebaController::indexAction',  '_route' => 'prueba_page',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}

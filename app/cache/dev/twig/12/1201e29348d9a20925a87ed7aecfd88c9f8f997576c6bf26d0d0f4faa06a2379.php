<?php

/* menu/submenu/usuario.html.twig */
class __TwigTemplate_65cabcd61ead968b9aa8f69c9c19dd5c09be9a95aedd3cc6fed11ca7c1513f74 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_a6b413e7baffba73c755abbe877374eb8ac6847e43c74ef66a28df1a993f3691 = $this->env->getExtension("native_profiler");
        $__internal_a6b413e7baffba73c755abbe877374eb8ac6847e43c74ef66a28df1a993f3691->enter($__internal_a6b413e7baffba73c755abbe877374eb8ac6847e43c74ef66a28df1a993f3691_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/usuario.html.twig"));

        // line 1
        echo "    ";
        // line 2
        echo "    <li class=\"dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
            ";
        // line 4
        if ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array(), "any", false, true), "username", array(), "any", true, true)) {
            echo "    
                <span class=\"glyphicon glyphicon-user\"></span> ";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user", array()), "username", array()), "html", null, true);
            echo "<b class=\"caret\"></b>&nbsp;&nbsp;&nbsp;&nbsp;
            ";
        } else {
            // line 7
            echo "                <span class=\"glyphicon glyphicon-user\"></span>Nuevo Usuario<b class=\"caret\"></b>
            ";
        }
        // line 9
        echo "        </a>
        <ul class=\"dropdown-menu\">
            ";
        // line 11
        if ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array(), "any", false, true), "username", array(), "any", true, true)) {
            echo "    
                <li><a href=\"";
            // line 12
            echo $this->env->getExtension('routing')->getPath("fos_user_profile_show");
            echo "\"><span class=\"glyphicon glyphicon-user\"></span> ";
            echo $this->env->getExtension('translator')->getTranslator()->trans("menu_usuario_micuenta", array(), "messages");
            echo "</a></li>
                <li><a href=\"";
            // line 13
            echo $this->env->getExtension('routing')->getPath("fos_user_change_password");
            echo "\"><span class=\"glyphicon glyphicon-lock\"></span> ";
            echo $this->env->getExtension('translator')->getTranslator()->trans("menu_usuario_cambiarcontrasenia", array(), "messages");
            echo "</a></li>
                <li role=\"presentation\" class=\"divider\"></li>
                <li><a href=\"";
            // line 15
            echo $this->env->getExtension('routing')->getPath("fos_user_security_logout");
            echo "\"><span class=\"glyphicon glyphicon-log-out\"></span> ";
            echo $this->env->getExtension('translator')->getTranslator()->trans("menu_usuario_cerrarsesion", array(), "messages");
            echo "</a></li>
            ";
        } else {
            // line 17
            echo "                
                <li><a href=\"";
            // line 18
            echo $this->env->getExtension('routing')->getPath("fos_user_registration_register");
            echo "\"><span class=\"glyphicon glyphicon-edit\"></span> ";
            echo $this->env->getExtension('translator')->getTranslator()->trans("menu_usuario_registrate", array(), "messages");
            echo "</a></li>
                <li><a href=\"";
            // line 19
            echo $this->env->getExtension('routing')->getPath("fos_user_security_login");
            echo "\"><span class=\"glyphicon glyphicon-log-in\"></span> ";
            echo $this->env->getExtension('translator')->getTranslator()->trans("menu_usuario_iniciarsesion", array(), "messages");
            echo "</a></li>
            ";
        }
        // line 21
        echo "        </ul>
    </li>    
    ";
        
        $__internal_a6b413e7baffba73c755abbe877374eb8ac6847e43c74ef66a28df1a993f3691->leave($__internal_a6b413e7baffba73c755abbe877374eb8ac6847e43c74ef66a28df1a993f3691_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/usuario.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 21,  78 => 19,  72 => 18,  69 => 17,  62 => 15,  55 => 13,  49 => 12,  45 => 11,  41 => 9,  37 => 7,  32 => 5,  28 => 4,  24 => 2,  22 => 1,);
    }
}
/*     {#USUARIO#}*/
/*     <li class="dropdown">*/
/*         <a href="#" class="dropdown-toggle" data-toggle="dropdown">*/
/*             {% if app.user.username is defined %}    */
/*                 <span class="glyphicon glyphicon-user"></span> {{ app.user.username  }}<b class="caret"></b>&nbsp;&nbsp;&nbsp;&nbsp;*/
/*             {%else%}*/
/*                 <span class="glyphicon glyphicon-user"></span>Nuevo Usuario<b class="caret"></b>*/
/*             {%endif%}*/
/*         </a>*/
/*         <ul class="dropdown-menu">*/
/*             {% if app.user.username is defined %}    */
/*                 <li><a href="{{path("fos_user_profile_show")}}"><span class="glyphicon glyphicon-user"></span> {%trans%}menu_usuario_micuenta{%endtrans%}</a></li>*/
/*                 <li><a href="{{path("fos_user_change_password")}}"><span class="glyphicon glyphicon-lock"></span> {%trans%}menu_usuario_cambiarcontrasenia{%endtrans%}</a></li>*/
/*                 <li role="presentation" class="divider"></li>*/
/*                 <li><a href="{{path("fos_user_security_logout")}}"><span class="glyphicon glyphicon-log-out"></span> {%trans%}menu_usuario_cerrarsesion{%endtrans%}</a></li>*/
/*             {%else%}*/
/*                 */
/*                 <li><a href="{{path("fos_user_registration_register")}}"><span class="glyphicon glyphicon-edit"></span> {%trans%}menu_usuario_registrate{%endtrans%}</a></li>*/
/*                 <li><a href="{{path("fos_user_security_login")}}"><span class="glyphicon glyphicon-log-in"></span> {%trans%}menu_usuario_iniciarsesion{%endtrans%}</a></li>*/
/*             {%endif%}*/
/*         </ul>*/
/*     </li>    */
/*     */

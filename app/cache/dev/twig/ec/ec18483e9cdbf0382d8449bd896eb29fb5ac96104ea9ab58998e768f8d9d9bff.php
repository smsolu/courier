<?php

/* :menu:menu.html.twig */
class __TwigTemplate_8e53ce2441a220039841b50a003c199e589760dc5f6c5b2cad36cb42a0b6cfd8 extends Twig_Template
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
        $__internal_d7eb177a3a23e8ce941f751dfbafbe754e5be9194ebfacee0d20e4e2a6503cd8 = $this->env->getExtension("native_profiler");
        $__internal_d7eb177a3a23e8ce941f751dfbafbe754e5be9194ebfacee0d20e4e2a6503cd8->enter($__internal_d7eb177a3a23e8ce941f751dfbafbe754e5be9194ebfacee0d20e4e2a6503cd8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":menu:menu.html.twig"));

        // line 1
        echo "<header class=\"navbar navbar-default navbar-fixed-top\">          
    ";
        // line 3
        echo "    ";
        $this->loadTemplate("menu/submenu/titulo.html.twig", ":menu:menu.html.twig", 3)->display($context);
        // line 4
        echo "    <div class=\"collapse navbar-collapse navbar-ex1-collapse\">
        ";
        // line 5
        if ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array(), "any", false, true), "username", array(), "any", true, true)) {
            echo "        
            <ul class=\"nav navbar-nav\">

                ";
            // line 9
            echo "                ";
            $this->loadTemplate("menu/submenu/caso.html.twig", ":menu:menu.html.twig", 9)->display($context);
            // line 10
            echo "
                ";
            // line 12
            echo "                ";
            $this->loadTemplate("menu/submenu/entidad.html.twig", ":menu:menu.html.twig", 12)->display($context);
            // line 13
            echo "
                ";
            // line 15
            echo "                ";
            $this->loadTemplate("menu/submenu/agenda.html.twig", ":menu:menu.html.twig", 15)->display($context);
            echo " 

                ";
            // line 18
            echo "                ";
            $this->loadTemplate("menu/submenu/contabilidad.html.twig", ":menu:menu.html.twig", 18)->display($context);
            echo "                 
                
            </ul>  

            <ul class=\"nav navbar-nav navbar-right pull-right\">

                ";
            // line 25
            echo "                ";
            $this->loadTemplate("menu/submenu/favorito.html.twig", ":menu:menu.html.twig", 25)->display($context);
            echo "                 
                
                ";
            // line 28
            echo "                ";
            $this->loadTemplate("menu/submenu/alerta.html.twig", ":menu:menu.html.twig", 28)->display($context);
            echo " 
                
                ";
            // line 31
            echo "                ";
            $this->loadTemplate("menu/submenu/buscar.html.twig", ":menu:menu.html.twig", 31)->display($context);
            echo " 

                ";
            // line 34
            echo "                ";
            $this->loadTemplate("menu/submenu/estudio.html.twig", ":menu:menu.html.twig", 34)->display($context);
            echo "  
                
                ";
            // line 37
            echo "                ";
            $this->loadTemplate("menu/submenu/usuario.html.twig", ":menu:menu.html.twig", 37)->display($context);
            // line 38
            echo "
            </ul>
        ";
        } else {
            // line 41
            echo "            <ul class=\"nav navbar-nav\">
                ";
            // line 42
            $this->loadTemplate("menu/submenu/usuario.html.twig", ":menu:menu.html.twig", 42)->display($context);
            // line 43
            echo "            </ul>
        ";
        }
        // line 45
        echo "    </div>
    
        
    ";
        // line 49
        echo "    ";
        // line 50
        echo "    ";
        // line 51
        echo "</header>          
";
        
        $__internal_d7eb177a3a23e8ce941f751dfbafbe754e5be9194ebfacee0d20e4e2a6503cd8->leave($__internal_d7eb177a3a23e8ce941f751dfbafbe754e5be9194ebfacee0d20e4e2a6503cd8_prof);

    }

    public function getTemplateName()
    {
        return ":menu:menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 51,  113 => 50,  111 => 49,  106 => 45,  102 => 43,  100 => 42,  97 => 41,  92 => 38,  89 => 37,  83 => 34,  77 => 31,  71 => 28,  65 => 25,  55 => 18,  49 => 15,  46 => 13,  43 => 12,  40 => 10,  37 => 9,  31 => 5,  28 => 4,  25 => 3,  22 => 1,);
    }
}
/* <header class="navbar navbar-default navbar-fixed-top">          */
/*     {# TITULO #}*/
/*     {% include 'menu/submenu/titulo.html.twig' %}*/
/*     <div class="collapse navbar-collapse navbar-ex1-collapse">*/
/*         {% if app.user.username is defined %}        */
/*             <ul class="nav navbar-nav">*/
/* */
/*                 {#CASOS#}*/
/*                 {% include 'menu/submenu/caso.html.twig' %}*/
/* */
/*                 {#ENTIDADES#}*/
/*                 {% include 'menu/submenu/entidad.html.twig' %}*/
/* */
/*                 {#AGENDA#}*/
/*                 {% include 'menu/submenu/agenda.html.twig' %} */
/* */
/*                 {#CONTABILIDAD#}*/
/*                 {% include 'menu/submenu/contabilidad.html.twig' %}                 */
/*                 */
/*             </ul>  */
/* */
/*             <ul class="nav navbar-nav navbar-right pull-right">*/
/* */
/*                 {# EXPEDIENTES FAVORITOS #}*/
/*                 {% include 'menu/submenu/favorito.html.twig' %}                 */
/*                 */
/*                 {# ALERTAS #}*/
/*                 {% include 'menu/submenu/alerta.html.twig' %} */
/*                 */
/*                 {# BUSCAR #}*/
/*                 {% include 'menu/submenu/buscar.html.twig' %} */
/* */
/*                 {# ESTUDIO #}*/
/*                 {% include 'menu/submenu/estudio.html.twig' %}  */
/*                 */
/*                 {# USUARIO #}*/
/*                 {% include 'menu/submenu/usuario.html.twig' %}*/
/* */
/*             </ul>*/
/*         {%else%}*/
/*             <ul class="nav navbar-nav">*/
/*                 {% include 'menu/submenu/usuario.html.twig' %}*/
/*             </ul>*/
/*         {%endif%}*/
/*     </div>*/
/*     */
/*         */
/*     {#    {% include 'nav/sections/alerts_nav.html.twig' %}#}*/
/*     {#    {% include 'nav/sections/favorites_nav.html.twig' %} #}*/
/*     {#    {% include 'nav/sections/find_nav.html.twig' %}#}*/
/* </header>          */
/* */

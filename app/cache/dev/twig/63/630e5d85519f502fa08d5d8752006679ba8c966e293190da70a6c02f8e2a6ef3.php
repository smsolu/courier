<?php

/* menu/submenu/caso.html.twig */
class __TwigTemplate_753c4b0435eea5e497cb2f0a368851746392a2d39f9b636f81b3a1c76e476a10 extends Twig_Template
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
        $__internal_4e2bf5f081109246873c84b4b9e20851f8f9103d840d1e4a8f2963c8e9a843f7 = $this->env->getExtension("native_profiler");
        $__internal_4e2bf5f081109246873c84b4b9e20851f8f9103d840d1e4a8f2963c8e9a843f7->enter($__internal_4e2bf5f081109246873c84b4b9e20851f8f9103d840d1e4a8f2963c8e9a843f7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/caso.html.twig"));

        // line 2
        echo "
<li><a href=\"";
        // line 3
        echo $this->env->getExtension('routing')->getPath("expediente_list");
        echo "\"><span class=\"glyphicon glyphicon-file\"></span>";
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_expediente", array(), "messages");
        echo "</a></li>";
        
        $__internal_4e2bf5f081109246873c84b4b9e20851f8f9103d840d1e4a8f2963c8e9a843f7->leave($__internal_4e2bf5f081109246873c84b4b9e20851f8f9103d840d1e4a8f2963c8e9a843f7_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/caso.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 3,  22 => 2,);
    }
}
/* {#  CASOS   #}*/
/* */
/* <li><a href="{{path("expediente_list")}}"><span class="glyphicon glyphicon-file"></span>{%trans%}menu_expediente{%endtrans%}</a></li>*/

<?php

/* menu/submenu/estudio.html.twig */
class __TwigTemplate_12f667a2e0f73c81b1b5a6c792f6a5b8bf4a7c8c77c9b4f5c6cf1c663237c3b1 extends Twig_Template
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
        $__internal_4fb29ea2fd9a530d496519577f1cfc067190f99973e0f0c41cc8b92d8672aa2a = $this->env->getExtension("native_profiler");
        $__internal_4fb29ea2fd9a530d496519577f1cfc067190f99973e0f0c41cc8b92d8672aa2a->enter($__internal_4fb29ea2fd9a530d496519577f1cfc067190f99973e0f0c41cc8b92d8672aa2a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/estudio.html.twig"));

        // line 1
        echo "    ";
        // line 2
        echo "    <li class=\"dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
            <span class=\"glyphicon glyphicon-education\"></span> ";
        // line 4
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_estudio", array(), "messages");
        echo "<b class=\"caret\"></b>
        </a>
        <ul class=\"dropdown-menu\">
            <li><a href=\"";
        // line 7
        echo $this->env->getExtension('routing')->getPath("estudio_cuenta");
        echo "\">Cuenta</a></li>
            <li role=\"presentation\" class=\"divider\"></li>
            <li><a href=\"";
        // line 9
        echo $this->env->getExtension('routing')->getPath("estudio_show");
        echo "\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_estudio_datosestudio", array(), "messages");
        echo "</a></li>
            <li><a href=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("user_list");
        echo "\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_estudio_usuario", array(), "messages");
        echo "</a></li>
        </ul>
    </li>

";
        
        $__internal_4fb29ea2fd9a530d496519577f1cfc067190f99973e0f0c41cc8b92d8672aa2a->leave($__internal_4fb29ea2fd9a530d496519577f1cfc067190f99973e0f0c41cc8b92d8672aa2a_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/estudio.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 10,  39 => 9,  34 => 7,  28 => 4,  24 => 2,  22 => 1,);
    }
}
/*     {# ESTUDIO    #}*/
/*     <li class="dropdown">*/
/*         <a href="#" class="dropdown-toggle" data-toggle="dropdown">*/
/*             <span class="glyphicon glyphicon-education"></span> {%trans%}menu_estudio{%endtrans%}<b class="caret"></b>*/
/*         </a>*/
/*         <ul class="dropdown-menu">*/
/*             <li><a href="{{path("estudio_cuenta")}}">Cuenta</a></li>*/
/*             <li role="presentation" class="divider"></li>*/
/*             <li><a href="{{path("estudio_show")}}">{%trans%}menu_estudio_datosestudio{%endtrans%}</a></li>*/
/*             <li><a href="{{path("user_list")}}">{%trans%}menu_estudio_usuario{%endtrans%}</a></li>*/
/*         </ul>*/
/*     </li>*/
/* */
/* */

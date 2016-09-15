<?php

/* menu/submenu/entidad.html.twig */
class __TwigTemplate_1b5a1c9e91559b49f7bcfb6ae0c87d6c8fcd6eddf46ad2d592ffb0abe52c3413 extends Twig_Template
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
        $__internal_4819187d999ee99c3576e21cf66cef9352e14d42a79c152828b225b015c9bfce = $this->env->getExtension("native_profiler");
        $__internal_4819187d999ee99c3576e21cf66cef9352e14d42a79c152828b225b015c9bfce->enter($__internal_4819187d999ee99c3576e21cf66cef9352e14d42a79c152828b225b015c9bfce_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/entidad.html.twig"));

        // line 1
        echo "    ";
        // line 2
        echo "
    <li class=\"dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
            <span class=\"glyphicon glyphicon-list\"></span> ";
        // line 5
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_entidad", array(), "messages");
        echo "<b class=\"caret\"></b>
        </a>
        ";
        // line 16
        echo "        
    </li>

";
        
        $__internal_4819187d999ee99c3576e21cf66cef9352e14d42a79c152828b225b015c9bfce->leave($__internal_4819187d999ee99c3576e21cf66cef9352e14d42a79c152828b225b015c9bfce_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/entidad.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 16,  29 => 5,  24 => 2,  22 => 1,);
    }
}
/*     {#ENTIDADES#}*/
/* */
/*     <li class="dropdown">*/
/*         <a href="#" class="dropdown-toggle" data-toggle="dropdown">*/
/*             <span class="glyphicon glyphicon-list"></span> {%trans %}menu_entidad{% endtrans %}<b class="caret"></b>*/
/*         </a>*/
/*         {#*/
/*         <ul class="dropdown-menu">*/
/*             */
/*             <li><a href="{{path("entidad_list",{'tipo':'cliente'})}}">{%trans%}menu_entidad_cliente{%endtrans%}</a></li>*/
/*             <li><a href="{{path("entidad_list",{'tipo':'oponente'})}}">{%trans%}menu_entidad_oponente{%endtrans%}</a></li>*/
/*             <li><a href="{{path("entidad_list",{'tipo':'empleado'})}}">{%trans%}menu_entidad_empleado{%endtrans%}</a></li>*/
/*             <li><a href="{{path("entidad_list",{'tipo':'abogado'})}}">{%trans%}menu_entidad_abogado{%endtrans%}</a></li>*/
/*             <li><a href="{{path("tipoentidad_list")}}">{%trans%}menu_entidad_otrascategorias{%endtrans%}</a></li>*/
/*         </ul>*/
/*         #}        */
/*     </li>*/
/* */
/* */

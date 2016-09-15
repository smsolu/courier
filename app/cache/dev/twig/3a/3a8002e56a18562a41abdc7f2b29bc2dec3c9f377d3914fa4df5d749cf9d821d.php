<?php

/* menu/submenu/agenda.html.twig */
class __TwigTemplate_839a20842fc23257c90dd45181914131d82c68c0a0fc39acc8f4efe7abc3cc12 extends Twig_Template
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
        $__internal_14f72d3293a27bb7094cb8f741a4c5abd6f0d3ead8b40fef50ea2c9a430e0f6c = $this->env->getExtension("native_profiler");
        $__internal_14f72d3293a27bb7094cb8f741a4c5abd6f0d3ead8b40fef50ea2c9a430e0f6c->enter($__internal_14f72d3293a27bb7094cb8f741a4c5abd6f0d3ead8b40fef50ea2c9a430e0f6c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/agenda.html.twig"));

        // line 1
        echo "    ";
        // line 2
        echo "    <li class=\"dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
            <span class=\"glyphicon glyphicon-calendar\"></span> ";
        // line 4
        echo $this->env->getExtension('translator')->getTranslator()->trans("menu_agenda", array(), "messages");
        echo "<b class=\"caret\"></b>
        </a>
        ";
        // line 13
        echo "    </li>  

";
        
        $__internal_14f72d3293a27bb7094cb8f741a4c5abd6f0d3ead8b40fef50ea2c9a430e0f6c->leave($__internal_14f72d3293a27bb7094cb8f741a4c5abd6f0d3ead8b40fef50ea2c9a430e0f6c_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/agenda.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 13,  28 => 4,  24 => 2,  22 => 1,);
    }
}
/*     {#AGENDA#}*/
/*     <li class="dropdown">*/
/*         <a href="#" class="dropdown-toggle" data-toggle="dropdown">*/
/*             <span class="glyphicon glyphicon-calendar"></span> {%trans%}menu_agenda{%endtrans%}<b class="caret"></b>*/
/*         </a>*/
/*         {#<ul class="dropdown-menu">*/
/*             <li><a href="{{path("agenda_list",{'tipo': 0})}}">Eventos de hoy</a></li>*/
/*             <li><a href="{{path("agenda_list",{'tipo': 1})}}">Eventos del mes</a></li>*/
/*             <li><a href="{{path("agenda_list",{'tipo': 2})}}">Todos los eventos</a></li>*/
/*             <li class="divider"></li>*/
/*             <li><a href="{{path("agenda_new",{'tipo':'2'})}}">Nuevo evento</a></li>*/
/*         </ul>#}*/
/*     </li>  */
/* */
/* */

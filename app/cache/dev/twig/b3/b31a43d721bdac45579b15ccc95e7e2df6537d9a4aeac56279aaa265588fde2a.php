<?php

/* menu/submenu/buscar.html.twig */
class __TwigTemplate_8fb571ca1925d5d86f33a0edee5ae0596f6c6f4de7ee1685ccce5aa4636d1426 extends Twig_Template
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
        $__internal_ddad0b01fc5ba4879d93bdaec6c1c299e7f06b51b065ed7b16d9b591325ab142 = $this->env->getExtension("native_profiler");
        $__internal_ddad0b01fc5ba4879d93bdaec6c1c299e7f06b51b065ed7b16d9b591325ab142->enter($__internal_ddad0b01fc5ba4879d93bdaec6c1c299e7f06b51b065ed7b16d9b591325ab142_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/buscar.html.twig"));

        // line 1
        echo "    ";
        // line 2
        echo "    <form class=\"navbar-form navbar-left\" role=\"search\" action=\"";
        echo $this->env->getExtension('routing')->getPath("expediente_list");
        echo "\">
        <div class=\"input-group\">
            <input type=\"text\" class=\"form-control\" placeholder=\"";
        // line 4
        echo $this->env->getExtension('translator')->getTranslator()->trans("number_year", array(), "messages");
        echo "\" name='keywords' value=\"\">
            <span class=\"input-group-btn\">
                <button type=\"submit\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-search\"></span></button>
            </span>
        </div>
    </form>

";
        
        $__internal_ddad0b01fc5ba4879d93bdaec6c1c299e7f06b51b065ed7b16d9b591325ab142->leave($__internal_ddad0b01fc5ba4879d93bdaec6c1c299e7f06b51b065ed7b16d9b591325ab142_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/buscar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 4,  24 => 2,  22 => 1,);
    }
}
/*     {#CUADRO DE BÚSQUEDA#}*/
/*     <form class="navbar-form navbar-left" role="search" action="{{ path("expediente_list") }}">*/
/*         <div class="input-group">*/
/*             <input type="text" class="form-control" placeholder="{% trans %}number_year{% endtrans %}" name='keywords' value="">*/
/*             <span class="input-group-btn">*/
/*                 <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>*/
/*             </span>*/
/*         </div>*/
/*     </form>*/
/* */
/* */

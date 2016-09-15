<?php

/* menu/submenu/titulo.html.twig */
class __TwigTemplate_4f989b4f4ed1277e5dfd774e53e1611ce08cffec7c0bba8e296b77e676d2af8e extends Twig_Template
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
        $__internal_458a2e0a683b25e1d951638553cfba107184d48c077554cdaefddf52b937cf77 = $this->env->getExtension("native_profiler");
        $__internal_458a2e0a683b25e1d951638553cfba107184d48c077554cdaefddf52b937cf77->enter($__internal_458a2e0a683b25e1d951638553cfba107184d48c077554cdaefddf52b937cf77_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu/submenu/titulo.html.twig"));

        // line 1
        echo "    <div class=\"navbar-header\">
        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\"
                data-target=\".navbar-ex1-collapse\">
          <span class=\"sr-only\">Desplegar navegación</span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
        </button>
        <a class=\"navbar-brand\" href=\"#\"><b>";
        // line 9
        echo $this->env->getExtension('translator')->getTranslator()->trans("product_name", array(), "messages");
        echo "</b></a>
    </div>
";
        
        $__internal_458a2e0a683b25e1d951638553cfba107184d48c077554cdaefddf52b937cf77->leave($__internal_458a2e0a683b25e1d951638553cfba107184d48c077554cdaefddf52b937cf77_prof);

    }

    public function getTemplateName()
    {
        return "menu/submenu/titulo.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 9,  22 => 1,);
    }
}
/*     <div class="navbar-header">*/
/*         <button type="button" class="navbar-toggle" data-toggle="collapse"*/
/*                 data-target=".navbar-ex1-collapse">*/
/*           <span class="sr-only">Desplegar navegación</span>*/
/*           <span class="icon-bar"></span>*/
/*           <span class="icon-bar"></span>*/
/*           <span class="icon-bar"></span>*/
/*         </button>*/
/*         <a class="navbar-brand" href="#"><b>{%trans%}product_name{%endtrans%}</b></a>*/
/*     </div>*/
/* */

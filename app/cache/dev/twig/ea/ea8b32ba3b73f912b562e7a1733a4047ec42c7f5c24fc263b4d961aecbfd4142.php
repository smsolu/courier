<?php

/* knp_menu_base.html.twig */
class __TwigTemplate_a6dc4ee31efbfaaae64b1fca1dae09fb815e3ecee3cb6b6a90332774fc505a4c extends Twig_Template
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
        $__internal_10f2348711986a24aabd1c14ca2d10b1a79d75b53cc8cacd73b88527bcd73b82 = $this->env->getExtension("native_profiler");
        $__internal_10f2348711986a24aabd1c14ca2d10b1a79d75b53cc8cacd73b88527bcd73b82->enter($__internal_10f2348711986a24aabd1c14ca2d10b1a79d75b53cc8cacd73b88527bcd73b82_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "knp_menu_base.html.twig"));

        // line 1
        if ($this->getAttribute((isset($context["options"]) ? $context["options"] : $this->getContext($context, "options")), "compressed", array())) {
            $this->displayBlock("compressed_root", $context, $blocks);
        } else {
            $this->displayBlock("root", $context, $blocks);
        }
        
        $__internal_10f2348711986a24aabd1c14ca2d10b1a79d75b53cc8cacd73b88527bcd73b82->leave($__internal_10f2348711986a24aabd1c14ca2d10b1a79d75b53cc8cacd73b88527bcd73b82_prof);

    }

    public function getTemplateName()
    {
        return "knp_menu_base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% if options.compressed %}{{ block('compressed_root') }}{% else %}{{ block('root') }}{% endif %}*/
/* */

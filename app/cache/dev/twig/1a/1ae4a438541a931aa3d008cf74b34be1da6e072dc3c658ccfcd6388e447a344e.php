<?php

/* UserBundle::layout_custom.html.twig */
class __TwigTemplate_7f01900dc2e4e2234bd8e6fb17a1cba9d007daba9ec90337aa179e8ba66f3b31 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "UserBundle::layout_custom.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_f2dcbf44603167aec0edea1f542c0119babab241ab07fbf11aa76dc8a1a048cf = $this->env->getExtension("native_profiler");
        $__internal_f2dcbf44603167aec0edea1f542c0119babab241ab07fbf11aa76dc8a1a048cf->enter($__internal_f2dcbf44603167aec0edea1f542c0119babab241ab07fbf11aa76dc8a1a048cf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "UserBundle::layout_custom.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_f2dcbf44603167aec0edea1f542c0119babab241ab07fbf11aa76dc8a1a048cf->leave($__internal_f2dcbf44603167aec0edea1f542c0119babab241ab07fbf11aa76dc8a1a048cf_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_491c25badc3c7bbce59d4b28e7ccf4e62dfb91749a29cefb82c8e04e742bb1e1 = $this->env->getExtension("native_profiler");
        $__internal_491c25badc3c7bbce59d4b28e7ccf4e62dfb91749a29cefb82c8e04e742bb1e1->enter($__internal_491c25badc3c7bbce59d4b28e7ccf4e62dfb91749a29cefb82c8e04e742bb1e1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Demo Application";
        
        $__internal_491c25badc3c7bbce59d4b28e7ccf4e62dfb91749a29cefb82c8e04e742bb1e1->leave($__internal_491c25badc3c7bbce59d4b28e7ccf4e62dfb91749a29cefb82c8e04e742bb1e1_prof);

    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        $__internal_63b7aca0aacca4f8c1c88ca84bb834c6c37a046586be19b910021b0c3cbc49e1 = $this->env->getExtension("native_profiler");
        $__internal_63b7aca0aacca4f8c1c88ca84bb834c6c37a046586be19b910021b0c3cbc49e1->enter($__internal_63b7aca0aacca4f8c1c88ca84bb834c6c37a046586be19b910021b0c3cbc49e1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 5
        echo "    ";
        $this->displayBlock('fos_user_content', $context, $blocks);
        
        $__internal_63b7aca0aacca4f8c1c88ca84bb834c6c37a046586be19b910021b0c3cbc49e1->leave($__internal_63b7aca0aacca4f8c1c88ca84bb834c6c37a046586be19b910021b0c3cbc49e1_prof);

    }

    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_2e8cf3511be9002f2f5b4b6dac7f129860aa4f244a2b1538b2e2f994275fb5ec = $this->env->getExtension("native_profiler");
        $__internal_2e8cf3511be9002f2f5b4b6dac7f129860aa4f244a2b1538b2e2f994275fb5ec->enter($__internal_2e8cf3511be9002f2f5b4b6dac7f129860aa4f244a2b1538b2e2f994275fb5ec_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        
        $__internal_2e8cf3511be9002f2f5b4b6dac7f129860aa4f244a2b1538b2e2f994275fb5ec->leave($__internal_2e8cf3511be9002f2f5b4b6dac7f129860aa4f244a2b1538b2e2f994275fb5ec_prof);

    }

    public function getTemplateName()
    {
        return "UserBundle::layout_custom.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 5,  48 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* */
/* {% block title %}Demo Application{% endblock %}*/
/* {% block body %}*/
/*     {% block fos_user_content %}{% endblock %}*/
/* {% endblock %}*/

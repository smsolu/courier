<?php

/* UserBundle::layout.html.twig */
class __TwigTemplate_6fc3bc170b082a34b37c0e5c2450bde889fa3a9c14f6d1b0fb1dff7ab5aa0977 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "UserBundle::layout.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'aside_left' => array($this, 'block_aside_left'),
            'aside_right' => array($this, 'block_aside_right'),
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
        $__internal_0e8548744d46b8fa8a3c32f7af738cfc00464c7d418258113938b28fd5774e7f = $this->env->getExtension("native_profiler");
        $__internal_0e8548744d46b8fa8a3c32f7af738cfc00464c7d418258113938b28fd5774e7f->enter($__internal_0e8548744d46b8fa8a3c32f7af738cfc00464c7d418258113938b28fd5774e7f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "UserBundle::layout.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_0e8548744d46b8fa8a3c32f7af738cfc00464c7d418258113938b28fd5774e7f->leave($__internal_0e8548744d46b8fa8a3c32f7af738cfc00464c7d418258113938b28fd5774e7f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_4aca0b7a4709811503e9de20f3cbb03dc5de265e1de6bf0f0b0a872ed5786e47 = $this->env->getExtension("native_profiler");
        $__internal_4aca0b7a4709811503e9de20f3cbb03dc5de265e1de6bf0f0b0a872ed5786e47->enter($__internal_4aca0b7a4709811503e9de20f3cbb03dc5de265e1de6bf0f0b0a872ed5786e47_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Demo Application";
        
        $__internal_4aca0b7a4709811503e9de20f3cbb03dc5de265e1de6bf0f0b0a872ed5786e47->leave($__internal_4aca0b7a4709811503e9de20f3cbb03dc5de265e1de6bf0f0b0a872ed5786e47_prof);

    }

    // line 4
    public function block_aside_left($context, array $blocks = array())
    {
        $__internal_5e1778313372df0133096e92f2ee8b4b6ceea005480119b29fd24f825b9de86f = $this->env->getExtension("native_profiler");
        $__internal_5e1778313372df0133096e92f2ee8b4b6ceea005480119b29fd24f825b9de86f->enter($__internal_5e1778313372df0133096e92f2ee8b4b6ceea005480119b29fd24f825b9de86f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_left"));

        
        $__internal_5e1778313372df0133096e92f2ee8b4b6ceea005480119b29fd24f825b9de86f->leave($__internal_5e1778313372df0133096e92f2ee8b4b6ceea005480119b29fd24f825b9de86f_prof);

    }

    // line 5
    public function block_aside_right($context, array $blocks = array())
    {
        $__internal_37656cfe6f23d59e5b71e69875540e8b1232829c0e94053382c5ef1de409bed8 = $this->env->getExtension("native_profiler");
        $__internal_37656cfe6f23d59e5b71e69875540e8b1232829c0e94053382c5ef1de409bed8->enter($__internal_37656cfe6f23d59e5b71e69875540e8b1232829c0e94053382c5ef1de409bed8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_right"));

        
        $__internal_37656cfe6f23d59e5b71e69875540e8b1232829c0e94053382c5ef1de409bed8->leave($__internal_37656cfe6f23d59e5b71e69875540e8b1232829c0e94053382c5ef1de409bed8_prof);

    }

    // line 8
    public function block_body($context, array $blocks = array())
    {
        $__internal_3700c06b84e9137407a07a39250546db67802694d459a7fcf98127b59842ee12 = $this->env->getExtension("native_profiler");
        $__internal_3700c06b84e9137407a07a39250546db67802694d459a7fcf98127b59842ee12->enter($__internal_3700c06b84e9137407a07a39250546db67802694d459a7fcf98127b59842ee12_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 10
        echo "        <div class='container-fluid'>
            ";
        // line 11
        $this->displayBlock('fos_user_content', $context, $blocks);
        // line 12
        echo "        </div>
";
        
        $__internal_3700c06b84e9137407a07a39250546db67802694d459a7fcf98127b59842ee12->leave($__internal_3700c06b84e9137407a07a39250546db67802694d459a7fcf98127b59842ee12_prof);

    }

    // line 11
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_1159aec4617ba8041b5bbc7931ae806e163e74ccd3dff420a7ea950c60da22c0 = $this->env->getExtension("native_profiler");
        $__internal_1159aec4617ba8041b5bbc7931ae806e163e74ccd3dff420a7ea950c60da22c0->enter($__internal_1159aec4617ba8041b5bbc7931ae806e163e74ccd3dff420a7ea950c60da22c0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        
        $__internal_1159aec4617ba8041b5bbc7931ae806e163e74ccd3dff420a7ea950c60da22c0->leave($__internal_1159aec4617ba8041b5bbc7931ae806e163e74ccd3dff420a7ea950c60da22c0_prof);

    }

    public function getTemplateName()
    {
        return "UserBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 11,  83 => 12,  81 => 11,  78 => 10,  72 => 8,  61 => 5,  50 => 4,  38 => 3,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* */
/* {% block title %}Demo Application{% endblock %}*/
/* {% block aside_left %}{% endblock %}*/
/* {% block aside_right %}{% endblock %}*/
/* {#{% block aside_breadcrumb %}{% endblock %}#}*/
/* */
/* {% block body %}*/
/* {#    <div class='jumbotron'>#}*/
/*         <div class='container-fluid'>*/
/*             {% block fos_user_content %}{% endblock %}*/
/*         </div>*/
/* {#    </div>#}*/
/* {% endblock %}*/

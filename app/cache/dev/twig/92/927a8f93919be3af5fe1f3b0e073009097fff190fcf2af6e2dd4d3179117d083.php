<?php

/* FOSUserBundle:User:list.html.twig */
class __TwigTemplate_a9271fcdeef3810e6fdba1d361114b205cf2ef52fd5d8d5f856a5d070331be30 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("UserBundle::layout_custom.html.twig", "FOSUserBundle:User:list.html.twig", 1);
        $this->blocks = array(
            'aside_breadcrumb' => array($this, 'block_aside_breadcrumb'),
            'aside_left' => array($this, 'block_aside_left'),
            'body_top' => array($this, 'block_body_top'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "UserBundle::layout_custom.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_299dbdb197d3983a5b3947ddc9d5591aca3c3fe0d5236b693a2f3d02e06c3074 = $this->env->getExtension("native_profiler");
        $__internal_299dbdb197d3983a5b3947ddc9d5591aca3c3fe0d5236b693a2f3d02e06c3074->enter($__internal_299dbdb197d3983a5b3947ddc9d5591aca3c3fe0d5236b693a2f3d02e06c3074_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:User:list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_299dbdb197d3983a5b3947ddc9d5591aca3c3fe0d5236b693a2f3d02e06c3074->leave($__internal_299dbdb197d3983a5b3947ddc9d5591aca3c3fe0d5236b693a2f3d02e06c3074_prof);

    }

    // line 2
    public function block_aside_breadcrumb($context, array $blocks = array())
    {
        $__internal_9fd93fd813f937bce9a3008ea99c761963289c2a57e1aea357e87ae80660a22a = $this->env->getExtension("native_profiler");
        $__internal_9fd93fd813f937bce9a3008ea99c761963289c2a57e1aea357e87ae80660a22a->enter($__internal_9fd93fd813f937bce9a3008ea99c761963289c2a57e1aea357e87ae80660a22a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_breadcrumb"));

        
        $__internal_9fd93fd813f937bce9a3008ea99c761963289c2a57e1aea357e87ae80660a22a->leave($__internal_9fd93fd813f937bce9a3008ea99c761963289c2a57e1aea357e87ae80660a22a_prof);

    }

    // line 5
    public function block_aside_left($context, array $blocks = array())
    {
        $__internal_534237e02792bc4c328c82cd0948b0bd8b71b21dc5d123d5ed9f4d08432539c8 = $this->env->getExtension("native_profiler");
        $__internal_534237e02792bc4c328c82cd0948b0bd8b71b21dc5d123d5ed9f4d08432539c8->enter($__internal_534237e02792bc4c328c82cd0948b0bd8b71b21dc5d123d5ed9f4d08432539c8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_left"));

        
        $__internal_534237e02792bc4c328c82cd0948b0bd8b71b21dc5d123d5ed9f4d08432539c8->leave($__internal_534237e02792bc4c328c82cd0948b0bd8b71b21dc5d123d5ed9f4d08432539c8_prof);

    }

    // line 8
    public function block_body_top($context, array $blocks = array())
    {
        $__internal_8b6d9933b6a52f3f937fa72584cfb439cf7a7107b21a5c33ce1e03377cf9de1f = $this->env->getExtension("native_profiler");
        $__internal_8b6d9933b6a52f3f937fa72584cfb439cf7a7107b21a5c33ce1e03377cf9de1f->enter($__internal_8b6d9933b6a52f3f937fa72584cfb439cf7a7107b21a5c33ce1e03377cf9de1f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_top"));

        
        $__internal_8b6d9933b6a52f3f937fa72584cfb439cf7a7107b21a5c33ce1e03377cf9de1f->leave($__internal_8b6d9933b6a52f3f937fa72584cfb439cf7a7107b21a5c33ce1e03377cf9de1f_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_25e32137ff7e0869e2f7e647e85d6d39b0bef0e7da3ecee4fc20eaac7ada4d75 = $this->env->getExtension("native_profiler");
        $__internal_25e32137ff7e0869e2f7e647e85d6d39b0bef0e7da3ecee4fc20eaac7ada4d75->enter($__internal_25e32137ff7e0869e2f7e647e85d6d39b0bef0e7da3ecee4fc20eaac7ada4d75_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        echo twig_include($this->env, $context, "ListViewBundle:ListView:ListPrueba.html.twig", array("data" =>         // line 14
(isset($context["pagination"]) ? $context["pagination"] : $this->getContext($context, "pagination")), "list" => (isset($context["list"]) ? $context["list"] : $this->getContext($context, "list"))));
        // line 15
        echo "
";
        
        $__internal_25e32137ff7e0869e2f7e647e85d6d39b0bef0e7da3ecee4fc20eaac7ada4d75->leave($__internal_25e32137ff7e0869e2f7e647e85d6d39b0bef0e7da3ecee4fc20eaac7ada4d75_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:User:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 15,  78 => 14,  76 => 12,  70 => 11,  59 => 8,  48 => 5,  37 => 2,  11 => 1,);
    }
}
/* {% extends 'UserBundle::layout_custom.html.twig' %}*/
/* {% block aside_breadcrumb %}*/
/* {#        {{ knp_menu_render('CommonBundle:BreadcrumbBuilder:usuariosMenu', {'allow_safe_labels': true} ) }}#}*/
/* {% endblock %}*/
/* {% block aside_left %}*/
/* {#    {% render (controller("CommonBundle:Submenu:userList", {'active' : 'empleados'}))%}#}*/
/* {% endblock %}*/
/* {% block body_top %}*/
/* {#    {% render (controller("CommonBundle:Submenu:NAVuserList", {'active' : 'empleados'}))%}#}*/
/* {% endblock %}*/
/* {% block body %}*/
/*     {{ include(*/
/*         'ListViewBundle:ListView:ListPrueba.html.twig',*/
/*         {'data': pagination, 'list':list}*/
/*     )}}*/
/* {% endblock %}*/
/* */

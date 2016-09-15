<?php

/* AppBundle:Expediente\Expediente:list.html.twig */
class __TwigTemplate_1c4d3aa5a58ec845e0fa838031696197acd425916efe9a1334e102f8fcb7c50b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "AppBundle:Expediente\\Expediente:list.html.twig", 1);
        $this->blocks = array(
            'aside_breadcrumb' => array($this, 'block_aside_breadcrumb'),
            'aside_left' => array($this, 'block_aside_left'),
            'body_top' => array($this, 'block_body_top'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_97cdec1b3d03bbb8837e8e1b6a4b321c4df1821da9a376bbd87dc3ca550d4c9f = $this->env->getExtension("native_profiler");
        $__internal_97cdec1b3d03bbb8837e8e1b6a4b321c4df1821da9a376bbd87dc3ca550d4c9f->enter($__internal_97cdec1b3d03bbb8837e8e1b6a4b321c4df1821da9a376bbd87dc3ca550d4c9f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Expediente\\Expediente:list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_97cdec1b3d03bbb8837e8e1b6a4b321c4df1821da9a376bbd87dc3ca550d4c9f->leave($__internal_97cdec1b3d03bbb8837e8e1b6a4b321c4df1821da9a376bbd87dc3ca550d4c9f_prof);

    }

    // line 2
    public function block_aside_breadcrumb($context, array $blocks = array())
    {
        $__internal_2636d121e2ff402f676472ef1dcacac02a947fc5a29fffe9e2363bc0c6b577d1 = $this->env->getExtension("native_profiler");
        $__internal_2636d121e2ff402f676472ef1dcacac02a947fc5a29fffe9e2363bc0c6b577d1->enter($__internal_2636d121e2ff402f676472ef1dcacac02a947fc5a29fffe9e2363bc0c6b577d1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_breadcrumb"));

        // line 3
        echo "    ";
        echo $this->env->getExtension('knp_menu')->render("AppBundle:BreadcrumbBuilder:expedienteMenu", array("allow_safe_labels" => true));
        echo "
";
        
        $__internal_2636d121e2ff402f676472ef1dcacac02a947fc5a29fffe9e2363bc0c6b577d1->leave($__internal_2636d121e2ff402f676472ef1dcacac02a947fc5a29fffe9e2363bc0c6b577d1_prof);

    }

    // line 5
    public function block_aside_left($context, array $blocks = array())
    {
        $__internal_130385c101411e829c82421321052d5e97e7c03d3483f2bac986c92ebc76a50b = $this->env->getExtension("native_profiler");
        $__internal_130385c101411e829c82421321052d5e97e7c03d3483f2bac986c92ebc76a50b->enter($__internal_130385c101411e829c82421321052d5e97e7c03d3483f2bac986c92ebc76a50b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_left"));

        // line 6
        echo "    ";
        echo twig_include($this->env, $context, "AppBundle:Expediente:submenu/sm_expediente_list.html.twig");
        echo "
";
        
        $__internal_130385c101411e829c82421321052d5e97e7c03d3483f2bac986c92ebc76a50b->leave($__internal_130385c101411e829c82421321052d5e97e7c03d3483f2bac986c92ebc76a50b_prof);

    }

    // line 8
    public function block_body_top($context, array $blocks = array())
    {
        $__internal_898ae9800757639d228d096763530c8a0e84f1d4a93fe4d0225c5e2a52d3ed33 = $this->env->getExtension("native_profiler");
        $__internal_898ae9800757639d228d096763530c8a0e84f1d4a93fe4d0225c5e2a52d3ed33->enter($__internal_898ae9800757639d228d096763530c8a0e84f1d4a93fe4d0225c5e2a52d3ed33_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_top"));

        
        $__internal_898ae9800757639d228d096763530c8a0e84f1d4a93fe4d0225c5e2a52d3ed33->leave($__internal_898ae9800757639d228d096763530c8a0e84f1d4a93fe4d0225c5e2a52d3ed33_prof);

    }

    // line 13
    public function block_body($context, array $blocks = array())
    {
        $__internal_21aaefc3808773897409114010a9934752548d19d4e78ced77f9cae239b4ef2f = $this->env->getExtension("native_profiler");
        $__internal_21aaefc3808773897409114010a9934752548d19d4e78ced77f9cae239b4ef2f->enter($__internal_21aaefc3808773897409114010a9934752548d19d4e78ced77f9cae239b4ef2f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 14
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("ListViewBundle:ListView:ListView", array("request" => (isset($context["request"]) ? $context["request"] : $this->getContext($context, "request")), "listview" => (isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")))));
        echo "
";
        
        $__internal_21aaefc3808773897409114010a9934752548d19d4e78ced77f9cae239b4ef2f->leave($__internal_21aaefc3808773897409114010a9934752548d19d4e78ced77f9cae239b4ef2f_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Expediente\\Expediente:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 14,  80 => 13,  69 => 8,  59 => 6,  53 => 5,  43 => 3,  37 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block aside_breadcrumb %}*/
/*     {{ knp_menu_render('AppBundle:BreadcrumbBuilder:expedienteMenu', {'allow_safe_labels': true} ) }}*/
/* {% endblock %}*/
/* {% block aside_left %}*/
/*     {{ include('AppBundle:Expediente:submenu/sm_expediente_list.html.twig') }}*/
/* {% endblock %}*/
/* {% block body_top %}*/
/* {#    {% render (controller("CommonBundle:Submenu:NAVExpediente", {'seccion':'list','action': ''}))%}#}*/
/* {% endblock %}*/
/* */
/* */
/* {% block body %}*/
/*     {{ render (controller("ListViewBundle:ListView:ListView", {'request': request, 'listview': list}))}}*/
/* {% endblock %}*/
/* */

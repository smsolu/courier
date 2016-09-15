<?php

/* AppBundle:Expediente:submenu/sm_expediente_list.html.twig */
class __TwigTemplate_359be8df6c74218ea02238a0caaf069cab73c11c779fe64d50258a044e0d7af3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 5
        $this->parent = $this->loadTemplate("::submenu/submenu.html.twig", "AppBundle:Expediente:submenu/sm_expediente_list.html.twig", 5);
        $this->blocks = array(
            'heading' => array($this, 'block_heading'),
            'buttons' => array($this, 'block_buttons'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::submenu/submenu.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_500eb6e70df2a044b2383e5abe09be5c84928c22a482a306c2db7a353e730584 = $this->env->getExtension("native_profiler");
        $__internal_500eb6e70df2a044b2383e5abe09be5c84928c22a482a306c2db7a353e730584->enter($__internal_500eb6e70df2a044b2383e5abe09be5c84928c22a482a306c2db7a353e730584_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Expediente:submenu/sm_expediente_list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_500eb6e70df2a044b2383e5abe09be5c84928c22a482a306c2db7a353e730584->leave($__internal_500eb6e70df2a044b2383e5abe09be5c84928c22a482a306c2db7a353e730584_prof);

    }

    // line 7
    public function block_heading($context, array $blocks = array())
    {
        $__internal_d156c999c953fc6f7e3acf00e9307b6caffec722371e348e6c6d055bb0d37a8e = $this->env->getExtension("native_profiler");
        $__internal_d156c999c953fc6f7e3acf00e9307b6caffec722371e348e6c6d055bb0d37a8e->enter($__internal_d156c999c953fc6f7e3acf00e9307b6caffec722371e348e6c6d055bb0d37a8e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "heading"));

        // line 8
        echo "    <span class=\"glyphicon glyphicon-file\"> Casos</span>
";
        
        $__internal_d156c999c953fc6f7e3acf00e9307b6caffec722371e348e6c6d055bb0d37a8e->leave($__internal_d156c999c953fc6f7e3acf00e9307b6caffec722371e348e6c6d055bb0d37a8e_prof);

    }

    // line 11
    public function block_buttons($context, array $blocks = array())
    {
        $__internal_eab3723c50c693aafda04b68bd998ef8312d8dea594499b2f23535cbe5ac1a06 = $this->env->getExtension("native_profiler");
        $__internal_eab3723c50c693aafda04b68bd998ef8312d8dea594499b2f23535cbe5ac1a06->enter($__internal_eab3723c50c693aafda04b68bd998ef8312d8dea594499b2f23535cbe5ac1a06_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "buttons"));

        // line 12
        echo "    <li><a href=\"";
        echo $this->env->getExtension('routing')->getPath("expediente_new", array());
        echo "\"><span class=\"glyphicon glyphicon-plus\"></span> Nuevo</a></li>
    <li><a href=\"\"><span class=\"glyphicon glyphicon-search\"></span> Buscar</a></li>
";
        
        $__internal_eab3723c50c693aafda04b68bd998ef8312d8dea594499b2f23535cbe5ac1a06->leave($__internal_eab3723c50c693aafda04b68bd998ef8312d8dea594499b2f23535cbe5ac1a06_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Expediente:submenu/sm_expediente_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 12,  49 => 11,  41 => 8,  35 => 7,  11 => 5,);
    }
}
/* {#*/
/*     REQUIERE:*/
/*         -NADA*/
/* #}*/
/* {% extends '::submenu/submenu.html.twig' %}*/
/* */
/* {%block heading %}*/
/*     <span class="glyphicon glyphicon-file"> Casos</span>*/
/* {% endblock %}*/
/* */
/* {% block buttons %}*/
/*     <li><a href="{{path('expediente_new', {})}}"><span class="glyphicon glyphicon-plus"></span> Nuevo</a></li>*/
/*     <li><a href=""><span class="glyphicon glyphicon-search"></span> Buscar</a></li>*/
/* {% endblock %}    */
/*         */

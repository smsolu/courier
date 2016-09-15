<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_e196718ab8fac130ccc68a580e463444aa276aac4dd1deef60f62127c244f737 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_0144af84f895810a791b8a8e7a995051d57e583d6d6a5e95014da32a4512d896 = $this->env->getExtension("native_profiler");
        $__internal_0144af84f895810a791b8a8e7a995051d57e583d6d6a5e95014da32a4512d896->enter($__internal_0144af84f895810a791b8a8e7a995051d57e583d6d6a5e95014da32a4512d896_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_0144af84f895810a791b8a8e7a995051d57e583d6d6a5e95014da32a4512d896->leave($__internal_0144af84f895810a791b8a8e7a995051d57e583d6d6a5e95014da32a4512d896_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_30a63093ce3a13791c596d48dcf5103b4ae4bac72eca95be1fd3eeda722d81cf = $this->env->getExtension("native_profiler");
        $__internal_30a63093ce3a13791c596d48dcf5103b4ae4bac72eca95be1fd3eeda722d81cf->enter($__internal_30a63093ce3a13791c596d48dcf5103b4ae4bac72eca95be1fd3eeda722d81cf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_30a63093ce3a13791c596d48dcf5103b4ae4bac72eca95be1fd3eeda722d81cf->leave($__internal_30a63093ce3a13791c596d48dcf5103b4ae4bac72eca95be1fd3eeda722d81cf_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_80d8e896a9af3110f5076013a126a0eec19879e4dc3b44911e6fb1c598563d15 = $this->env->getExtension("native_profiler");
        $__internal_80d8e896a9af3110f5076013a126a0eec19879e4dc3b44911e6fb1c598563d15->enter($__internal_80d8e896a9af3110f5076013a126a0eec19879e4dc3b44911e6fb1c598563d15_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_80d8e896a9af3110f5076013a126a0eec19879e4dc3b44911e6fb1c598563d15->leave($__internal_80d8e896a9af3110f5076013a126a0eec19879e4dc3b44911e6fb1c598563d15_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_0d17782a11cedacc58fbe71155663bb5c8f2c8daa4efa5d0359f042c3f3d1a3b = $this->env->getExtension("native_profiler");
        $__internal_0d17782a11cedacc58fbe71155663bb5c8f2c8daa4efa5d0359f042c3f3d1a3b->enter($__internal_0d17782a11cedacc58fbe71155663bb5c8f2c8daa4efa5d0359f042c3f3d1a3b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_0d17782a11cedacc58fbe71155663bb5c8f2c8daa4efa5d0359f042c3f3d1a3b->leave($__internal_0d17782a11cedacc58fbe71155663bb5c8f2c8daa4efa5d0359f042c3f3d1a3b_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */

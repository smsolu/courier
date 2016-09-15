<?php

/* ::submenu/submenu.html.twig */
class __TwigTemplate_926eddb593a276596c1d9cc9e481961fb6f59eba05df5c4dddc5593b99f2e865 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'heading' => array($this, 'block_heading'),
            'buttons' => array($this, 'block_buttons'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d7e56830792992144356118cbd3d7858871f79b959e85cfb5fdfa82e5d1255cb = $this->env->getExtension("native_profiler");
        $__internal_d7e56830792992144356118cbd3d7858871f79b959e85cfb5fdfa82e5d1255cb->enter($__internal_d7e56830792992144356118cbd3d7858871f79b959e85cfb5fdfa82e5d1255cb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::submenu/submenu.html.twig"));

        // line 7
        echo "
<div class=\"panel panel-primary\" style=\"margin:0;padding:0;background-color: whitesmoke\">
    <div class='panel-heading'>
        ";
        // line 10
        $this->displayBlock('heading', $context, $blocks);
        // line 12
        echo "    </div>
    <div class='panel-body'>
        <ul class='nav nav-pills nav-stacked'>
            ";
        // line 15
        $this->displayBlock('buttons', $context, $blocks);
        // line 17
        echo "    
        </ul>
    </div>
</div>
";
        
        $__internal_d7e56830792992144356118cbd3d7858871f79b959e85cfb5fdfa82e5d1255cb->leave($__internal_d7e56830792992144356118cbd3d7858871f79b959e85cfb5fdfa82e5d1255cb_prof);

    }

    // line 10
    public function block_heading($context, array $blocks = array())
    {
        $__internal_23dfff1e1ebcf8c70d7c7961cfde7f00aa85a2b006b95058cce8b06426e9550d = $this->env->getExtension("native_profiler");
        $__internal_23dfff1e1ebcf8c70d7c7961cfde7f00aa85a2b006b95058cce8b06426e9550d->enter($__internal_23dfff1e1ebcf8c70d7c7961cfde7f00aa85a2b006b95058cce8b06426e9550d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "heading"));

        // line 11
        echo "        ";
        
        $__internal_23dfff1e1ebcf8c70d7c7961cfde7f00aa85a2b006b95058cce8b06426e9550d->leave($__internal_23dfff1e1ebcf8c70d7c7961cfde7f00aa85a2b006b95058cce8b06426e9550d_prof);

    }

    // line 15
    public function block_buttons($context, array $blocks = array())
    {
        $__internal_6b7471a8138c58a69199296d648b64c92dc4f968f2e94be827f5c5a3b1a6b648 = $this->env->getExtension("native_profiler");
        $__internal_6b7471a8138c58a69199296d648b64c92dc4f968f2e94be827f5c5a3b1a6b648->enter($__internal_6b7471a8138c58a69199296d648b64c92dc4f968f2e94be827f5c5a3b1a6b648_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "buttons"));

        // line 16
        echo "                
            ";
        
        $__internal_6b7471a8138c58a69199296d648b64c92dc4f968f2e94be827f5c5a3b1a6b648->leave($__internal_6b7471a8138c58a69199296d648b64c92dc4f968f2e94be827f5c5a3b1a6b648_prof);

    }

    public function getTemplateName()
    {
        return "::submenu/submenu.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  68 => 16,  62 => 15,  55 => 11,  49 => 10,  38 => 17,  36 => 15,  31 => 12,  29 => 10,  24 => 7,);
    }
}
/* {#*/
/*     MODOS DE USO:*/
/*     Redefinir bloques:*/
/*         -Bloque heading: Contiene el titulo del menu*/
/*         -Bloque buttons: Contiene el cuerpo del listado de botones*/
/* #}*/
/* */
/* <div class="panel panel-primary" style="margin:0;padding:0;background-color: whitesmoke">*/
/*     <div class='panel-heading'>*/
/*         {%block heading %}*/
/*         {% endblock %}*/
/*     </div>*/
/*     <div class='panel-body'>*/
/*         <ul class='nav nav-pills nav-stacked'>*/
/*             {% block buttons %}*/
/*                 */
/*             {% endblock %}    */
/*         </ul>*/
/*     </div>*/
/* </div>*/
/* */

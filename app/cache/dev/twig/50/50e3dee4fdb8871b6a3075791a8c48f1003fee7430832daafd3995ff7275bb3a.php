<?php

/* ::base.html.twig */
class __TwigTemplate_c5127d720283c35fe9326a8a2454f3d5d7772f45aaba078109c18d2aaa5771fc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'aside_breadcrumb' => array($this, 'block_aside_breadcrumb'),
            'aside_left' => array($this, 'block_aside_left'),
            'msg' => array($this, 'block_msg'),
            'body_top' => array($this, 'block_body_top'),
            'body' => array($this, 'block_body'),
            'body_bottom' => array($this, 'block_body_bottom'),
            'aside_right' => array($this, 'block_aside_right'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_19b79e46ac6a4d71cf5bd099d7af96ca0c373ba46df2aba1d73cd22b5c8a9b7e = $this->env->getExtension("native_profiler");
        $__internal_19b79e46ac6a4d71cf5bd099d7af96ca0c373ba46df2aba1d73cd22b5c8a9b7e->enter($__internal_19b79e46ac6a4d71cf5bd099d7af96ca0c373ba46df2aba1d73cd22b5c8a9b7e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        ";
        // line 7
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "    </head>
    <body>        

        ";
        // line 17
        echo "        ";
        echo twig_include($this->env, $context, ":menu:menu.html.twig");
        echo "


        ";
        // line 21
        echo "        <div style=\"height: 55px;\"> 
        </div>
 
        <aside class='container-fluid col-lg-12'>
            ";
        // line 25
        $this->displayBlock('aside_breadcrumb', $context, $blocks);
        // line 28
        echo "        </aside>
  
        <aside class='col-md-2 col-xs-12'>
            ";
        // line 31
        $this->displayBlock('aside_left', $context, $blocks);
        // line 34
        echo "        </aside>
      
        <div class=\"container-fluid col-md-7 col-xs-12\">
            <aside>
            ";
        // line 38
        $this->displayBlock('msg', $context, $blocks);
        // line 41
        echo "            </aside>
            <article>
                ";
        // line 43
        $this->displayBlock('body_top', $context, $blocks);
        // line 44
        echo "                ";
        $this->displayBlock('body', $context, $blocks);
        // line 45
        echo "                ";
        $this->displayBlock('body_bottom', $context, $blocks);
        echo "                
            </article>
        </div>
        <aside class='col-md-3 col-xs-12'>
            ";
        // line 49
        $this->displayBlock('aside_right', $context, $blocks);
        // line 52
        echo "        </aside>
      
        ";
        // line 54
        $this->displayBlock('javascripts', $context, $blocks);
        // line 65
        echo "    
";
        // line 67
        echo "
    </body>
</html>
";
        
        $__internal_19b79e46ac6a4d71cf5bd099d7af96ca0c373ba46df2aba1d73cd22b5c8a9b7e->leave($__internal_19b79e46ac6a4d71cf5bd099d7af96ca0c373ba46df2aba1d73cd22b5c8a9b7e_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_f9860a1b3bde83803ca7379e0cffcfcf54935862add37be0c59921d6c67ebe5f = $this->env->getExtension("native_profiler");
        $__internal_f9860a1b3bde83803ca7379e0cffcfcf54935862add37be0c59921d6c67ebe5f->enter($__internal_f9860a1b3bde83803ca7379e0cffcfcf54935862add37be0c59921d6c67ebe5f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo $this->env->getExtension('translator')->getTranslator()->trans("title", array(), "messages");
        
        $__internal_f9860a1b3bde83803ca7379e0cffcfcf54935862add37be0c59921d6c67ebe5f->leave($__internal_f9860a1b3bde83803ca7379e0cffcfcf54935862add37be0c59921d6c67ebe5f_prof);

    }

    // line 7
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_2fd875f6d366d5ddea00d932a9dc1193d2b3011d800b14e224ccbc044646a304 = $this->env->getExtension("native_profiler");
        $__internal_2fd875f6d366d5ddea00d932a9dc1193d2b3011d800b14e224ccbc044646a304->enter($__internal_2fd875f6d366d5ddea00d932a9dc1193d2b3011d800b14e224ccbc044646a304_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 8
        echo "            <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"), "html", null, true);
        echo "\"/>              <!-- Importación del framework css -->
            <link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"), "html", null, true);
        echo "\"/> <!-- importación del tema css (Esto es opcional) -->
            <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css\"/>            
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>
        ";
        
        $__internal_2fd875f6d366d5ddea00d932a9dc1193d2b3011d800b14e224ccbc044646a304->leave($__internal_2fd875f6d366d5ddea00d932a9dc1193d2b3011d800b14e224ccbc044646a304_prof);

    }

    // line 25
    public function block_aside_breadcrumb($context, array $blocks = array())
    {
        $__internal_53eb1073f1c249d5950c444c132011533a18db08ecb2c946c4cbb8d8b8c18edf = $this->env->getExtension("native_profiler");
        $__internal_53eb1073f1c249d5950c444c132011533a18db08ecb2c946c4cbb8d8b8c18edf->enter($__internal_53eb1073f1c249d5950c444c132011533a18db08ecb2c946c4cbb8d8b8c18edf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_breadcrumb"));

        // line 27
        echo "            ";
        
        $__internal_53eb1073f1c249d5950c444c132011533a18db08ecb2c946c4cbb8d8b8c18edf->leave($__internal_53eb1073f1c249d5950c444c132011533a18db08ecb2c946c4cbb8d8b8c18edf_prof);

    }

    // line 31
    public function block_aside_left($context, array $blocks = array())
    {
        $__internal_3bcdcb29609d78520d61462b05a7af14ada60e0c7b9399a7ff6cd3b2fcde9f34 = $this->env->getExtension("native_profiler");
        $__internal_3bcdcb29609d78520d61462b05a7af14ada60e0c7b9399a7ff6cd3b2fcde9f34->enter($__internal_3bcdcb29609d78520d61462b05a7af14ada60e0c7b9399a7ff6cd3b2fcde9f34_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_left"));

        // line 33
        echo "            ";
        
        $__internal_3bcdcb29609d78520d61462b05a7af14ada60e0c7b9399a7ff6cd3b2fcde9f34->leave($__internal_3bcdcb29609d78520d61462b05a7af14ada60e0c7b9399a7ff6cd3b2fcde9f34_prof);

    }

    // line 38
    public function block_msg($context, array $blocks = array())
    {
        $__internal_182f15d5924f48e12ef0704dd17407608362779447bcd49d26c9d1e1abe2381f = $this->env->getExtension("native_profiler");
        $__internal_182f15d5924f48e12ef0704dd17407608362779447bcd49d26c9d1e1abe2381f->enter($__internal_182f15d5924f48e12ef0704dd17407608362779447bcd49d26c9d1e1abe2381f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "msg"));

        // line 39
        echo "                ";
        echo twig_include($this->env, $context, "::aside_alerts.html.twig");
        echo "
            ";
        
        $__internal_182f15d5924f48e12ef0704dd17407608362779447bcd49d26c9d1e1abe2381f->leave($__internal_182f15d5924f48e12ef0704dd17407608362779447bcd49d26c9d1e1abe2381f_prof);

    }

    // line 43
    public function block_body_top($context, array $blocks = array())
    {
        $__internal_24dcd6ac34bac5d0f64b2fea3e6aa13add10e4c10eca9ae732022b4ddba1366d = $this->env->getExtension("native_profiler");
        $__internal_24dcd6ac34bac5d0f64b2fea3e6aa13add10e4c10eca9ae732022b4ddba1366d->enter($__internal_24dcd6ac34bac5d0f64b2fea3e6aa13add10e4c10eca9ae732022b4ddba1366d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_top"));

        
        $__internal_24dcd6ac34bac5d0f64b2fea3e6aa13add10e4c10eca9ae732022b4ddba1366d->leave($__internal_24dcd6ac34bac5d0f64b2fea3e6aa13add10e4c10eca9ae732022b4ddba1366d_prof);

    }

    // line 44
    public function block_body($context, array $blocks = array())
    {
        $__internal_dc9a0068f476becb226c87627fc0fc0e657d6f3f58ae837f4e3fb3ba1c42a7a8 = $this->env->getExtension("native_profiler");
        $__internal_dc9a0068f476becb226c87627fc0fc0e657d6f3f58ae837f4e3fb3ba1c42a7a8->enter($__internal_dc9a0068f476becb226c87627fc0fc0e657d6f3f58ae837f4e3fb3ba1c42a7a8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_dc9a0068f476becb226c87627fc0fc0e657d6f3f58ae837f4e3fb3ba1c42a7a8->leave($__internal_dc9a0068f476becb226c87627fc0fc0e657d6f3f58ae837f4e3fb3ba1c42a7a8_prof);

    }

    // line 45
    public function block_body_bottom($context, array $blocks = array())
    {
        $__internal_7527ba733e18393e299ec72883de46455411c4186b39b2c27c38f23379bdfc34 = $this->env->getExtension("native_profiler");
        $__internal_7527ba733e18393e299ec72883de46455411c4186b39b2c27c38f23379bdfc34->enter($__internal_7527ba733e18393e299ec72883de46455411c4186b39b2c27c38f23379bdfc34_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_bottom"));

        
        $__internal_7527ba733e18393e299ec72883de46455411c4186b39b2c27c38f23379bdfc34->leave($__internal_7527ba733e18393e299ec72883de46455411c4186b39b2c27c38f23379bdfc34_prof);

    }

    // line 49
    public function block_aside_right($context, array $blocks = array())
    {
        $__internal_5a51c99f43548e125fea2e4a554b3a34b9c62ed95f7b09d68d3ecfaf30044b33 = $this->env->getExtension("native_profiler");
        $__internal_5a51c99f43548e125fea2e4a554b3a34b9c62ed95f7b09d68d3ecfaf30044b33->enter($__internal_5a51c99f43548e125fea2e4a554b3a34b9c62ed95f7b09d68d3ecfaf30044b33_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_right"));

        // line 51
        echo "            ";
        
        $__internal_5a51c99f43548e125fea2e4a554b3a34b9c62ed95f7b09d68d3ecfaf30044b33->leave($__internal_5a51c99f43548e125fea2e4a554b3a34b9c62ed95f7b09d68d3ecfaf30044b33_prof);

    }

    // line 54
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_6a8002b33c56f7e700d17c20f9840d711d6ccec65f67b332244a43f9dec5f6d2 = $this->env->getExtension("native_profiler");
        $__internal_6a8002b33c56f7e700d17c20f9840d711d6ccec65f67b332244a43f9dec5f6d2->enter($__internal_6a8002b33c56f7e700d17c20f9840d711d6ccec65f67b332244a43f9dec5f6d2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 55
        echo "            <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("http://code.jquery.com/jquery.js"), "html", null, true);
        echo "\"></script>
            <script src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script> <!-- Importación del framework en js -->
        
";
        // line 60
        echo "        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js\"></script> 
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/lang/es.js\"></script> 
        
        ";
        
        $__internal_6a8002b33c56f7e700d17c20f9840d711d6ccec65f67b332244a43f9dec5f6d2->leave($__internal_6a8002b33c56f7e700d17c20f9840d711d6ccec65f67b332244a43f9dec5f6d2_prof);

    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  259 => 60,  254 => 56,  249 => 55,  243 => 54,  236 => 51,  230 => 49,  219 => 45,  208 => 44,  197 => 43,  187 => 39,  181 => 38,  174 => 33,  168 => 31,  161 => 27,  155 => 25,  144 => 9,  139 => 8,  133 => 7,  121 => 5,  111 => 67,  108 => 65,  106 => 54,  102 => 52,  100 => 49,  92 => 45,  89 => 44,  87 => 43,  83 => 41,  81 => 38,  75 => 34,  73 => 31,  68 => 28,  66 => 25,  60 => 21,  53 => 17,  48 => 13,  46 => 7,  42 => 6,  38 => 5,  32 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <title>{% block title %}{% trans %}title{% endtrans %}{% endblock %}</title>*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*         {% block stylesheets %}*/
/*             <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css') }}"/>              <!-- Importación del framework css -->*/
/*             <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css') }}"/> <!-- importación del tema css (Esto es opcional) -->*/
/*             <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css"/>            */
/*             <meta name="viewport" content="width=device-width, initial-scale=1"/>*/
/*         {% endblock %}*/
/*     </head>*/
/*     <body>        */
/* */
/*         {#MENÚ        #}*/
/*         {{ include(':menu:menu.html.twig')}}*/
/* */
/* */
/*         {# ESPACIO PARA DEJAR FIJO EL TITULO       #}*/
/*         <div style="height: 55px;"> */
/*         </div>*/
/*  */
/*         <aside class='container-fluid col-lg-12'>*/
/*             {% block aside_breadcrumb %}*/
/* {#                {{ include('::aside_breadcrumb.html.twig')}}#}*/
/*             {% endblock %}*/
/*         </aside>*/
/*   */
/*         <aside class='col-md-2 col-xs-12'>*/
/*             {% block aside_left %}*/
/* {#                {{ include('::aside_left.html.twig')}}#}*/
/*             {% endblock %}*/
/*         </aside>*/
/*       */
/*         <div class="container-fluid col-md-7 col-xs-12">*/
/*             <aside>*/
/*             {% block msg %}*/
/*                 {{ include('::aside_alerts.html.twig')}}*/
/*             {% endblock %}*/
/*             </aside>*/
/*             <article>*/
/*                 {% block body_top %}{% endblock %}*/
/*                 {% block body %}{% endblock %}*/
/*                 {% block body_bottom %}{% endblock %}                */
/*             </article>*/
/*         </div>*/
/*         <aside class='col-md-3 col-xs-12'>*/
/*             {% block aside_right %}*/
/* {#                {{ include('::aside_right.html.twig')}}#}*/
/*             {% endblock %}*/
/*         </aside>*/
/*       */
/*         {% block javascripts %}*/
/*             <script src="{{ asset('http://code.jquery.com/jquery.js') }}"></script>*/
/*             <script src="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') }}"></script> <!-- Importación del framework en js -->*/
/*         */
/* {#      CALENDARIO#}*/
/* {#        <script src="http://code.jquery.com/jquery.js"></script>#}*/
/*         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script> */
/*         <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>*/
/*         <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/lang/es.js"></script> */
/*         */
/*         {% endblock %}*/
/*     */
/* {#          </div>          #}*/
/* */
/*     </body>*/
/* </html>*/
/* */

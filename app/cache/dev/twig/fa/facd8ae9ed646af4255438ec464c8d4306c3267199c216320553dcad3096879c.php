<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_df614c155f41d48bef1c08aaa068aaa651bdd80de9cc8f7dec612cac72ad5e15 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("UserBundle::layout.html.twig", "FOSUserBundle:Security:login.html.twig", 1);
        $this->blocks = array(
            'aside_left' => array($this, 'block_aside_left'),
            'aside_right' => array($this, 'block_aside_right'),
            'aside_breadcrumb' => array($this, 'block_aside_breadcrumb'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "UserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_dc901b57957b8c9f0126cbe49663508875e833926fdbaaed4a2c9436ffd5f4e1 = $this->env->getExtension("native_profiler");
        $__internal_dc901b57957b8c9f0126cbe49663508875e833926fdbaaed4a2c9436ffd5f4e1->enter($__internal_dc901b57957b8c9f0126cbe49663508875e833926fdbaaed4a2c9436ffd5f4e1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_dc901b57957b8c9f0126cbe49663508875e833926fdbaaed4a2c9436ffd5f4e1->leave($__internal_dc901b57957b8c9f0126cbe49663508875e833926fdbaaed4a2c9436ffd5f4e1_prof);

    }

    // line 2
    public function block_aside_left($context, array $blocks = array())
    {
        $__internal_aade196dac61221a45dd3b441e6974dfd4edec6e5a5e27521363d5bea551c388 = $this->env->getExtension("native_profiler");
        $__internal_aade196dac61221a45dd3b441e6974dfd4edec6e5a5e27521363d5bea551c388->enter($__internal_aade196dac61221a45dd3b441e6974dfd4edec6e5a5e27521363d5bea551c388_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_left"));

        
        $__internal_aade196dac61221a45dd3b441e6974dfd4edec6e5a5e27521363d5bea551c388->leave($__internal_aade196dac61221a45dd3b441e6974dfd4edec6e5a5e27521363d5bea551c388_prof);

    }

    // line 3
    public function block_aside_right($context, array $blocks = array())
    {
        $__internal_bb97c7c4dad979ce13583e18f3c8a1c35579353c7235c150ec2043379ca1c49e = $this->env->getExtension("native_profiler");
        $__internal_bb97c7c4dad979ce13583e18f3c8a1c35579353c7235c150ec2043379ca1c49e->enter($__internal_bb97c7c4dad979ce13583e18f3c8a1c35579353c7235c150ec2043379ca1c49e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_right"));

        
        $__internal_bb97c7c4dad979ce13583e18f3c8a1c35579353c7235c150ec2043379ca1c49e->leave($__internal_bb97c7c4dad979ce13583e18f3c8a1c35579353c7235c150ec2043379ca1c49e_prof);

    }

    // line 4
    public function block_aside_breadcrumb($context, array $blocks = array())
    {
        $__internal_8f33613c34998b6484a5fbf1b1fd3c35081f85bfa038ec709235dc7f530ecd68 = $this->env->getExtension("native_profiler");
        $__internal_8f33613c34998b6484a5fbf1b1fd3c35081f85bfa038ec709235dc7f530ecd68->enter($__internal_8f33613c34998b6484a5fbf1b1fd3c35081f85bfa038ec709235dc7f530ecd68_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "aside_breadcrumb"));

        
        $__internal_8f33613c34998b6484a5fbf1b1fd3c35081f85bfa038ec709235dc7f530ecd68->leave($__internal_8f33613c34998b6484a5fbf1b1fd3c35081f85bfa038ec709235dc7f530ecd68_prof);

    }

    // line 5
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_a1bf00434ad4c4e7d123d8858710dcd9b91c6f6371315abdd2ee0e1f992586f7 = $this->env->getExtension("native_profiler");
        $__internal_a1bf00434ad4c4e7d123d8858710dcd9b91c6f6371315abdd2ee0e1f992586f7->enter($__internal_a1bf00434ad4c4e7d123d8858710dcd9b91c6f6371315abdd2ee0e1f992586f7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 6
        echo "    ";
        if ((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error"))) {
            // line 7
            echo "        <div class=\"alert alert-danger\">";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "messageKey", array()), $this->getAttribute((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "messageData", array()), "security"), "html", null, true);
            echo "</div>
    ";
        }
        // line 9
        echo "    
    
    <div class=\"panel panel-primary\">
        <div class=\"panel-heading\"><h3 class=\"panel-title\">";
        // line 12
        echo $this->env->getExtension('translator')->getTranslator()->trans("ingresar_cuenta", array(), "messages");
        echo "</h3></div>
        <div class=\"panel-body\">
            <form action=\"";
        // line 14
        echo $this->env->getExtension('routing')->getPath("fos_user_security_check");
        echo "\" method=\"post\">
                <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["csrf_token"]) ? $context["csrf_token"] : $this->getContext($context, "csrf_token")), "html", null, true);
        echo "\" />

                <div class=\"form-group col-xs-12 col-sm-12\">
                    <label class=\"control-label required\" for=\"username\">";
        // line 18
        echo $this->env->getExtension('translator')->getTranslator()->trans("user_email", array(), "messages");
        echo "</label>
                    <input class=\"form-control\" type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["last_username"]) ? $context["last_username"] : $this->getContext($context, "last_username")), "html", null, true);
        echo "\" required=\"required\" />
                </div>
                <div class=\"form-group col-xs-12 col-sm-12\">
                    <label class=\"control-label required\" for=\"password\">";
        // line 22
        echo $this->env->getExtension('translator')->getTranslator()->trans("password", array(), "messages");
        echo "</label>
                    <input class=\"form-control\" type=\"password\" id=\"password\" name=\"_password\" required=\"required\" />
                </div>
                <div class=\"form-group col-xs-12 col-sm-12\">
                    <p><a href='";
        // line 26
        echo $this->env->getExtension('routing')->getPath("fos_user_resetting_request");
        echo "'>";
        echo $this->env->getExtension('translator')->getTranslator()->trans("olvide_mi_clave", array(), "messages");
        echo "</a></p>
                </div>
                <div class=\"form-group col-xs-12 col-sm-12\">
                    <div class='checkbox'>
                        <label for=\"remember_me\">
                            <input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" value=\"on\" />
                            ";
        // line 32
        echo $this->env->getExtension('translator')->getTranslator()->trans("recordarme", array(), "messages");
        // line 33
        echo "                        </label>
                    </div>
                </div>
                <div class=\"form-group col-xs-12 col-sm-12\">
                    <input class=\"btn btn-primary\" type=\"submit\" id=\"_submit\" name=\"_submit\" value=\"";
        // line 37
        echo $this->env->getExtension('translator')->getTranslator()->trans("boton_ingresar", array(), "messages");
        echo "\" />
                </div>
            </form>
        </div>
    </div>
    <div class='col-xs-12'>
        <p>";
        // line 43
        echo $this->env->getExtension('translator')->getTranslator()->trans("aun_no_tienes_cuenta", array(), "messages");
        echo " <a href='";
        echo $this->env->getExtension('routing')->getPath("fos_user_registration_register");
        echo "'>";
        echo $this->env->getExtension('translator')->getTranslator()->trans("boton_registrate", array(), "messages");
        echo "</a></p>
    </div>
";
        
        $__internal_a1bf00434ad4c4e7d123d8858710dcd9b91c6f6371315abdd2ee0e1f992586f7->leave($__internal_a1bf00434ad4c4e7d123d8858710dcd9b91c6f6371315abdd2ee0e1f992586f7_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  150 => 43,  141 => 37,  135 => 33,  133 => 32,  122 => 26,  115 => 22,  109 => 19,  105 => 18,  99 => 15,  95 => 14,  90 => 12,  85 => 9,  79 => 7,  76 => 6,  70 => 5,  59 => 4,  48 => 3,  37 => 2,  11 => 1,);
    }
}
/* {% extends 'UserBundle::layout.html.twig' %}*/
/* {% block aside_left %}{% endblock %}*/
/* {% block aside_right %}{% endblock %}*/
/* {% block aside_breadcrumb %}{% endblock %}*/
/* {% block fos_user_content %}*/
/*     {% if error %}*/
/*         <div class="alert alert-danger">{{ error.messageKey|trans(error.messageData, 'security') }}</div>*/
/*     {% endif %}*/
/*     */
/*     */
/*     <div class="panel panel-primary">*/
/*         <div class="panel-heading"><h3 class="panel-title">{%trans%}ingresar_cuenta{%endtrans%}</h3></div>*/
/*         <div class="panel-body">*/
/*             <form action="{{ path("fos_user_security_check") }}" method="post">*/
/*                 <input type="hidden" name="_csrf_token" value="{{ csrf_token }}" />*/
/* */
/*                 <div class="form-group col-xs-12 col-sm-12">*/
/*                     <label class="control-label required" for="username">{%trans%}user_email{%endtrans%}</label>*/
/*                     <input class="form-control" type="text" id="username" name="_username" value="{{ last_username }}" required="required" />*/
/*                 </div>*/
/*                 <div class="form-group col-xs-12 col-sm-12">*/
/*                     <label class="control-label required" for="password">{%trans%}password{%endtrans%}</label>*/
/*                     <input class="form-control" type="password" id="password" name="_password" required="required" />*/
/*                 </div>*/
/*                 <div class="form-group col-xs-12 col-sm-12">*/
/*                     <p><a href='{{ path("fos_user_resetting_request")}}'>{%trans%}olvide_mi_clave{%endtrans%}</a></p>*/
/*                 </div>*/
/*                 <div class="form-group col-xs-12 col-sm-12">*/
/*                     <div class='checkbox'>*/
/*                         <label for="remember_me">*/
/*                             <input type="checkbox" id="remember_me" name="_remember_me" value="on" />*/
/*                             {%trans%}recordarme{%endtrans%}*/
/*                         </label>*/
/*                     </div>*/
/*                 </div>*/
/*                 <div class="form-group col-xs-12 col-sm-12">*/
/*                     <input class="btn btn-primary" type="submit" id="_submit" name="_submit" value="{%trans%}boton_ingresar{%endtrans%}" />*/
/*                 </div>*/
/*             </form>*/
/*         </div>*/
/*     </div>*/
/*     <div class='col-xs-12'>*/
/*         <p>{%trans%}aun_no_tienes_cuenta{%endtrans%} <a href='{{ path("fos_user_registration_register")}}'>{%trans%}boton_registrate{%endtrans%}</a></p>*/
/*     </div>*/
/* {% endblock fos_user_content %}*/
/* */

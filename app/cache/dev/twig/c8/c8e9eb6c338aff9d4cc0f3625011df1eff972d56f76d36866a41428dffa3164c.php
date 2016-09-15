<?php

/* ::aside_alerts.html.twig */
class __TwigTemplate_7516e499c55709709b6d0197a3a343925f4a2b178b9bb71fe1ad4479c7bcf156 extends Twig_Template
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
        $__internal_42a77895c218aacdd782ae509023d4305638427936ec5f511638d884c4ebbb32 = $this->env->getExtension("native_profiler");
        $__internal_42a77895c218aacdd782ae509023d4305638427936ec5f511638d884c4ebbb32->enter($__internal_42a77895c218aacdd782ae509023d4305638427936ec5f511638d884c4ebbb32_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::aside_alerts.html.twig"));

        // line 1
        $context["bag"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session", array()), "flashbag", array()), "all", array());
        // line 2
        if ( !twig_test_empty((isset($context["bag"]) ? $context["bag"] : $this->getContext($context, "bag")))) {
            // line 3
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["bag"]) ? $context["bag"] : $this->getContext($context, "bag")));
            foreach ($context['_seq'] as $context["label"] => $context["flashes"]) {
                // line 4
                echo "            ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["flashes"]);
                foreach ($context['_seq'] as $context["_key"] => $context["flash"]) {
                    // line 5
                    echo "                <div class=\"alert alert-";
                    echo twig_escape_filter($this->env, $context["label"], "html", null, true);
                    echo "\">
                    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                    ";
                    // line 7
                    echo $context["flash"];
                    echo "
                </div>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flash'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 10
                echo "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['label'], $context['flashes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        
        $__internal_42a77895c218aacdd782ae509023d4305638427936ec5f511638d884c4ebbb32->leave($__internal_42a77895c218aacdd782ae509023d4305638427936ec5f511638d884c4ebbb32_prof);

    }

    public function getTemplateName()
    {
        return "::aside_alerts.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 10,  42 => 7,  36 => 5,  31 => 4,  26 => 3,  24 => 2,  22 => 1,);
    }
}
/* {% set bag = app.session.flashbag.all %}*/
/* {% if bag is not empty %}*/
/*         {% for label, flashes in bag %}*/
/*             {% for flash in flashes %}*/
/*                 <div class="alert alert-{{ label }}">*/
/*                     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>*/
/*                     {{ flash|raw }}*/
/*                 </div>*/
/*             {% endfor %}*/
/*         {% endfor %}*/
/* {%endif%}*/
/* */

<?php

/* ListViewBundle:ListView:ListView.html.twig */
class __TwigTemplate_06f819e3b5b90d79c99bd617238b96c1b94b9478a554252357a44b9f92d512df extends Twig_Template
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
        $__internal_d2baeba9fd5d33f2214b5028ed2f6c38626f87e3b92a83f3ce920ffd0f6483c5 = $this->env->getExtension("native_profiler");
        $__internal_d2baeba9fd5d33f2214b5028ed2f6c38626f87e3b92a83f3ce920ffd0f6483c5->enter($__internal_d2baeba9fd5d33f2214b5028ed2f6c38626f87e3b92a83f3ce920ffd0f6483c5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ListViewBundle:ListView:ListView.html.twig"));

        // line 1
        echo "    <table class=\"table table-hover\">
            <thead>
            <tr>
                ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "columns", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 5
            echo "                   <th>
                    ";
            // line 6
            if (($this->getAttribute($context["column"], "allow_order", array()) == "1")) {
                // line 7
                echo "                        ";
                $context["order"] = 1;
                // line 8
                echo "                        ";
                if (($this->getAttribute($context["column"], "name", array()) == $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "OrderCol", array()))) {
                    // line 9
                    echo "                            ";
                    $context["order"] = $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "getNextOrderStatus", array(), "method");
                    // line 10
                    echo "                            ";
                    if (($this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderStatus", array()) == "1")) {
                        echo " 
                                <span class=\"glyphicon glyphicon-chevron-down\"></span>
                            ";
                    } elseif (($this->getAttribute(                    // line 12
(isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderStatus", array()) == "2")) {
                        // line 13
                        echo "                                <span class=\"glyphicon glyphicon-chevron-up\"></span>
                            ";
                    }
                    // line 15
                    echo "                        ";
                }
                // line 16
                echo "                        ";
                if ( !twig_test_empty((isset($context["parameters"]) ? $context["parameters"] : $this->getContext($context, "parameters")))) {
                    // line 17
                    echo "                            ";
                    // line 18
                    echo "                            ";
                    $context["parameters"] = twig_array_merge((isset($context["parameters"]) ? $context["parameters"] : $this->getContext($context, "parameters")), array("order_col" => $this->getAttribute($context["column"], "name", array()), "order_status" => (isset($context["order"]) ? $context["order"] : $this->getContext($context, "order"))));
                    // line 19
                    echo "                                <a href='";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute(                    // line 20
(isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderRoute", array()),                     // line 21
(isset($context["parameters"]) ? $context["parameters"] : $this->getContext($context, "parameters"))), "html", null, true);
                    // line 23
                    echo "'
                            >";
                    // line 24
                    echo twig_escape_filter($this->env, $this->getAttribute($context["column"], "name", array()), "html", null, true);
                    echo "</a>
                        ";
                } else {
                    // line 26
                    echo "                            <a href='";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute(                    // line 27
(isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderRoute", array()), array("order_col" => $this->getAttribute(                    // line 29
$context["column"], "name", array()), "order_status" =>                     // line 30
(isset($context["order"]) ? $context["order"] : $this->getContext($context, "order")))), "html", null, true);
                    // line 33
                    echo "'
                               >";
                    // line 34
                    echo twig_escape_filter($this->env, $this->getAttribute($context["column"], "name", array()), "html", null, true);
                    echo "</a>
                        ";
                }
                // line 36
                echo "                           
                    ";
            } else {
                // line 37
                echo "    
                        ";
                // line 38
                echo twig_escape_filter($this->env, $this->getAttribute($context["column"], "name", array()), "html", null, true);
                echo "
                    ";
            }
            // line 40
            echo "                   </th>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "            </tr>
            </thead>
            ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 45
            echo "                ";
            echo twig_include($this->env, $context, "ListViewBundle:ListView:Item.html.twig", array("row" =>             // line 47
$context["row"], "columns" => $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "columns", array()), "format" => $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "format", array())));
            // line 49
            echo "
            ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        echo "        </table>
        <div>
            ";
        // line 53
        if (array_key_exists("paginator_enabled", $context)) {
            // line 54
            echo "                ";
            echo $this->env->getExtension('knp_pagination')->render($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")));
            echo "
            ";
        }
        // line 56
        echo "        </div>
        ";
        
        $__internal_d2baeba9fd5d33f2214b5028ed2f6c38626f87e3b92a83f3ce920ffd0f6483c5->leave($__internal_d2baeba9fd5d33f2214b5028ed2f6c38626f87e3b92a83f3ce920ffd0f6483c5_prof);

    }

    public function getTemplateName()
    {
        return "ListViewBundle:ListView:ListView.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 56,  160 => 54,  158 => 53,  154 => 51,  139 => 49,  137 => 47,  135 => 45,  118 => 44,  114 => 42,  107 => 40,  102 => 38,  99 => 37,  95 => 36,  90 => 34,  87 => 33,  85 => 30,  84 => 29,  83 => 27,  81 => 26,  76 => 24,  73 => 23,  71 => 21,  70 => 20,  68 => 19,  65 => 18,  63 => 17,  60 => 16,  57 => 15,  53 => 13,  51 => 12,  45 => 10,  42 => 9,  39 => 8,  36 => 7,  34 => 6,  31 => 5,  27 => 4,  22 => 1,);
    }
}
/*     <table class="table table-hover">*/
/*             <thead>*/
/*             <tr>*/
/*                 {% for column in list.columns %}*/
/*                    <th>*/
/*                     {% if column.allow_order == "1" %}*/
/*                         {% set order = 1 %}*/
/*                         {% if column.name == list.OrderCol %}*/
/*                             {% set order = list.getNextOrderStatus()%}*/
/*                             {% if list.orderStatus == "1" %} */
/*                                 <span class="glyphicon glyphicon-chevron-down"></span>*/
/*                             {% elseif list.orderStatus == "2" %}*/
/*                                 <span class="glyphicon glyphicon-chevron-up"></span>*/
/*                             {% endif %}*/
/*                         {% endif %}*/
/*                         {% if parameters is not empty %}*/
/*                             {# USAR MERGE ANTES#}*/
/*                             {% set parameters = parameters|merge({ 'order_col' : column.name, 'order_status': order }) %}*/
/*                                 <a href='{{ */
/*                                     path(list.orderRoute, */
/*                                     parameters*/
/*                                 ) */
/*                             }}'*/
/*                             >{{column.name}}</a>*/
/*                         {% else %}*/
/*                             <a href='{{ */
/*                                         path(list.orderRoute, */
/*                                         {*/
/*                                             'order_col' : column.name,*/
/*                                             'order_status': order*/
/*                                         }*/
/*                                     ) */
/*                                }}'*/
/*                                >{{column.name}}</a>*/
/*                         {%endif%}*/
/*                            */
/*                     {% else %}    */
/*                         {{ column.name }}*/
/*                     {% endif %}*/
/*                    </th>*/
/*                 {% endfor %}*/
/*             </tr>*/
/*             </thead>*/
/*             {% for row in data %}*/
/*                 {{ include(*/
/*                         'ListViewBundle:ListView:Item.html.twig',*/
/*                         {'row': row, 'columns':list.columns, 'format': list.format}*/
/*                     )*/
/*                 }}*/
/*             {% endfor %}*/
/*         </table>*/
/*         <div>*/
/*             {%if paginator_enabled is defined %}*/
/*                 {{ knp_pagination_render(data) }}*/
/*             {%endif%}*/
/*         </div>*/
/*         */

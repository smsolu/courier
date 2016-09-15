<?php

/* ListViewBundle:ListView:ListPrueba.html.twig */
class __TwigTemplate_908e6a7335d178a5efe9d25740f00687489e399a0f0c1ae782605c42bb5a5541 extends Twig_Template
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
        $__internal_fe1c46046b9a0f626a50637df1811943286ef98e1600f93044132f08d13a7e4e = $this->env->getExtension("native_profiler");
        $__internal_fe1c46046b9a0f626a50637df1811943286ef98e1600f93044132f08d13a7e4e->enter($__internal_fe1c46046b9a0f626a50637df1811943286ef98e1600f93044132f08d13a7e4e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ListViewBundle:ListView:ListPrueba.html.twig"));

        // line 6
        echo "<div>
    <h1>PRUEBA</h1>
</div>
<table class=\"table table-hover\">
            <thead>
            <tr>
                ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "columns", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 13
            echo "                   <th>
                    ";
            // line 14
            if (($this->getAttribute($context["column"], "allow_order", array()) == "1")) {
                // line 15
                echo "                        ";
                $context["order"] = 1;
                // line 16
                echo "                        ";
                if (($this->getAttribute($context["column"], "name", array()) == $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "OrderCol", array()))) {
                    // line 17
                    echo "                            ";
                    $context["order"] = $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "getNextOrderStatus", array(), "method");
                    // line 18
                    echo "                            ";
                    if (($this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderStatus", array()) == "1")) {
                        echo " 
                                <span class=\"glyphicon glyphicon-chevron-down\"></span>
                            ";
                    } elseif (($this->getAttribute(                    // line 20
(isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderStatus", array()) == "2")) {
                        // line 21
                        echo "                                <span class=\"glyphicon glyphicon-chevron-up\"></span>
                            ";
                    }
                    // line 23
                    echo "                        ";
                }
                // line 24
                echo "                        
                        ";
                // line 25
                if ( !twig_test_empty((isset($context["tipo"]) ? $context["tipo"] : $this->getContext($context, "tipo")))) {
                    // line 26
                    echo "                            ";
                    // line 36
                    echo "                            ";
                    echo $this->env->getExtension('knp_pagination')->sortable($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), $this->getAttribute($context["column"], "name", array()), $this->getAttribute($context["column"], "name", array()));
                    echo "
                        ";
                } else {
                    // line 38
                    echo "                            <a href='";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute(                    // line 39
(isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "orderRoute", array()), array("order_col" => $this->getAttribute(                    // line 41
$context["column"], "name", array()), "order_status" =>                     // line 42
(isset($context["order"]) ? $context["order"] : $this->getContext($context, "order")))), "html", null, true);
                    // line 45
                    echo "'
                               >";
                    // line 46
                    echo twig_escape_filter($this->env, $this->getAttribute($context["column"], "name", array()), "html", null, true);
                    echo "</a>
                        ";
                }
                // line 48
                echo "                           
                    ";
            } else {
                // line 49
                echo "    
";
                // line 51
                echo $this->env->getExtension('knp_pagination')->sortable($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), $this->getAttribute($context["column"], "name", array()), ("u." . twig_lower_filter($this->env, $this->getAttribute($context["column"], "column", array()))));
                echo "
                    ";
            }
            // line 53
            echo "                   </th>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "            </tr>
            </thead>
            ";
        // line 57
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
            // line 58
            echo "                ";
            echo twig_include($this->env, $context, "ListViewBundle:ListView:Item.html.twig", array("row" =>             // line 60
$context["row"], "columns" => $this->getAttribute((isset($context["list"]) ? $context["list"] : $this->getContext($context, "list")), "columns", array())));
            // line 62
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
        // line 64
        echo "        </table>
        
        <table>
            <tr>
            ";
        // line 69
        echo "                <th>";
        echo $this->env->getExtension('knp_pagination')->sortable($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), "Nombre", "u.username");
        echo "</th>
                <th>";
        // line 70
        echo $this->env->getExtension('knp_pagination')->sortable($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), "Email", "u.email");
        echo "</th>
            </tr>
        </table>
        <div>
            ";
        // line 74
        echo $this->env->getExtension('knp_pagination')->render($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")));
        echo "
        </div>
  ";
        
        $__internal_fe1c46046b9a0f626a50637df1811943286ef98e1600f93044132f08d13a7e4e->leave($__internal_fe1c46046b9a0f626a50637df1811943286ef98e1600f93044132f08d13a7e4e_prof);

    }

    public function getTemplateName()
    {
        return "ListViewBundle:ListView:ListPrueba.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  167 => 74,  160 => 70,  155 => 69,  149 => 64,  134 => 62,  132 => 60,  130 => 58,  113 => 57,  109 => 55,  102 => 53,  97 => 51,  94 => 49,  90 => 48,  85 => 46,  82 => 45,  80 => 42,  79 => 41,  78 => 39,  76 => 38,  70 => 36,  68 => 26,  66 => 25,  63 => 24,  60 => 23,  56 => 21,  54 => 20,  48 => 18,  45 => 17,  42 => 16,  39 => 15,  37 => 14,  34 => 13,  30 => 12,  22 => 6,);
    }
}
/* {#<div class="panel panel-default">*/
/*     <div class="panel-heading">*/
/*         {{ list.title }}*/
/*     </div>*/
/*     <div class="panel-body">#}*/
/* <div>*/
/*     <h1>PRUEBA</h1>*/
/* </div>*/
/* <table class="table table-hover">*/
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
/*                         */
/*                         {% if tipo is not empty %}*/
/*                             {#<a href='{{ */
/*                                     path(list.orderRoute, */
/*                                     {*/
/*                                         'order_col' : column.name,*/
/*                                         'order_status': order,*/
/*                                         'tipo': tipo*/
/*                                     }*/
/*                                 ) */
/*                             }}'*/
/*                             >{{column.name}}</a>#}*/
/*                             {{ knp_pagination_sortable(data, column.name, column.name) }}*/
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
/* {#                        {{ column.name }}#}*/
/* {{ knp_pagination_sortable(data, column.name, 'u.'~ column.column|lower) }}*/
/*                     {% endif %}*/
/*                    </th>*/
/*                 {% endfor %}*/
/*             </tr>*/
/*             </thead>*/
/*             {% for row in data %}*/
/*                 {{ include(*/
/*                         'ListViewBundle:ListView:Item.html.twig',*/
/*                         {'row': row, 'columns':list.columns}*/
/*                     )*/
/*                 }}*/
/*             {% endfor %}*/
/*         </table>*/
/*         */
/*         <table>*/
/*             <tr>*/
/*             {# sorting of properties based on query components #}*/
/*                 <th>{{ knp_pagination_sortable(data, 'Nombre', 'u.username') }}</th>*/
/*                 <th>{{ knp_pagination_sortable(data, 'Email', 'u.email') }}</th>*/
/*             </tr>*/
/*         </table>*/
/*         <div>*/
/*             {{ knp_pagination_render(data) }}*/
/*         </div>*/
/*   {#  </div>#}*/
/* {#</div>#}*/

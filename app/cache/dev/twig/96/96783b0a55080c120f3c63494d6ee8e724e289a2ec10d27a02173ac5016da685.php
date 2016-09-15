<?php

/* ListViewBundle:ListView:Item.html.twig */
class __TwigTemplate_0f42e1372248a8c46bbe13f8a0f6bc83dca4ba174d81cfa40032918a3cc583f1 extends Twig_Template
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
        $__internal_198c57be74cda09ecf8c2e549e3dfdb3df09f1c5e8a3c5f6cd2e315273feab03 = $this->env->getExtension("native_profiler");
        $__internal_198c57be74cda09ecf8c2e549e3dfdb3df09f1c5e8a3c5f6cd2e315273feab03->enter($__internal_198c57be74cda09ecf8c2e549e3dfdb3df09f1c5e8a3c5f6cd2e315273feab03_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ListViewBundle:ListView:Item.html.twig"));

        // line 1
        if ((array_key_exists("format", $context) &&  !twig_test_empty((isset($context["format"]) ? $context["format"] : $this->getContext($context, "format"))))) {
            // line 2
            echo "    <tr class=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["format"]) ? $context["format"] : $this->getContext($context, "format")), "getClassRow", array(0 => (isset($context["row"]) ? $context["row"] : $this->getContext($context, "row"))), "method"), "html", null, true);
            echo "\" >
";
        } else {
            // line 4
            echo "    <tr>
";
        }
        // line 6
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["columns"]) ? $context["columns"] : $this->getContext($context, "columns")));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 7
            echo "        ";
            if ((array_key_exists("format", $context) &&  !twig_test_empty((isset($context["format"]) ? $context["format"] : $this->getContext($context, "format"))))) {
                // line 8
                echo "            <td class=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["format"]) ? $context["format"] : $this->getContext($context, "format")), "getClassCell", array(0 => (isset($context["row"]) ? $context["row"] : $this->getContext($context, "row")), 1 => $this->getAttribute($context["column"], "name", array())), "method"), "html", null, true);
                echo "\" >
        ";
            } else {
                // line 10
                echo "            <td>
        ";
            }
            // line 12
            echo "                ";
            if (($this->getAttribute($context["column"], "type", array()) == "object")) {
                // line 13
                echo "                    ";
                $context["obj"] = $this->getAttribute((isset($context["row"]) ? $context["row"] : $this->getContext($context, "row")), $this->getAttribute($context["column"], "object", array()));
                // line 14
                echo "                    ";
                $context["columnName"] = $this->getAttribute($context["column"], "property", array());
                // line 15
                echo "                ";
            } else {
                // line 16
                echo "                    ";
                $context["columnName"] = $this->getAttribute($context["column"], "column", array());
                // line 17
                echo "                    ";
                $context["obj"] = (isset($context["row"]) ? $context["row"] : $this->getContext($context, "row"));
                echo "                    
                ";
            }
            // line 19
            echo "        
                ";
            // line 20
            if (($this->getAttribute($context["column"], "type", array()) == "link")) {
                // line 21
                echo "                    <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute($this->getAttribute($context["column"], "route", array()), "getRouteName", array()), $this->getAttribute($this->getAttribute($context["column"], "route", array()), "getRouteParameters", array(0 => (isset($context["row"]) ? $context["row"] : $this->getContext($context, "row"))), "method")), "html", null, true);
                echo "\">";
                echo $this->getAttribute($context["column"], "value", array());
                echo "</a>
                ";
            } else {
                // line 23
                echo "                    ";
                if (($this->getAttribute($context["column"], "type", array()) == "string")) {
                    // line 24
                    echo "                        ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), "html", null, true);
                    echo "
                    ";
                } elseif (($this->getAttribute(                // line 25
$context["column"], "type", array()) == "datetime")) {
                    // line 26
                    echo "                        ";
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), "d/m/Y H:i"), "html", null, true);
                    echo "
                    ";
                } elseif (($this->getAttribute(                // line 27
$context["column"], "type", array()) == "date")) {
                    // line 28
                    echo "                        ";
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), "d/m/Y"), "html", null, true);
                    echo "
                    ";
                } elseif (($this->getAttribute(                // line 29
$context["column"], "type", array()) == "raw")) {
                    // line 30
                    echo "                        ";
                    echo $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName")));
                    echo "
                    ";
                } elseif (($this->getAttribute(                // line 31
$context["column"], "type", array()) == "time")) {
                    // line 32
                    echo "                        ";
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), "H:i"), "html", null, true);
                    echo "
                    ";
                } elseif (($this->getAttribute(                // line 33
$context["column"], "type", array()) == "boolean")) {
                    // line 34
                    echo "                        ";
                    echo (($this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName")))) ? ("Si") : ("No"));
                    echo "                        
                    ";
                } elseif (($this->getAttribute(                // line 35
$context["column"], "type", array()) == "money")) {
                    // line 36
                    echo "                        ";
                    echo twig_escape_filter($this->env, ("\$ " . twig_number_format_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), 2, ",", ".")), "html", null, true);
                    echo "                        
                    ";
                } else {
                    // line 38
                    echo "                       ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["obj"]) ? $context["obj"] : $this->getContext($context, "obj")), (isset($context["columnName"]) ? $context["columnName"] : $this->getContext($context, "columnName"))), "html", null, true);
                    echo "
                    ";
                }
                // line 40
                echo "                ";
            }
            // line 41
            echo "            </td>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "</tr>";
        
        $__internal_198c57be74cda09ecf8c2e549e3dfdb3df09f1c5e8a3c5f6cd2e315273feab03->leave($__internal_198c57be74cda09ecf8c2e549e3dfdb3df09f1c5e8a3c5f6cd2e315273feab03_prof);

    }

    public function getTemplateName()
    {
        return "ListViewBundle:ListView:Item.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  153 => 43,  146 => 41,  143 => 40,  137 => 38,  131 => 36,  129 => 35,  124 => 34,  122 => 33,  117 => 32,  115 => 31,  110 => 30,  108 => 29,  103 => 28,  101 => 27,  96 => 26,  94 => 25,  89 => 24,  86 => 23,  78 => 21,  76 => 20,  73 => 19,  67 => 17,  64 => 16,  61 => 15,  58 => 14,  55 => 13,  52 => 12,  48 => 10,  42 => 8,  39 => 7,  34 => 6,  30 => 4,  24 => 2,  22 => 1,);
    }
}
/* {% if format is defined and not format is empty %}*/
/*     <tr class="{{format.getClassRow(row)}}" >*/
/* {% else %}*/
/*     <tr>*/
/* {% endif %}*/
/*     {% for column in columns %}*/
/*         {% if format is defined and not format is empty %}*/
/*             <td class="{{format.getClassCell(row, column.name)}}" >*/
/*         {% else %}*/
/*             <td>*/
/*         {% endif %}*/
/*                 {%if column.type == 'object' %}*/
/*                     {% set obj = attribute(row, column.object) %}*/
/*                     {% set columnName = column.property %}*/
/*                 {%else%}*/
/*                     {% set columnName = column.column %}*/
/*                     {% set obj = row %}                    */
/*                 {%endif%}*/
/*         */
/*                 {% if column.type == 'link' %}*/
/*                     <a href="{{ path(column.route.getRouteName, column.route.getRouteParameters(row)) }}">{{ column.value|raw }}</a>*/
/*                 {% else %}*/
/*                     {% if column.type == 'string' %}*/
/*                         {{attribute(obj, columnName)}}*/
/*                     {% elseif column.type == 'datetime' %}*/
/*                         {{ attribute(obj, columnName)|date("d/m/Y H:i") }}*/
/*                     {% elseif column.type == 'date' %}*/
/*                         {{attribute(obj, columnName)|date("d/m/Y") }}*/
/*                     {% elseif column.type == 'raw' %}*/
/*                         {{attribute(obj, columnName)|raw }}*/
/*                     {% elseif column.type == 'time' %}*/
/*                         {{ attribute(obj, columnName)|date("H:i") }}*/
/*                     {% elseif column.type == 'boolean' %}*/
/*                         {{ attribute(obj, columnName)? 'Si':'No' }}                        */
/*                     {% elseif column.type == 'money' %}*/
/*                         {{ '$ ' ~ attribute(obj, columnName)|number_format(2, ',', '.') }}                        */
/*                     {% else %}*/
/*                        {{attribute(obj, columnName)}}*/
/*                     {% endif %}*/
/*                 {% endif %}*/
/*             </td>*/
/*     {% endfor %}*/
/* </tr>*/

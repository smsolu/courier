<?php
namespace ABMBundle\Services;
class AbmButton {
    private $menuVisible;
    private $type; //DEL TIPO AbmManager::const
    private $name;
    private $label;
    private $route;
    private $visible;


    public function __construct($name, $label, $menuVisible,$type,$route, $visible) {
        $this->menuVisible = $menuVisible;
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->route = $route;
        $this->visible = $visible;
    }
    public function setRoute($route){
        $this->route = $route;
    }
    public function getRoute(){
        return $this->route;
    }
    public function setType($type){
        $this->type = $type;
    }
    public function getType(){
        return $this->type;
    }      
    public function setMenuVisible($menuVisible){
        $this->menuVisible = $menuVisible;
    }
    public function getMenuVisible(){
        return $this->menuVisible;
    }   
    function getName() {
        return $this->name;
    }

    function getLabel() {
        return $this->label;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLabel($label) {
        $this->label = $label;
    }
    function getVisible() {
        return $this->visible;
    }

    function setVisible($visible) {
        $this->visible = $visible;
    }
}

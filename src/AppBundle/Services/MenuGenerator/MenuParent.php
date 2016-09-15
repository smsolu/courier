<?php
namespace AppBundle\Services\MenuGenerator;

// Permite agregar X MenuGenerators

class MenuParent {
    private $heading;
    private $menus;

    public function __construct() {
        $this->heading = ''; 
        $this->menus = array();
        $this->separator = '<div style="spacing:10px;margin:10px;padding:10px"></div>';
    }

    
    public function addMenu($order,$name, $menuGenerator){
        $this->menus[$order] = array(
                    'name' => $name,
                    'menu' => $menuGenerator,
                );
        return $this;
    }

    public function setHeading($heading){
        $this->heading = $heading;
        return $this;
    }
    public function getHeading(){
        return $this->heading;
    }
    public function setSeparator($separator){
        $this->separator = $separator;
        return $this;
    }
    public function getSeparator(){
        return $this->serparator;
    }    
    
    public function getMenus(){
        return $this->menus;
    }
    
}


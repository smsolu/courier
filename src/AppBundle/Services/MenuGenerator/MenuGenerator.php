<?php
namespace AppBundle\Services\MenuGenerator;

class MenuGenerator {
    private $heading;
    private $sections;
    private $subheading;
    private $category;
    private $twigPath;
    private $arrayData;
    private $richTitle;

    public function __construct() {
        $this->heading = ''; 
        $this->sections = array();
        $this->richTitle = false;
        $this->twigPath = null;
        $this->arrayData = null;
        $this->classMenu = 'panel panel-primary';
        $this->styleMenu = "";
    }
    /**
     * Reemplaza el titulo, y la cabecera por un twig con el objeto.
     * @param type $twigPath
     * @param type $objData
     */
    public function setRichFormat($twigPath, $arrayData){
        $this->twigPath = $twigPath;
        $this->arrayData = $arrayData;
        $this->richTitle = true;
        return $this;
    }
    
    
    
    public function addSection($name, $link, $value, $active = false, $class=''){
        $this->sections[$name] = array(
                    'name' => $name,
                    'link' => $link,
                    'value' => $value,
                    'active' => $active,
                    'class' => $class
                );
        return $this;
    }

    public function getRichTitle(){
        return $this->richTitle;
    }       
    public function getTwigPath(){
        return $this->twigPath;
    }    
    public function getArrayData(){
        return $this->arrayData;
    }        
    
    public function setCategory($category){
        $this->category = $category;
        return $this;
    }    
    public function getCategory(){
        return $this->category;
    }        
    public function setSubHeading($subheading){
        $this->subheading = $subheading;
        return $this;
    }    
    public function getSubHeading(){
        return $this->subheading;
    }    
    public function setHeading($heading){
        $this->heading = $heading;
        return $this;
    }
    
    public function getHeading(){
        return $this->heading;
    }
    
    public function getSections(){
        return $this->sections;
    }
    public function getActive(){
        foreach($this->sections as $section){
            if($section->active){
                return $section->name;
            }
        }
        return '';
    }
    public function setActive($active){
        if(isset($this->sections[$active])){
            $this->sections[$active]['active'] = true;
        }
        return $this;
    }
    
    public function setMenuClass($menuclass){
        $this->menuClass = $menuclass;
        return $this;
    }
    
    public function getMenuClass(){
        return $this->menuClass;
    }    
    
    
    public function setMenuStyle($menustyle){
        $this->menuStyle = $menustyle;
        return $this;
    }
    
    public function getMenuStyle(){
        return $this->menuStyle;
    }    
}


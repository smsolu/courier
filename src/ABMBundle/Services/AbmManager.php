<?php
namespace ABMBundle\Services;
use ABMBundle\Services\AbmButton;

class AbmManager {
    
    /* TIPOS DE BOTONES QUE SE AGREGAN AL ABMMANAGER */
    const button_cancel = 0;
    const button_new = 1;
    const button_savemodify = 2;    
    const button_save = 3;
    const button_custom = 4;
    
    const abm_ope_new = 0;
    const abm_ope_show = 1;
    const abm_ope_modify = 2;
    
    private $buttons;
    private $form;
    private $message;
    private $title;
    private $subtitle;
    private $show_modify = true;
    private $show_cancel = true;
    private $show_save = true;
    
    function __construct() {
        $this->form = null;
        $this->cancel_path = "";
        $this->message = "";
        $this->title = "";
        $this->subtitle = "";
        $this->fields = array();
        $this->show_modify = true;
        $this->show_cancel = true;
        $this->show_save = true; 
        
        //AGREGAR LOS BOTONES ESTANDAR!
        $this->addButton("cancel", "Cancelar", true, AbmManager::button_cancel, "",true);
        $this->addButton("modificar", "Guardar y Modificar", false, AbmManager::button_savemodify, "",true);
        $this->addButton("save", "Guardar", false, AbmManager::button_save, "",true);                
    }
    function getEditPath() {
        $button = $this->getButton("modificar");
        return $button->getRoute();
    }

    function getForm() {
        return $this->form;
    }

    function getCancelPath() {
        $button = $this->getButton("cancel");
        return $button->getRoute();
    }

    function getMessage() {
        return $this->message;
    }

    function getTitle() {
        return $this->title;
    }

    function getSubtitle() {
        return $this->subtitle;
    }

    function getShowButtonModify(){
        $button = $this->getButton("modificar");
        return $button->getVisible();        
    }
    function getShowButtonSave(){
        $button = $this->getButton("save");
        return $button->getVisible();
    }
    function getShowButtonCancel(){
        $button = $this->getButton("cancel");
        return $button->getVisible();
    }        

    function setShowButtonModify($bStatus){
        $button = $this->getButton("modificar");
        $button->setVisible($bStatus);
        return $this;
    }
    function setShowButtonSave($bStatus){
        $button = $this->getButton("save");
        $button->setVisible($bStatus);
        return $this;
    }
    function setShowButtonCancel($bStatus){
        $button = $this->getButton("cancel");
        $button->setVisible($bStatus);
        return $this;
    }    
    function setEditPath($edit_path) {
        $button = $this->getButton("modificar");
        $button->setRoute($edit_path);
        return $this;
    }
    
    function setForm($form) {
        $this->form = $form;
        return $this;
    }

    function setCancelPath($cancel_path) {
        $button = $this->getButton("cancel");
        $button->setRoute($cancel_path);
        return $this;
    }

    function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
        return $this;
    }
    
    function getFields() {
        return $this->fields;
    }

    function setFields($fields) {
        $this->fields = $fields;
        return $this;
    }

    function addButton($name, $label, $menuVisible,$type,$route,$visible){
        $button = new AbmButton($name, $label, $menuVisible,$type,$route,$visible);
        $this->buttons[$name] = $button;
    }
    function getButtons(){
        return $this->buttons;
    }
    function getButton($name){
        return $this->buttons[$name];
    }
    function setOperation($operation){
        //Usado para el SHOW, desactiva todos los botones y deja el de modificar solamente
        foreach ($this->buttons as $button){
            if($button->getType() != AbmManager::button_custom  ){
                $button->setVisible(false);$button->setMenuVisible(false);
            }
        }
        
        switch($operation){
            case AbmManager::abm_ope_new; DEFAULT:
                $button = $this->getButton("modificar");
                $button->setVisible(true);$button->setMenuVisible(false);
                $button = $this->getButton("cancel");
                $button->setVisible(true);$button->setMenuVisible(true);                
                $button = $this->getButton("save");
                $button->setVisible(true);$button->setMenuVisible(false); 
            break;
            case AbmManager::abm_ope_show:
                $button = $this->getButton("modificar");
                $button->setVisible(true);$button->setMenuVisible(true);
                $button->setLabel("Modificar");
            break;
            case AbmManager::abm_ope_modify:
                $button = $this->getButton("modificar");
                $button->setVisible(false);$button->setMenuVisible(false);
                $button = $this->getButton("cancel");
                $button->setVisible(true);$button->setMenuVisible(true);                
                $button = $this->getButton("save");
                $button->setVisible(true);$button->setMenuVisible(false);                
            break;       
        }
        
        return $this;
    }
}


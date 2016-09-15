<?php
namespace ABMBundle\Services;
class AbmField {
    private $routeName;
    private $parameters;

    public function __construct($routeName, $parameters) {
        $this->routeName = $routeName;
        $this->parameters = $parameters;
    }
    public function setRoute($route, $parameters){
        $this->route = $route;
        $this->parameters = $parameters;
    }
    
    public function getRouteParameters($entity){
        $entityParams = array();
        foreach($this->parameters as $key => $param){
            $entityParams[$key] = $entity->$param();
        }
        return $entityParams;
    }
    public function getRouteName(){
        return $this->routeName;
    }
}

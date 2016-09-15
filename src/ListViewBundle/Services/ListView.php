<?php
namespace ListViewBundle\Services;

class ListView {
    private $data;
    private $columns;
    private $title;
    private $queryBuilder = null;
    private $queryBuilderPrefix = 'e';
    private $resultpage=10;
    private $page = 1;
    private $url_parent = '';
    private $order_col_fieldname = '';
    private $order_col = '';    
    private $order_status = '';
    private $order_route ='';
    private $parentController = null; // Para poder ejecutar el translate
    private $format = null;
    private $sendObjects = false;
    
    public function getSendObjects(){
        return $this->sendObjects;
    }
    public function setSendObjects($value){
        $this->sendObjects = $value;
        return $this;
    }    
    
    public function getOrderRoute(){
        return $this->order_route;
    }
    public function setOrderRoute($order_route){
        $this->order_route = $order_route;
        return $this;
    }
    function getQueryBuilderPrefix() {
        return $this->queryBuilderPrefix;
    }

    function setQueryBuilderPrefix($queryBuilderPrefix) {
        $this->queryBuilderPrefix = $queryBuilderPrefix;
        return $this;
    }
    
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function getParent(){
        return $this->url_parent;
    }
    
    public function setOrderCol($colName,$status){
        /**
         * Setea la columna en la que se va a ordenar, si no logra encontrar ninguna setea con la primer
         * columna que permite orden
         */

        $this->order_status=$status;
        $this->order_col = $colName;
        $this->order_col_fieldname = "";
        $firstElementOrder = '';
        foreach($this->columns as $element){
            if ($element['allow_order'] == '1' && $firstElementOrder == ''){
                $firstElementOrder = $element['column'];
            }
            if ($element['name'] == $colName && $element['allow_order'] == '1'){
                $element['order_status'] = $status;
                $firstElementOrder = $element['column'];
            }
        }
        $this->order_col_fieldname = $this->getQueryBuilderPrefix().".".$firstElementOrder;   
        return $this;
        
    }
    
    public function getOrderColFieldName(){
        return $this->order_col_fieldname;
    }
    
    public function getOrderCol(){
        return $this->order_col;
    }
    public function getOrderStatus(){
        return $this->order_status;
    }
    public function getNextOrderStatus(){
        switch ($this->order_status){
            case 0:
                return 1;
            case 1:
                return 2;
            case 2:
                return 1;
        }
    }
    public function setControllerParent($parentController){
        $this->parentController  = $parentController;
        return $this;
    }
    public function addColumn($name, $dbColumn, $options = array()){
        $index = count($this->columns);
        
        // Revisar si tiene un translate esa columna.
        // Lo hace automaticamente buscando en el archivo message un valor col_ + dbcolumn
//        if(!array_key_exists('label',$options)){
//            $name =  $this->columns[$index]['label'];
//        }else{
        if($name ==""){
            if($this->parentController != null){
                $trans = 'col_' . $dbColumn;
//                HACER: inyectar el translator para hacer esto
                $name_trans = $this->parentController->get('translator')->trans($trans);
                if($name_trans != $trans){
                    $name  = $name_trans;
                }
            }
        }

                
        $this->columns[$index] = array(
                        'name' => $name,
                        'column' => $dbColumn,
                    );
        if(!array_key_exists('type',$options)){
            $this->columns[$index]['type'] = 'string';
        }
        if(!array_key_exists('allow_order',$options)){
            $this->columns[$index]['allow_order'] = "0";
        }
        if(!array_key_exists('allow_find',$options)){
            $this->columns[$index]['allow_find'] = "0";
        }              
        if(!array_key_exists('order_status',$options)){
            $this->columns[$index]['order_status'] = "0";
        }
        if(!array_key_exists('object_property',$options)){
            $this->columns[$index]['object_property'] = "";
        }        
        /**
         * order_status => 0 => No Order
         * order_status => 1 => Order DESC
         * order_status => 2 => Order ASC
         */
        if($options){
            foreach($options as $key =>$option){
                $this->columns[$index][$key] = $option;
            }
        }
        $type = $this->columns[$index]['type'];
        if($type=="object"){
            $object = $this->strAntes($this->columns[$index]['column'],".");
            $property = $this->strDespues($this->columns[$index]['column'],".");
            
            $this->columns[$index]['object'] = $object;
            $this->columns[$index]['property'] = $property;
        }
        
        return $this;
    }
    public function getColumns(){
        return $this->columns;
    }
    public function getList(){
        
    }
    public function setQueryBuilder($query){
        $this->queryBuilder = $query;
        return $this;
    }
    public function getQueryBuilder(){
        return $this->queryBuilder;
    }

    public function setPage($page){
        $this->page = $page;
        return $this;
    }
    public function getPage(){
        return $this->page;
    }
    
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setFormat($value){
        $this->format = $value;
        return $this;
    }
    public function getFormat(){
        return $this->format;
    }    
    
    public function setResultPage($resultPage){
        $this->resultpage=$resultPage;
        return $this;
    }
    public function getResultPage(){
        return $this->resultpage;
    }
    public function getQuery(){
        if($this->queryBuilder){
            if($this->order_col_fieldname!='' && $this->order_col_fieldname !='e.'){
                $this->queryBuilder->orderBy($this->order_col_fieldname, $this->getOrderStatusString($this->order_status));
            }
        }
        return $this->queryBuilder->getQuery();
    }
    private function getOrderStatusString($order_status){
        switch ($order_status){
            case 0:
                return '';
            case 1:
                return 'DESC';
            case 2:
                return 'ASC';
        }
    }

/**
     * Devuelve el contenido posterior al separador, si no lo encuentra devuelve vacio.
     * @param type $linea : [string] Linea origen de texto
     * @param type $sep : [string] Separador
     * @param type $final : [Boolean] Si final = true busca el separador desde el final de la linea.
     * @return string
     */
    function strDespues($linea,$sep = " ",$final =false)
    {
        if($final == false)
            {$tmpLinea = $linea;
        }else{
             $tmpLinea = strrev($linea);
             $sep = strrev($sep);
        };
        
        $t = stripos($tmpLinea,$sep);
        if($t!==false){
            if($final) {
                $t = strlen($linea)- $t;
                return substr($linea , $t, strlen($linea));
            }else{
                return substr($linea , -(strlen($linea) - $t - strlen($sep)));
            }
        }else{
            return "";
        }
    }

     /**
     * Devuelve el contenido anterior al separador, si no lo encuentra devuelve vacio.
     * @param type $linea : [string] Linea origen de texto
     * @param type $sep : [string] Separador
     * @param type $final : [Boolean] Si final = true busca el separador desde el final de la linea.
     * @return string
     */
    public function strAntes($linea, $sep= " ", $final = false){
        if($final == false){$tmpLinea = $linea;}else{$tmpLinea = strrev($linea);$sep = strrev($linea);};
        $t = stripos($tmpLinea,$sep);
        if($t!==false){
            if($final == true ) $t = strlen($linea)- $t;
            return substr($linea , 0, $t);
        }else{
            return "";
        }
    }   
}

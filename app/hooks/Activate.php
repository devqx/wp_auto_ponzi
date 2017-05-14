<?php 

/**
 *This class is responsible for defining methods 
 *to be called at plugin activation 
 *@since 1.0.0 
 */
 namespace app\hooks;

class Activate {
    /**
    *@var $model an instance of the model class 
    *@since 1.0.0
    */

    private $model;

    public function __construct($model,$pages){
        
        $this->model = $model;
        $this->page = $pages;
    }

    public function activate(){

        $this->model->migrations();
        $this->page->create_pages();
    }

}

?>
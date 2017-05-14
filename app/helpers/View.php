<?php

/**
* Class for rendering the views with dynamic data
*@since 1.0.0
*/

namespace app\helpers;

class View {

    public function __contsruct(){

    }

    /**
     *@return the_requested_template
     */

    public function load_view( $view_name, $data= array() ){
        $view_file = require( ABSPATH.'wp-content/plugins/auto-ponzi/app/views/'.$view_name.'.php' );
        if(file_exists(view_file)){
            return $view_file;

            
        }
    }

}


?>
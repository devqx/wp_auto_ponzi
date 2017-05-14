<?php 

/**
 * Utilities class for the plugin , run some errands 
 *@since 1.0.0
 */

namespace app\helpers;


 class Util{

     public function __construct(){

     }

     /**
      * Redirect current visitor
      *
      * @since 1.0.0
      **/

     public function redirect_logged_user(){
        if(is_user_logged_in()){
            wp_redirect(home_url('member-dashboard'));
        }
     }

     public function is_user_logged_in(){
         if(!is_user_logged_in()){
            wp_redirect(home_url('login'));
         }
     }

     public function get_user_info(){
         $current_user = wp_get_current_user();
         return  $current_user;
     }

 }

?>
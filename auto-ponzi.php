<?php 
/**
 * Plugin Name: Auto Ponzi
 * Plugin URI: http://www.devstackng.com
 * Description: Automatic ponzi system 
 * Version: 1.0.0
 * Author: Oluwaseun Paul 
 * Author URI: http://www.devstackng.com 
 * License: MIT 
 */

 ob_start();

//abort if the file is accessed directly 
if( !defined('WPINC') ){
    die;
}

require 'vendor/autoload.php';

use app\pages\Plugin_Pages;
use app\shortcodes\Plugin_Shortcodes;
use app\helpers\View;
use app\hooks\Hooks;
use app\hooks\Activate;
use app\hooks\Deactivate;
use app\model\Model;
use app\auth\Register;
use app\helpers\Util;
use app\assets\Assets;
use app\match\Match;
use app\users\Member_Area;



function init(){
    //pages class
    $pages = new Plugin_Pages();
   // $pages->create_pages();

    //assets class
    $assets = new Assets();
    $assets->load_assets();

    //model class 
    $model = new Model();
    //the view class
     $views = new View();

     //an instance of the match class
     $match = new Match($register);

     //the registration / auth class
     $register = new Register($match);

        //some helpers 
     $util = new Util();

     //an instance of Member_Area class
     $member_area = new Member_Area($model,$util,$match);

  
     //the shortcodes 
    $shortcodes = new Plugin_Shortcodes($views,$register,$util,$model,$member_area);
    $shortcodes->shortcodes();

    //all hooks and filters used 
    $hooks = new Hooks($assets, $model);
    $hooks->add_actions();
    $hooks->add_filters();



}

    function activate(){

        //create the plugin migrations and the plugin pages
        $model = new Model();

        $pages = new Plugin_Pages();

        $activator = new Activate($model, $pages);

        $activator->activate();

    }

    function deactivate(){

      $deactivator = new Deactivate();

      $deactivator->deactivate();  
    }

add_action( 'plugins_loaded', 'init' );

//register the plugin activation hooks 
register_activation_hook( __FILE__, 'activate' );

//register the plugin deactivation hooks 
register_deactivation_hook( __FILE__, 'deactivate' );


?>
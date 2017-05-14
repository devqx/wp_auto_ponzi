<?php 


/** 
 *class for rendering all shortcodes in the plugin 
 *@since 1.0.0
 *@author oluwaseun paul <devqxz@gmail.com>
 */

 namespace app\shortcodes;

 class Plugin_Shortcodes {

      /** 
       *@var $views holds an instance of the View class
       */
      private $views;

      /** 
       *@var $views holds an instance of the Utility class
       */
      private $util;

      /** 
       *@var $register holds an instance of the register class
       */
     private $register;

        /** 
       *@var $member_area holds an instance of the member_area class
       */
     private $member_area;

     public function __construct($view,$register,$util,$model,$member_area){
        $this->view = $view;
        $this->register = $register;
        $this->util = $util;
        $this->model = $model;
        $this->member_area = $member_area;
     }

     /**
     *@return the added shortcodes 
     */

     public function shortcodes(){
       add_shortcode('new-member-register', array($this, 'render_new_member_register'));
       add_shortcode('member-login', array($this, 'render_member_login'));
       add_shortcode('member-dashboard', array($this, 'render_member_dashboard')); 
       add_shortcode('admin-dashboard', array($this, 'render_admin_dashboard'));
       add_shortcode('admin-add-receiver', array($this, 'render_admin_addReceiver')); 

     }

     public function render_new_member_register(){
       $this->util->redirect_logged_user();
        $this->view->load_view('member_register');
        $this->register->register($this->model->donators_table, 'donator');
        
        
     }

      public function render_member_login(){
       
         $this->util->redirect_logged_user();
         $this->view->load_view('member_login', $data);
       
     }

     public function render_member_dashboard($data){
       $data['current_user'] = $this->util->get_user_info();
        $this->util->is_user_logged_in();
        $this->view->load_view('member_area',$data);
        $this->member_area->check_logged_user();
     }

     public function render_admin_dashboard(){
       $this->view->load_view('admin_dashboard');
     }

     public function render_admin_addReceiver(){
       $this->view->load_view('admin_add_receiver');
       $this->register->register($this->model->receivers_table, 'receiver');

     }


 }


?>
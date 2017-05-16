<?php 

/**
 * This class adds hooks ( actions and filters needed by the plugin )
 *
 *@since 1.0.0 
 */

 namespace app\hooks;

 class Hooks {

     private $redirect_url;

     private $assets;

     private $model;

     public function __construct($assets){

         $this->assets = $assets;
         $this->model = $model;

     }

     public function add_actions(){
        add_action('wp_head', array($this, 'custom_styles'));
        add_action('login_form_register', array($this, 'custom_redirect'));
        add_action('login_form_login', array($this, 'login_redirect'));
        //add_action('wp_head',array($this, 'show_scripts'));
        add_action('wp_enqueue_scripts',array($this, 'load_assets'));
       // add_action('wp_enqueue_scripts', array($this, 'localize_ajax'));
        add_action('wp_ajax_nopriv_handle_delete_user', array($this, 'handle_delete_user'));
        add_action('wp_ajax_handle_delete_user', array($this, 'handle_delete_user'));
        add_action('hourly_event', array($this, 'update_db_hourly'));
       
        
     }

     public function add_filters(){
         add_filter('authenticate', array($this, 'check_auth_errors' ),101,3);
         add_filter( 'login_redirect', array($this, 'auth_login_redirect'), 10, 3 );

     }

     public function custom_redirect(){

         if("GET" === $_SERVER['REQUEST_METHOD']){
             wp_redirect(home_url('registration'));
         }
        

     }


      public function login_redirect(){
          
         if("GET" === $_SERVER['REQUEST_METHOD']){
             wp_redirect(home_url('login'));
         }
        
     }

     public function auth_login_redirect($redirect_to, $request, $user){
       /**
        * Redirect user after successful login.
        *
        * @param string $redirect_to URL to redirect to.
        * @param string $request URL the user is coming from.
        * @param object $user Logged user's data.
        * @return string
        */
            //is there a user to check?
            if ( isset( $user->roles ) && is_array( $user->roles ) ) {
                //check for admins
                if ( in_array( 'administrator', $user->roles ) ) {
                    // redirect them to the default place
                    return $redirect_to;
                } else {
                    return home_url('member-dashboard');
                }
            } else {
                return $redirect_to;
            }
     }


     public function check_auth_errors($user,$username,$password){

         if("POST"===$_SERVER['REQUEST_METHOD']){
             if(is_wp_error($user)){
                $this->redirect_url = add_query_arg('login_errors', join(',',$user->get_error_codes()), home_url('login'));
                 wp_redirect($this->redirect_url);
                 exit;
             }
         }

        return $user;

     }  


     public function custom_styles(){
         echo "<style>input[type=text],input[type=password],input[type=email],input[type=number]{ height:3em;}</style>";
     }

     public function load_assets(){
         $this->assets->load_assets();

     }

     public function localize_ajax(){
         wp_localize_script( 'delete_user', 'wpdx_obj', array('ajax_url'=>admin_url('admin.php')) );
     }

     public function handle_delete_user(){

        global $wpdb;

        $donators_table = $this->model->donators_table;

        $user = $_POST['expired_user'];

        $check_if_paid = "SELECT payment_proof FROM $donators_table WHERE user_login='$user'";
        $proof_status = $wpdb->get_var($check_if_paid);

        if(empty($proof_status)){

        $delete_sql = "DELETE FROM $donators_table WHERE user_login='$user'";

        $del_respons = $wpdb->query($delete_sql);

        }

        exit;

     }

     
 }

?>
<?php 

namespace app\match;

class Match {

    private $model;

    private $register;

    public function __construct($register){

        $this->register = $register;

    }


    public function match_users($username){
    
    global $wpdb;
    
    //select a user from the receiver table who has not received and match to a new user 
    $receivers_table = $wpdb->prefix."autoponzi_ready_to_receive";
    $sql = "SELECT * FROM $receivers_table WHERE matched_to ='' ORDER BY created_at ASC LIMIT 1"; 
    $user_selected = $wpdb->get_row($sql, ARRAY_A);  
    $user_sel_username = $user_selected['user_login']; 
  
    //update the donators matched_to column for the found receiver 
    $username_to_match = $this->register->request['username'];

    $donators_table = $wpdb->prefix."autoponzi_ready_to_donate";

    $match_donator = "UPDATE $donators_table SET matched_to ='$user_sel_username' WHERE user_login='$username'";

    //update the receiver to know who he is matched to
    $the_receiver = "UPDATE $receivers_table SET matched_to ='$username' WHERE user_login='$user_sel_username'";

    $matched_receiver = $wpdb->query($the_receiver);

    $matched = $wpdb->query($match_donator);
   
    }

    public function get_matched_user_details($username,$table_name){
        global $wpdb;
        $details = "SELECT * FROM $table_name WHERE matched_to='$username'";
        $user_details = $wpdb->get_row($details);
        return $user_details;
    }
   
}

?>
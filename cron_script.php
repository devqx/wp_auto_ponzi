<?php

//cron_command : /usr/local/bin/php /home/user/public_html/cron_script.php

date_default_timezone_set('Africa/Lagos');

//require wordpress init
require(dirname(__FILE__).'/wp-blog-header.php');

global $wpdb;

//donators table 
$donators_table = $wpdb->prefix.'autoponzi_ready_to_donate';

//receivers table 
$receivers_table = $wpdb->prefix.'autoponzi_ready_to_receive';

$all_matched_donators = "SELECT * FROM $donators_table WHERE payment_proof ='' ";
$get_donators = $wpdb->get_results($all_matched_donators, ARRAY_A);
//var_export($get_donators);
foreach($get_donators as $donators){
    //$time = explode(' ', $donators['created_at']);

    //user's registration time
    $reg_time = $donators['created_at'];
    //echo $reg_time. '</br>';
    $reg_date = strtotime($reg_time);
    
   // echo $reg_date .'</br>';

    //get current date 
    $cDate = strtotime(date('Y-m-d H:i:s'));

    $old_date = $reg_date + 86400;

    //get the difference
    if($cDate > $old_date ){
        //queue the receiver again to be matched by another person 

        /** get the receiver the donator is matched to **/
        $donator_receiver = $donators['matched_to'];

        /** Update the receiver to queue again to be matched ** sorry receiver **/

        /** get the current time **/
        //$now = current_time( 'mysql');

        /** Update the receiver and make him queue to be matched by a new registered donator **/
        $update_receiver = "UPDATE $receivers_table SET matched_to='' WHERE user_login='$donator_receiver' ";
        $update_the_receiver = $wpdb->query($update_receiver);


       // delete the user who has not paid 
       $donator_delete = "DELETE FROM $donators_table WHERE payment_proof='' ";
       $wpdb->query($donator_delete);
    } 




}

?>
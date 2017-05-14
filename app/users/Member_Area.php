<?php

namespace app\users;

class Member_Area{

    // an instance of the Model class
    private $model;

    //an instance of the Util(Utitlites) class
    private $util;

    //an instance of the Match class
    private $match;

    /**
     * currently logged in user 
     *
     * @var string 
     */
    private $logged_user;

    /**
     * currently logged in username
     *
     * @var string 
     */

    private $cur_username;

    /**
     * receiver matched to the current logged in user
     *
     * @var string 
     */

    private $receiver;


    public function __construct($model,$util,$match){
        $this->model = $model;
        $this->util = $util;
        $this->match = $match;
    }

    public function check_logged_user(){

    global $wpdb;

    $wpdb->show_errors();

    $this->logged_user = $this->util->get_user_info();

    $this->cur_username = $this->logged_user->user_login;
    //check if we have a donator or a receiver 
    $donators_table = $this->model->donators_table;

    $receivers_table = $this->model->receivers_table;

    $donator = "SELECT role FROM $donators_table WHERE user_login='$this->cur_username' ";
    $user_role[] = $wpdb->get_var($donator);


    $receiver = "SELECT role FROM $receivers_table WHERE user_login='$this->cur_username' ";
    $user_role[] = $wpdb->get_var($receiver);
    foreach($user_role as $role){
    switch($role){
       case 'donator':
       $this->donator_account();
       break;
       case 'receiver':
       $this->receiver_account();
       break;
   }
    }
    
    }


    public function donator_account(){

        

        $receivers_table = $this->model->receivers_table;
        $receiver_info = $this->match->get_matched_user_details($this->cur_username, $receivers_table);
 
        //statvar_export($receiver_info->matched_to);
        if(!empty($receiver_info->matched_to)){
        echo "<div class='col-md-8 col-md-offset-3' style='margin-bottom:45px'>
        <div class='panel panel-default' style='border-radius:0'>
          <h3 class='text-center' style='padding:10px'>You Have Been Matched! With";?>
          
     <?php echo $receiver_info->user_login; $this->receiver = $receiver_info->user_login ;?></h3><hr>
          <div style='padding:20px;'>
          <h3>Please Pay &#8358;20,000 To:</h3>
           <p>Account Name: <?php echo $receiver_info->account_name;?></p>
           <p>Account Name: <?php echo $receiver_info->account_number;?></p>
           <p>Bank Name: <?php echo $receiver_info->bank_name;?></p>
           <strong><p>Receiver Phone Number: <?php echo $receiver_info->phone_number;?></p></strong>
           <div id='timetxt'> 
           <h3>You Have</h3>
             <ul id="timer" class="list-inline">
                <!--<li>Days: <span class="days"></span></li>-->
                <li><span class="hours"></span> Hours </li>
                <li><span class="minutes"></span> Minutes </li>
                <li><span class="seconds"></span> Seconds</li>
                </ul>

                <h3>Remaing Time To Pay </h3>
           </div>
           <script>
           
            updateClock();

            var timeInterval = setInterval(updateClock, 1000);

           </script>
           <?php $this->check_donator_proof();?>
           <div id='confirm'>
           <p class='badge'> Made The Payment ? </p></br>
           <button type="button" id="donate" class="btn btn-lg btn-default btn-block">Upload Proof Of Payment</button>
           </div>

           <form id="proof_form" action="" method="POST" enctype='multipart/form-data' style="margin-top:15px">

           <div class='form-group'>

           <label for='proof' class='badge'>Upload Proof of Payment</label>
           <input type='file' name='proof' class='form-control'/>
    
           </div>

           <div class='form-group'>

           <input type='submit' id='proof_submit' class='form-control' name='proof_upload' class='btn btn-warning' value='Upload'/>
            </div>

           </form>

        <?php 

        $this->handle_donator_proof();
        echo "</div></div></div>";
        }
        else {

             echo "<div class='col-md-8 col-md-offset-3' style='margin-bottom:45px'>
        <div class='panel panel-default' style='border-radius:0'>
          <h3 class='text-center' style='padding:10px'>Waiting To Be Matched
          </h3><hr></div></div>";

        }
        
       
    }

    public function handle_donator_proof(){
        if(isset($_POST['proof_upload']) && !empty($_POST['proof_upload'])){
        
          $supported_types = array('image/jpeg','image/jpg','image/png','image/gif');
          $file_type = wp_check_filetype( basename($_FILES['proof']['name']));
          $uploaded_type = $file_type['type'];
          $file_name = $_FILES['proof']['name'];
          if(in_array($uploaded_type, $supported_types)){
              wp_upload_bits($_FILES['proof']['name'], null, file_get_contents($_FILES['proof']['tmp_name']));
              echo "<div class='alert-success' style='margin-top:15px'><p style='padding:15px'>Your Proof Have been uploaded successfully</p></div>";

              //handle updating the receiver about the proof just sent 
              $this->notify_receiver_payment_proof($file_name);

                wp_redirect(home_url('member-dashboard'));
          }
          else{
             echo "<div class='alert-danger' style='margin-top:15px'><p style='padding:15px'>There was an error uploading your proof, Please check the file type</p></div>";
          }
        
    }

    }

    public function notify_receiver_payment_proof($proof_name){
        global $wpdb;
        $receivers_table = $this->model->receivers_table;
        $donators_table = $this->model->donators_table;

        $receiver = $this->receiver;
        $proof_details = "UPDATE $receivers_table SET donator_proof='$proof_name' WHERE user_login='$receiver'";

        $payment_proof = "UPDATE $donators_table SET payment_proof='$proof_name' WHERE user_login='$this->cur_username'";

        $payment_proof = $wpdb->query($payment_proof);
        $send_proof = $wpdb->query($proof_details);

      
    }

    public function check_donator_proof(){
        global $wpdb;
    $donators_table = $this->model->donators_table;
    $proof_image = "SELECT payment_proof FROM $donators_table WHERE user_login='$this->cur_username'";

    $the_proof = $wpdb->get_var($proof_image);

    if(!empty($the_proof)){?>
        <script>
        window.hideconfirm = true;
        </script>
        <?php 
        $wp_uploads_dir = wp_upload_dir();
        //var_export($wp_uploads_dir);
        $uploads_directory = $wp_uploads_dir ['url'];
        echo "<hr><h3>Uploaded Proof Of Payment, Waiting confirmation</h3></br><hr>
        <img src='$uploads_directory/$the_proof'>";
    }

    }


      public function receiver_account(){

          global $wpdb;

        $receivers_table = $this->model->receivers_table;
        $donators_table = $this->model->donators_table;

        //fetch the donator matched with this receiver 
        $matched_with = "SELECT matched_to FROM $receivers_table WHERE user_login='$this->cur_username'";

        //donators username 
        $donator = $wpdb->get_var($matched_with);

        //fetch the donators details to display to the receiver 
        $donator_query = "SELECT * FROM $donators_table WHERE user_login='$donator' ";
        $donator_info = $wpdb->get_row($donator_query, ARRAY_A);
        $donators_username = $donator_info['user_login'];
        $has_matched = $donator_info['matched_to'];

        
        if(! empty($has_matched)) {
        echo "<div class='col-md-8 col-md-offset-3' style='margin-bottom:45px'>
        <div class='panel panel-default' style='border-radius:0'>
          <h3 class='text-center' style='padding:10px'>You Have Been Matched! With  ";
          echo $donators_username.'</h3><hr>';?>
          
          <?php if(!empty($donator_info['matched_to'])){?>
          <div style='padding:20px'>
          <h3>Payer Details Below:</h3><hr>
          <p>Full Name: <?php echo $donator_info['full_name'];?></p>
          <p>Phone Number: <?php echo $donator_info['phone_number'];?></p>
          <p>Amount To Pay: &#8358;<?php echo $donator_info['amt_donated'];?></p>
          <p> NOTE : <strong class='badge' style='padding:10px'>The Other &#8358;20,000 Has been used to donate for your automatically</strong></p>
          <?php }?>
          <?php if(!empty($donator_info['payment_proof'])){

            $payment_proof = $donator_info['payment_proof'];
            $wp_uploads_dir = wp_upload_dir();
            $proof_img_url = $wp_uploads_dir['url'];

            $html="<hr><h3>Donator Proof Of Payment</h3><hr>
            <img src='$proof_img_url/$payment_proof'/>";

            $html.="<p class='badge'>Seen The Payment ? </p><hr>";

             $html.="<form action='' method='POST'>
             <input type='hidden' value='yes' name='payment_receipt'/>
             
             ";

             $html.="<input type='submit' name='confirmed' class='btn btn-lg btn-warning form-control' id='receiver_confrim' value='Confirm Payment' />
             </form>
             ";

             echo $html;

            $this->receiver_confirm_payment();
          }
          
            ?>
            
          </div>

         
        <?php 
        echo "</div></div>";

        }


        else{
            echo "<div class='col-md-8 col-md-offset-3' style='margin-bottom:45px'>
        <div class='panel panel-default' style='border-radius:0'>
          <h3 class='text-center' style='padding:10px'>Waiting To Be Matched
          </h3><hr></div></div>";
        }


    }

    public function receiver_confirm_payment(){

        //update the receiver's table and the donators table 

      if(isset($_POST['confirmed']) && !empty($_POST['confirmed'])){
          $confirm_receipt = $_POST['payment_receipt'];
          global $wpdb;
          //update the donator and receiver table 
          $receivers_table = $this->model->receivers_table;

          $donators_table = $this->model->donators_table;

          $receiver_sql = "UPDATE $receivers_table SET received='1', amt_received='20,000' WHERE user_login='$this->cur_username' ";

          //get the donator 
          $the_donator = "SELECT matched_to FROM $receivers_table WHERE user_login='$this->cur_username'";

          $donator_username = $wpdb->get_var($the_donator);

          //var_export($donator_username );

          $donator_sql = "UPDATE $donators_table SET donated='1', amt_donated='20,000' WHERE user_login='$donator_username' ";

          //update the donator that he has paid 

          $update_donator = $wpdb->query($donator_sql);

        
          //update the receiver that he has received payment 
          $update_receiver = $wpdb->query($receiver_sql);

     
          //unmatched the receiver and queue him

          $unmatch_user = "UPDATE $receivers_table SET matched_to='' WHERE user_login='$this->cur_username' ";

          $wpdb->query($unmatch_user);

          //register and queue the donator to be a receiver 

          //get the donator's receiver 
          $fetch_donators_details = "SELECT * FROM $donators_table WHERE user_login='$donator_username' ";

          $donators_details = $wpdb->get_row($fetch_donators_details, ARRAY_A);


          $donator_to_receiver = array(
              'full_name'=>$donators_details['full_name'],
              'user_login'=>$donators_details['user_login'],
              'email'=>$donators_details['email'],
              'user_pwd'=>md5($donators_details['user_pwd']),
              'account_name'=>$donators_details['account_name'],
              'account_number'=>$donators_details['account_number'],
              'bank_name'=>$donators_details['bank_name'],
              'received'=>'',
              'amt_received'=>'',
              'matched_to'=>'',
              'created_at'=>current_time('mysql'),
              'role'=>'receiver',
              'phone_number'=>$donators_details['phone_number'],
              'donator_proof'=>''
          );

       $insert_donator =  $wpdb->insert( $receivers_table,$donator_to_receiver );

        $delete_res ="";
       //finally delete the donator from the donator table 
       if($insert_donator === 1 ){
       $delete_donator = "DELETE FROM  $donators_table WHERE user_login='$donator_username'";

       $delete_res = $wpdb->query($delete_donator);

       }

       wp_redirect(home_url('member-dashboard'));

        
      }
 
    }
}

?>
<?php 

/**
 *This class is responsible for creating the database tables 
 *
 *@since 1.0.0 
 */
 namespace app\model;

class Model {

    public $table_name;

    public $receivers_table;

    public function __construct(){

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table_prefix = $wpdb->prefix;

    $this->donators_table = $table_prefix."autoponzi_ready_to_donate";

    $this->receivers_table = $table_prefix."autoponzi_ready_to_receive";

    }

    public function migrations(){

    global $wpdb;

    $sql[] = "CREATE TABLE $this->donators_table (
        ID int(55) NOT NULL AUTO_INCREMENT,
        full_name varchar(55) DEFAULT '' NOT NULL,
        email varchar(55) DEFAULT '' NOT NULL ,
        user_login varchar(55) DEFAULT '' NOT NULL ,
        user_pwd varchar(55) DEFAULT '' NOT NULL ,
        account_name varchar(55) DEFAULT '' NOT NULL ,
        account_number varchar(55) DEFAULT '' NOT NULL,
        bank_name varchar(55) DEFAULT '' NOT NULL,
        donated varchar(55) DEFAULT '' NOT NULL,
        amt varchar(55) DEFAULT '0' NOT NULL,
        matched_to varchar(55) DEFAULT '' NOT NULL,
        role varchar(55) DEFAULT '' NOT NULL,
        payment_proof varchar(55) DEFAULT '' NOT NULL,
        phone_number varchar(55) DEFAULT '' NOT NULL,
        created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (ID)
        )$charset_collate;";

    $sql[] = "CREATE TABLE $this->receivers_table (
        ID int(55) NOT NULL AUTO_INCREMENT,
        full_name varchar(55) DEFAULT '' NOT NULL,
        email varchar(55) DEFAULT '' NOT NULL ,
        user_login varchar(55) DEFAULT '' NOT NULL ,
        user_pwd varchar(55) DEFAULT '' NOT NULL ,
        account_name varchar(55) DEFAULT '' NOT NULL ,
        account_number varchar(55) DEFAULT '' NOT NULL,
        bank_name varchar(55) DEFAULT '' NOT NULL,
        received varchar(55) DEFAULT '' NOT NULL,
        amt varchar(55) DEFAULT '0' NOT NULL,
        matched_to varchar(55) DEFAULT '' NOT NULL,
        role varchar(55) DEFAULT '' NOT NULL,
        phone_number varchar(55) DEFAULT '' NOT NULL,
        donator_proof varchar(55) DEFAULT '' NOT NULL,
        created_at Timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (ID)
        )$charset_collate;";

    // require the upgrade file to use dbDelta()
    require_once(ABSPATH.'/wp-admin/includes/upgrade.php');

    dbDelta($sql);
    
}



}

?>
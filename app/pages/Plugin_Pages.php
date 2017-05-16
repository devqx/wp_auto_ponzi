<?php 

namespace app\pages;

class Plugin_Pages {

    /** 
    @var $page_definitions array of all plugin pages to be created
    */

    private $page_definitions;

    /** 
    @var $is_exist check if the pages /page has been created
    */

    private $is_exist;


    /** 
    @var $created_id id of the page created
    */

    private $created_id;

     /** 
    @var $pages returned from the page definitions array;
    */

    private $pages;


    public function __construct(){
        //$this->page_definitions = $page_definitions;
    }

    public function the_pages(){

        $this->page_definitions = array(
            'Registration'=>array(
                'title'=>'New Member Registration',
                'content'=>'[new-member-register]'
            ),
            'Login'=>array(
                'title'=>'Member Login',
                'content'=>'[member-login]'
            ),
            'Member Dashboard'=>array(
                'title'=>'Your Dashboard',
                'content'=>'[member-dashboard]'
            ),
              'Admin Dashboard'=>array(
                'title'=>'Your Admin Dashboard',
                'content'=>'[admin-dashboard]'
            ),

             'Admin Delete User'=>array(
                'title'=>'Delete User Page',
                'content'=>'[admin-del-user]'
            ),

        );

        return $this->page_definitions;
    }

    public function create_pages(){

        $this->pages = $this->the_pages();

        //run a foor loop of all the pages , the $page_definitions array
        foreach($this->pages as $slug=>$page){
        $this->is_exist = new \WP_Query('pagename='.$slug);
        
        //create the pages only if the page does not exist 
        if(!$this->is_exist->have_posts()){
            //create the pages using wordpress native API:wp_insert_post
            $this->page_id = wp_insert_post( array(
                'post_title'=>$page['title'],
                'post_name'=>$slug,
                'post_content'=>$page['content'],
                'post_type'=>'page',
                'post_status'=>'publish',
                'ping_status'=>'closed',
                'comment_status'=>'closed'
            ));

            $created_pages[] = $this->page_id;

            update_option('ponzi_pages', $created_pages);
        }
        }
    }

}
?>
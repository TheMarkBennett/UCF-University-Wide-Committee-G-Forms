<?php
/**
 * Plugin Name: UCF University Wide Committee GForm
 * Plugin URI: http://provost.ucf.edu
 * Description: Intergrates with garavity forms to pull data form the committees cpt
 * Version: 1.0
 * Author: Mark Bennett
 * Author URI: http://provost.ucf.edu
 */

defined( 'ABSPATH' ) or die( 'Nope!' );




add_action( 'wp_ajax_load_post_content', 'load_post_content' );
add_action( 'wp_ajax_nopriv_load_post_content', 'load_post_content' );

function load_post_content() {
$postArray = array();

      $post_args = array(
                'post_type' => 'committees',
                'p'  => $_POST['postID'],
                'numberposts' => 1
        );

        $posts = get_posts( $post_args );

        foreach ( $posts as $key => $post) {

              $term_names = wp_get_post_terms( $_POST['postID'], 'responsible_office', array('fields' => 'all'));

            $postArray['title'][$key]= $post->post_title;
            $postArray['charge'][$key]= wp_strip_all_tags($post->post_content);
            $postArray['contact'][$key]= $post->committee_contact;
            $postArray['email'][$key]= $post->committee_contact_email;
            $postArray['url'][$key]= $post->committee_url;
            $name =  $post->committee_contact;
            $splitname = explode(" ", $name);
            $postArray['first_name'][$key]= $splitname[0];
            $postArray['last_name'][$key]= $splitname[1];
            $postArray['tax'][$key]=  $term_names;




        }
        // return result as json
       $json_result = wp_send_json( $postArray );

       die($json_result);
}



function my_load_scripts() {


    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . '/js/committees.js' ));


    wp_register_script( 'gravityforms-committees', plugins_url('/js/committees.js', __FILE__ ) , array('jquery'), $my_js_ver );

    wp_localize_script( 'gravityforms-committees', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

 wp_enqueue_script('gravityforms-committees');

}
add_action('wp_enqueue_scripts', 'my_load_scripts'); // load scripts

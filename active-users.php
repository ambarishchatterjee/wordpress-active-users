<?php
/**
 * Plugin Name: Active Users List
 * Description: This is a plugin which lists all the active/Logged in users.
 * Version:     1.0
 * Author:      Ambarish Chatterjee
 * Author URI:  https://github.com/ambarishchatterjee
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: active-users
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I am just a plugin';
	exit;
}

if(!function_exists('loggedInUsers')){
    function loggedInUsers(){
	
        if(is_admin_bar_showing()){
            
            //return "Hello This is my world.";
            global $wpdb;
            $users=$wpdb->get_results( 'SELECT * FROM wp_users where user_status="1"', 'ARRAY_A');
            echo '<h3>Active Users</h3>';
            echo '<ul class="activeUsers">';
            foreach( $users as $user )
        { 
            echo '<li>'.$user['user_login'].'</li>';
        }
            echo '</ul>';
        }
    }    
} 

add_shortcode( 'Available-Users', 'loggedInUsers' );

if(!function_exists('loggedInUsers_session')){
    function loggedInUsers_session()
    {
        global $wpdb;
        if(is_user_logged_in())
        {
            $user_id = get_current_user_id();
            $wpdb->query("UPDATE wp_users SET `user_status` = '1' WHERE `wp_users`.`ID` = $user_id;");
        }
         $user_id;
    }    
}
add_action('init','loggedInUsers_session');

if(!function_exists('loggedOutUsers_session')){
    function loggedOutUsers_session() {
        global $wpdb;
            if(is_user_logged_in())
            {
                $user_id = get_current_user_id();
                $wpdb->query("UPDATE wp_users SET `user_status` = '0' WHERE `wp_users`.`ID` = $user_id;");
            }
         $user_id;
        }        
}
add_action('wp_logout', 'loggedOutUsers_session');


// We need some CSS
function active_users_css() {
	echo "
	<style type='text/css'>
	ul.activeUsers li {
        list-style: none;
        font-family: cursive;
        text-transform: capitalize;
    }
    ul.activeUsers li:before {
        content: '-> ';
        color: #31ef31;
    }
	</style>
	";
}

add_action( 'wp_head', 'active_users_css' );
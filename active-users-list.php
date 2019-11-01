<?php
/**
 * Plugin Name: Active Users List
 * Description: This is a plugin which lists all the active/Logged in users.
 * Version:     1.0
 * Author:      Ambarish Chatterjee
 * Author URI:  https://github.com/ambarishchatterjee
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: active-users-list
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I am just a plugin';
	exit;
}

    function aul_loggedInUsers(){
	
        if(is_admin_bar_showing()){
            
            //return "Hello This is my world.";
            global $wpdb;
            $users=$wpdb->get_results( 'SELECT * FROM wp_users where user_status="1"', 'ARRAY_A');
            echo '<h3>Active Users</h3>';
            echo '<ul class="aul_activeUsers">';
            foreach( $users as $user )
        { 
            echo '<li>'.$user['user_login'].'</li>';
        }
            echo '</ul>';
        }
    }    

add_shortcode( 'Available-Users', 'aul_loggedInUsers' );

    function aul_loggedInUsers_session()
    {
        global $wpdb;
        if(is_user_logged_in())
        {
            $user_id = get_current_user_id();
            $wpdb->query("UPDATE wp_users SET `user_status` = '1' WHERE `wp_users`.`ID` = $user_id;");
        }
         $user_id;
    }    
add_action('init','aul_loggedInUsers_session');

    function aul_loggedOutUsers_session() {
        global $wpdb;
            if(is_user_logged_in())
            {
                $user_id = get_current_user_id();
                $wpdb->query("UPDATE wp_users SET `user_status` = '0' WHERE `wp_users`.`ID` = $user_id;");
            }
         $user_id;
        }        
add_action('wp_logout', 'aul_loggedOutUsers_session');


// We need some CSS
function aul_active_users_css() {
	echo "
    <style type='text/css'>
    ul.aul_activeUsers {
        padding: 0;
    }
	ul.aul_activeUsers li {
        list-style: none;
        text-transform: capitalize;
    }
    ul.aul_activeUsers li:before {
        content: '';
        display: inline-block;
        width: 15px;
        height: 15px;
        -moz-border-radius: 7.5px;
        -webkit-border-radius: 7.5px;
        border-radius: 7.5px;
        background-color: #31ef31;
        margin-right: 10px;
    }
	</style>
	";
}

add_action( 'wp_head', 'aul_active_users_css' );
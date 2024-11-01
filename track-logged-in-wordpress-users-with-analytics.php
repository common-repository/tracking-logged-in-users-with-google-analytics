<?php
/*
Plugin Name: Track Logged in Wordpress Users with Analytics
Plugin URI: http://inboundable.com/blog/track-logged-in-wordpress-users-with-analytics
Description: Create Google Analytics segments based on logged in user roles. Be sure "wp_footer" is used on your footer.php file.
Version: 1.0
Author: Donnie Cooper
Author URI: http://inboundable.com
*/

/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// making sure the session is started at wordPress initialization
// and destroying it at the logout step.
function gsbrStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function gsbrEndSession() {
    session_destroy ();
}

add_action('init', 'gsbrStartSession', 1);
add_action('wp_logout', 'gsbrEndSession');


// Getting user role at login and saving it to the session
function gsbrGetUserRole($user_login, $user)
{
    $_SESSION['gsbrUsrRole'] = $user->roles[0];
}

add_action('wp_login', 'gsbrGetUserRole',10,2);

// echo the google custom variables to each page
function gsbrSetCustomVariables ()
{
    echo "<script>_gaq.push(['_setCustomVar',5,'user_role','" . $_SESSION['gsbrUsrRole'] . "',1])</script>";
}

add_action('wp_footer', 'gsbrSetCustomVariables');


?>
<?php
/*
 * Plugin Name: WP Mobile Edition
 * Plugin URI: http://wordpress.org/extend/plugins/wp-mobile-edition
 * Description: Is a complete toolkit to mobilize your WordPress site. It has a mobile switcher and Mobile themes.
 * Version: 2.2.3
 * Author: Fabrix DoRoMo
 * Author URI: http://fabrix.net
 * License: GPL-2.0+
 * Text Domain: wp-mobile-edition
 * Domain Path: /languages
 * Copyright 2014 fabrix.net (email: fabrix@fabrix.net)
 */

/*
|--------------------------------------------------------------------------
| Public-Facing Functionality
|--------------------------------------------------------------------------
*/
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-public.php' );
add_action( 'plugins_loaded', array( 'WP_Mobile_Edition', 'get_instance' ) );

/*
|--------------------------------------------------------------------------
| Register hooks that are fired when the plugin is activated or deactivated.
| When the plugin is deleted, the uninstall.php file is loaded.
|--------------------------------------------------------------------------
*/
register_activation_hook( __FILE__, array( 'WP_Mobile_Edition', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Mobile_Edition', 'deactivate' ) );

/*
|--------------------------------------------------------------------------
| Dashboard and Administrative Functionality
|--------------------------------------------------------------------------
*/
if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-admin.php' );
	add_action( 'plugins_loaded', array( 'WP_Mobile_Edition_Admin', 'get_instance' ) );
}
<?php

/*
Plugin Name: Virtue ToolKit
Description: Custom Portfolio and Shortcode functionality for Virtue Theme
Version: 1.8
Author: Kadence Themes
Author URI: http://kadencethemes.com/
License: GPLv2 or later
*/
function virtue_toolkit_activation() {
}
register_activation_hook(__FILE__, 'virtue_toolkit_activation');

function virtue_toolkit_deactivation() {
}
register_deactivation_hook(__FILE__, 'virtue_toolkit_deactivation');

require_once('post-types.php');
require_once('shortcodes.php');
require_once('shortcode_ajax.php');

if(!defined('VIRTUE_TOOLKIT_PATH')){
	define('VIRTUE_TOOLKIT_PATH', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR );
}
if(!defined('VIRTUE_TOOLKIT_URL')){
	define('VIRTUE_TOOLKIT_URL', plugin_dir_url(__FILE__) );
}

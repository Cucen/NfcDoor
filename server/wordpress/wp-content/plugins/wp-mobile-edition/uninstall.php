<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Plugin_Name
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
    //core
    delete_option('fdx_switcher_mode');
    delete_option('fdx_switcher_desktop_domains');
    delete_option('fdx_switcher_mobile_domains');
    delete_option('fdx_switcher_mobile_theme');
    delete_option('fdx_switcher_mobile_theme_stylesheet');
    delete_option('fdx_switcher_mobile_theme_template');
    delete_option('fdx_switcher_footer_links');

    // ALL Settings
    delete_option('fdx_settings_2');

    //remove avisos
    delete_option('fdx_warning_2');
    delete_option('fdx_flash_2');

    // remove donate time d1
    delete_option('fdx1_hidden_time_2');































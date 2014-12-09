<?php
//Shortcode for year
function kad_year_shortcode_function() {
    $year = date('Y');
	return $year;
}
function kad_copyright_shortcode_function() {
	return '&copy;';
}
function kad_sitename_shortcode_function() {
	$sitename = get_bloginfo('name');
	return $sitename;
}
function kad_themecredit_shortcode_function() {
	$my_theme = wp_get_theme();
	$output = '- WordPress Theme by <a href="'.$my_theme->{'Author URI'}.'">Kadence Themes</a>';
	return $output;
}

function virtue_register_shortcodes(){
	add_shortcode('the-year', 'kad_year_shortcode_function');
	add_shortcode('copyright', 'kad_copyright_shortcode_function');
	add_shortcode('site-name', 'kad_sitename_shortcode_function');
	add_shortcode('theme-credit', 'kad_themecredit_shortcode_function');
}
add_action( 'init', 'virtue_register_shortcodes');

add_filter('widget_text', 'do_shortcode');
/*--------------------------------------*/
/*    Clean up Shortcodes
/*--------------------------------------*/
function wpex_clean_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'wpex_clean_shortcodes');
<?php
/*
Plugin Name: Random Number Generator Shortcode
Plugin URI: http://wordpress.org/plugins/random-number-generator-shortcode/
Description: Adds [randomnumgen] shortcode which generates a user-defined amount of random numbers between a user-definable range
Version: 1.1
Author: Alexander C. Block
Author URI: http://pizzli.com
License: GPLv2
*/
/*  Copyright 2013 Alexander C. Block  (email : ablock@pizzli.com)

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
function RandomNumGen( $atts ) {
extract(shortcode_atts(array(
		"min" => '',
		"max" => '',
		"numtogen" =>''
	), $atts));
	$counter = 0;
do{
	echo rand($min, $max);
	echo "<br>";
	$counter++;
}while ($counter < $numtogen);
	}
add_shortcode('randomnumgen', 'RandomNumGen');
?>
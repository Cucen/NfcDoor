=== Random Number Generator Shortcode ===
Contributors: pizzli
Donate link: http://pizzli.com/donate.php
Tags: random, randomnumber, random number, random number generator, random number generator shortcode
Requires at least: 3.0.1
Tested up to: 3.5.2
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds [randomnumgen] shortcode which generates a user-defined amount of random numbers between a user-definable range

== Description ==

Adds [randomnumgen] shortcode which generates a user-defined amount of random numbers between a user-definable range


== Installation ==

1. Upload `randomnumgen` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the [randomnumgen min='' max='' numtogen=''] shortcode in your posts and pages
4. "min" and "max" attributes are used to specify the range. "numtogen" sets the amount of random numbers to output.
5. Must define all shortcode attributes (min,max,numtogen). 
6. Example Use: [randomnumgen min='1' max='100' numtogen='10'] would generate 10 random numbers between 1 and 100. One number is output per line.


== Frequently Asked Questions ==

= How many numbers can I generate? =

You can generate as many random numbers as you want. Use the numtogen attribute to define the number of random numbers to output.
Example Use: [randomnumgen min='1' max='100' numtogen='10'] would generate 10 random numbers between 1 and 100. One number is output per line.

== Screenshots ==
1. screenshot-1.png

== Upgrade Notice ==
None

== Changelog ==

= 1.0 =
* Initial Development

= 1.1 =
* Updated Donate Link
* Verified Compatability with 3.5.2
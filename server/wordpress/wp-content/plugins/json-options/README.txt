=== JSON Options ===
Contributors: JeremyJanrain
Tags: developer, development, import, export, options, wp_options, settings, plugin, theme, support, migrate, backup
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 0.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Import and Export Wordpress Options to/from JSON with filters.

== Description ==
Import and Export Wordpress Options to/from JSON with filters.

= Features =
* migrate/backup your options
* filter exports AND imports with the multiple filter system 
* filter options for specific plugin/theme (if plugin/theme properly namespace options)
* plugin/theme support - export -> email -> modify JSON -> email -> import
* options revision logs
* export via copy/paste OR file download
* easy mode for integrating with Janrain Capture plugin  
* upsert - now using update_option()

= Feature Requests =
* import/export all tables & all data (maybe?)
* multi-site support (most likely)
* WP.com & WP VIP listing/support (most likely)

== Installation ==
1. Upload the `json-options` folder to your plugins directory (e.g. `/wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Follow the instructions

Note: If you have the Janrain Capture plugin activated and WP_DEBUG set to false the settings will fold into the Janrain Capture Settings menu as `Export/Import Settings`. Otherwise, the full 3-panel `JSON Options` menu will display.

== Changelog ==
= 0.0.1 =
* Initial Release

= 0.0.2 =
* added easy mode for integrating with Janrain Capture plugin

= 0.0.3 =
* update export filename pattern: '<site>_<date>_<time>_WP_<wp_version>.json'
* upsert - now using update_option()

= 0.0.4 =
* NEVER output client secrets or api keys
 
== Frequently Asked Questions ==
= Why aren't there more FAQs? =
Because you haven't asked.
= I have Janrain Capture installed. Where did the settings go? =
If you have the Janrain Capture plugin activated and WP_DEBUG set to false the settings will fold into the Janrain Capture Settings menu as `Export/Import Settings`. Otherwise, the full 3-panel `JSON Options` menu will display.



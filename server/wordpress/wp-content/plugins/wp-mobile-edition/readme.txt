=== WP Mobile Edition ===
Plugin Name: WP Mobile Edition
Contributors: fdoromo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BABHNAQX4HLLW
Tags: iPhone, Android, Windows Phone, HTML5, Touch, Mobile detection, Mobile switcher, Mobilize, Switch Theme, Mobile Toolkit, Disqus, Widget, QR-Code
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: 2.2.3
License: GPLv2 or later

Is a complete toolkit to mobilize your WordPress site. It has a mobile switcher and Mobile themes.

== Description ==
Fully optimized for the best performance on smartphones, compatible with: iPhone, Android, Windows Phone. Simple and easy to use: An Intuitive setting page gives you complete control. The pack contains the following functionality:

= Mobile switcher =
* The mobile switcher automatically detects whether the visitor to the site is mobile or not, and switches between the primary WordPress theme (for desktop users) or loads a mobile theme.

* Includes the ability for visitors to switch between mobile view and your site's regular theme (and remembers their choice).

* Manual Switcher - to allow your user to manually switch between desktop and mobile versions. Available in 3 versions: shortcodes, option to automatically insert into footer, or template tag.

* Based detector on [mobiledetect](http://mobiledetect.net/) project, meaning device detection will stay up to date with latest mobile devices.


= A standard mobile theme =
* Was designed to be as lightweight and speedy as possible, while still serving your site's content in a richly presented way, sparing no essential features like search, categories, tags, comments etc.

* Device adaptation, including the rescaling of images, intelligent splitting of articles and posts into multiple pages, the simplifaction styles, and the removal of non-supported media.

* Smart Formatting: It doesn't matter whether users are viewing your site horizontally or vertically, mTheme will re-position all media on the fly.

* Full Comments System: Default wordpressor or DISQUS.

* You can choose from 8 different color schemes in the settings panel.

* Easily customize your mobile theme logo with our easy uploader.

* No SEO Knowledge Needed: mTheme will automatically optimize your site for SEO. You don't need to touch a button, just sit back and watch your rankings rise.

* Equipped with a mobile ad, you can put any ads scripts (Adsense, admob, or banner ads of your own) and it will appear on your mobile version.

* Mobile-friendly: an extensible theme that is ready for display on mobile devices.

= DEMO =
* To see mTheme in action visit [This demo](http://dev.fabrix.net/run/demo/).
* Look: Gallery page, Contact form, comments in levels, and all functionality like a theme for desktop.


= Languages Available =
* English (default)
* Brazilian Portuguese **(pt_BR)** by [Fabrix Doromo](http://fabrix.net/)
* Ukrainian **(uk)** by [Віталій Ткач](http://www.kids-center.com.ua/)
* Russian **(ru)** by [zerg959](http://100wines.net/)

* **Non-English Speaking Users** - Contribute a translation using the GlotPress web interface – no technical knowledge required ([how to](http://dev.fabrix.net/translate/projects/wp-mobile-edition)).


== Screenshots ==
1. Core Settings
2. Mobile theme (General Settings)
3. Mobile theme (Advanced Settings)
4. Mobile Emulator
4. mTheme-Unus


== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for `WP Mobile Edition`
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `wp-mobile-edition.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `wp-mobile-edition.zip`
2. Extract the `wp-mobile-edition` directory to your computer
3. Upload the `wp-mobile-edition` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

= Why desktop-view link did not redirect me to the desktop version? =
This plugin requires cookie, so you need to enable the cookie's setting.

= I have created a mobile subdomain, but I still can't access my mobile version? =
Did you point a mobile domain document root to the root of wordpress installation? if you did not, login to your cpanel, point the document root into the root of wordpress installation.


== Changelog ==
* 2.2.3
    * IMPROVED - Russian **(ru)** Language pack added (thanks to zerg959)

* 2.2.2
    * IMPROVED - Ukrainian **(uk)** Language pack added (thanks to Віталій Ткач)

* 2.2.1
    * IMPROVED - Brazilian Portuguese **(pt_BR)** Language pack added (thanks to Fabrix)

* 2.2
    * IMPROVED - Added 'nofollow' in all Switcher links.
    * IMPROVED - mTheme-Unus: If menu item has submenu items, toggle the submenu on click.

* 2.1
    * NEW FEATURE - Widget: A QR-Code used for navigating to a mobile URL and Switcher link.

* 2.0
    * NEW FEATURE - Switcher Mode (Normal Site or Mobile Sub domain)
    * IMPROVED - Admin styling cleaned up.
    * IMPROVED - Code refactored.
    * IMPROVED - Mobile Theme - Various cosmetic fixes.


* 1.9.3
    * mTheme - cosmetic fixes and option for Favicon and "Apple Touch Icon".

* 1.9.2
    * Adds Italian translation.
    * Adds Russian translation.


* 1.9.1
    * Minor bug fixes

* 1.9
    * Minor bug fixes.
    * Adds Dutch translation.

* 1.8
    * Minor bug fixes
    * Added support for Custom location of WP Core.

* 1.7
    * Replacement of the deactivation, by uninstalling, to reset settings.
    * Improvement of performance

* 1.6
    * Minor bug fixes
    * Adds Spanish translation.

* 1.5.1
    * Adds Brazilian Portuguese translation.

* 1.5
    * mTheme - Various cosmetic fixes

* 1.4
    * Minor bug fixes
    * Various cosmetic fixes
    * Improvement of performance

* 1.3
    * Added the login page and control panel basics.

* 1.2
    * Minor bug fixes

* 1.1
    * Minor bug fixes

* 1.0
    * Initial release

== Upgrade Notice ==

= 2.2.3 =
IMPORTANT: After upgrade, Deactivate and Activate the plugin to update the files of mobile theme.


== SETTING UP A SUBDOMAIN IS DONE THROUGH YOUR HOSTING PROVIDER ==

You need to create a CName, and unfortunately the way you do this differs from one host to another, with some it's a drop down box and it takes two seconds to do, with others the process will be a little bit more complicated.

If you use an external host somewhere there will be a section where you can edit your DNS details - if your service doesn't allow it then it's probably time to move to another host.

When you create a subdomain, you will need two things, the domain the subdomain is for and the location from which the new subdomain will load it's content.

Type your subdomain (m), that will be your mobile subdomain, then point for your website root. (don't create a extra folder) this plugin will not work if you point it to be different from the directory you installed WordPress.

To confirm that the process was performed correctly visit your full site in `m.yousite.com` (before enable the plugin)


https://www.youtube.com/watch?v=VNOPU3WiVd8


= TESTING YOUR INSTALLATION (after enable the plugin) =

* Ideally, use a real mobile device to access your (public) site address and check that the witching and theme work correctly.

* Use the Mobile emulator in admin dashboard.

* In Firefox Browser, the [User-Agent Switcher](https://addons.mozilla.org/pt-br/firefox/addon/user-agent-switcher/) add-on can be configured to send mobile headers and crudely simulate a mobile device's request.
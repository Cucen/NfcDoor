wurde korrigiert=== custom tables ===
Contributors: Stefan M.
Donate link: http://blog.murawski.ch/2011/08/custom-tables-wordpress-plugin/
Tags: custom tables, tables, databases, custom databases
Requires at least: 3.8
Tested up to: 3.8.1
Stable tag: trunk

Create Tables and show on a page/article. Usable for all kind of diffrent databases. Freely definable fields for any purpose.

== Description ==

With this Plugin, the Admin can very simply create an new Table in the Database.
The Table can filled in manually over the WordPress Admin Menu with new entries, or he can choose the way over Excel for MultiEditing all lines and reimport the data as CSV File.
The Plugin will create diffrent Shortcodes to add this Tables to the WordPress sites.

The Demo Table can be added with `[wctable id="1"]` or `[wctable]` to the page as example.
All Tables are full supprting HTML Code, therefor its not problem to add pictures or links to any specific Article or Page or upload them directly in the created fields.
Also it supports search and sort orders and caching functionalities for all output of the plugin to have a high performance on the WordPress installation.
Instructions are added in the plugin itself, including pictures and demo db to see how everything is working! For new features, please read the changelog!

You can add Search form `[wctsearch felder="id,name"]` and Filters `[wctselect id="1" field="name"]` or also the artcile archive with `[wctdate]` and `[wctarchive]`.

You can also add Custom Forms where Visitors can edit/create/edit/delete data in the table. The custom forms can be added with `[wctform id="1"]` to a page or article.

As example, you can create an index list of all restaurants of a region and people can then search in the table for a restaurant by the city and click on the entry to get more detail on the separate page / article.
And of corse you cannot only add one table, you can add as much as diffrent tables as you want without any limitation! So, create your own lists for whatever you want.

This Plugin is hugh and many things can be done with it, please take your time to learn or if you have questions or problems, please do not hesitate to contact us:
[wuk-custom-tables.com](http://wuk-custom-tables.com/ "wuk-custom-tables.com") or [web updates kmu - Webpage (German)](http://wuk.ch/ "web updates kmu")


== Installation ==

1. Extract the content of the `custom-tables.zip`
2. Upload the extracted content to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the Plugin on the `Custom Tables` page

== Screenshots ==

1. Screenshot of the Page how the Table is look like
2. Screenshot of the Page how the Tables and Widgets is look like (2 Tables and 2 Widgets on one Page!)
3. Demo of the Overlay function which shows up, if the mousecurser move over an Entry (on/off switchable)
4. You can modify your table as much as you want. Complete DB functionality behind
5. You can modify, add or delete all Entries in the list Online with this option
6. Edit Page for an Entry, supports TinyMCE Editor, Calenderpopup and File uploads.
7. Import and Export of the table is possible. Export it, Edit in Excel and import it again. Simply!
8. Setup of how the Table should be shown, which fields aso. Many Instructions included!
9. MultiDropdown Selection field as it is displayed (Premium Function)

== Frequently Asked Questions ==

= Multilanguage Support =

This plugin is supporting multilanguage with the [qtranslate](http://www.qianqin.de/qtranslate/download/ "qtranslate") plugin. 
You need to create complete Table View Setup (aso.) and not per field:

Example:
`<!--:de--><td>[date]</td><td><b>[title_de]</b></td><td>[description_de]</td><!--:-->
<!--:en--><td>[date]</td><td><b>[titel_en]</b></td><td>[description_en]</td><!--:-->`

= Can I grant some people edit rights which don't have an WordPress Account =

Yes, there is a Smarttag `[wctpageedit table="*" filter=""]` which you can add on a normal page or article. Protect ths page / article with a password and send the user the link.
Afterwards, the user can edit the table content and delete also entries, as he is logged in. Please use a secure passwort against bruteforce.

There is also the possibility to add special Forms to the page or article where you can grant users to add/delete/modify a set of data and only of specific fields. You can enable the approval loop, where you get an email when a modification within the table will be done.

= Versioning System =

User can create or modify the content of your tables if you enable this. There is no versioning system implemented.

= Manual Deinstallation =

1. Delete the content of the `/wp-content/plugins/custom-tables` directory
2. Connect to the database 
3. Delete the standard tables `wp_wctlist` and `wp_wctform`
4. Delete all Custom Tables `wp_wct*` (Attention, all data will be lost of your Tables)
5. Run the following SQL Script to remove settings: `DELETE FROM wp_options WHERE option_name='wuk_custom_tables' LIMIT 1`

== Known Bugs ==

= the_editor() modifications =
Plugins which will modify the standard editor, such as qtranslate are in general not compatible with this plugin.
The problem is that you cannot see the editor textfield in all view setup areas, bacause of the conflict.
It's also possible that you will only see a white page on some steps, due to the jQuery incompatibility.

If you find a incompatible plugin, please rapport this and I will fix it, if possible.

== Changelog ==

= 3.9.5 =
* [Change] mres() function changes to WordPress Standard function

= 3.9.4 =
* [Bugfix] SQL injection fix

= 3.9.3 =
* [Bugfix] Bugfix for missing jscal entries
* [Bugfix] Newline multiplication on HTML field

= 3.9.2 =
* [Premium Feature] Advertisment within the table as additional row possible

= 3.9.1 =
* [Feature] New filger `wctoutput` added for table filtering
* [Feature] Sortation in backendeditor is working on next pages

= 3.9.0 =
* [Premium Feature] UNIQUE Indexes are possible
* [Bugfix] Relations Fixed in table select
* [Bugfix] Small error wirh Adminrights fixed

= 3.8.9 =
* [Change] Tag Generator updated for relations in dropdowns
* [Change] Update of language packs made
* [Change] Show all fields added in Edit Content tab
* [Bugfix] Diffrent smaller bugs / corrections made
* [Bugfix] Small relations bug fix for relations

= 3.8.8 =
* [Bugfix] Restore changes of 3.8.3 which got lost

= 3.8.7 =
* [Bugfix] jQuery-UI improovements for WordPress
* [Bugfix] Bugfix for illegal usage of Premium Features

= 3.8.6 =
* [Change] Old function get_settings replaced with get_option
* [Bugfix] Clone DB fixed

= 3.8.5 =
* [Change] New Support types are now available

= 3.8.4 =
* [Bugfix] jQuery-UI working again
* [Bugfix] File Export in Frontend is showing dates correct

= 3.8.3 =
* [Change] Java Calender replaced with jQuery calender

= 3.8.2 =
* [Bugfix] Visible Number 1 in New entry Form removed
* [Bugfix] Redirect after New Entry has created corrected
* [Bugfix] Error with Adminrights detection fixed in main class

= 3.8.1 =
* [Bugfix] changing and creating tables possible again

= 3.8.0 =
* [Feature] Cloning of tables added
* [Bugfix] PHP Tag error with Adminrights detection fixed
* [Change] Improved ChangeLog
* [Change] Added version number in Changelog Nav point

= 3.7.5 =
* [Bugfix] Form Edit/Create/Delete working now with no captcha plugin
* [Bugfix] Create new entries with form fixed

= 3.7.4 =
* [Bugfix] Show Form uses correct unicode now
* [Bugfix] Dropdown working on SET() Field now
* [Bugfix] MultiSelect Dropdown jQuery Code fixed
* [Bugfix] Custom Editlink changed for better comprehensibility

= 3.7.3 =
* [Bugfix] Exact Search is also working by Tag `[wctsearch]`
* [Bugfix] Headline also hidden by Tag `searched="1"`

= 3.7.2 =
* [Bugfix] Create Table on newer SQL Instances was not working
* [Bugfix] Subrelations over multiple tables working now
* [Bugfix] If Tag corrected for if tag in if tag usage

= 3.7.1 =
* [Feature] New added Hooks for user tracking on table, entry and forms
* [Feature] Captcha Support for Custom Forms added with [Really Simple Captcha](http://wordpress.org/extend/plugins/really-simple-captcha/ "Really Simple Captcha")
* [Bugfix] License Code check by CSV Importer has been corrected

= 3.7.0 =
* [Feature] Overlays can be closed on Touch devices now

= 3.6.6 =
* [Bugfix] Pagenation in Backend by Edit Content now working properly

= 3.6.5 =
* [Bugfix] Language Selection in PHP Safe Mode disabled because of System Denied Error

= 3.6.4 =
* [Bugfix] Add of new fields to the table working again

= 3.6.3 =
* [Bugfix] Create or modify of table possible again

= 3.6.2 =
* [Premium Feature] Small Addon that Supports linking from Custom Table to Custom Form
* [Bugfix] Calender select fixed
* [Bugfix] MultiSelectDropdown jQuery UI position problem

= 3.6.1 =
* [Premium Feature] Exact Search possible with `[wctsearch exact="1"]` Tag
* [Bugfix] Creation of tables are working again

= 3.6.0 =
* [Premium Feature] 1:n Relations are now stable to use
* [Premium Feature] MultiEditor added to Edit Content for Inline Editing
* [Premium Feature] Relations on 2 diffrent fields can be done (to separate)
* [Feature] A bunch of new hooks where added to the plugin
* [Feature] Add manually edit button in table
* [Feature] Global Search optimization implemented
* [Bugfix] Too many bugfixes to mention

= 3.5.8 =
* [Bugfix] Table entries are shown again
* [Bugfix] PHP tag bugfix

= 3.5.7 [BROKEN] =
* [Bugfix] Table entries are shown again

= 3.5.6 =
* [Bugfix] Colspan corrected for table

= 3.5.5 =
* [Feature] Single select field now supports relations field

= 3.5.4 =
* [Feature] New action hook `wct_fixspecialchars` added for special chars
* [Bugfix] Search working again in Pro Version

= 3.5.3 =
* [Bugfix] Correct charcodes for Croation Chars added

= 3.5.2 =
* [Bugfix] Tag PHP error debug only visible on loggedin users
* [Bugfix] Croation Chars can be searched

= 3.5.1 =
* [Bugfix] Page numbers fixed
* [Bugfix] usort checks for array first

= 3.5.0 =
* [Feature] New language 'dutch' avaialble. Thanks to [Erik Noorlandt](http://www.zilvertron.com/nl/producten/motoren "Erik Noorlandt")
* [Feature] Number of Amount of Entries in Dropdown List hideable
* [Feature] Dropdown will show Date `Y-m-d` instead of timestamp in list
* [Change] Button Class changed to WordPress Standard
* [Change] Page numbers Class changed to WordPress Standard

= 3.4.6 = 
* [Bugfix] ShortCode Gernerator for `[wcteid id="" eid=""]` fixed
* [Bugfix] iFrame XSS Vulnerability fixed, reported by [wpsecure.net](http://wpsecure.net/2012/07/custom-tables-plugin/ "Vulnerability Report")

= 3.4.5 = 
* [Feature] Resort of Tablecontent is possible
* [Feature] Real Relations in the Database added
* [Feature] Protection for single relation between 2 tables
* [Bugfix] dl.php bugfix for XAMPP installations
* [Bugfix] Newline problem on Relations Tab fixed
* [Bugfix] Rowspan also valid for page numbers
* [Bugfix] Settingscheckbox for hide pagenumbers and edit button changed
* [Bugfix] Subrelations button in Editor are now valid
* [Bugfix] Single fields of relations can be added (INNER JOIN)

= 3.4.4 = 
* [Feature] Smarttag `[wcttaggen]` added for Smarttag Generator
* [Premium Feature] Possible to add own Field definitions as BETA feature
* [Bugfix] Add new fields to DB will also add Charset
* [Bugfix] Extended picture field from 160 to 254 characters
* [Bugfix] Installation of plugin showed error because of headers already sent

= 3.4.3 = 
* [Bugfix] Settings page fixed

= 3.4.2 = 
* [Feature] Table Filter applies also to downloads
* [Feature] Hide of Edit Buttons in Frontend possible
* [Feature] Possible to hide page numbers below all tables
* [Bugfix] Problems with Frameworks about distroyed Ampersamp fixed

= 3.4.1 = 
* [Bugfix] Create Table again possible

= 3.4.0 = 
* [Premium Feature] n2n Relations added as BETA feature
* [Bugfix] Headerline is showing again

= 3.3.1 = 
* [Bugfix] Changed `mysql_insert_id()` to WP Standard `$wpdb->insert_id`

= 3.3.0 =
* [Premium Feature] Show multiple Table Entries per Tableline possible
* [Bugfix] Demo DB Entries fixed
* [Bugfix] Filter will now be applied on Change Field Tab
* [Bugfix] Bugfix for `wctoverlay` Smarttag with caching
* [Bugfix] Backup / Restore Process fixed

= 3.2.4 =
* [Bugfix] Multiselect Fields Search fixed for Non-Salt Searches

= 3.2.3 =
* [Premium Feature] Search also works on `[wcteid id="" eid=""]` tag
* [Bugfix] Premium Features on MU Version dont crash all sites when enabled as network admin
* [Bugfix] Multiple Multiselect Dropdown for fields with same name supported
* [Bugfix] Clear Button now clears all SALTs

= 3.2.2 =
* [Bugfix] More Directories supported by dl.php

= 3.2.1 =
* [Bugfix] Nice SetFields PHP error fixed by no set fields
* [Bugfix] Plugin Tab again visible for admins

= 3.2.0 =
* [Feature] Remove of WCT Tab possible for user groups
* [Bugfix] New Premium Activation URL fixed
* [Bugfix] Bugfix for Admin Accounts without User rights
* [Bugfix] Remove from unused Table Rights in WP Array
* [Bugfix] Search Bugfix for Indexes

= 3.1.6 =
* [Change] Restore File detection improved
* [Change] Error added if no supported premium check methods are present

= 3.1.5 =
* [Bugfix] Character Charset Fix in show table
* [Bugfix] Smarttag `[wctloggedin][/wctloggedin]` fix for registered object with no content

= 3.1.4 =
* [Premium Feature] Search can handle now multile search tags with OR relation
* [Bugfix] Smarttag `wcteid` is working now
* [Bugfix] Warning about CKEditor which will cause some problems

= 3.1.3 =
* [Premium Feature] Add multiple Entries at the same time by a custom form with `[again]`
* [Change] Added PayPal Fee on License Cost
* [Change] Changed URL for Premium Activation to new server
* [Change] Changed CSV Importer URL to new server

= 3.1.2 =
* [Change] WCT Webpage added, Video Tutorials & Support removed
* [Bugfix] Setting Page works again
* [Bugfix] Directory Splitter improved
* [Bugfix] IE8 bugfix for high colspan

= 3.1.1 =
* [Feature] New Plugin web page introduced [wuk-custom-tables.com](http://wuk-custom-tables.com/ "wuk-custom-tables.com")
* [Feature] Video Tutorials added (1 Part)
* [Premium Feature] Added option for 'Edit directly first entry' in custom forms
* [Change] Smarttag Generator updated
* [Change] Alphabetical resort of `Set()` and `Enum()` fields optional
* [Change] Restore for strange Windows Characters improved
* [Change] Demo License now deleteable before testperjod is over
* [Bugfix] Global search works now with other than `blog_` Database prefix
* [Bugfix] Only Create Rights on Custom Form fixed
* [Bugfix] Premium Version HTML Editor on Lite version fixed

= 3.1.0 =
* [Feature] Video Tutorials added (7 Parts)
* [Bugfix] Smarttag `[wctloggedin]` does now `do_shortcode()`
* [Bugfix] Restore for strange Windows Characters fixed

= 3.0.2 =
* [Bugfix] Smarttag `[wctloggedin]` works now
* [Change] More Debuginformations added to dl.php

= 3.0.1 =
* [Bugfix] PHP Bugfix for older installations
* [Bugfix] Small multiselection fix for fieldname

= 3.0.0 =
* [Feature] Rightmanagement extended
* [Feature] Smarttag `[wcteid]` to show only one Entry added
* [Feature] Possible to use `USERNAME` within SQL statements which contains WordPress Username
* [Feature] Fileupload of Non-images to image fields possible
* [Premium Feature] Smarttag `[wctloggedin]content[/wctloggedin]` to only show content when user is logged in
* [Premium Feature] Multiselection fields `[wctmultiselect]` added
* [Premium Feature] Table download is possible on public page as Excel and CSV file
* [Change] Tag Generator updated
* [Change] Changelog colored
* [Change] PHP Tag needs an Echo to work now (more complex php possible)
* [Bugfix] wp-config.php include in dl.php fixed
* [Bugfix] Windows compatible path in dl.php fixed
* [Bugfix] Fields for Forms can be saved
* [Bugfix] Form Smarttag in Smarttag Generator fixed
* [Bugfix] PHP Tag works also with newline
* [Bugfix] Fix for missing `mbstring` extension of PHP
* [Bugfix] NewLine Bugfix by new/edit entry form
* [Bugfix] Enum/Set Entries with Point had problems by new/edit entry form
* [Bugfix] Show Table did not search in Enum and Set fields correctly
* [Bugfix] Missing buttons on new/edit entry on global form by no text field fixed
* [Bugfix] illegal string in 'administrtor' problem fixed

= 2.9.0 =
* [Feature] Fields order can be changed
* [Feature] Design selection in table with ID possible

= 2.8.6 =
* [Bugfix] Small Bugfix with Editing all Tables Smarttag

= 2.8.5 =
* [Bugfix] Dropdown fix by a whitespace on the end
* [Bugfix] Backup includes now cronjobs & alternative designs
* [Bugfix] Overlay fix for multiple designs

= 2.8.4 =
* [Bugfix] Widget Problem with empty properties fixed
* [Bugfix] Dropdown outsite of table fixed

= 2.8.3 =
* [Bugfix] Dropdown Filter Error Output fixed

= 2.8.2 =
* [Bugfix] Design Bugfixes
* [Bugfix] Minor DB improvements

= 2.8.1 =
* [Bugfix] Individual and global search fixed

= 2.8.0 =
* [Feature] Klick'n'Play Smarttag Generator added
* [Feature] Dropdown can be sorted by field or amount of entries
* [Feature] Multiselect fields with AND/OR possible (via Salt)
* [Bugfix] Bug with CharSet in Varchar() Fields fixed
* [Bugfix] Dropdown JS Fix by Caching
* [Bugfix] CSS Salt to Smarttag wctable works now
* [Bugfix] wp-config.php include in dl.php fixed

= 2.7.0 =
* [Feature] Dropdown for Multiselect fields added
* [Feature] Manual Filter in wctselect added
* [Bugfix] Caching by multiple Dropdowns with diffrent filters fixed

= 2.6.2 =
* [Bugfix] Missing Picture Fields in Front-End Forms added
* [Bugfix] Missing Set Fields in Front-End Forms added

= 2.6.1 =
* [Bugfix] TinyMCE Bugfixes for WordPress 3.3
* [Bugfix] Creation and Changing of Enum & Set field fixed
* [Bugfix] Create Table CharSet fix

= 2.6.0 =
* [Premium Feature] SQL Cronjobs possible
* [Feature] IF Tag supports now shortcodes
* [Feature] Added Section for other usefull plugins
* [Change] Unknown CSV File Importer to Restore moved
* [Bugfix] Chaching by multiple Table output with Diffrent Filters fixed
* [Bugfix] Tablefilter is now also applied to dropdown list
* [Bugfix] Content of Set and Enum fields can be changed again
* [Bugfix] Tablepopup willnot fall behind the Header Admin Menü anymore

= 2.5.1 =
* [Bugfix] Premium License Activation fix for fsocksopen

= 2.5.0 =
* [Feature] External Unknown CSV File Importer added (missing in 2.3.0)
* [Change] Ticket System added for Support
* [Change] Support Mailformular decommissioned
* [Change] New translations added

= 2.4.1 =
* [Bugfix] `do_shortcode` added to overlay

= 2.4.0 =
* [Feature] Multiselect fields `set()` added
* [Premium Feature] Multiple Output Designs possible
* [Change] Widget for Multiselect Fields added
* [Change] Usefull Plugins section under Settings added
* [Bugfix] New Tablefilters added (Breakline removals by Tables
* [Bugfix] Fields in If Smarttag can now contain HTML Code with identical Char as the Smarttag self
* [Bugfix] Show too many page numbers on the table
* [Bugfix] Wrong HTML code on Settings page fixed
* [Bugfix] Problem with Quote in Varchar fields fixed
* [Bugfix] Form Problem with saving fields fixed

= 2.3.0 =
* [Feature] External Unknown CSV File Importer added
* [Bugfix] rbr function was missing in dl.php
* [Bugfix] preg_match error in Search and show_table
* [Bugfix] Save & Next Bugfix by last entry

= 2.2.2 =
* [Bugfix] Enum Field was not saved with capital Chars in field name
* [Bugfix] Bugfix by Date search
* [Bugfix] `do_shortcode` by excerpt added
* [Bugfix] CSS definition will only shown once
* [Bugfix] Fieldrename is now case insensitive

= 2.2.1 =
* [Change] Editlink will be only shown in Frontend if Rights are granted
* [Change] New translations sentances added

= 2.2.0 =
* [Feature] SQL Statement Field added (with wpnonce security check)
* [Feature] Search for Dates is possible now with search
* [Feature] Search for Dates between 2 or more date fields is possible
* [Feature] `time()-1d` and `time()+1d` added in SQL Filter Statement
* [Premium Feature] SQL Filter added for Widget
* [Change] Show SQL Errors on Import and Restore
* [Change] All Entries Tag can be hiden by Widget
* [Bugfix] Picture Upload JS fix for new Entry, Comments removed
* [Bugfix] Dropdown Selection List Cache Error fixed
* [Bugfix] Calender Popup on New Entry Page fixed
* [Bugfix] SQL Filter can contain now `<= >=` Statements
* [Bugfix] Import of CSV File corrected (Comma splitted values)

= 2.1.0 =
* [Feature] Buttons in visual Editor added under Entry Setup & Overlay Setup
* [Feature] Buttons in visual Editor added for date Format
* [Feature] `<td>` can be extended in Table View Setup with HTML tags
* [Premium Feature] Extends Standard WordPress Search looks into Tables and show Article and Page if Searchstring will be found
* [Premium Feature] Widget can be opened&closed (Javascript), enable via
* [Bugfix] Absolute Path for Windows Installations Correction implemented
* [Bugfix] Now all searchfields are correct searched (incl. enum fields)
* [Bugfix] Entry View Filter corrected for back button

= 2.0.1 =
* [Bugfix] Article Archive not in DB (Update Script for one version corrected)
* [Bugfix] Export of Database not worked (Articel Archive related)
* [Bugfix] No data in tables visible (Update Script for one version corrected)
* [Bugfix] `html_entity_decode()` added for Table Filter

= 2.0.0 =
* [Feature] Forms added where you can enable the customer to edit / create / delete entries from a table
* [Feature] Tags in Changelog added
* [Feature] Search is now case insensitive
* [Feature] PHP Smarttag `[wctphp]strftime("%l, %Y-%m-%d",'{field}')[/wctphp]` added for PHP code
* [Feature] New field `date` added with popup to select the date
* [Feature] New field `status` added to deactivate Entries and enable approval flow
* [Feature] Support Details added, Donation possibility added
* [Feature] HTML Filter of WordPress can be disabled
* [Feature] Premium functions possible via license
* [Feature] New Translations added
* [Feature] Backup and Restore possibility added
* [Feature] New Quicksave Buttons added
* [Feature] Filter & Search added on Edit Table page
* [Feature] Sort is possible on Edit Table page
* [Feature] Link to Edit Entry from Show Table avaialble
* [Feature] CSS Salt to Smarttag wctable added
* [Feature] Adding of pictures possible in Tables
* [Feature] Added new Savefunctionalities in Edit Content page
* [Feature] Support Request Form available on Support page
* [Premium Feature] Widget added where enum field content can be linked as separate pages
* [Premium Feature] Customized Forms possible
* [Premium Feature] Search and Replace in Table possible
* [Premium Feature] TinyMCE in Frontend possible by Custom Forms
* [Premium Feature] HTML Editor in TinyMCE added
* [Change] Database Updates extracted to own function
* [Change] BETA Versions Changelog removed from readme.txt (Versions < 1.00)
* [Change] Online Changelog supports now Tags
* [Change] Change field Form shows now last name to edit faster
* [Change] Minor Improvements in Table field selection
* [Change] Else added by IF Smarttag
* [Change] Fieldnames with characters `-_` will be allowed now
* [Bugfix] Bugfix for SQL Update implementation
* [Bugfix] small german translation correction in JS
* [Bugfix] Edit Content showed only 6 entries then 7 in table
* [Bugfix] Code correction by enum fields with space inside
* [Bugfix] Remove Slashes by Database Textentries
* [Bugfix] New database entry form fixed
* [Bugfix] mce_buttons Priority for TinyMCE Advanced and other plugins changed
* [Bugfix] Your content Output on Headline Setup fixed
* [Bugfix] Indexe by enum() field fixed
* [Bugfix] Wrong Tabs displayed by User Permissions
* [Bugfix] One Entry missing on Next Page fixed
* [Bugfix] Breaklines between `><` will not anymore replaced with `<br/>` Code
* [Bugfix] Selects can have special characters inside now
* [Bugfix] Filter for field names added (removes special characters) because breaks JS Code
* [Bugfix] Changelog shows now HTML Code as normal Text
* [Bugfix] Search Bugfix for Themes with a Search button
* [Bugfix] Handle will be closed by Import of Table data
* [Bugfix] View error by multiple Dropdowns fixed
* [Bugfix] Creation of Demo Table by plugin activation fixed
* [Bugfix] Sort Values are base64 encoded to fix issues with special characters
* [Bugfix] Charset fix for Export & Import (CSV Format)
* [Bugfix] Export & Import to date() fields are possible
* [Bugfix] z-index for overlay added to be all the time on top
* [Bugfix] jQuery Fix for Front-End Editor added

= 1.4.0 =
* [Feature] Area for Overlay Effect added `[wctoverlay]Text[/wctoverlay]`
* [Feature] IF Smarttag added `[if field="{id}" check="==" var="text"]Text[/if]`
* [Feature] Changelog now visible by the Plugin List for Updates
* [Change] Database Fields new in `{}` Brackets, Normal Smarttags in `[]` Brackets
* [Bugfix] Highlight line code corrected by no Overlay activated

= 1.3.1 =
* [Feature] Clearbutton Smarttag added
* [Feature] Button and Dropdown added in CSS

= 1.3.0 =
* [Feature] Public Table Edit Smarttag added
* [Bugfix] Correct Plugin URL added
* [Bugfix] Double PHP function `wct_quicktag_button()` removed
* [Bugfix] `Enum()` field added to Table
* [Bugfix] Fix for non-existing databases in the list
* [Bugfix] Archive DB ID fix implemented

= 1.2.0 =
* [Bugfix] removes newlines bevor the table if they are added in tablesetup

= 1.1.6 =
* [Bugfix] Page_id added by Search as hidden field

= 1.1.5 =
* [Feature] Hooks `wct_table`, `wct_overlay` and `wct_entry` added
* [Bugfix] Beautifuler Code for fix 1.1.4
* [Bugfix] Selection Items with Value = Empty fixed
* [Bugfix] Selection and Search reset now Page Index
* [Bugfix] Fix in generating URLs by Permalink with filename
* [Change] Obfuscated searchtag removed

= 1.1.4 =
* [Bugfix] Many fixes in generating URLs for Permalink, multisite and normal installations

= 1.1.3 (broken) =
* [Bugfix] Filter `$_SERVER[REQUEST_URI]` with `basename()` for multisite installations

= 1.1.2 =
* [Bugfix] Replaced `WP_SITEURL` with `get_site_url()`

= 1.1.1 =
* [Change] Multi language Entry Editor need WordPress 3.2 (Requirement)
* [Bugfix] Small HTML Code correction in Settings
* [Bugfix] Multi language Overlay and Entry View fixed
* [Bugfix] Field buttons in Setup Editors added again

= 1.1.0 =
* [Feature] Initial sorting of the table (field and ASC, DESC) added
* [Feature] Database revision check added
* [Bugfix] page_id was missing by Search Form, preg_match corrected
* [Bugfix] Small HTML Code correction in Changelog

= 1.0.5 =
* [Feature] Inputbutton for wordtext to textarea
* [Bugfix] Rename of text fields wasn't visible
* [Bugfix] editor fixes by disable_wysiwyg()
* [Bugfix] Fix for WordPress < v2.2 with missing WP_SITEURL

= 1.0.4 =
* [Feature] Table sort by show_table and editcontent by field 'id'
* [Feature] CSS possibilities list added
* [Feature] New Fielddefinition added with varchar(128)
* [Feature] Field definition can be changed now
* [Bugfix] Import Bug fixed about HTML Entities

= 1.0.3 =
* [Feature] overlay max-width added for better view
* [Feature] CSV import supports more filetypes
* [Feature] replace newlines with HTML code on all show functions
* [Bugfix] CSS definitions will not be lost after update
* [Bugfix] Cache of Selectfild corrected
* [Bugfix] `stripslashes()` corrections on entry_page
* [Bugfix] Problem with Space in Select fields
* [Bugfix] Overlays cannot fall out of monitor after page anymore

= 1.0.2 =
* [Bugfix] Link by `e_setup` fixed unter the table

= 1.0.1 =
* [Feature] New strings translated
* [Change] Removed Beta Texts from Readme
* [Bugfix] Fix for Java problems after Code cleanup

= 1.0.0 =
* [Feature] Filter for categories added by Smarttag (SQL Code)
* [Change] Readded Web Updates KMU Ad
* [Change] Removed 15 days limit of Beta Version
* [Bugfix] In Tablesetup HTML Code was a `</div>` missing
* [Bugfix] Multilanguage Headerline fixed

<?php
/*
   Plugin Name: Custom Tables
   Plugin URI: http://blog.murawski.ch/2011/08/custom-tables-wordpress-plugin/
   Description: Create Tables and show on a page/article. Usable for all kind of diffrent databases.
   Version: 3.9.5
   Author: Web Updates KMU
   Author URI: http://wuk.ch/

   Copyright (c) 2011 web updates kmu <stefan@wuk.ch>
   All rights reserved.

   This program is distributed under the GNU General Public License, Version 2,
   June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
   St, Fifth Floor, Boston, MA 02110, USA

   THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
   ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
   WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
   DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
   ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
   (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
   LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
   ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
   (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
   SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

define('WCT_VERSION', '3.9.3');  
define('WCT_DBVERSION', '2013102001');    

if (!function_exists('mres')) { function mres($t) { $t = esc_sql($t); return $t; } }
if (!function_exists('rbr')) { function rbr($t,$replace = "<br/>",$s='',$e='', $a='') { if ($a == '1') { $t = html_entity_decode(str_replace(array($s."<br>".$e,$s."<br/>".$e,$s."<br />".$e,$s."\r\n".$e,$s."\n".$e,$s."\r".$e),array($s.$replace.$e,$s.$replace.$e,$s.$replace.$e,$s.$replace.$e,$s.$replace.$e,$s.$replace.$e),$t)); } else { $t = html_entity_decode(str_replace(array($s."\r\n".$e,$s."\n".$e,$s."\r".$e),array($s.$replace.$e,$s.$replace.$e,$s.$replace.$e),$t)); } return $t; } }

// Fix for installations without mbstring
if (!function_exists('mb_convert_encoding')) { function mb_convert_encoding($a,$b='',$c='') { return $a; } }

if (!function_exists('wct_fixspecialchars')) {
	function wct_fixspecialchars($string) {
		// Croation Chars
		$search = array(chr(196).chr(135),chr(196).chr(134),chr(196).chr(141),chr(196).chr(140),chr(196).chr(145),chr(196).chr(144),chr(197).chr(161),chr(197).chr(160),chr(197).chr(189),chr(197).chr(190));
		$replace = array('c','C','c','C','d','D','s','S','z','Z');
		$string = str_replace($search,$replace,$string);
		return apply_filters('wct_fixspecialchars',$string);
	}
}

if (!defined('DIRECTORY_SEPARATOR')) {
	if (strstr($_SERVER[DOCUMENT_ROOT],"/")) { define('DIRECTORY_SEPARATOR', '/'); }
	elseif (strstr($_SERVER[DOCUMENT_ROOT],"\\")) { define('DIRECTORY_SEPARATOR', '\\'); }
	
	if (!defined('DIRECTORY_SEPARATOR')) {
		if (strpos(php_uname('s'), 'Win') !== false ) { define('DIRECTORY_SEPARATOR', '\\'); }
		else { define('DIRECTORY_SEPARATOR', '/'); }
	}
}

include_once("tinymce-class.php");

if (!class_exists('wuk_custom_tables')) {
	class wuk_custom_tables {
		var $settings;
		var $wctpath;
		var $lastfilter;
		var $saltdone;
		var $wctnr;

		function wuk_custom_tables() {
			global $wpdb;
			$this->getOptions();
			$wctpath = explode(DIRECTORY_SEPARATOR."custom-tables",plugin_dir_path( __FILE__ ));
			$this->wctpath = $wctpath[0].DIRECTORY_SEPARATOR."custom-tables".DIRECTORY_SEPARATOR;
			
			/* Language File will be loaded */
			if (function_exists('load_plugin_textdomain')) load_plugin_textdomain('wct', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/languages', dirname(plugin_basename( __FILE__ )).'/languages');

			add_shortcode('wctable', array(&$this,'show_table'));

			add_shortcode('wctdate', array(&$this,'show_date'));
			add_shortcode('wctarchive', array(&$this,'show_archive'));
			add_shortcode('wctselect', array(&$this,'show_select'));

			add_shortcode('wctsearch', array(&$this,'show_search'));
			add_shortcode('wcteditpage', array(&$this,'show_editpage'));
			add_shortcode('wctclear', array(&$this,'show_clear'));
			add_shortcode('if', array(&$this,'smarttag_if'));
			add_shortcode('wctoverlay', array(&$this,'smarttag_overlay'));
			add_shortcode('wctform', array(&$this,'smarttag_form'));
			add_shortcode('wctphp', array(&$this,'smarttag_php'));
			add_shortcode('wctloggedin', array(&$this,'smarttag_loggedin'));
			add_shortcode('wcteid', array(&$this,'show_eid'));
			add_shortcode('wcttaggen', array(&$this, 'taggen'));

			if(is_admin()) {
				add_action('admin_menu', array(&$this, 'add_menupages'));
				if ($this->settings['dbversion'] == "2011072801") { $this->dbupdate('2011081501',1); }
				if ($this->settings['dbversion'] == "2011081501") { $this->dbupdate('2011090101',1); }
				if ($this->settings['dbversion'] == "2011090101") { $this->dbupdate('2011101801',1); }
				if ($this->settings['dbversion'] == "2011101801") { $this->dbupdate('2011103101',1); }
				if ($this->settings['dbversion'] == "2011103101") { $this->dbupdate('2011111101',1); }
				if ($this->settings['dbversion'] == "2011111101") { $this->dbupdate('2011113001',1); }
				if ($this->settings['dbversion'] == "2011113001") { $this->dbupdate('2011121101',1); }
				if ($this->settings['dbversion'] == "2011121101") { $this->dbupdate('2011122901',1); }
				if ($this->settings['dbversion'] == "2011122901") { $this->dbupdate('2012122301',1); }
				if ($this->settings['dbversion'] == "2012122301" OR $this->settings['dbversion'] == "2012041301") { $this->dbupdate('2012122302',1); }
				if ($this->settings['dbversion'] == "2012122302") { $this->dbupdate('2012122303',1); }
				if ($this->settings['dbversion'] == "2012122303") { $this->dbupdate('2012122304',1); }
				if ($this->settings['dbversion'] == "2012122304") { $this->dbupdate('2012122305',1); }
				if ($this->settings['dbversion'] == "2012122305") { $this->dbupdate('2012122306',1); }
				if ($this->settings['dbversion'] == "2012122306") { $this->dbupdate('2012122307',1); }
				if ($this->settings['dbversion'] == "2012122307") { $this->dbupdate('2012122308',1); }
				if ($this->settings['dbversion'] == "2012122308") { $this->dbupdate('2013030501',1); }
				if ($this->settings['dbversion'] == "2013030501") { $this->dbupdate('2013102001',1); }

				add_action('in_plugin_update_message-custom-tables/custom-tables.php', array(&$this, 'plugin_updates'));

				$crons = $wpdb->get_row("SELECT count(id) as `menge` FROM `".$wpdb->prefix."wct_cron` WHERE `active`='1'");
				if ($crons->menge >= '1' AND !wp_next_scheduled('wct_task_hook')) {
					wp_schedule_event( time(), 'hourly', 'wct_task_hook');
				}
				elseif ($crons->menge < '1' AND wp_next_scheduled('wct_task_hook')) {
					wp_clear_scheduled_hook('wct_task_hook');
				}
				add_action('admin_init', array( &$this, 'wuk_scripts'));
			}

			add_action('wp_enqueue_scripts', array( &$this, 'wuk_scripts'));
			
			if ($_GET['wcttab'] == "setup" OR $_GET['wcttab'] == "eviw") {
				add_filter( 'user_can_richedit', array(&$this, 'disable_wysiwyg') );
				add_filter( 'wp_default_editor', create_function('', 'return "html";') );
			}
			elseif ($_GET['wcttab'] == "content") {
				if ($this->settings['wct_unfilteredhtml'] == "1") {
					add_filter('tiny_mce_before_init', array( &$this, 'tinymce_filter_remove'), 999);
					add_filter('htmledit_pre', array( &$this, 'tinymce_htmledit'), 999);
					add_action('admin_print_footer_scripts', array( &$this, 'tinymce_replace'), 60);
				}
				// Tiny MCE Editor
				add_filter('wp_default_editor', create_function('', 'return "tinymce";') );
				add_filter('mce_buttons', create_function('', 'return array("pasteword","|","bold","italic","|","bullist","numlist","|","link","unlink","|","spellchecker");'),9999 );
				add_filter('mce_buttons_2', create_function('', 'return array();'),9999 );
				
				// Picture Upload
				add_action('admin_print_scripts', array( &$this, 'upload_scripts'));
				add_action('admin_print_styles', array( &$this, 'upload_styles'));
			}

			add_filter('wct_table', array( &$this, 'hook_table'));
			add_filter('wct_entry', array( &$this, 'hook_entry'));
			add_filter('wct_overlay', array( &$this, 'hook_overlay'));
			add_action('wct_task_hook', array( &$this, 'task_function'));

			if (strpos($_GET['page'],"wct_table") !== false OR strpos($_GET['page'],"wct_form") !== false) {
				//Fix for Front-end Editor
				if (class_exists('scbAdminPage')) {
					remove_action( '_admin_menu', array( 'scbAdminPage', '_pages_init'));
				}
			}

			if ($this->prem_chk() == true) {
				add_shortcode('wctmultiselect', array(&$this,'show_multiselect'));
			}
			
			// Filter for some framework which distroy Ampersamp in Java Code
			add_filter('the_content', array( &$this, 'frameworkfix'),99999);
			
			add_action( 'admin_bar_menu', array( &$this, 'adminbar'), 1000);
		}
		
		function adminbar() {
			global $wp_admin_bar, $wpdb;
			if ( !is_super_admin() || !is_admin_bar_showing() ) { return false; }
			$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
			if (count($qry) >= '1') {
				$wp_admin_bar->add_menu( array( 'id' => 'wctmenu', 'title' => 'Custom Tables', 'href' => FALSE ) );
				
				foreach ($qry as $row) {
					$wp_admin_bar->add_menu( array( 'parent' => 'wctmenu', 'title' => "&raquo; ".$row->name, 'href' => admin_url('admin.php?page=wct_table_'.$row->id.'&wcttab=content')) );
				}
			}
		}

		function captcha($case = '') {
			global $_POST;
			if (class_exists('ReallySimpleCaptcha')) {
				$captcha = new ReallySimpleCaptcha();
				switch ($case) {
					default:
						$captcha_word = $captcha->generate_random_word();
						$captcha_prefix = mt_rand();
						$captcha_image = $captcha->generate_image($captcha_prefix, $captcha_word);
						$captcha_file = rtrim(get_bloginfo('wpurl'), '/') . '/wp-content/plugins/really-simple-captcha/tmp/' . $captcha_image;
						$out = __('Captcha', 'wct')." <img style=\"margin-left: 0px; margin-right: 0px; margin-top: 0px; margin-bottom: -6px !important;\" src=\"".$captcha_file."\" alt=\"\" border=\"0\" />: <input size=\"5\" type=\"text\" name=\"captcha_code\" value=\"".esc_attr(stripslashes($_POST['captcha_code']))."\" /><input type=\"hidden\" name=\"captcha_prefix\" value=\"".$captcha_prefix."\" /><br/>";
						return $out;
					break;
					
					case 'check':
						if ($captcha->check($_POST['captcha_prefix'], $_POST['captcha_code'])) { return '1'; }
						else { return '0'; }
					break;
				}
			}
			else { return '1'; }
		}	

		function frameworkfix($content) {
			$content = str_replace("&#038;","&",$content);
			return $content;
		}

		function wuk_scripts() { 
			wp_enqueue_script('jquery');			
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_style('jquery-ui-theme', plugins_url('custom-tables/jquery/smoothness/jquery-ui.min.css'));
			
			if ($this->prem_chk() == true) {
				wp_enqueue_script('jquery-ui-multiselect', plugins_url('custom-tables/jquery/jquery.multiselect.js') , array('jquery'));
				wp_enqueue_style('jquery-ui-multiselect-css', plugins_url('custom-tables/jquery/jquery.multiselect.css'));
			}
		}

		function task_function() {
			global $wpdb;
			$qry = $wpdb->get_results("SELECT `id`,`command`,`schedule` FROM `".$wpdb->prefix."wct_cron` WHERE `nextrun`<='".time()."' AND `active`='1'");
			if (count($qry) >= '1') {
				foreach ($qry as $row) {
					$cronjobs = str_replace(array("\r","\n"),"",$this->sqldatefilter(stripslashes($row->command)));
					$wpdb->show_errors();
					ob_start();
					if (strpos($cronjobs,";") !== false) {
						$einzeln = explode(";",$cronjobs);
						for($x=0;$einzeln[$x]!='';$x++) {
							$wpdb->get_row($einzeln[$x].";");
						}
					}
					else {
						$wpdb->get_row(stripslashes($cronjobs.";"));
					}
					$fehler = ob_get_clean();
					$wpdb->hide_errors();

					$status = '1';
					if ($row->schedule == 'd') { $nexttime = time() + 86320; }
					elseif ($row->schedule == 't') { $nexttime = time() + 43140; }
					elseif ($row->schedule == 'h') { $nexttime = time() + 3540; }
					else { $status = '0'; }

					if ($fehler != '') {
						$status = '0';
						wp_mail(get_option('admin_email'), __('WCT Cronjob deactivated','wct'), __('Cronjob was deactivated because of an error.','wct')."\r\n\r\nCommand: ".stripslashes($cronjobs)."\r\n\r\nErrors: ".$fehler);
					}

					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_cron` SET `nextrun`='".$nexttime."', `error`='".mres($fehler)."', `active`='".$status."' WHERE `id`='".mres($row->id)."' LIMIT 1");
				}
			}
		}

		function upload_scripts() {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('jquery');
		}

		function filter_tables($content) {
			$content = preg_replace(
				array(	'/>[\r\n]*<td/','/>[\r]*<td/','/>[\n]*<td/',
					'/>[\r\n]*<tr/','/>[\r]*<tr/','/>[\n]*<tr/',
					'/>[\r\n]*<\/table>/','/>[\r]*<\/table>/','/>[\n]*<\/table>/'
				),
				array(	'><td','><td','><td',
					'><tr','><tr','><tr',
					'></table>','></table>','></table>'
				),
				$content);
			return $content;
		}

		function upload_styles() {
			wp_enqueue_style('thickbox');
		}

		function tinymce_filter_remove($init) {
			$init['apply_source_formatting'] = 'true';
			return $init;
		}

		function tinymce_htmledit($init) {
			$init = str_replace( array('&amp;', '&lt;', '&gt;'), array('&', '<', '>'), $init );
			$init = wpautop($init);
			$init = htmlspecialchars($init, ENT_NOQUOTES);
			return $init;
		}

		function tinymce_replace() {
			global $merged_filters;
			echo "<script type=\"text/javascript\">
				//<![CDATA[
				jQuery('body').bind('afterPreWpautop', function(e, o){
					o.data = o.unfiltered
					.replace(/caption\\]\\[caption/g, 'caption] [caption')
					.replace(/<object[\s\S]+?<\\/object>/g, function(a) {
						return a.replace(/[\\r\\n]+/g, ' ');
					});

				}).bind('afterWpautop', function(e, o){
					o.data = o.unfiltered;
				});
				//]]>
			</script>";
		}

		function picture_upload($feld) {
			echo "<script>
				jQuery(document).ready(function() {";
				foreach ($feld as $var) {
					echo "jQuery('#upload_image_button".$var."').click(function() {
						formfield = jQuery('#upload_image".$var."').attr('id');
						tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
						return false;
					});";
				}
				echo "window.send_to_editor = function(html) {
						imgurl = jQuery('img','<kk>' + html + '</kk>').attr('src');
						if (typeof imgurl == 'undefined') {
							imgurl = jQuery('a','<kk>' + html + '</kk>').attr('href');
						}
						jQuery('#' + formfield).val(imgurl);
						tb_remove();
					}
				});
			</script>";
		}

		function dbupdate($date,$write = '0') {
			global $wpdb;
			if (file_exists($this->wctpath."updates/".$date.".php")) {
				include($this->wctpath."updates/".$date.".php");
				if ($write == '1') {
					$this->settings['dbversion'] = $date;
					update_option('wuk_custom_tables', $this->settings);
				}
			}
			else {
				printf( __("Needed Custom Tables DB Update '%s' DB Update not found!",'wct'), $date);
			}

		}

		function show_eid($atts) {
			global $wpdb;
			/* Table auf der Seite anzeigen per Shortcode einfügen */
			extract(shortcode_atts(array('id' => '1', 'eid' => '', 'filter' => '', 'design'=>'', 'css'=> ''), $atts));

			if ($eid != '') {
				if ($filter != '' AND strpos($filter,"=") !== FALSE) {
					$this->lastfilter = " AND ".$this->sqldatefilter($filter);
				}
				else { $this->lastfilter = ''; }

				include($this->wctpath."pages/show_table.php");
			}
			else { $out = __('Please setup Smarttag correctly (No entry submitted)','wct'); }
			return apply_filters('wctoutput',$out);
		}

		function show_table($atts) {
			global $wpdb;
			/* Table auf der Seite anzeigen per Shortcode einfügen */
			extract(shortcode_atts(array('id' => '1', 'limit' => '50', 'filter' => '', 'nofilter' => '', 'design'=>'', 'pages' => '12', 'css'=> '', 'searched' => '', 'hidepagenumbers' => '0','searchfilter'=>''), $atts));

			if ($filter != '') {
				$this->lastfilter = " AND (".$this->sqldatefilter($filter).")";
			}
			else { $this->lastfilter = ''; }


			include($this->wctpath."pages/show_table.php");
			return apply_filters('wctoutput',$out);
		}

		function show_date() {
			global $wpdb;		
			include($this->wctpath."pages/show_date.php");
			return $out;
		}
		
		function OwnFields() {
			global $wpdb;		
			include($this->wctpath."pages/setup_fields.php");
			return $out;
		}
		
		function smarttag_if($atts, $content = '') {
			global $wpdb;
			
			extract(shortcode_atts(array('field' => '', 'check' => '==', 'var' => '', 'else'=> ''), $atts));
			if ($field == '' AND $atts[0] != '') {
				// Bugfix for People with HTML Code within the field
				$field = trim($atts[0]." ".$atts[1]." ".$atts[2]." ".$atts[3]." ".$atts[4]." ".$atts[5]." ".$atts[6]." ".$atts[7]);
			}
			include($this->wctpath."pages/tag_if.php");
			
			if (preg_match("/\[if /",$out) AND !preg_match("/\[\/if /",$out)) {
				$out .= "[/if]";
			}	
			return do_shortcode($out);
		}

		function smarttag_php($atts, $content = '') {
			global $wpdb;
			if ($content != '') {
				define('WCT_PHP_ON', true);
				include($this->wctpath."pages/tag_php.php");
			}
			return $out;
		}

		function smarttag_loggedin($atts, $content = '') {
			if ($this->prem_chk() !== true) { $out = __('Premium functionality has not been activated in the plugin. Please check for a valid licence!', 'wct'); }
			else {
				global $userdata;
				if ($content != '') {
					get_currentuserinfo();
					if (is_object($userdata)) {
						if ($userdata->data->user_login != '') {
							$out = do_shortcode($content);
						}
					}
					else { $out = ''; }
				}
				else { $out = ''; }
			}
			return $out;
		}

		function wct_sort_object($a, $b) {
			global $k, $l, $j;
			if ($a->$j == $b->$j ){ return 0; } 
			return ($a->$j < $b->$j) ? $k : $l;
		} 

		function smarttag_form($atts) {
			global $wpdb;
			extract(shortcode_atts(array('id' => '', 'limit' => '50', 'def' => false), $atts));

			if ($this->prem_chk() !== true) { $out = __('Premium functionality has not been activated in the plugin. Please check for a valid licence!', 'wct'); }
			elseif ($id != '') { include($this->wctpath."pages/show_form.php"); }
			return $out;
		}

		function smarttag_overlay($atts, $content = '') {
			extract(shortcode_atts(array('id' => '', 'color' => '1','cache'=>''), $atts));
			if ($id != '') {
				$out = "<div onmousemove=\"box_show('wct_overlay".$cache."_".$id."','wct_omaster".$cache."_".$id."','wct-td-hover')\" onmouseout=\"box_hide('wct_overlay".$cache."_".$id."','wct_omaster".$cache."_".$id."','wct-td".$color."')\">".$content."</div>";
			}
			return $out;
		}
		
		
		// box_show('wct_overlay3','wct_omaster3','wct-td-hover')

		function show_clear($atts) {
			$url = $this->generate_pagelink(array("/[&?]+[0-9]*wct.*=.*&/","/[&?]+wct.*=.*&/"),array("&","&"));
			$out = "<input type=\"submit\" class=\"wct-button\" onclick=\"top.location.href='".$url."'; return false;\" value=\"".__('Clear','wct')."\">";
			return $out;
		}

		function filtermd($filter) {
			if ($filter != '') { $filtermd = eregi_replace("[^0-9a-zA-Z]","",md5($filter)); }
			else { $filtermd = ''; }
			return $filtermd;
		}

		function sqldatefilter($filter) {
			if (is_user_logged_in()) {
				global $current_user,$arr_user,$user,$userdata,$wpdb;
				if (!isset($arr_user)) {
					$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);
				}
				get_currentuserinfo();
				if (is_object($userdata)) {
					$user = $userdata;
					$preset = $wpdb->prefix."capabilities";
					if ($user->roles['0'] == 'administrator' OR $user->{$preset}['administrator'] == '1') { $user->user_level = '10'; }
					$username = $user->data->user_login;
				}
			}
			$filter = html_entity_decode(str_replace(array("USERNAME","&lt;","&gt;","time()-1d","time()+1d","time()","TIME()"),array($username,"<",">",(time()-86400),(time()+86400),time(),time()),$filter));
			return $filter;
		}

		function show_select($atts) {
			global $wpdb;
			extract(shortcode_atts(array('jsname'=>'','style'=>'','amount'=>'1', 'count'=> '1', 'id' => '1', 'field' => '', 'limit' => '20', 'maintext' => __('All entries','wct'), 'filter'=>'', 'sort'=>'anz DESC', 'salt'=>'', 'linkfield' => '', 'linkname' => ''), $atts));
			if ($amount == '0') { $count = '0'; }
			if ($jsname == '') { $jsname = $field; }
			if ($linkfield == '') { $linkfield = $field; }
			
			if ($filter == '') { $filter = $this->lastfilter; }
			else { $filter = " AND ".$this->sqldatefilter($filter); }
			
			include($this->wctpath."pages/show_select.php");		
			if (!is_array($this->saltdone)) { $this->saltdone = array(); }
			
			if (!in_array($salt.$jsname.$chachingkey, $this->saltdone)) {
				$chachingkey = md5(get_permalink());
				$savechaching = 'wct_select_js'.$salt.$jsname.$chachingkey;
				$out2 = wp_cache_get( $savechaching , 'wct');
				if ($out2 == '') {
					include(plugin_dir_path( __FILE__ )."pages/show_select_js.php");
					wp_cache_set($savechaching, $out2, 'wct', $this->settings['wct_cachetime']);
				}
				$out .= $out2;
				$this->saltdone[] = $salt;
			}
			return $out;
		}

		function show_multiselect($atts) {
			global $wpdb;
			extract(shortcode_atts(array('jsname'=>'','style'=>'','amount'=>'1', 'count'=> '1', 'id' => '1', 'field' => '', 'limit' => '20', 'width' => '150', 'showheader' => 'true', 'maintext' => __('Choose an Option','wct'), 'filter'=>'', 'sort'=>'anz DESC', salt=>''), $atts));
			if ($field != '') {
				if ($filter == '') { $filter = $this->lastfilter; }
				else { $filter = " AND ".$this->sqldatefilter($filter); }
				if ($amount == '0') { $count = '0'; }
				if ($jsname == '') { $jsname = $field; }
				if ($linkfield == '') { $linkfield = $field; }
				
				$multiselectjs = '1';
				if ($amount == '0') { $count = '0'; }
				if (!is_array($this->saltdone)) { $this->saltdone = array(); }
				if (!in_array($salt, $this->saltdone)) { $this->saltdone[] = $salt; }
				include($this->wctpath."pages/show_select.php");
				
				$chachingkey = md5(get_permalink());				
				$savechaching = $filtermd.'wct_multiselect_js_'.$id.'_'.$salt.$field.$jsname.$feldnameaddon.$chachingkey;
				$out2 = wp_cache_get( $savechaching , 'wct');
				if ($out2 == '') {
					include($this->wctpath."pages/show_multiselect_js.php");
					wp_cache_set($savechaching, $out, 'wct', $this->settings['wct_cachetime']);
				}
				$out .= $out2;
			}
			else {
				$out = __('No field given','wct');
			}
			return $out;
		}

		function wct_quicktag_button() {
			global $wpdb;
			$tableid = str_replace("wct_table_","",$_GET['page']);
			include($this->wctpath."pages/editor_js.php");
		}

		function show_archive($atts) {
			global $wpdb;	
			include($this->wctpath."pages/show_archive.php");
			return $out;
		}

		function show_search($atts) {
			global $wpdb;	
			extract(shortcode_atts(array('felder' => '*', 'text' => 'sss', 'exact' => '0'), $atts));		
			include($this->wctpath."pages/show_search.php");
			return $out;
		}

		function show_editpage($atts) {
			global $wpdb;	
			extract(shortcode_atts(array('table' => '*', 'filter' => '', 'html' => '0'), $atts));
			$url = $this->generate_pagelink(array("/[&?]+wct_eid=[0-9]*/","/[&?]+tableselector=[0-9]*/"),"");
			if ($table == '*') {
				echo "<form action=\"".$url."\" method=\"GET\"><select name=\"tableselector\">";
				$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0';");
				if (count($qry) >= '1') {
					foreach ($qry as $row) {
						echo "<option value=\"".$row->id."\">".$row->name."</option>";
					}
				}	
				echo "</select><input type=\"submit\" value=\"". __ ('Change Table', 'wct') ."\"></form><br/>";
			}

			if ($table != '*' OR ($table == '*' AND $_GET['tableselector'] != '')) {
				if ($table == '*') { $tableid = (int)mres($_GET['tableselector']); }
				else { $tableid = $_GET['tableselector'] = $table; }

				$wctmp = str_replace("admin.php?page=admin.php?","admin.php?",$url)."tableselector=";

				if ($_POST['submit'] != '') {
					include($this->wctpath."pages/save_tables.php");
				}
				include($this->wctpath."pages/editcontent.php");
			}
		}

		function tab_link($wcttab,$name,$shorttag,$wcttab2 = '',$text = '') {
			global $_GET;
			if ($wcttab2 != '') { $a = "&wcttab2=".$wcttab2; }
			$out = "<th onclick=\"document.location='admin.php?page=".$_GET['page']."&wcttab=".$shorttag.$a."'\" style=\"cursor:pointer;min-width:148px;width:148px;font-family: 'Lucida Grande',Verdana,Arial,'Bitstream Vera Sans',sans-serif;color: ";
			if ($wcttab == $shorttag && $wcttab2 == '') { $out .= "black"; }
			elseif ($wcttab2 == $_GET['wcttab2'] AND $_GET['wcttab2'] != '') { $out .= "black"; } 
			else { $out .= "#21759b"; }

			$out .= ";\">".__($name, 'wct').$text."</th>";
			return $out;
		}

		function taggen() {
			global $wpdb;
			include($this->wctpath."pages/wuk.php");
			include($this->wctpath."pages/tag_gen.php");
		}

		function wctmenu() {
			include($this->wctpath."pages/wuk.php");
			echo "<div><h2>".__('Custom Tables', 'wct')."</h2>".
			     __('On the Navigation panel at the left, you can create new Tables or edit the existing ones','wct').":<br/>".
			     "<img src=\"".plugins_url('custom-tables/img/tutorial/createeditdb.jpg')."\" border=\"0\" alt=\"Tutorial Picture\"><br/><br/>".
			     __('If you have questions or problems, please do not hesitate to contact us','wct').": <a href=\"http://wuk.ch/?piwik_campaign=plugin&piwik_kwd=custom-tables\">web updates kmu</a></div>";
		}

		function explodei($ASeperator, $ASource) {
			$ASeperator = strtolower($ASeperator);
			$x_insensitive = strtolower($ASource);
			$x_data = explode($ASeperator, $x_insensitive);
			$x_position = 0;
			$x_sep_len  = strlen($ASeperator);
  
			foreach ($x_data as $myElement) {
				$x_element_length = strlen($myElement);
				$retval[] = substr($ASource, $x_position, $x_element_length);
				$x_position += $x_element_length + $x_sep_len;
			}
			return $retval;
		}

		function create_table() {
			global $wpdb, $current_user;

			if ($this->info != '') {
				echo $this->info;
			}

			$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);
			get_currentuserinfo();
			$user = $current_user;
			if (is_object($user)) {
				$preset = $wpdb->prefix."capabilities";
				if ($user->roles['0'] == 'administrator' OR $user->{$preset}['administrator'] == '1') { $user->user_level = '10'; }
			}
			$wcttab = $_GET['wcttab'];
			
			include($this->wctpath."pages/wuk.php");
			if ($_POST['submit'] != '') {
				include($this->wctpath."pages/save_tables.php");
			}

			$wctmp = "admin.php?page=wct_table_";
			if ($_GET['page'] != 'wct_table_create') {
				$tableid = (integer)str_replace("wct_table_","",$_GET['page']);
				echo "<div style=\"padding-top:15px;\"><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
				if ($tableid != '0') {
					if ($arr_user[$this->settings['crole'.$tableid.'_s']] <= $user->user_level) { echo $this->tab_link($wcttab,'Table Setup',''); }
					if ($arr_user[$this->settings['crole'.$tableid.'_c']] <= $user->user_level) { echo $this->tab_link($wcttab,'Edit Content','content'); }
					if ($arr_user[$this->settings['crole'.$tableid.'_i']] <= $user->user_level) { echo $this->tab_link($wcttab,'Import / Export','importexport'); }
					if ($arr_user[$this->settings['crole'.$tableid.'_s']] <= $user->user_level) { echo $this->tab_link($wcttab,'View Setup','setup'); }
				}
				else {
					$tableid = (integer)str_replace("wct_table2_","",$_GET['page']);
					if ($tableid != '0') {
						echo $this->tab_link($wcttab,'Edit Content','content');
						$wctmp = "admin.php?page=wct_table2_";
						$wcttab = 'content';
						$wcmenr = '1';
					}
					else {
						if ($arr_user[$this->settings['role_archive']] <= $user->user_level) {
							echo $this->tab_link($wcttab,'Table Setup','show');
							echo $this->tab_link($wcttab,'View Setup','setup');
						}
					}
				}

				echo "</tr></table></div>";
			}

			switch ($wcttab) {
				default:
					if ($tableid == '0') {
						if ($arr_user[$this->settings['role_archive']] <= $user->user_level) { include($this->wctpath."pages/setup_archive.php"); }
						else { include($this->wctpath."pages/405.php"); }
					}
					else {
						if ($arr_user[$this->settings['crole'.$tableid.'_s']] <= $user->user_level) { include($this->wctpath."pages/setup_table.php"); }
						elseif ($arr_user[$this->settings['crole'.$tableid.'_c']] <= $user->user_level) { include($this->wctpath."pages/editcontent.php"); }
						elseif ($arr_user[$this->settings['crole'.$tableid.'_i']] <= $user->user_level) { include($this->wctpath."pages/importexport.php"); }
						else { include($this->wctpath."pages/405.php"); }
					}
				break;	

				case 'content':
					include($this->wctpath."pages/editor_fixes.php");
					if ($arr_user[$this->settings['crole'.$tableid.'_c']] <= $user->user_level) { include($this->wctpath."pages/editcontent.php"); }
					else { include($this->wctpath."pages/405.php"); }
				break;

				case 'sdo':
					if ($tableid == '0' AND $arr_user[$this->settings['role_archive']] <= $user->user_level) { include($this->wctpath."pages/manage_designoutout.php"); }
					elseif ($tableid != '0' AND $arr_user[$this->settings['crole'.$tableid.'_s']] <= $user->user_level) { include($this->wctpath."pages/manage_designoutout.php"); }
					else { include($this->wctpath."pages/405.php"); }
				break;

				case 'importexport':
					if ($arr_user[$this->settings['crole'.$tableid.'_i']] <= $user->user_level) { include($this->wctpath."pages/importexport.php"); }
					else { include($this->wctpath."pages/405.php"); }
				break;

				case 'setup':
					include($this->wctpath."pages/editor_fixes.php");
					if ($tableid == '0' AND $arr_user[$this->settings['role_archive']] <= $user->user_level) { include($this->wctpath."pages/setup_view.php"); }
					elseif ($tableid != '0' AND $arr_user[$this->settings['crole'.$tableid.'_s']] <= $user->user_level) { include($this->wctpath."pages/setup_view.php"); }
					else { include($this->wctpath."pages/405.php"); }
				break;

				case 'show':
					include($this->wctpath."pages/setup_archive.php");
				break;
			}

		}

		function getOptions() {
			global $wpdb;
			$this->settings = get_option('wuk_custom_tables');
			if (!is_array($this->settings)) { $this->settings = array(); }

			if (!array_key_exists('wct_cachetime',$this->settings)) {
				$this->settings['wct_cachetime'] = '21600';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_ct',$this->settings)) {
				$this->settings['role_ct'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_css',$this->settings)) {
				$this->settings['role_css'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_archive',$this->settings)) {
				$this->settings['role_archive'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_cronjob',$this->settings)) {
				$this->settings['role_cronjob'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_form',$this->settings)) {
				$this->settings['role_form'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_backup',$this->settings)) {
				$this->settings['role_backup'] = 'administrator';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('wct_immaster',$this->settings)) {
				$this->settings['wct_immaster'] = 'no';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('css',$this->settings)) {
				$this->settings['css'] = ".wct-overlay {\n\tpadding: 5px;\n\tbackground-color: white;\n\tborder: 1px black solid;\n\ttop: 1px;\n\tleft: 1px;\n\tvisibility: hidden;\n\toverflow: hidden;\n\tdisplay:none;\n\tmax-width: 300px;\n}\n.wct-td1 {\n\tbackground-color: #808080;\n}\n.wct-td2 {\n\tbackground-color: transparent;\n}\n.wct-td-hover {\n\tbackground-color: #DBD8FE;\n}\n.wct-sortdown {\n\tmargin: 0px 1px 0px 0px !important;\n}\n.wct-sortup {\n\tmargin: 0px 0px 0px 1px !important;\n}\n.wct-table {\n\twidth: 100% !important;\n}\n.wct-search {\n\twidth: 300px !important;\n}\n.wct-errorfield {\n\tborder-right: 0px !important;\n\tborder-bottom: 0px !important;\n\tborder-left: 0px !important;\n}\n.wctarchiveheader {\n\tfont-weight: bold !important;\n}\n.wctarchiveul {\n}\n.wctarchiveli {\n\tline-height: 1.1em !important;\n}\n.wctarchivea {\n\ttext-decoration: none !important;\n}";
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('form_serial',$this->settings)) {
				$this->settings['form_serial'] = '';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('form_serialvu',$this->settings) OR $this->settings['form_serialvu'] == '') {
				$this->settings['form_serialvu'] = '0';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('installed',$this->settings)) {
				$this->settings['installed'] = time();
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('nhide',$this->settings)) {
				$this->settings['nhide'] = '';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('role_tab',$this->settings)) {
				$this->settings['role_tab'] = 'contributor';
				update_option('wuk_custom_tables', $this->settings);
			}
			if (!array_key_exists('dbversion',$this->settings)) {
				// db mutation machen wenn eine db existiert!
				$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct_list`;");
				if (count($table) >= '1') {
					$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
					if (strpos("`sort`",$array['Create Table']) == false AND $array['Create Table'] != '') {
						$this->info = __('Database Update done','wct');
						$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list` ADD COLUMN `sort` varchar(32) NULL DEFAULT 'id', ADD COLUMN `sortB` enum('ASC','DESC') NOT NULL DEFAULT 'ASC';");
						$this->settings['dbversion'] = "2011072801";
						update_option('wuk_custom_tables', $this->settings);
					}
				}


				else {
					$this->settings['dbversion'] = WCT_DBVERSION;
					update_option('wuk_custom_tables', $this->settings);
				}
			}
		}

		function activate() {
			global $wpdb;
			$qry = $wpdb->get_results("SHOW CREATE TABLE `".$wpdb->prefix."wct_list`;");
			if (count($qry) < '1') {
				$wctpath = explode(DIRECTORY_SEPARATOR."custom-tables",plugin_dir_path( __FILE__ ));
				$wctpath = $wctpath[0].DIRECTORY_SEPARATOR."custom-tables".DIRECTORY_SEPARATOR;
	    			include($wctpath."pages/activate.php");
			}
		}

		function uninstall() {
			global $wpdb;

			if ( wp_next_scheduled('wct_task_hook') ) {
				wp_clear_scheduled_hook('wct_task_hook');
			}

			delete_option('wuk_custom_tables');
			$qry = $wpdb->get_results("SELECT `id` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0';");
			if (count($qry) >= '1') {
				foreach ($qry as $row) {
					$wpdb->get_row("DROP TABLE `".$wpdb->prefix."wct".$row->id."`;");
				}
			}
			$wpdb->get_row("DROP TABLE `".$wpdb->prefix."wct_list`;");
			$wpdb->get_row("DROP TABLE `".$wpdb->prefix."wct_form`;");
		}

		function add_menupages() {
			global $wpdb;
			$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);

			$qry = $wpdb->get_results("SELECT `id`,`menu` FROM `".$wpdb->prefix."wct_list` WHERE `menu`!='' ORDER BY `id` ASC;");
			foreach ($qry as $row) {
				add_menu_page($row->menu, $row->menu, 'level_'.$arr_user[$this->settings['crole'.$row->id.'_c']], 'wct_table2_'.$row->id , array(&$this, 'create_table'), NULL, 28);
			}
			
			add_menu_page('Custom Tables','Custom Tables', 'level_'.$arr_user[$this->settings['role_tab']], __FILE__, array(&$this, 'wctmenu'));
			add_submenu_page(__FILE__, __('Create Table', 'wct'), "<b>".__('Create Table', 'wct')."</b>", 'level_'.$arr_user[$this->settings['role_ct']], 'wct_table_create', array(&$this, 'create_table'));
			$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");

			foreach ($qry as $row) {
				if (!array_key_exists('crole'.$row->id.'_s',$this->settings)) {
					$this->settings['crole'.$row->id.'_s'] = 'administrator';
					update_option('wuk_custom_tables', $this->settings);
				}
				if (!array_key_exists('crole'.$row->id.'_c',$this->settings)) {
					$mincap = $this->settings['crole'.$row->id.'_c'] = 'contributor';
					update_option('wuk_custom_tables', $this->settings);
					$mincap = $arr_user[$this->settings['crole'.$row->id.'_c']];
				}
				else {
					$mincap = $arr_user[$this->settings['crole'.$row->id.'_c']];
				}
				if (!array_key_exists('crole'.$row->id.'_i',$this->settings)) {
					$this->settings['crole'.$row->id.'_i'] = 'editor';
					update_option('wuk_custom_tables', $this->settings);
				}
	
				if ($mincap > $arr_user[$this->settings['crole'.$row->id.'_i']]) { $mincap = $arr_user[$this->settings['crole'.$row->id.'_i']]; };
				if ($mincap > $arr_user[$this->settings['crole'.$row->id.'_s']]) { $mincap = $arr_user[$this->settings['crole'.$row->id.'_s']]; };
				if ($_POST['vipID'] == '' OR $_POST['vipID'] != $row->id) { add_submenu_page(__FILE__, __('Table', 'wct')." ".$row->id , "&raquo; ".$row->name , "level_".$mincap, 'wct_table_'.$row->id , array(&$this, 'create_table')); }
			}
			add_submenu_page(__FILE__, __('Archive','wct'),"&raquo; ".__('Article Archive','wct'), 'level_'.$arr_user[$this->settings['role_archive']], 'wct_table_0', array(&$this, 'create_table'));
			

			add_submenu_page(__FILE__, __('Create Form','wct'),"<b>".__('Create Form','wct')."</b>", 'level_'.$arr_user[$this->settings['role_form']], 'wct_editforms', array(&$this, 'CreateForm'));
			if ($this->settings['form_serial'] != '') {
				$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_form` ORDER BY `id` ASC;");
				foreach ($qry as $row) {
					add_submenu_page(__FILE__, __('Form', 'wct')." ".$row->id , "&raquo; ".$row->name." Form" , 'level_'.$arr_user[$this->settings['role_form']], 'wct_form_'.$row->id , array(&$this, 'CreateForm'));
				}
				add_submenu_page(__FILE__, __('Own DB Fields', 'wct'), __('Own DB Fields', 'wct') , 'level_8', 'wct_fields' , array(&$this, 'OwnFields'));
			}

			add_submenu_page(__FILE__, __('Edit CSS', 'wct'), __('Edit CSS', 'wct'), 'level_'.$arr_user[$this->settings['role_css']], 'wct_css', array(&$this, 'edit_css'));
			if(is_admin()) {
				if ($this->settings['wct_unfilteredsql'] == '1') { add_submenu_page(__FILE__, __('Cronjob', 'wct'),__('Cronjob', 'wct'), 'level_'.$arr_user[$this->settings['role_cronjob']], 'wct_cronjob', array(&$this, 'Cronjob')); }

				add_submenu_page(__FILE__, __('Settings'),__('Settings'), 'level_8', 'wct_settings', array(&$this, 'Settings'));
				if ($this->settings['form_serial'] != '') {
					add_submenu_page(__FILE__, __('Advertisment','wct'),__('Advertisment','wct'), 'level_8', 'wct_ads', array(&$this, 'Advertisment'));
				}				
				add_submenu_page(__FILE__, __('Backup/Restore', 'wct'),__('Backup/Restore', 'wct'), 'level_'.$arr_user[$this->settings['role_backup']], 'wct_backuprestore', array(&$this, 'backuprestore'));
				add_submenu_page(__FILE__, __('Smarttag Generator', 'wct'),"<b>".__('Smarttag Generator', 'wct')."</b>", 'level_'.$arr_user[$this->settings['role_tab']], 'wct_taggen', array(&$this, 'taggen'));
				add_submenu_page(__FILE__, __('WCT Webpage', 'wct'),"<b>".__('WCT Webpage', 'wct')."</b>", 'level_'.$arr_user[$this->settings['role_tab']], 'wct_webpage', array(&$this, 'webpage'));
				
				add_submenu_page(__FILE__, 'Support','<span style="color: red;">Support</span>', 'level_8', 'wct_support', array(&$this, 'Support'));
				add_submenu_page(__FILE__, 'Changelog '.WCT_VERSION,'Changelog '.WCT_VERSION, 'level_8', 'wct_changelog', array(&$this, 'ChangeLog'));

			}
		}

		function webpage() {
			include($this->wctpath."pages/wuk.php");
			echo "<div><h2>".__('Custom Tables', 'wct')."</h2><a href=\"http://wuk-custom-tables.com/\" target=\"_blank\"><font size=\"+2\">Custom Tables Webpage</font></a>
			<script>window.open('http://wuk-custom-tables.com/', '_blank');</script></div>";
		}

		function Cronjob() {
			global $wpdb;
			include($this->wctpath."pages/wuk.php");
			if ($this->prem_chk() !== true) { $out = __('Premium functionality has not been activated in the plugin. Please check for a valid licence!', 'wct'); }
			else { include($this->wctpath."pages/cronjob.php"); }
		}

		function Settings() {
			global $wpdb;
			include($this->wctpath."pages/wuk.php");
	    		include($this->wctpath."pages/setup_settings.php");
		}
		
		function Advertisment() {
			global $wpdb;
			include($this->wctpath."pages/wuk.php");
	    		include($this->wctpath."pages/setup_ads.php");
		}

		function backuprestore() {
			global $wpdb;
			include($this->wctpath."pages/wuk.php");
	    	include($this->wctpath."pages/backuprestore.php");
		}
		
		function Support() {
			include($this->wctpath."pages/wuk.php");
			include($this->wctpath."pages/support.php");
		}

		function CreateForm() {
			global $wpdb, $current_user;

			if ($this->info != '') {
				echo $this->info;
			}

			$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);
			get_currentuserinfo();
			$user = $current_user;
			if (is_object($user)) {
				$preset = $wpdb->prefix."capabilities";
				if ($user->roles['0'] == 'administrator' OR $user->{$preset}['administrator'] == '1') { $user->user_level = '10'; }
			}

			$wcttab = $_GET['wcttab'];
			
			include($this->wctpath."pages/wuk.php");
			echo "<br/><font size=\"+1\" color=\"#0000A0\">PREMIUM FEATURE</font><br/>";

			if ($this->settings['form_serial'] != '' AND $this->settings['form_serialvu'] >= time())  {
				include($this->wctpath."pages/setup_form.php");
				if ($this->settings['form_serialvu'] != '' AND $_GET['page'] == 'wct_editforms') { printf( "<br/><br/>".__('Premium features licensed. Valid until %s.','wct'), date("Y-m-d",$this->settings['form_serialvu'])); }
			}
			else {
				echo "<br/>".__('You can create Forms that Visitors or People can edit the content of your table on your own site, without having an account on your WordPress installation.', 'wct')."<br/>";
				printf( __('The Standardform can be added with %s to the page and includes all rights (read, write, delete, create) to edit all Tables.', 'wct'), '<input type="text" size="30" value=\'[wcteditpage table="*" filter="" html="0"]\' readonly>');
				echo "<br/>".__('You can use the filter as SQL Filter that not all Entries are shown. The html Tag can be used to enable (1) the HTML Editor or disable it (0).','wct')."<br/><br/>".__('To create individual forms with individual rights, you need to have a valid serial number for the premium feature.', 'wct');
				if ($this->settings['form_serial'] != '') {
					echo "<br/><br/>".__('The license has expired, please renew it','wct')." <a href=\"admin.php?page=wct_settings#premium\">". __('now','wct')."</a>.";
				}
				else {
					echo "<br/><br/>".__('No valid premium feature license found, please enter serial ','wct')." <a href=\"admin.php?page=wct_settings#premium\">". __('now','wct')."</a>.";
				}
			}
		}

		function ChangeLog() {
			include($this->wctpath."pages/wuk.php");
			include($this->wctpath."pages/view_changelog.php");
		}

		function edit_css() {
			include($this->wctpath."pages/wuk.php");
			include($this->wctpath."pages/setup_css.php");
		}

		function wct_sort($feld,$table) {
			$url = $this->generate_pagelink(array("/[&?]+wctinvs=1*/","/[&?]+wctsort=.*&/"),array("","&"));

			if ($feld == $_REQUEST['wctsort']) {
				if ($table->sheme == '1') {
					if ($_REQUEST['wctinvs'] == '1') { $zusatz1 = "_white";  } else { $zusatz2 = "_white"; }
				}
				else {
					if ($_REQUEST['wctinvs'] == '1') { $zusatz1 = "_black";  } else { $zusatz2 = "_black"; }
				}
			}
			$out .= "<a href=\"".$url."wctsort=".$feld."\"><img class=\"wct-sortdown\" src=\"".plugins_url('custom-tables/img/sort_down'.$zusatz2.'.gif')."\" alt=\"sort down\" border=\"0\" /></a>";
			$out .= "<a href=\"".$url."wctsort=".$feld."&wctinvs=1\"><img class=\"wct-sortup\" src=\"".plugins_url('custom-tables/img/sort_up'.$zusatz1.'.gif')."\" alt=\"sort up\" border=\"0\" /></a>";

			return $out;
		}

		function tablerights($label,$role,$recht = 'administrator') {
			global $profileuser;
			$user_roles = $profileuser->roles;
			$user_role = @array_shift($user_roles);
			echo "<tr><td><label for=\"role\">". $label ."</label></td><td><select name=\"wctrole_".$role."\" id=\"wctrole".$role."\">";
			wp_dropdown_roles($recht);
			echo "</select></td></tr>";
			return true;
		}

		function option($label,$role,$recht = '', $desc = '') {
			echo "<tr><td><label for=\"role\">". $label ."</label></td><td><input type=\"text\" name=\"wctrole_".$role."\" id=\"wctrole".$role."\" value=\"".$recht."\"/></td><td>&nbsp;<i>".$desc."</i></td></tr>";
			return true;
		}

		function disable_wysiwyg($wert) {
    			if($_GET['wcttab'] == 'setup') { return false; }
    			return $wert;
		}

		function generate_pagelink($arrayA,$arrayB) {
			include($this->wctpath."pages/generate_url.php");
			return $url;
		}

		function http_request($method, $url, $data = '', $auth = '', $check_status = true) {
			$status = 0;
			$method = strtoupper($method);
			if (function_exists('curl_init')) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERAGENT, 'SMuBot');
				@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($ch, CURLOPT_TIMEOUT, 180);

				switch ($method) {
					case 'POST':
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						break;

					case 'PURGE':
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
						break;
				}
				if ($auth) { curl_setopt($ch, CURLOPT_USERPWD, $auth); }
				$contents = curl_exec($ch);
				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
			}
			elseif (function_exists('fsockopen')) {
				$parse_url = @parse_url($url);
				if ($parse_url && isset($parse_url['host'])) {
					$host = $parse_url['host'];
					$port = (isset($parse_url['port']) ? (int) $parse_url['port'] : 80);
					$path = (!empty($parse_url['path']) ? $parse_url['path'] : '/');
					$query = (isset($parse_url['query']) ? $parse_url['query'] : '');
					$request_uri = $path . ($query != '' ? '?' . $query : '');
					$request_headers_array = array(
						sprintf('%s %s HTTP/1.1', $method, $request_uri),
						sprintf('Host: %s', $host),
						sprintf('User-Agent: %s', 'SMuBot'),
						"Content-type: application/x-www-form-urlencoded"
					);
					if (!empty($data)) { $request_headers_array[] = sprintf('Content-Length: %d', strlen($data)); }
					if (!empty($auth)) { $request_headers_array[] = sprintf('Authorization: Basic %s', base64_encode($auth)); }
					$request_headers_array[] = "Connection: close";
					$request_headers = implode("\r\n", $request_headers_array);
					$request = $request_headers . "\r\n\r\n" . $data . "\r\n\r\n";
					$errno = null;
					$errstr = null;
					$fp = @fsockopen($host, 80, $errno, $errstr, 30);
					if (!$fp) { return false; }
					$response = '';
					@fputs($fp, $request);
					while (!@feof($fp)) { $response .= @fgets($fp, 4096); }
					@fclose($fp);
					list($response_headers, $contents) = explode("\r\n\r\n", $response, 2);
					$matches = null;
					if (preg_match('~^HTTP/1.[01] (\d+)~', $response_headers, $matches)) { $status = (int) $matches[1]; }
				}
			}
			else { return 'No supported methods found'; }

			if (!$check_status || $status == 200) { return $contents; }
			return false;
		}

		function plugin_updates() {
			$data = $this->http_request('GET','http://plugins.trac.wordpress.org/browser/custom-tables/trunk/readme.txt?format=txt');

			if ($data) {
				$matches = null;
				$regexp = '~==\s*Changelog\s*==\s*=\s*[0-9.]+\s*=(.*)(=\s*' . preg_quote(WCT_VERSION) . '\s*=|$)~Uis';

				if (preg_match($regexp, $data, $matches)) {
					$changelog = (array) preg_split('~[\r\n]+~', trim($matches[1]));

					echo '<div style="color: #f00;">'.__('Please find below the new Features / Bugfixes', 'wct').':</div><div style="font-weight: normal;">';
					$ul = false;

					foreach ($changelog as $index => $line) {
						if (preg_match('~^\s*\*\s*~', $line)) {
							if (!$ul) {
								echo '<ul style="list-style: disc; margin-left: 20px;">';
								$ul = true;
							}
							$line = preg_replace(array('~^\s*\*\s*~',"/\[(.*?)\]/"), array('',"<i>[$1]</i>"), htmlspecialchars($line));
							echo '<li style="width: 50%; margin: 0; float: left; ' . ($index % 2 == 0 ? 'clear: left;' : '') . '">' . $line . '</li>';
						} else {
							if ($ul) {
								echo '</ul><div style="clear: left;"></div>';
								$ul = false;
							}
							echo '<p style="margin: 5px 0;">' . htmlspecialchars($line) . '</p>';
						}
					}

					if ($ul) {
						echo '</ul><div style="clear: left;"></div>';
					}

					echo '</div>';
				}
			}
		}

		function ShowTinyMCE() {
			wp_enqueue_script( 'common' );
			wp_enqueue_script( 'jquery-color' );
			wp_print_scripts('editor');
			if (function_exists('add_thickbox')) add_thickbox();
			wp_print_scripts('media-upload');
			if (function_exists('wp_tiny_mce')) wp_tiny_mce();
			wp_admin_css();
			wp_enqueue_script('utils');
			do_action("admin_print_styles-post-php");
			do_action('admin_print_styles');
		}

		/* Hooks for additional Extensions */
		function hook_table($content) { return $content; }
		function hook_entry($content) { return $content; }
		function hook_overlay($content) { return $content; }
		function prem_chk($serial = '', $do = '0') {
			if ($serial == '') { $serial = $this->settings['form_serial']; }
			if ($do == '1') { return $serial; }
			else {
				$parts = explode('-',$serial);
				if(sizeof($parts) != 4) return false;
 				list($part1, $part2, $part3, $part4) = $parts;
				if (($part2 % 4) == substr($part3,2,1) AND ($part1 % 9) == substr($part2,0,1) AND ($part1 % 5) == substr($part2,3,1) AND $part4 == (($part3 + 4) % 8).(($part1 + $part3 * 39) % 7 ).(($part2 + 12 + $part3 / (2/7)) % 3 ).(($part2 * 27 + 1) % 3 )) { return true; }
				else { return false; }
			}
		}

		function iplugin($name,$value,$check,$sett,$desc = '',$settings = 'options-general.php') {
			$wuk_plugin_check = substr(plugin_dir_path( __FILE__ ),0,stripos( plugin_dir_path( __FILE__ ) , PLUGINDIR ) ).PLUGINDIR.DIRECTORY_SEPARATOR;

			echo "<tr><th scope=\"row\" valign=\"top\"><b>".$name."</b></th><td>&nbsp;</td><td>";
			if (file_exists($wuk_plugin_check.$check)) {
				echo __('Plugin is already installed','wct');
				if ($settings != '') {
					echo " (<a href=\"".$settings."?page=".$sett."\">Einstellungen</a>)";
				}
			}
			else {
				printf(__('Plugin %s not installed.', 'wct'), $name);
				if (strpos($value,"http") !== false) {
					echo " <a target=\"_blank\" href=\"".$value."\">".__('Install now', 'wct')."</a>";
				}
				elseif ($value != '') {
					echo " <a target=\"_blank\" href=\"plugin-install.php?tab=plugin-information&plugin=".$value."\">".__('Install now', 'wct')."</a>";
				}
			}
			echo ".";
			if ($desc != '') {
				echo "<br/><small>".$desc."</small>";
			}				
			echo "</td></tr>";
		}
	}

	add_action('init', 'wuk_custom_tables1');
	function wuk_custom_tables1() {
		global $wuk_custom_tables;
		$wuk_custom_tables = new wuk_custom_tables();
	}
}

if (function_exists('register_activation_hook')) { register_activation_hook(__FILE__, array('wuk_custom_tables', 'activate')); }
if (function_exists('register_uninstall_hook')) { register_uninstall_hook(__FILE__, array('wuk_custom_tables', 'uninstall')); }
if (!function_exists('wct_session_start')) { function wct_session_start() { session_start(); } }
if (!session_id()) { add_action('init', 'wct_session_start'); }


?>
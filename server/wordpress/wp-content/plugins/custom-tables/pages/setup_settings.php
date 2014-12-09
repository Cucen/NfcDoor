<?php


if ($_GET['dellic'] == '1') {
	$this->settings['form_serial'] = '';
	$this->settings['form_serialvu'] = '0';
	update_option('wuk_custom_tables', $this->settings);
}
elseif ($_POST['submit'] != '' AND $_GET['validate'] != '1') {
	$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);

	$this->settings['role_ct'] = $_POST['wctrole_ct'];
	$this->settings['role_tab'] = $_POST['wctrole_tab'];
	$this->settings['role_css'] = $_POST['wctrole_css'];
	$this->settings['role_archive'] = $_POST['wctrole_archive'];
	$this->settings['role_cronjob'] = $_POST['wctrole_cronjob'];
	$this->settings['role_form'] = $_POST['wctrole_form'];
	$this->settings['role_backup'] = $_POST['wctrole_backup'];
	
	if ($_POST['hidepagenumbers'] == '1') { $this->settings['hidepagenumbers'] = '1'; }
	else { $this->settings['hidepagenumbers'] = '0'; }

	if ($_POST['hideedit'] == '1') { $this->settings['hideedit'] = '1'; }
	else { $this->settings['hideedit'] = '0'; }

	if ($_POST['wct_unfilteredhtml'] == '1') { $this->settings['wct_unfilteredhtml'] = '1'; }
	else { $this->settings['wct_unfilteredhtml'] = '0'; }

	if ($_POST['wct_unfilteredsql'] == '1') { $this->settings['wct_unfilteredsql'] = '1'; }
	else { $this->settings['wct_unfilteredsql'] = '0'; }


	if ($_POST['nice_setfields'] == '1') { $this->settings['nice_setfields'] = '1'; }
	else { $this->settings['nice_setfields'] = '0'; }


	if ($_POST['wct_immaster'] != 'yes') { $_POST['wct_immaster'] = 'no'; }
	$this->settings['wct_immaster'] = $_POST['wct_immaster'];

	foreach ($this->settings as $var => $wert) {
		if (substr($var,0,5) == 'crole') {
			unset($this->settings[$var]);
		}
	}
	update_option('wuk_custom_tables', $this->settings);
	$this->getOptions();

	$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list`;");
	foreach ($qry as $row) {
		if ($_POST['wctreset'] != '1') {
			$this->settings['crole'.$row->id.'_s'] = $_POST['wctrole_crole'.$row->id.'_s'];
			$this->settings['crole'.$row->id.'_c'] = $_POST['wctrole_crole'.$row->id.'_c'];
			$this->settings['crole'.$row->id.'_i'] = $_POST['wctrole_crole'.$row->id.'_i'];
		}
		else {
			$this->settings['crole'.$row->id.'_s'] = $_POST['wctrole_crolem_s'];
			$this->settings['crole'.$row->id.'_c'] = $_POST['wctrole_crolem_c'];
			$this->settings['crole'.$row->id.'_i'] = $_POST['wctrole_crolem_i'];
		}
	}

	foreach ($this->settings as $var => $wert) {
		if ((substr($var,0,5) == 'role_' OR substr($var,0,5) == 'crole') AND $wert != '') {
			if ($arr_user[$wert] < $arr_user[$this->settings['role_tab']]) {
				$this->settings['role_tab'] = $wert;
			}
		}
	}

	if (isset($_POST['wct_dbcharset'])) {
		if ($_POST['wct_dbcharset'] == "auto") {
			$this->settings['search_charset'] = "auto";
		}
		else {
			$this->settings['search_charset'] = $_POST['wct_dbcharset2'];
		}
	} 

	$this->settings['wct_cachetime'] = $_POST['wctrole_cachetime'];

	update_option('wuk_custom_tables', $this->settings);

	echo "<br/><b>".__('Changes successfully saved', 'wct')."</b><br/><br/>";
}

echo "<style type=\"text/css\">
fieldset
{
	margin-top: 1em;
	margin-right: 0pt;
	margin-bottom: 1em;
	margin-left: 0pt;
	background-color: #fdfdfd;
	background-image: none;
	background-repeat: repeat;
	background-attachment: scroll;
	background-position: 0% 0%;
	padding-top: 0pt;
	padding-right: 1em;
	padding-bottom: 1em;
	padding-left: 1em;
	border-top-width: 1px;
	border-right-width-value: 1px;
	border-right-width-ltr-source: physical;
	border-right-width-rtl-source: physical;
	border-bottom-width: 1px;
	border-left-width-value: 1px;
	border-left-width-ltr-source: physical;
	border-left-width-rtl-source: physical;
	border-top-style: solid;
	border-right-style-value: solid;
	border-right-style-ltr-source: physical;
	border-right-style-rtl-source: physical;
	border-bottom-style: solid;
	border-left-style-value: solid;
	border-left-style-ltr-source: physical;
	border-left-style-rtl-source: physical;
	border-top-color: #bbbbbb;
	border-right-color-value: #bbbbbb;
	border-right-color-ltr-source: physical;
	border-right-color-rtl-source: physical;
	border-bottom-color: #bbbbbb;
	border-left-color-value: #bbbbbb;
	border-left-color-ltr-source: physical;
	border-left-color-rtl-source: physical;
}
</style>
<form action=\"admin.php?page=".$_GET['page']."\" method=\"post\" onSubmit=\"return validate(this)\" name=\"wctform\">".__('Setup who can access which pages of the plugin.<br/>You can only break down on groups, not on users!','wct')."<fieldset><legend><strong>" . __('Rights', 'wct') . "</strong></legend><h3>". __('Global rights', 'wct')."</h3><table>";
$this->tablerights(__('Show WCT Tab', 'wct') ,'tab',$this->settings['role_tab']);
$this->tablerights(__('Create Table', 'wct') ,'ct',$this->settings['role_ct']);
$this->tablerights(__('Edit CSS', 'wct') ,'css',$this->settings['role_css']);
$this->tablerights(__('Archive Setup', 'wct') ,'archive',$this->settings['role_archive']);
$this->tablerights(__('Cronjobs', 'wct') ,'cronjob',$this->settings['role_cronjob']);
$this->tablerights(__('Custom Forms', 'wct') ,'form',$this->settings['role_form']);
$this->tablerights(__('Backup/Restore', 'wct') ,'backup',$this->settings['role_backup']);

echo "</table><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"><h3>". __('Table rights', 'wct')."</h3><table><tr><td valign=\"top\"><table>";
$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE id!='0';");
foreach ($qry as $row) {
	if (!array_key_exists('crole'.$row->id.'_s',$this->settings)) {
		$this->settings['crole'.$row->id.'_s'] = 'administrator';
		update_option('crole'.$row->id.'_s', $this->settings);
	}
	if (!array_key_exists('crole'.$row->id.'_c',$this->settings)) {
		$this->settings['crole'.$row->id.'_c'] = 'contributor';
		update_option('crole'.$row->id.'_c', $this->settings);
	}
	if (!array_key_exists('crole'.$row->id.'_i',$this->settings)) {
		$this->settings['crole'.$row->id.'_i'] = 'editor';
		update_option('crole'.$row->id.'_i', $this->settings);
	}
	$this->tablerights("&raquo; ".$row->name." ".__('Setup Option', 'wct'),'crole'.$row->id.'_s',$this->settings['crole'.$row->id.'_s']);
	$this->tablerights("&raquo; ".$row->name." ".__('Import/Export', 'wct'),'crole'.$row->id.'_i',$this->settings['crole'.$row->id.'_i']);
	$this->tablerights("&raquo; ".$row->name." ".__('Content', 'wct'),'crole'.$row->id.'_c',$this->settings['crole'.$row->id.'_c']);
	echo "<tr height=\"10\"><td colspan=\"2\"></td></tr>";
}
echo "</table></td><td style=\"background-image:url(" . plugins_url('custom-tables/img/table.png') . ");\" valign=\"bottom\"><img src=\"".plugins_url('custom-tables/img/tableend.png')."\" border=\"0\" alt=\"\"/></td><td valign=\"top\">
<input type=\"checkbox\" name=\"wctreset\" value=\"1\"> ".__('Reset all tables to following Standard').":<table>";

$this->tablerights( __('Setup Option', 'wct'),'crolem_s','administrator');
$this->tablerights( __('Import/Export', 'wct'),'crolem_i','editor');
$this->tablerights( __('Content', 'wct'),'crolem_c','contributor');

echo "</table></td></tr></table><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></fieldset>
<fieldset><legend><strong>" . __('Cache', 'wct') . "</strong></legend><table>";
$this->option(__('Cache expire', 'wct'),'cachetime',$this->settings['wct_cachetime'],__('How long is the Cache valid in secounds', 'wct'));
echo "</table>". __('<b>Attention:</b> Cache functionality will only work, if the Caching functionality in WordPress is enabled and a cache plugin is installed.','wct')."<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></fieldset>";

echo "<fieldset><legend><strong>" . __('Advanced Features', 'wct') . "</strong></legend>".
__('Table Indexes', 'wct')." <input type=\"checkbox\" name=\"wct_immaster\" value=\"yes\"";
if ($this->settings['wct_immaster'] == 'yes') { echo " checked"; }
echo "> ".__('If you want to enable Table Indexes to define which fields can be searched faster.', 'wct')."<br/>".
__('<b>Attention:</b> This feature should only be used by Database Engineers which knowing what they are doing. In fact, correct indexes can speedup the database by user searches, but on wrong indexes destroy database performance at all.','wct')."<br/><br/>".

__('Hide Edit Button in Frontend', 'wct')." <input type=\"checkbox\" name=\"hideedit\" value=\"1\"";
if ($this->settings['hideedit'] == '1') { echo " checked"; }
echo "> ".__('Hide the Edit Button also from Loggedin Users (Normal Users don\'t see it at all)', 'wct')."<br/><br/>".

__('Hide Page nubmers below Table', 'wct')." <input type=\"checkbox\" name=\"hidepagenumbers\" value=\"1\"";
if ($this->settings['hidepagenumbers'] == '1') { echo " checked"; }
echo "><br/><br/>".

__('Nice Set Fields', 'wct')." <input type=\"checkbox\" name=\"nice_setfields\" value=\"1\"";
if ($this->settings['nice_setfields'] == '1') { echo " checked"; }
echo "> ".__('Set fields are Comma separated. Betewwn Entries there is no Space like A,B. With this Option activated, the Entry get Spaces between like A, B.', 'wct')."<br/>".
__('<b>Attention:</b> This feature can have performance impact on large tables.','wct')."<br/><br/>".

__('Disable HTML Filter', 'wct')." <input type=\"checkbox\" name=\"wct_unfilteredhtml\" value=\"1\"";
if ($this->settings['wct_unfilteredhtml'] == '1') { echo " checked"; }
echo "> ".__('WordPress filters the HTML befor it saves. This filter removes &lt;p&gt; and &lt;br&gt; Tags. If you don\' like it, disable it here.', 'wct')."<br/>".
"<br/>".

__('Show SQL Statements Fields', 'wct')." <input type=\"checkbox\" name=\"wct_unfilteredsql\" value=\"1\"";
if ($this->settings['wct_unfilteredsql'] == '1') { echo " checked"; }
echo "> ".__('This Checkbox will make SQL Statement and SQL Filter Fields visible. Errors in this fields are not checked!', 'wct')."<br/>".
"<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></fieldset>";



if ($this->settings['form_serialvu'] >= time())  {
	echo "<script type=\"text/javascript\">
			function hidden_def(){
				var selection = document.getElementById(\"wctewr\").value;
				if (selection == 'auto') { document.getElementById(\"wcthwer\").type = \"hidden\"; }
				else { document.getElementById(\"wcthwer\").type = \"text\"; }
			}
			</script><fieldset><legend><strong>" . __('DB Charset for Search', 'wct') . "</strong></legend>".
	__('DB Charset', 'wct')." <select name=\"wct_dbcharset\" id=\"wctewr\" onChange=\"hidden_def()\"><option value=\"auto\"";
	if ($this->settings['search_charset'] == 'auto' OR $this->settings['search_charset'] == '') { echo " selected"; $type = "hidden"; }
	echo ">".__('Auto','wct')."</option><option value=\"manual\"";
	if ($this->settings['search_charset'] != '' AND $this->settings['search_charset'] != 'auto') { echo " selected"; $type = "text"; }
	echo ">".__('Custom','wct')."</option></select> <input id=\"wcthwer\" type=\"".$type."\" name=\"wct_dbcharset2\" value=\"".$this->settings['search_charset']."\" size=\"16\"><br/>".
	__('If you submit special characters from other kind of charsets, the search will return nothing. You can manually set here the correct Charset from your table if it doesn\'t work!','wct').
	"<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></fieldset>";

}

echo "</form><fieldset id=\"premium\" name=\"premium\"><legend><strong>PREMIUM FEATURE</strong></legend>";

if ($this->settings['form_serial'] == '') {
	if ($_POST['wct_serial_key'] != '') {
		$_POST['wct_serial_key'] = trim(str_replace(array("\n","\r","\t","\s"),"",$_POST['wct_serial_key']));
		if (preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}$/', trim($_POST['wct_serial_key']))) { $goliz = '1';	}
		elseif (strlen($_POST['wct_serial_key']) == '14') {
			$_POST['wct_serial_key'] = substr($_POST['wct_serial_key'],0,4)."-".substr($_POST['wct_serial_key'],5,4)."-".substr($_POST['wct_serial_key'],10,4);
			$goliz = '1';
		}
		elseif (strlen($_POST['wct_serial_key']) == '12') {
			$_POST['wct_serial_key'] = substr($_POST['wct_serial_key'],0,4)."-".substr($_POST['wct_serial_key'],4,4)."-".substr($_POST['wct_serial_key'],8,4);
			$goliz = '1';
		}

		if ($goliz == '1') {
			$data = $this->http_request('POST','http://wuk-custom-tables.com/wct-premium.php','serial='.trim($_POST['wct_serial_key'])."&dom=".$_SERVER['SERVER_NAME']);
			if (strpos($data,"|") !== false) {
				$tmp = explode("|",$data);
				$data = $tmp[0];
				$vu = $tmp[1];
			}
			if (preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/', $data)) {
				if ($this->prem_chk($data) == true) {
					$this->settings['form_serial'] = $data;
					if ($vu != '') { $this->settings['form_serialvu'] = $vu; }
					update_option('wuk_custom_tables', $this->settings);
					echo __('<br/>Thanks for supporting web updates kmu. Please reload page.', 'wct')."<br/><br/>";
				}
				else {
					printf("<br/><font color=\"red\">".__('Serial not accepted: \'%s\'', 'wct')."</font><br/><br/>", $data);
				}
			}
			else {
				printf("<br/><font color=\"red\">".__('Serial not accepted: \'%s\'', 'wct')."</font><br/><br/>", $data);
			}
		}
		else {
			echo "<form action=\"admin.php?page=wct_settings&validate=1\" method=\"POST\"><b>".__('Serial', 'wct').":</b> <input type=\"text\" size=\"15\" name=\"wct_serial_key\" /> <input class=\"button-primary\" type=\"submit\" value=\"".__('Validate','wct')." *\"></form>";
			echo "<i>* ". __('Validation need to have online connection to web updates kmu server!','wct')."</i>";
			echo "<br/><font color=\"red\">".__('Please check the serial number, the submitted serial number has a wrong format', 'wct')."</font><br/><br/>";
		}
	}
	else {
		echo "<form action=\"admin.php?page=wct_settings&validate=1\" method=\"POST\"><b>".__('Serial', 'wct').":</b> <input type=\"text\" size=\"15\" name=\"wct_serial_key\" /> <input class=\"button-primary\" type=\"submit\" value=\"".__('Validate','wct')." *\"></form>";
		echo "<i>* ". __('Validation need to have online connection to web updates kmu server!','wct')."</i>";
		$aktuellekosten = '40.00';

		$paypal = array('_cart','Custom Table - Premium Feature License for '.$_SERVER['SERVER_NAME'],$aktuellekosten+1.77,'');
		echo "<table><tr><td valign=\"top\">";
		include($this->wctpath."pages/paypal.php");
		echo "</td><td valign=\"top\"><br/>";
		printf( __('Premium feature will remain for 25 years and all new WCT Premium feature will be automatically licenced with this serial!<br/>The licence costs are %s &euro; *','wct'), $aktuellekosten);
		echo "</td></tr></table>";
	}
}
elseif ($this->settings['form_serialvu'] >= (time() - 1209600) AND $this->settings['form_serialvu'] != '')  {
	printf( __('Premium features licensed. Valid until %s.','wct')."<br/><br/>", date("Y-m-d",$this->settings['form_serialvu']));
}
elseif ($this->settings['form_serialvu'] >= time() AND $this->settings['form_serialvu'] != '')  {
	printf( __('Premium features licensed. Expire soon %s.','wct')."<br/>", date("Y-m-d",$this->settings['form_serialvu']));
	echo __('If you want to delete the license before it\'s expired','wct').": <a href=\"admin.php?page=wct_settings&dellic=1\">". __('click here','wct')."</a>.<br/><br/>";
}
elseif ($this->settings['form_serialvu'] == '') {
	$this->settings['form_serial'] = '';
	$this->settings['form_serialvu'] = '';
	update_option('wuk_custom_tables', $this->settings);
	echo "<br/><br/>";
}
else {
	echo __('The license has expired, please delete and renew it','wct')." <a href=\"admin.php?page=wct_settings&dellic=1\">". __('now','wct')."</a>.<br/><br/>";
}
echo "<b>". __('Features which are included','wct').":</b>
<UL>
<li>". __('Custom Forms: Define which fields can be written / updated of which tables)','wct')."</li>
<li>". __('Multiple Output Designs possible','wct')."</li>
<li>". __('Category Widget (of Enum & Set fields)','wct')."</li>
<li>". __('Search & Replace in Table','wct')."</li>
<li>". __('Extends Standard WordPress Search looks into Tables and show Article and Page if search string was found','wct')."</li>
<li>". __('SQL Cronjobs','wct')."</li>
<li>". __('Multiselection fields possible (needs jQuery)','wct')."</li>
<li>". __('Show Table/Form only if a user is logged in (Option)','wct')."</li>
<li>". __('Table download is possible on public page as Excel and CSV file (Option)','wct')."</li>
<li>". __('Unknown CSV Importer has no limits','wct')."</li>
<li>". __('n2n Relations between Tables possible','wct')." (BETA)</li>
<li>". __('Multiple database rows in 1 line possible','wct')."</li>
</UL>";
if ($this->settings['form_serial'] == '') {
	echo "<br/>* ". __('Please note, the key price can increase in the future, the valid price is in the latest plugin version committed. Prices in older Pluginversions are not valid and don\'t garantee the same price.','wct')."<br/>* ". __('Premium Feature License is valid for 1 Domain only!','wct');
}

echo "</fieldset><fieldset><legend><strong>".__('Other usefull plugins', 'wct')." ". __('in combination','wct')."</strong></legend>".__('Please note that the following Plugins are NOT developed from web updates kmu and therefor no support can be granted.','wct')."<br/>&nbsp;<table>";

$this->iplugin('qTranslate','qtranslate','qtranslate/qtranslate.php','qtranslate','Multilanguage Plugin which is fully supported of Custom Tables');
$this->iplugin('Really Simple CAPTCHA','really-simple-captcha','really-simple-captcha/really-simple-captcha.php','really-simple-captcha','Add Captcha Support on the Custom Forms');
$this->iplugin('Cart66&nbsp;Lite','cart66-lite','cart66-lite/cart66.php','cart66_admin','Webshop Plugin to have full Webshop functionality within the Custom Tables Plugin','admin.php');
if ($this->settings['form_serialvu'] >= time())  {
	$this->iplugin('CharSetFix','http://api.wuk.ch/charsetfix.zip','charsetfix/charsetfix.php','CharSetFix','Changes the Custom Tables Database CharSet to UTF8, this is only needed once if you have problems with special chars.');
}

echo "</table></fieldset><fieldset><legend><strong>".__('Other usefull plugins', 'wct')."</strong></legend><table>";

$this->iplugin('Manual DoFollow','manuall-dofollow','manuall-dofollow/manual_dofollow.php','manuall-dofollow/manual_dofollow.php','SMu DoFollow has many DoFollow Options (Manual or Automatism) and included URL Validator (Manual, WP-Cron or Cronjob)', 'admin.php');

echo "</table></fieldset>";

?>
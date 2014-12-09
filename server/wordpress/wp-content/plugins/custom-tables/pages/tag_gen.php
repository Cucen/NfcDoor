<?php

if (is_user_logged_in()) {
	global $current_user,$arr_user,$user;
	if (!isset($arr_user)) {
		$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);
	}
	get_currentuserinfo();
	$preset = $wpdb->prefix."capabilities";
	if ($userdata->{$preset}['administrator'] == '1' AND $userdata->user_level == '0') { $userdata->user_level = '10'; }
	$username = $user->data->user_login;
}

if (strstr($_SERVER[PHP_SELF],'admin.php')) { echo "<h3>".__('Smarttag Generator','wct')."</h3>"; }

$possibilities = array(
	'wctable' => __('Show Table on Article or Page','wct'),
	'wctselect' => __('Show Dropdown from a field','wct'),
	'wctsearch' => __('Show Searchfield','wct'),
	'wctclear' => __('Add the Clear button by the Search','wct'),
	'wcteid' => __('Show only one Entry of a Table on Article or Page','wct'),
	'if' => __('IF Statement','wct'),
	'wctoverlay' => __('Show Overlay when mouseover in table','wct'),
	'wctphp' => __('Add PHP Code on Page or Article','wct'),
	'wctdate2' => __('Show a date from a timestamp','wct'),
	'wcteditpage' => __('Show the Edit Form for all Tables (all Rights)','wct'));
	
if ($this->settings['hideedit'] == '1') {
	$possibilities['wctedit'] = __('Add manually the Editbutton in table setup view (only visible for Admins)','wct');
}

$possibilities2 = array(
	'wctmultiselect' => __('Show Multiselect Dropdown from a field','wct'),
	'wctform' => __('Show generated Form','wct'),
	'wctloggedin' => __('Show content only if user is logged in','wct'));

$possibilities3 = array(
	'wctarchive' => __('Show Archive on a Page or Article','wct'),
	'wctdate' => __('Show all dates which have Articles','wct'));

if ($this->settings['wct_unfilteredsql'] == '1') {
	$sqlfiltertext = "<br/><b>*<sup>2</sup>:</b> ".__('There are some special filters which can be applied on SQL field','wct').":<br/>
	<table><tr><td><b>time()</b></td><td>".__('actual time as timestamp like','wct').": ".time()."</td></tr>
	<tr><td><b>time()-1d</b></td><td>".__('actual time minus one day as timestamp like','wct').": ".(time()-86400)."</td></tr>
	<tr><td><b>time()+1d</b></td><td>".__('actual time plus one day as timestamp like','wct').": ".(time()+86400)."</td></tr>
	<tr><td><b>USERNAME</b></td><td>".__('Username of logged in user like','wct').": ".$username."</td></tr></table>";
}

if (strstr($_SERVER[PHP_SELF],'admin.php')) { $aurl = "admin.php?page=wct_taggen"; }
else { $aurl = $this->generate_pagelink("/test/","test"); }

echo "<form id=\"form\" name=\"form\" action=\"".$aurl."\" method=\"POST\"><input id=\"case\" type=\"hidden\" name=\"case\" value=\"\">".
__('For what do you want to generate a Smarttag?','wct').
"<br/><select id=\"wassa\" onChange=\"javascript:taggensend();\"><option value=\"\"></option>";
foreach ($possibilities as $var => $wert) {
	echo "<option value=\"".$var."\"";
	if ($_POST['case'] == $var) { echo 'selected'; $titel = $wert; }
	echo ">".$wert."</option>";
}
if ($this->prem_chk() == true) {
	echo "<OPTGROUP LABEL=\"Premium Functions\">";
	foreach ($possibilities2 as $var => $wert) {
		echo "<option value=\"".$var."\"";
		if ($_POST['case'] == $var) { echo 'selected'; $titel = $wert; }
		echo ">".$wert."</option>";
	}
	echo "</OPTGROUP>";
}

echo "<OPTGROUP LABEL=\"Article Archive\">";
foreach ($possibilities3 as $var => $wert) {
	echo "<option value=\"".$var."\"";
	if ($_POST['case'] == $var) { echo 'selected'; $titel = $wert; }
	echo ">".$wert."</option>";
}
echo "</OPTGROUP></select></form><br/>
<script type=\"text/javascript\">function taggensend() { document.getElementById(\"case\").value = document.getElementById(\"wassa\").value;document.forms['form'].submit(); } </script>";

if ($_POST['case'] != '') { echo "<h3>".$titel."</h3>"; }

switch($_POST['case']) {
	case 'wctable':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<script type=\"text/javascript\">
			function wselect() {";

		if ($this->prem_chk() == true) {
			echo "document.getElementById('removable').options.length = 0;
				var the_element = document.getElementById('removable');
				if ( the_element !== null ) {
					the_element.parentNode.removeChild( the_element );
				}
				var the_table = document.getElementById('f_id').value;
				var div=document.getElementById('erer');
				if (the_table == '') {


					var objSelect = document.createElement('select');
					objSelect.id = \"removable\";
					objSelect.name = \"f_design\";

					var objOption = document.createElement('option');
					objOption.text=\"\";
					objOption.value=\"\";
					objSelect.options.add(objOption);

				}
";
			foreach ($qry as $row) {
				echo "\t\t\t\tif (the_table == '".$row->id."') {
					var objSelect = document.createElement('select');
					objSelect.id = \"removable\";
					objSelect.name = \"f_design\";

					var objOption = document.createElement(\"option\");
					objOption.text=\"Standard\";
					objOption.value=\"\";
					objSelect.options.add(objOption);";

				$qry2 = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$row->id."';");
				if (count($qry2) >= '1') { foreach ($qry2 as $row2) {
					echo "
					var objOption = document.createElement(\"option\");
					objOption.text=\"".$row2->name."\";
					objOption.value=\"".$row2->id."\";
					objSelect.options.add(objOption);";
				}}
					echo "
				}
";
			}
			echo "	
				div.appendChild(objSelect);	";
		}
		echo "
			}
		</script>
		<table><tr><td><b>".__('Select Table to display','wct').":</b></td><td><select onChange=\"wselect();\" id=\"f_id\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<tr><td><b>".__('How many Records should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_limit\" value=\"50\"></td></tr>";
		if ($this->prem_chk() == true) {
			echo "<tr><tr><td><b>".__('Design to select (ID or Name)','wct').":</b></td><td><div id=\"erer\"><select id=\"removable\"><option></option></select></div></td></tr>";
		}
		else {
			echo "<input type=\"hidden\" id=\"f_design\" value=\"\">";
		}
		echo "<tr><td><b>".__('How many Pagenumbers should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_pages\" value=\"12\"></td></tr>
		<tr><td><b>".__('Show Table only if someone searched something','wct').":</b></td><td><select id=\"f_searched\"><option value=\"\">". __('No','wct') ."</option><option value=\"1\">". __('Yes','wct') ."</option></select></td></tr>
		<tr><td><b>".__('Do not apply filters','wct').":</b></td><td><select id=\"f_nofilter\"><option value=\"\">". __('No','wct') ."</option><option value=\"true\">". __('Yes','wct') ."</option></select></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') { echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *<sup>2</sup></td></tr>"; }
		echo "<tr><td><b>CSS Salt:</b></td><td><input size=\"10\" type=\"text\" id=\"f_css\" value=\"\"></td></tr>
		</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			if (id != '') {
				var limit = document.getElementById(\"f_limit\").value;
				if (limit != '50' && limit != '') { limit = ' limit=\"' + limit + '\"'; } else { limit = ''; }
				var searched = document.getElementById(\"f_searched\").value;
				if (searched != '') { searched = ' searched=\"1\"'; } else { searched = ''; }";
				if ($this->prem_chk() == true) {
					echo "var design = document.getElementById(\"removable\").value;
					if (design != '') { design = ' design=\"' + design + '\"'; } else { design = ''; }"; }
				else { echo "var design = '';"; }
				echo "
				var pages = document.getElementById(\"f_pages\").value;
				if (pages != '12' && pages != '') { pages = ' pages=\"' + pages + '\"'; } else { pages = ''; }
				var css = document.getElementById(\"f_css\").value;
				if (css != '') { css = ' css=\"' + css + '\"'; } else { css = ''; }
				var nofilter = document.getElementById(\"f_nofilter\").value;
				if (nofilter != '') { nofilter = ' nofilter=\"1\"'; } else { nofilter = ''; }";
					if ($this->settings['wct_unfilteredsql'] == '1') {
					echo "
						var filter = document.getElementById(\"f_filter\").value;
						if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }";
					}
				else { echo "filter = '';"; }
				echo "
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[wctable id=\"' + id + '\"' + pages + limit + design + nofilter + filter + css + searched + ']';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script>".$sqlfiltertext;
	break;

	case 'wcteid':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<script type=\"text/javascript\">
			function wselect() {";

		if ($this->prem_chk() == true) {
			echo "document.getElementById('removable').options.length = 0;
				var the_element = document.getElementById('removable');
				if ( the_element !== null ) {
					the_element.parentNode.removeChild( the_element );
				}
				var the_table = document.getElementById('f_id').value;
				var div=document.getElementById('erer');
				if (the_table == '') {
					var objSelect = document.createElement('select');
					objSelect.id = \"removable\";
					objSelect.name = \"f_design\";

					var objOption = document.createElement('option');
					objOption.text=\"\";
					objOption.value=\"\";
					objSelect.options.add(objOption);

				}
";
			foreach ($qry as $row) {
				echo "\t\t\t\tif (the_table == '".$row->id."') {
					var objSelect = document.createElement('select');
					objSelect.id = \"removable\";
					objSelect.name = \"f_design\";

					var objOption = document.createElement(\"option\");
					objOption.text=\"Standard\";
					objOption.value=\"\";
					objSelect.options.add(objOption);";

				$qry2 = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$row->id."';");
				if (count($qry2) >= '1') { foreach ($qry2 as $row2) {
					echo "
					var objOption = document.createElement(\"option\");
					objOption.text=\"".$row2->name."\";
					objOption.value=\"".$row2->id."\";
					objSelect.options.add(objOption);";
				}}
					echo "
				}
";
			}
			echo "	
				div.appendChild(objSelect);	";
		}
		echo "
			}
		</script><table><tr><td><b>".__('Select Table to display','wct').":</b></td><td><select onChange=\"wselect();\" id=\"f_id\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<tr><td><b>".__('ID of the Entry which should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_eid\" value=\"\"></td></tr>";
		if ($this->prem_chk() == true) {
			echo "<tr><tr><td><b>".__('Design to select (ID or Name)','wct').":</b></td><td><div id=\"erer\"><select id=\"f_design\"><option></option></select></div></td></tr>";
		}
		else {
			echo "<input type=\"hidden\" id=\"f_design\" value=\"\">";
		}
		echo "<tr><td><b>".__('Do not apply filters','wct').":</b></td><td><select id=\"f_nofilter\"><option value=\"\">". __('No','wct') ."</option><option value=\"true\">". __('Yes','wct') ."</option></select></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') { echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *<sup>2</sup></td></tr>"; }
		echo "<tr><td><b>CSS Salt:</b></td><td><input size=\"10\" type=\"text\" id=\"f_css\" value=\"\"></td></tr>
		</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			var eid = document.getElementById(\"f_eid\").value;
			if (id != '' && eid != '') {

				var design = document.getElementById(\"f_design\").value;
				if (design != '') { design = ' design=\"' + design + '\"'; } else { design = ''; }
							alert('test');
				var css = document.getElementById(\"f_css\").value;
				if (css != '') { css = ' css=\"' + css + '\"'; } else { css = ''; }
				var nofilter = document.getElementById(\"f_nofilter\").value;
				if (nofilter != '') { nofilter = ' nofilter=\"1\"'; } else { nofilter = ''; }";
		if ($this->settings['wct_unfilteredsql'] == '1') { 
			echo "
				var filter = document.getElementById(\"f_filter\").value;
				if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }";
		}
		else { echo "
				var filter = '';"; }
		echo "
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[wcteid id=\"' + id + '\" eid=\"' + eid + '\"' + design + nofilter + filter + css + ']';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script>".$sqlfiltertext;
	break;

	case 'wctselect':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<table><tr><td><b>".__('Select Table to display','wct').":</b></td><td><select id=\"f_id\" onchange=\"WctOnChange();\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<script type=\"text/javascript\">
			function WctOnChange () {
				var myindex = document.getElementById('f_id').selectedIndex;
				var SelTable = document.getElementById('f_id').options[myindex].value;
				document.getElementById('f_field').options.length=0;
				document.getElementById('f_rfield').options.length=0;";
				

				$anz = count($qry);
				foreach ($qry as $row ) {
					$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
					$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
					$tmp = explode("PRIMARY KEY",$array['Create Table']);
					$tmp = explode("`status`",$tmp[0]);
					echo "if (SelTable == '".$row->id."') {";

					preg_match_all("/`(.*)` (.*)/",$tmp[1],$matches);
					$g = $h = 0;
					for ($x=0;$matches[1][$x] != '';$x++) {
						if (substr($matches[2][$x],0,7) == 'int(12)' AND $this->prem_chk() == true) {
							$g++;
							$subqry = $wpdb->get_row("SELECT `z_field`,`z_field2` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$row->id."' AND `s_field`='".mres($matches[1][$x])."' LIMIT 1;");
							
							echo "document.getElementById('f_rfield').options[$g]=new Option(\"".$subqry->z_field."\", \"".$matches[1][$x]."|".$subqry->z_field."\", false, false);";
							if ($row->id == $instance['table']) {
								$stdoptr .= "<option value=\"".$matches[1][$x]."|".$subqry->z_field."\"". (($subqry->z_field == $field) ? ' selected' : '' ).">".$subqry->z_field."</option>";
							}
						}
						elseif ($matches[1][$x] != 'status') {
							$h++;
							echo "document.getElementById('f_field').options[$h]=new Option(\"".$matches[1][$x]."\", \"".$matches[1][$x]."\", false, false);";
							if ($row->id == $instance['table']) {
								$stdopt .= "<option value=\"".$matches[1][$x]."\"". (($matches[1][$x] == $field) ? ' selected' : '' ).">".$matches[1][$x]."</option>";
							}
						}
					}
					echo "}";
				}
			echo "}</script>";


		echo "<tr><td><b>".__('Field','wct').":</b></td><td><select id=\"f_field\" name=\"f_field\">".$stdopt."</select></td></tr>";
		if ($this->prem_chk() == true) {
			echo "<tr><td><b>".__('Take Relation field instead','wct').":</b></td><td><select id=\"f_rfield\" name=\"f_rfield\">".$stdoptr."</select></td></tr>";			
		}		
		echo "<tr><td><b>".__('How many entries should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_limit\" value=\"20\"></td></tr>
		<tr><td><b>".__('Title Text','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_text\" value=\"".__('All entries','wct')."\"></td></tr>
		<tr><td><b>Salt:</b></td><td><input size=\"4\" type=\"text\" id=\"f_salt\" value=\"\"> (only numbers!) *</td></tr>
		<tr><td><b>".__('Sort by','wct').":</b></td><td><select id=\"f_sortA\"><option value=\"anz\">". __('Amount of Entries','wct') ."</option><option value=\"name\">". __('Alphabetical','wct') ."</option></select> <select id=\"f_sortB\"><option value=\"DESC\">DESC</option><option value=\"ASC\">ASC</option></select></td></tr>
		<tr><td><b>".__('Show Amount of Entries','wct').":</b></td><td><input type=\"checkbox\" id=\"f_amount\" value=\"1\" checked></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') { echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *<sup>2</sup></td></tr>"; }
		echo "</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			var field = document.getElementById(\"f_field\").value;
			if (id != '' && field != '') {
				var limit = document.getElementById(\"f_limit\").value;
				if (limit != '20' && limit != '') { limit = ' limit=\"' + limit + '\"'; } else { limit = ''; }
				var sortB = document.getElementById(\"f_sortB\").value;
				var sortA = document.getElementById(\"f_sortA\").value;
				if (sortB != 'DESC' || sortA != 'anz') { sort = ' sort=\"' + sortA + ' ' + sortB + '\"'; } else { sort = ''; }
				var salt = document.getElementById(\"f_salt\").value;
				if (salt != '') { salt = ' salt=\"' + salt + '\"'; } else { salt = ''; }
				var text = document.getElementById(\"f_text\").value;
				if (text != '".__('All entries','wct')."' && text != '') { text = ' maintext=\"' + text + '\"'; } else { text = ''; }
				if (document.getElementById(\"f_amount\").checked == true) { amon = ''; } else { amon = ' amount=\"0\"'; }";
		if ($this->settings['wct_unfilteredsql'] == '1') { 
			echo "
				var filter = document.getElementById(\"f_filter\").value;
				if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }";
		}
		else { echo "var filter = '';"; }
		
		if ($this->prem_chk() == true) { 
			echo "
				var rfield = document.getElementById(\"f_rfield\").value;
				rfieldb = rfield.replace('|', '\" linkname=\"');
				if (rfield != '') { rfieldd = ' linkfield=\"' + rfieldb + '\" '; } else { rfieldd = ''; } ";
		}
		else { echo "var rfieldd = '';"; }
		
		echo "
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[wctselect id=\"' + id + '\" field=\"' + field + '\"' + limit + rfieldd + text + filter + sort + salt + amon + ']';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script> <br/><b>*:</b> ".__('Dropdown fields will normally reset all other dropdown fields. Now you can make groups via SALT. Dropdown fields within the same Salt group will reset each others. 2 dropdown fields in other Salt groups will not reseat each other and additionaly both Filters will applied.','wct').$sqlfiltertext;
	break;

	case 'wctmultiselect':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<table><tr><td><b>".__('Select Table to display','wct').":</b></td><td><select id=\"f_id\" onchange=\"WctOnChange();\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<script type=\"text/javascript\">
			function WctOnChange () {
				var myindex = document.getElementById('f_id').selectedIndex;
				var SelTable = document.getElementById('f_id').options[myindex].value;
				document.getElementById('f_field').options.length=0;";

				$anz = count($qry);
				foreach ($qry as $row ) {
					$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
					$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
					$tmp = explode("PRIMARY KEY",$array['Create Table']);
					$tmp = explode("`status`",$tmp[0]);
					echo "if (SelTable == '".$row->id."') {";

					preg_match_all("/`(.*)` .*/",$tmp[1],$matches);

					for ($x=0;$matches[1][$x] != '';$x++) {
						if ($matches[1][$x] != 'status') {
							echo "document.getElementById('f_field').options[$x]=new Option(\"".$matches[1][$x]."\", \"".$matches[1][$x]."\", false, false);";
							if ($row->id == $instance['table']) {
								$stdopt .= "<option value=\"".$matches[1][$x]."\"". (($matches[1][$x] == $field) ? ' selected' : '' ).">".$matches[1][$x]."</option>";
							}
						}
					}
					echo "}";
				}
			echo "}</script>";


		echo "<tr><td><b>".__('Field','wct').":</b></td><td><select id=\"f_field\" name=\"f_field\">".$stdopt."</select></td></tr>
		<tr><td><b>".__('How many entries should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_limit\" value=\"20\"></td></tr>
		<tr><td><b>".__('The fixed width of the selection field','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_width\" value=\"150\"></td></tr>
		<tr><td><b>".__('Title Text','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_text\" value=\"".__('Choose an Option','wct')."\"></td></tr>
		<tr><td><b>".__('Show Header line','wct').":</b></td><td><select id=\"f_header\"><option value=\"true\">". __('Yes','wct') ."</option><option value=\"false\">". __('No','wct') ."</option></select></td></tr>
		<tr><td><b>Salt:</b></td><td><input size=\"4\" type=\"text\" id=\"f_salt\" value=\"\"> (only numbers!) *</td></tr>
		<tr><td><b>".__('Sort by','wct').":</b></td><td><select id=\"f_sortA\"><option value=\"anz\">". __('Amount of Entries','wct') ."</option><option value=\"name\">". __('Alphabetical','wct') ."</option></select> <select id=\"f_sortB\"><option value=\"DESC\">DESC</option><option value=\"ASC\">ASC</option></select></td></tr>
		<tr><td><b>".__('Show Amount of Entries','wct').":</b></td><td><input type=\"checkbox\" id=\"f_amount\" value=\"1\" checked></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') { echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *<sup>2</sup></td></tr>"; }
		echo "</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			var field = document.getElementById(\"f_field\").value;
			if (id != '' && field != '') {
				var limit = document.getElementById(\"f_limit\").value;
				if (limit != '20' && limit != '') { limit = ' limit=\"' + limit + '\"'; } else { limit = ''; }
				var sortB = document.getElementById(\"f_sortB\").value;
				var sortA = document.getElementById(\"f_sortA\").value;
				if (sortB != 'DESC' || sortA != 'anz') { sort = ' sort=\"' + sortA + ' ' + sortB + '\"'; } else { sort = ''; }
				var salt = document.getElementById(\"f_salt\").value;
				if (salt != '') { salt = ' salt=\"' + salt + '\"'; } else { salt = ''; }
				var header = document.getElementById(\"f_header\").value;
				if (header != 'true') { header = ' header=\"' + header + '\"'; } else { header = ''; }
				var width = document.getElementById(\"f_width\").value;
				if (width != '150') { width = ' width=\"' + width + '\"'; } else { width = ''; }
				var text = document.getElementById(\"f_text\").value;
				if (text != '".__('All entries','wct')."' && text != '') { text = ' maintext=\"' + text + '\"'; } else { text = ''; }
				if (document.getElementById(\"f_amount\").checked == true) { amon = ''; } else { amon = ' amount=\"0\"'; }";
		if ($this->settings['wct_unfilteredsql'] == '1') { 
			echo "
				var filter = document.getElementById(\"f_filter\").value;
				if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }";
		}
		else { echo "filter = '';"; }
		echo "
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[wctmultiselect id=\"' + id + '\" field=\"' + field + '\"' + width + limit + text + filter + sort + salt + header + amon + ']';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script> <br/><b>*:</b> ".__('Dropdown fields will normally reset all other dropdown fields. Now you can make groups via SALT. Dropdown fields within the same Salt group will reset each others. 2 dropdown fields in other Salt groups will not reseat each other and additionaly both Filters will applied.','wct').$sqlfiltertext;
	break;


	case 'wctclear':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctclear]\" readonly>";
	break;

	case 'wcteditpage':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<table><tr><td><b>".__('Select Table to edit','wct').":</b></td><td><select id=\"f_id\"><option value=\"\">".__('All tables','wct')."</option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<tr><td><b>".__('HTML Editor','wct').":</b></td><td><select id=\"f_html\"><option value=\"0\">". __('Deactivated','wct') ."</option><option value=\"1\">". __('Activated','wct') ."</option></select></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') { echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *<sup>2</sup></td></tr>"; }
		echo "</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>

		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			if (id != '') { id = ' id=\"' + id + '\"'; } else { id = ''; }
			var html = document.getElementById(\"f_html\").value;
			if (html == '1') { html = ' html=\"1\"'; } else { html = ''; }";
			if ($this->settings['wct_unfilteredsql'] == '1') { 
			echo "
			var filter = document.getElementById(\"f_filter\").value;
			if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }";
		}
		else { echo "filter = '';"; }
		echo "
			document.getElementById(\"ausgabe\").style.visibility = 'visible';
			document.getElementById(\"ausgabe\").style.display = 'block';
			document.getElementById(\"ausgabe2\").value = '[wcteditpage' + id + html + filter + ']';
		}
		</script>".$sqlfiltertext;
	break;

	case 'wctphp':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctphp] [/wctphp]\" readonly><br/><br/>
		<b>".__('Example','wct').":</b> <input id=\"ausgabe2\" style=\"width:300px;\" type=\"text\" value=\"[wctphp]echo &quot;test&quot;;[/wctphp]\" readonly>";
	break;

	case 'wctloggedin':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctloggedin] [/wctloggedin]\" readonly><br/><br/>
		<b>".__('Example','wct').":</b> <input id=\"ausgabe2\" style=\"width:475px;\" type=\"text\" value=\"[wctloggedin]Add here code or another Shortcode (e.g. a custom table)[/wctloggedin]\" readonly>";
	break;

	case 'wctdate':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctdate]\" readonly>";
	break;
	
	case 'wctedit':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctedit]&lt;td&gt;editlink&lt;/td&gt;[/wctedit]\" readonly>";
	break;

	case 'wctdate2':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctphp]strftime(&quot;%A, %d.%m.%Y&quot;,'')[/wctphp]\" readonly><br/><br/>
		<b>".__('Example','wct').":</b> <input id=\"ausgabe2\" style=\"width:300px;\" type=\"text\" value=\"[wctphp]strftime(&quot;%A, %d.%m.%Y&quot;,'{date}')[/wctphp]\" readonly><br/><br/>
		".__('If you have problems with the language of the date/time, please consider to set the correct langauge as follow (not all Hostings supporting this)','wct').":<br/><textarea style=\"width:270px !important;height:120px !important;\" readonly>[wctphp]\nputenv('LC_ALL=en_US.utf8');\nsetlocale(LC_ALL, 'en_US.utf8');\necho strftime(&quot;%A, %d.%m.%Y&quot;,'{date}');\n[/wctphp]</textarea>";
	break;

	case 'wctarchive':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctarchive]\" readonly>";
	break;

	case 'wctform':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_form` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<table><tr><td><b>".__('Select Table to edit','wct').":</b></td><td><select id=\"f_id\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name."</option>";
		}
		echo "</select></td></tr>
		<tr><td><b>".__('How many Records should be shown','wct').":</b></td><td><input size=\"5\" type=\"text\" id=\"f_limit\" value=\"50\"></td></tr>";
		if ($this->settings['wct_unfilteredsql'] == '1') {
			echo "<tr><td><b>".__('SQL Filter','wct').":</b></td><td><input size=\"60\" type=\"text\" id=\"f_filter\" value=\"\"> *</td></tr>
			<tr><td><b>".__('Edit direct first Entry','wct').":</b></td><td><input type=\"checkbox\" id=\"f_def\" value=\"1\"></td></tr>";
		}
		echo "</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>
		<script type=\"text/javascript\">
		function taggen() {
			var id = document.getElementById(\"f_id\").value;
			if (id != '') {
				var limit = document.getElementById(\"f_limit\").value;
				if (limit != '50' && limit != '') { limit = ' limit=\"' + limit + '\"'; } else { limit = ''; }
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';";
				if ($this->settings['wct_unfilteredsql'] == '1') { 
					echo "var filter = document.getElementById(\"f_filter\").value;
					if (filter != '') { filter = ' filter=\"' + filter + '\"'; } else { filter = ''; }
					if (document.getElementById('f_def').checked == true) { filter = filter + ' def=\"1\"'; }";
				} else { echo "filter = '';"; }

				echo "document.getElementById(\"ausgabe2\").value = '[wctform id=\"' + id + '\"' + limit + filter + ']';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script>".
		"* ".__('To filter after a Username which is logged in to WordPress, you can use USERNAME within the SQL field, like:','wct')." `user`='USERNAME'";
	break;

	case 'wctoverlay':
		echo "<b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" value=\"[wctoverlay] [/wctoverlay]\" readonly><br/><br/>
		<b>".__('Example','wct').":</b> <input id=\"ausgabe2\" style=\"width:300px;\" type=\"text\" value=\"[wctoverlay]Some Text[/wctoverlay]\" readonly>";

	break;

	case 'wctsearch':
		echo "<script type=\"text/javascript\">


function getCheckedValue(radioObj) {
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked) {
			if (radioObj.value == 'all') {
				document.getElementById(\"indiv\").style.visibility = 'hidden';
				document.getElementById(\"indiv\").style.display = 'none';
				return '';
			}
			else {
				document.getElementById(\"indiv\").style.visibility = 'visible';
				document.getElementById(\"indiv\").style.display = 'block';
				return '';
			}
		}
		else
			return '';
	}
</script>
<style type=\"text/css\">fieldset{margin-top: 1em;margin-right: 0pt;margin-bottom: 1em;margin-left: 0pt;background-color: #fdfdfd;background-image:none;background-repeat:repeat;background-attachment:scroll;background-position: 0% 0%;padding-top: 0pt;padding-right: 1em;padding-bottom: 1em;padding-left: 1em;border-top-width: 1px;border-right-width-value: 1px;border-right-width-ltr-source: physical;border-right-width-rtl-source: physical;border-bottom-width: 1px;border-left-width-value: 1px;border-left-width-ltr-source: physical;border-left-width-rtl-source: physical;border-top-style: solid;border-right-style-value: solid;border-right-style-ltr-source: physical;border-right-style-rtl-source: physical;border-bottom-style: solid;border-left-style-value: solid;border-left-style-ltr-source: physical;border-left-style-rtl-source: physical;border-top-color: #bbbbbb;border-right-color-value: #bbbbbb;border-right-color-ltr-source: physical;border-right-color-rtl-source: physical;border-bottom-color: #bbbbbb;border-left-color-value: #bbbbbb;border-left-color-ltr-source: physical;border-left-color-rtl-source: physical;}</style>".__('The search will work over all tables and all fields. Of corse, you can define which fields can be searched over all tables.','wct');
		echo "<fieldset><legend><h4>" . __('Search', 'wct') . "</h4></legend>
		<b>".__('Search Text','wct').":</b> <input size=\"60\" type=\"text\" id=\"f_text\" value=\"sss\"> (sss = ".__('Language sensitive text','wct')."<br/>
		<input onClick=\"getCheckedValue(this)\" type=\"radio\" name=\"wassa\" value=\"all\" id=\"wassa1\" checked>" . __('All Tables and all Fields', 'wct') . "<br/><input onClick=\"getCheckedValue(this)\" type=\"radio\" name=\"wassa\" value=\"individual\" id=\"wassa\">" . __('Individual Tables and fields', 'wct') . "<br/>
		<input type=\"checkbox\" name=\"wassae\" value=\"1\" id=\"wassae\"> ".__('Exact Search','wct')."</fieldset>";
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		
		echo "<div id=\"indiv\" style=\"visibility:hidden;display:none;\"><fieldset><legend><h4>" . __('Individual Tables and fields', 'wct') . "</h4></legend>";
		foreach ($qry as $row) {
			echo "<br/><b>".$row->name." ".__('Fields','wct')."</b><br/>";
			$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
			$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
			$felder = explode("PRIMARY KEY",$array['Create Table']);
			$felder = array_slice(explode("`",$felder[0]),5);
			for ($x=0;$felder[$x] !='';$x++) {
				if ($felder[$x] != 'id' AND $felder[$x] != 'status') {
					echo "<div style=\"width:135px;float:left;overflow:hidden;\"><input type=\"checkbox\" id=\"t".$row->id.$felder[$x]."\" value=\"1\">".$felder[$x]."</div>\n";
					$r++;
					if ($r >= '4') { echo "<br/>"; $r = '0'; }
					$java .= "if (document.getElementById('t".$row->id.$felder[$x]."').checked == true) { total = total + '".$felder[$x].",'; }\n";
				}
				$x++;
			}
			echo "<div class=\"clear\"></div>";
		}
		echo "</fieldset></div><script>function taggen() {

			var text = document.getElementById(\"f_text\").value;
			if (text != 'sss') { text = ' text=\"' + text + '\"'; } else { text = ''; }
			
			if (document.getElementById('wassae').checked == true) {
				text += ' exact=\"1\"';
			}

			if (document.getElementById('wassa1').checked == true) {
				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[wctsearch' + text + ']';
			}
			else {			
				var total = '';
				".$java."
				var len = total.length;
				if (len > 1) {
					document.getElementById(\"ausgabe\").style.visibility = 'visible';
					document.getElementById(\"ausgabe\").style.display = 'block';
					document.getElementById(\"ausgabe2\").value = '[wctsearch fields=\"' + total.substr(0,len-1) + '\"' + text + ']';
				}
				else {
					document.getElementById(\"ausgabe\").style.visibility = 'hidden';
					document.getElementById(\"ausgabe\").style.display = 'none';
				}
			}
		}
		</script>
		<input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><input id=\"ausgabe2\" style=\"width:580px;\" type=\"text\" readonly></div>";
	break;

	case 'if':
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		echo "<table><tr><td><b>".__('Select Field','wct').":</b></td><td><select id=\"f_field\"><option value=\"\"></option>";
		foreach ($qry as $row) {
			echo "<OPTGROUP LABEL=\"".$row->name." ".__('Fields','wct')."\">";
			$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
			$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
			$felder = explode("PRIMARY KEY",$array['Create Table']);
			$felder = array_slice(explode("`",$felder[0]),5);
			for ($x=0;$felder[$x] !='';$x++) {
				if ($felder[$x] != 'id' AND $felder[$x] != 'status') {
					echo "<option value=\"".$felder[$x]."\">".$felder[$x]."</option>";
				}
				$x++;
			}
			echo "</OPTGROUP>";
		}
		echo "</select></td></tr>
		<tr><td><b>".__('Operator','wct').":</b></td><td><select id=\"f_op\">
			<option value=\"!=\">".__('Not Equal','wct')."</option>
			<option value=\"==\">".__('Equal','wct')."</option>
			<option value=\">=\">".__('Bigger or Equal','wct')."</option>
			<option value=\"<=\">".__('Smaller or Equal','wct')."</option>
			<option value=\">\">".__('Bigger','wct')."</option>
			<option value=\"<\">".__('Smaller ','wct')."</option></select></td></tr>
		<tr><td><b>".__('Reference','wct').":</b></td><td><input size=\"20\" type=\"text\" id=\"f_var\" value=\"\"></td></tr>
		<tr><td><b>If:</b></td><td><textarea style=\"width:500px;height:200px;\" id=\"f_if\"></textarea></td></tr>
		<tr><td><b>Else:</b></td><td><textarea style=\"width:500px;height:200px;\" id=\"f_else\"></textarea></td></tr>
		</table><input type=\"button\" onclick=\"javascript:taggen();\" value=\"".__('Generate','wct')."\"><br/><br/>
		<div id=\"ausgabe\" style=\"visibility:hidden;display:none;\"><b>".__('Shortcode to copy and add where ever you want','wct').":</b><br/><textarea style=\"width:500px;height:200px;\" id=\"ausgabe2\" readonly></textarea></div>
		<script type=\"text/javascript\">
		function taggen() {
			var field = document.getElementById(\"f_field\").value;

			if (field != '') {
				var rlse = document.getElementById(\"f_else\").value;
				if (rlse != '') { rlse = ' else=\"' + rlse + '\"'; } else { rlse = ''; }

 				document.getElementById(\"ausgabe\").style.visibility = 'visible';
				document.getElementById(\"ausgabe\").style.display = 'block';
				document.getElementById(\"ausgabe2\").value = '[if field=\"{' + field + '}\" check=\"' + document.getElementById(\"f_op\").value + '\" var=\"' + document.getElementById(\"f_var\").value + '\"' + rlse + ']' + document.getElementById(\"f_if\").value + '[/if]';
			}
			else {
				document.getElementById(\"ausgabe\").style.visibility = 'hidden';
				document.getElementById(\"ausgabe\").style.display = 'none';
			}
		}
		</script>";
	break;
}

?>
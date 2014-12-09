<?php

if ($_GET['page'] != 'wct_table_create') {
	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
	if(count($table) == '0' AND $tableid != '0') {
		$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `id`='".mres($tableid)."' LIMIT 1;");
		exit("<meta http-equiv=\"refresh\" content=\"0;url=admin.php?page=custom-tables/custom-tables.php\">");
	}
	/*Hack to transform PHP Object to Array, because Objectname has a Space in the middle*/
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
}

if ($_GET['wcttab2'] == '') { $_GET['wcttab2'] = 'ts'; }
echo "<div><h2>".__('Table Setup','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
echo $this->tab_link($wcttab,'Table Setup','','ts');
if ($tableid != '') {
	$tablename = $wpdb->get_row("SELECT `name`,`overlay`,`headerline`,`sheme`,`searchaddon`,`dl`,`globaledit`,`editlink`,`menu` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".mres($tableid)."' LIMIT 1;");
	if ($tablename->name != '' AND $this->settings['wct_immaster'] == 'yes') { echo $this->tab_link($wcttab,'Indexes Setup','','sindex'); }
	if ($tablename->name != '')	{ echo $this->tab_link($wcttab,'Sort Fields','','sortfields'); }	
	if ($tablename->name != '')	{ echo $this->tab_link($wcttab,'Change Field','','renfield'); }
	
	if (strpos($array['Create Table'],"int(12)") AND $this->prem_chk() == true) {
		if ($tablename->name != '')	{ echo $this->tab_link($wcttab,'Relations','','relation'); }	
	}
	if ($this->settings['wct_unfilteredsql'] == "1") { echo $this->tab_link($wcttab,'Search Setup','','wcs'); }
	if ($tablename->name != '')	{ echo $this->tab_link($wcttab,'Delete Table','','delwct'); }	
}
else {
	echo $this->tab_link($wcttab,'Clone Table','','clonetable');
}

echo "</tr></table>";

if ($_GET['page'] != 'wct_table_create' AND $_GET['wcttab2'] == 'sortfields') {
	$tmp = str_replace(array("int(12)","varchar(254)","int(10)",",","8 ,2","' ,'"),array("relationship","picture","date"," ,","8.2","'.'"),$array['Create Table']);
	$tmp = explode("PRIMARY KEY",$tmp);
	$felder = explode(",",$tmp[0]);

	for ($i=2;$felder[$i] != '';$i++) {
		$feldoutput .= preg_replace("/`(.*)`.*/","<div class=\"box\" style=\"width: 160px;height: 25px;margin: 0 0;padding: 0px;position: relative;\"><input type=\"text\" name=\"fields[]\" value=\"$1\" readonly><div class=\"buttoner\" style=\"position: absolute;right: 4px;top: 3px;\"><a href=\"#\" class=\"up\"><img class=\"up\" src=\"".plugins_url('custom-tables/img/sort_up_black.gif')."\" alt=\"sort up\" border=\"0\" /></a> <a href=\"#\" class=\"down\"><img class=\"down\" src=\"".plugins_url('custom-tables/img/sort_down_black.gif')."\" alt=\"sort down\" border=\"0\" /></a></div></div>",$felder[$i]);
	}
}
elseif ($_GET['page'] != 'wct_table_create' AND $_GET['wcttab'] == '') {
	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
	if(count($table) == '0' AND $tableid != '0') {
		$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `id`='".mres($tableid)."' LIMIT 1;");
		exit("<meta http-equiv=\"refresh\" content=\"0;url=admin.php?page=custom-tables/custom-tables.php\">");
	}
	/*Hack to transform PHP Object to Array, because Objectname has a Space in the middle*/
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }

	$tmp = str_replace(array("int(12)","varchar(254)","int(10)",",","8 ,2","' ,'"),array("relationship","picture","date"," ,","8.2","'.'"),$array['Create Table']);
	$tmp = explode("PRIMARY KEY",$tmp);
	$felder = explode(",",$tmp[0]);

	for ($i=2;$felder[$i] != '';$i++) {
		$felder[$i] = str_replace(array("8.2","'.'"),array("8,2","','"),$felder[$i]);
		if (strpos ($felder[$i]," text") !== false OR strpos ($felder[$i]," date") !== false OR strpos ($felder[$i]," picture") !== false OR strpos ($felder[$i]," relationship") !== false) {
			$feldoutput .= preg_replace("/`(.*)`\s(.*?)\s.*/","<input type=\"hidden\" name=\"vipInfoC[]\" value=\"$1\"><div id=\"wctf_$1\"><label><input type=\"text\" name=\"vipInfo[]\" value=\"$1\" readonly><input type=\"text\" name=\"vipInfoB[]\" value=\"$2\" style=\"width:108px;\" readonly><input type=\"button\" value=\"". __('Del','wct')."\" style=\"marginLeft:5px;\" onclick=\"removeField2('wctf_$1')\" /></label></div>",$felder[$i]);
		}
		else {
			$feldoutput .= preg_replace("/`(.*)`\s(.*\))\s.*/","<input type=\"hidden\" name=\"vipInfoC[]\" value=\"$1\"><div id=\"wctf_$1\"><label><input type=\"text\" name=\"vipInfo[]\" value=\"$1\" readonly><input type=\"text\" name=\"vipInfoB[]\" value=\"$2\" style=\"width:108px;\" readonly><input type=\"button\" value=\"". __('Del','wct')."\" style=\"marginLeft:5px;\" onclick=\"removeField2('wctf_$1')\" /></label></div>",$felder[$i]);
		}
		$renaming .= preg_replace("/`(.*)`\s(.*?)\s.*/","<option value=\"$1\">$1</option>",$felder[$i]);
		if (strpos($felder[$i],"enum") === false AND strpos($felder[$i],"set") === false) {
			$renaming2 .= preg_replace("/`(.*)`\s(.*?)\s.*/","if (selection == '$1') { document.getElementById(\"wcthidden\").value = \"$2\"; document.getElementById(\"enums\").value = \"\"; document.getElementById('enums').style.visibility = 'hidden'; document.getElementById('enums2').style.visibility = 'hidden'; }",$felder[$i]);
		}
		elseif (strpos($felder[$i],"enum") !== false) {
			$renaming2 .= preg_replace("/`(.*)`\senum\((.*)\)\s.*/","if (selection == '$1') { document.getElementById(\"wcthidden\").value = \"enum\"; document.getElementById(\"enums\").value = \"$2\"; document.getElementById('enums').style.visibility = 'visible'; document.getElementById('enums2').style.visibility = 'visible'; }",$felder[$i]);
		}
		else {
			$renaming2 .= preg_replace("/`(.*)`\sset\((.*)\)\s.*/","if (selection == '$1') { document.getElementById(\"wcthidden\").value = \"set\"; document.getElementById(\"enums\").value = \"$2\"; document.getElementById('enums').style.visibility = 'visible'; document.getElementById('enums2').style.visibility = 'visible'; }",$felder[$i]);
		}
	}
}
else {
	$feldoutput = "<div class=\"field\"><label><input type=\"text\" name=\"vipInfo[]\" value=\"\"><select name=\"vipInfoB[]\" style=\"width:103px;\"><option value=\"varchar32\">varchar(32)</option><option value=\"varchar64\">varchar(64)</option><option value=\"varchar128\">varchar(128)</option><option value=\"int11\">int(11)</option><option value=\"smallint6\">smallint(6)</option><option value=\"text\">text</option><option value=\"float82\">float(8,2)</option><option value=\"int10\">date</option><option value=\"varchar254\">picture</option>".($this->prem_chk() == true ? "<option value=\"int12\">relationship</option>" : "")."</select></label></div>";
}

switch($_GET['wcttab2']) {
	case 'clonetable':
		echo "<h2>". __('Clone Table', 'wct')."</h2>";
		if ($_GET['done'] == 'false') {
			echo "<font color=\"red\">".__('Please select existing Table to clone','')."</font><br/>";
		}
		echo "<form action=\"admin.php?page=".$_GET['page']."&wcttab2=clonetable\" method=\"post\" name=\"wctform\">
		<table><tr><td><b>".__('Select Table to clone','wct').":</b></td><td><select name=\"source\">
		<option value=\"\"></option>";
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\">".$row->name." (".$row->id.")</option>";
		}		
		echo "</select></td></tr>
		<tr><td><b>".__('Select what to clone','wct').":</b></td><td><select name=\"what\"><option value=\"t\">".__('Table only','wct')."</option><option value=\"d\">".__('Table &amp; data','wct')."</option></select></td></tr>
		</table>
		<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form>";
	break;

	case 'relation':
		echo "<h2>". __('Relations', 'wct')."</h2><form action=\"admin.php?page=".$_GET['page']."&wcttab2=relation\" method=\"post\" name=\"wctform\">
		<input type=\"hidden\" name=\"viptID\" value=\"".$tableid."\">
		<font color=\"red\"><b>".__('Attention','wct').":</b> ".__('Wrong usage of this feature cannot only distroy your page, it can overload or slowdown your database until complete breakdown of the hosting server! Don\'t make loops in relationships! 1 relation to another database is secure.','')."</font><br/><br/>";

		$relats = explode(" int(12)",$array['Create Table']);
		array_pop($relats);
		
		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' AND `id`!='".$tableid."' ORDER BY `id` ASC;");
		$java = "function changeoptions(name) {
			var elSel = document.getElementById('tete_' + name);
			var elSel2 = document.getElementById('tete2_' + name);
			var i;
			for (i = elSel.length - 1; i>=0; i--) {
				elSel.remove(i);
				elSel2.remove(i);
			}
		var elOptNew2 = document.createElement('option');

		elOptNew2.text = '".$t[1]."';
		elOptNew2.value = '".$t[1]."';
		try {
			elSel2.add(elOptNew2, null);
		}
		catch(ex) {
			elSel2.add(elOptNew2);
		}";
		foreach ($qry as $row) {
			$tableer = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
			$array1=array(); foreach($tableer as $member=>$data) { $array1[$member]=$data; }
			$tmp = str_replace(array("int(12)","varchar(254)","int(10)",",","8 ,2","' ,'"),array("relationship","picture","date"," ,","8.2","'.'"),$array1['Create Table']);
			$tmp = explode("PRIMARY KEY",$tmp);
			$felder = explode(",",$tmp[0]);
			array_shift($felder);
			array_shift($felder);
			array_pop($felder);
			$java .= "			var elSelzv = document.getElementById('rel_' + name).options[document.getElementById('rel_' + name).selectedIndex].value;
					if (elSelzv == '".$row->id."') {
					";
			foreach ($felder as $var => $wert) {
				$t = explode("`",$wert);
				$java .= "			var elOptNew = document.createElement('option');
								var elOptNew2 = document.createElement('option');
						elOptNew.text = '".$t[1]."';
						elOptNew.value = '".$t[1]."';
						elOptNew2.text = '".$t[1]."';
						elOptNew2.value = '".$t[1]."';
						try {
							elSel.add(elOptNew, null);
							elSel2.add(elOptNew2, null);
						}
						catch(ex) {
							elSel.add(elOptNew);
							elSel2.add(elOptNew2);
						}
			";
			}
			$java .= "}
		";
		}
		$java .= "}";
				

		foreach($relats as $wert) {
			$name = str_replace("`","",explode(" ",$wert));
			$name = array_pop($name);
			
			$selectfeld = "<select onchange=\"changeoptions('".$name."');\" name=\"rel_".$name."\" id=\"rel_".$name."\"><option value=\"\"></option>";
			foreach ($qry as $row) {
				$exists = $wpdb->get_row("SELECT `t_table`,`z_field`,`z_field2` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".mres($tableid)."' AND `s_field`='".mres($name)."' LIMIT 1;");
				if (count($exists) == '1') { $wert = $exists->t_table; } else { $wert = ""; }
				$selectfeld .= "<option value=\"".$row->id."\"".($wert == $row->id ? " selected" : "").">".$row->name."</option>";
			}
			$selectfeld .= "</select>";
			printf(__('Relation from Table %s.%s to %s.id and show following field %s on edit content tab.','wct'),"<b>".$tableid,$name."</b>",$selectfeld,"<select id=\"tete_".$name."\" name=\"tete_".$name."\"><option value=\"".($exists->z_field != "" ? $exists->z_field : "")."\">".($exists->z_field != "" ? $exists->z_field : "")."</option></select> <select id=\"tete2_".$name."\" name=\"tete2_".$name."\"><option value=\"".($exists->z_field2 != "" ? $exists->z_field2 : "")."\">".($exists->z_field2 != "" ? $exists->z_field2 : "")."</option></select>");
			echo "<br/>";
		}	
		echo "<script>".$java."</script><br/><br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form>";
	break;
	
	case 'sindex':
		$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
		$felderm = explode("PRIMARY KEY",$array['Create Table']);
		$felder = array_slice(explode("`",$felderm[0]),5);

		$indexes = explode("`",$felderm[1]);
		for ($x=2;$felder[$x] !='';$x++) {
			$f[] = $felder[$x];
			$x++;
		}
		for ($x=2;$indexes[$x] !='';$x++) {
			if (preg_match("/UNIQUE KEY/",$indexes[$x])) {
				$j[$indexes[$x+1]][2] = '1';
			}
			$x++;
			$j[$indexes[$x]][1] = '1';
		}
		echo "<form action=\"admin.php?page=wct_table_".$tableid."&wcttab2=sindex\" method=\"post\" onSubmit=\"return chkrename()\" name=\"wctrform\" id=\"wctrform\">".
		     "<input type=\"hidden\" name=\"viptID2\" value=\"".$tableid."\"><h2>". __('Indexes Setup', 'wct')."</h2><table><tr><td><b>".__('Field Name','wct')."</b></td><td>&nbsp;</td><td><b>".__('Set Index', 'wct')."</b></td><td><b>".__('Unique value','wct')."</b></td></tr>";
		foreach ($f as $var) {
			echo "<tr><td>".$var."</td><td>&nbsp;</td><td><input type=\"checkbox\" name=\"wcti_".$var."\" value=\"1\"";
			if ($j[$var][1] == '1') { echo " checked"; $suche = $var.","; }
			echo "></td><td><input type=\"checkbox\" name=\"wctiu_".$var."\" value=\"1\"";
			if ($j[$var][2] == '1') { echo " checked"; $suche = $var.","; }
			echo "></td></tr>";
		}
		echo "</table>".__('Please adjust the Search accordently to your Indexes, by a Search over all fields, the Indexes makes no sense!','wct').
		     "<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form><br/>";
		if ($suche != '') { printf( __('The optimized searchform for the indexes can be add with %s or %s to the page.', 'wct')."</br>", '<input type=\'text\' value=\'[wctsearch felder="'.substr($suche,0,strlen($suche)-1).'" text="sss"]\' size=\'42\' readonly/>', '<input type=\'text\' value=\'[wctsearch felder="'.substr($suche,0,strlen($suche)-1).'"]\' size=\'42\' readonly/>'); }
	break;

	case 'sortfields':
 		echo "<h2>". __('Sort Fields', 'wct')."</h2><form action=\"admin.php?page=".$_GET['page']."&wcttab2=sortfields\" method=\"post\" name=\"wctform\">
		<input type=\"hidden\" name=\"viptID\" value=\"".$tableid."\"><div class=\"field\"><label><strong>". __('Table Name', 'wct') .":</strong>&nbsp;".$tablename->name."</label></div>".
		     "<br/><strong>".__('Fields', 'wct').":</strong><br/>".
		     "<input type=\"text\" name=\"id\" value=\"id\" readonly><br/>".
		     "<input type=\"text\" name=\"status\" value=\"status\" readonly><br/>
			".$feldoutput.
		     "<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form><script>jQuery(function() {
			function buttonInit() {jQuery('.buttoner a').show().filter(':first,:last').hide();}
			jQuery('.buttoner a').live('click', function(event) {var parent = jQuery(this).closest('.box');
				(jQuery(event.target).hasClass('up'))?parent.insertBefore(parent.prev()): parent.insertAfter(parent.next());         
				buttonInit();
				return false;
			});
			buttonInit();
			});
			</script>";
	break;

	case 'renfield':
	
		$a = array("\"relationship\"","\"picture\"","\"date\"");
		$b = array("\"int(12)\"","\"varchar(254)\"","\"int(10)\"");
		
		if ($this->prem_chk() == true) {
			$abfrage = $wpdb->get_results("SELECT `name`,`definition` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".$feld2[$i]."' AND `special`='0';");
			if (count($abfrage) >= '1') {
				foreach($abfrage as $roe) {
					$eigene_felder .= "<option value=\"".$roe->definition."\">".$roe->name."</option>";
					$a[] = "\"".$roe->name."\"";
					$b[] = "\"".$roe->definition."\"";
				}
			}
		}
	
		echo "<script type=\"text/javascript\">
			function hidden_def(){
				var selection = document.getElementById(\"wctfren\").value;
				if (selection == '') { document.getElementById(\"wcthidden\").value = \"\"; }
				document.getElementById(\"wctrfield\").value = document.getElementById(\"wctfren\").value;
				".str_replace($a,$b,$renaming2)."
			}
			function chkrename() {
				if (document.getElementById('wctrfield').value == \"\") {
					alert('". __ ('Please select a Field to rename', 'wct')."!');
					return false;
				}
				if (document.getElementById('wctfren').value == \"\") {
					alert('". __ ('Please give the field a new name', 'wct')."!');
					return false;
				}
				if (document.getElementById('wcthidden').value == \"\") {
					alert('". __ ('Please give the field a new name', 'wct')."!');
					return false;
				}
				return true;
			}
			function enumfield() {
				if (document.getElementById('wcthidden').value == \"enum\") {
					document.getElementById('enums').style.visibility = 'visible';
					document.getElementById('enums2').style.visibility = 'visible';
				}
				else if (document.getElementById('wcthidden').value == \"set\") {
					document.getElementById('enums').style.visibility = 'visible';
					document.getElementById('enums2').style.visibility = 'visible';
				}
				else {
					document.getElementById('enums').style.visibility = 'hidden';
					document.getElementById('enums2').style.visibility = 'hidden';
				}
			}
			</script>";
					
		echo "<h2>". __('Change Field', 'wct')."</h2>".
		     "<form action=\"admin.php?page=wct_table_".$tableid."&wcttab2=renfield\" method=\"post\" onSubmit=\"return chkrename()\" name=\"wctrform\" id=\"wctrform\"><table><input type=\"hidden\" name=\"viptID2\" value=\"".$tableid."\">".
		     "<tr><td><b>".__('Field to rename', 'wct').":</b></td><td><select name=\"wctfren\" id=\"wctfren\" onChange=\"hidden_def()\" value=\"\"><option value=\"\"></option>".$renaming."</select></td></tr>".
		     "<tr><td><b>".__('New Fieldname', 'wct').":</b></td><td><input type=\"text\" name=\"wctrfield\" id=\"wctrfield\" value=\"\"></td></tr>".
		     "<tr><td><b>".__('New definition', 'wct').":</b></td><td><select onChange=\"enumfield()\" name=\"wcthidden\" id=\"wcthidden\"><option value=\"\"></option><option value=\"varchar(32)\">varchar(32)</option><option value=\"varchar(64)\">varchar(64)</option><option value=\"varchar(128)\">varchar(128)</option><option value=\"int(11)\">int(11)</option><option value=\"smallint(6)\">smallint(6)</option><option value=\"text\">text</option><option value=\"float(8,2)\">float(8,2)</option><option value=\"enum\">enum</option><option value=\"set\">set</option><option value=\"int(10)\">date</option><option value=\"varchar(254)\">picture</option>".($this->prem_chk() == true ? "<option value=\"int(12)\">relationship</option>".$eigene_felder : "")."</select>".
		     "<input id=\"enums\" name=\"enums\" style=\"visibility:hidden;\" type=\"text\" value=\"\" size=\"120\"></td></tr>".
		     "<tr id=\"enums2\" style=\"visibility:hidden;\"><td></td><td><input name=\"resort\" type=\"checkbox\" value=\"1\" checked /> ".__('Sort all Entries alphabetically','wct')."</td></tr>".
		     "</table><input type=\"submit\" name=\"submit\" value=\"". __('Rename Field', 'wct') ."\"></form>";
	break;

	case 'delwct':
			echo "<script type=\"text/javascript\">
			function chkdelete() {
				if (document.wctdform.wctdelete.checked == true) {
					return true;
				}
				else {
					alert('". __ ('Please accept Checkbox that all data\nwill be deleted from this table!', 'wct')."');
					return false;
				}
			}
			</script>";
			echo "<h2>". __('Delete Table', 'wct')."</h2>".
			     "<form action=\"admin.php?page=wct_table_create\" method=\"post\" onSubmit=\"return chkdelete()\" name=\"wctdform\">".
			     "<input type=\"hidden\" name=\"vipID\" value=\"".$tableid."\"><input type=\"checkbox\" name=\"wctdelete\" value=\"1\" id=\"wctdelete\"> ". __('Yes, delete this table with the complete content.','wct').
			     "<br/><input type=\"submit\" name=\"submit\" value=\"". __('Delete Table including all content', 'wct') ."\"></form>";

	break;

	case 'wcs':
		$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
		$felderm = explode("PRIMARY KEY",$array['Create Table']);
		$felder = array_slice(explode("`",$felderm[0]),5);
		$indexes = explode("`",$felderm[1]);
		for ($x=3;$felder[$x] !='';$x++) {
			if (strpos($felder[$x],"int(10)") !== false) { $f[] = $felder[$x-1]; }
			$x++;
		}
		echo "<h2>". __('Search Setup', 'wct')."</h2>".__('This search AddOn can be used to search within multiple date fields.<br/>As example you have 2 fields as `start_day`=10/03/2011 and `end_day`=10/05/2011.<br/>If a user searches for one of the tags: 10/03/2011 or 10/05/2011 it will match, but not for 10/04/2011, because the database doesn\'t know which field is what.<br/>In this page you can create your own Search query which enables to search also beteween given dates in the database.','wct')."<br/><br/>";
		if( count($f) <= '1') {
			echo __('Your setup doesn\'t have at least 2 date fields, feature therefor not avaialble.','wct');
		}
		else {
			echo "<form action=\"admin.php?page=wct_table_".$tableid."&wcttab2=wcs\" method=\"post\" name=\"wctdform\">".
			     "<input type=\"hidden\" name=\"viprID\" value=\"".$tableid."\"><table><tr><td valign=\"top\"><b>".__('Search Query','wct').":</b><br><textarea style=\"width:590px;height:220px;\" name=\"searchq\">".stripslashes($tablename->searchaddon)."</textarea></td>".
			     "<td valign=\"top\"><b>".__('Availalble fields','wct').":</b><br/><textarea name=\"ignore\" style=\"width:130px;height:220px;\" readonly>";
			foreach ($f as $var) { echo $var."\r\n"; }
			echo "</textarea></td></tr></table>".
			     "<br/><input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form><br/><br/><b>".__('Example','wct').":</b> <input name=\"ignore2\" type=\"text\" size=\"58\" value=\"`date_start` <= 'SEARCH' AND `date_end` >= 'SEARCH'\" readonly><br/>".
			     __('Please enter the Tag SEARCH whereever the Search String of the Visitor should be entered.','wct');
		}
	break;

	default:
		echo "<div style=\"float:left;width:350px;\"><h2>";
		if ($tablename->name == '') { echo __('Create Table', 'wct'); } else { echo __('Edit Table', 'wct'); }
		echo "</h2>".
		     "<script type=\"text/javascript\">

		var nFloor = \"\";

		function removeField2(nField) {
			var answer = confirm('". __ ('Attention, with that action, all data in this field will be erased in the database.\nDo you want to proceed?', 'wct')."');
			if (answer) {
				var d = document.getElementById(nField);
				d.parentNode.removeChild(d);
			}
		}

		function validate(form) {
			for(var i = 0; i < form.elements.length; i++) {
				if(form.elements[i].type == \"text\" && form.elements[i].value == \"\") {
					if (form.elements[i].name != \"wceditlink\" && form.elements[i].name != \"wcmen\") {
						alert(\"". __ ('Please fillout all fields or delete them if not needed!', 'wct')."\");
						return false;
					}
				}
			}
			return true;
		}

		function removeField(nField) {
			nField.parentNode.parentNode.removeChild(nField.parentNode);
		}

		function EnumField(field){
			if (field.parentNode.parentNode.childNodes[2] != null) {
				var feldda = field.parentNode.parentNode.childNodes[2].name;
				if (feldda == \"enum\") {
					field.parentNode.parentNode.removeChild(field.parentNode.parentNode.childNodes[2]);
				}
			}

			var chosenoption=field.options[field.selectedIndex].value;
			if (chosenoption == \"enum\") {
				var newFieldLabel = document.createElement('label');
				newFieldLabel.name = \"enum\";
				newFieldLabel.innerHTML = \"<br/>Enum:&nbsp;\";

				var newField = document.createElement('input');
				newField.type = \"text\";
				newField.name = \"enum[]\";
				newField.value = \"'0','1'\";
				newField.style.width = \"206px\";
				newFieldLabel.appendChild(newField);
				field.parentNode.parentNode.appendChild(newFieldLabel);
			}
			else if ( chosenoption == \"set\") {
				var newFieldLabel = document.createElement('label');
				newFieldLabel.name = \"enum\";
				newFieldLabel.innerHTML = \"<br/>Set:&nbsp;\";

				var newField = document.createElement('input');
				newField.type = \"text\";
				newField.name = \"enum[]\";
				newField.value = \"'0','1'\";
				newField.style.width = \"220px\";
				newFieldLabel.appendChild(newField);
				field.parentNode.parentNode.appendChild(newFieldLabel);
			}
		}
		function insertField(){

			var newFieldContainer = document.createElement('div');
			var newFieldLabel = document.createElement('label');
			newFieldLabel.innerHTML = \"\";

			var newField = document.createElement('input');
			newField.type = \"text\";
			newField.name = \"vipInfo[]\";
			newFieldContainer.appendChild(newFieldLabel);
			newFieldLabel.appendChild(newField);

			var objSelect = document.createElement('select');
			objSelect.name = \"vipInfoB[]\";
			objSelect.onchange = function(){EnumField(this);};
			objSelect.style.width = \"103px\";

			var objOption = document.createElement(\"option\");
			objOption.text=\"varchar(32)\";
			objOption.value=\"varchar32\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"varchar(64)\";
			objOption.value=\"varchar64\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"varchar(128)\";
			objOption.value=\"varchar128\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"smallint(6)\";
			objOption.value=\"smallint6\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"date\";
			objOption.value=\"int10\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"int(11)\";
			objOption.value=\"int11\";
			objSelect.options.add(objOption);
					
			var objOption = document.createElement(\"option\");
			objOption.text=\"text\";
			objOption.value=\"text\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"float(8,2)\";
			objOption.value=\"float82\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"enum\";
			objOption.value=\"enum\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"set\";
			objOption.value=\"set\";
			objSelect.options.add(objOption);

			var objOption = document.createElement(\"option\");
			objOption.text=\"picture\";
			objOption.value=\"varchar254\";
			objSelect.options.add(objOption);
			
			".($this->prem_chk() == true ? "var objOption = document.createElement(\"option\");
			objOption.text=\"relationship\";
			objOption.value=\"int12\";
			objSelect.options.add(objOption);" : "")."

			newFieldLabel.appendChild(objSelect);

			var deleteBtn = document.createElement('input');
			deleteBtn.type = \"button\";
			deleteBtn.value = \"". __ ('Del', 'wct')."\";
			deleteBtn.style.marginLeft = \"5px\";
			deleteBtn.onclick = function(){removeField(this)};
			newFieldContainer.appendChild(deleteBtn);
			document.forms[0].insertBefore(newFieldContainer,nFloor);
		}

		function init() {
			var insertBtn = document.getElementById('newFieldBtn');
			insertBtn.onclick = function() { insertField(); }
			nFloor = insertBtn;
		}

		navigator.appName == \"Microsoft Internet Explorer\" ? attachEvent('onload', init, false) : addEventListener('load', init, false);
		</script>".
		     "<form action=\"admin.php?page=".$_GET['page']."\" method=\"post\" onSubmit=\"return validate(this)\" name=\"wctform\">";
		if ($tablename->name != '')	{ echo "<input type=\"hidden\" name=\"viptID\" value=\"".$tableid."\">"; }
		echo "<div class=\"field\"><label><strong>". __('Table Name', 'wct') .":</strong>&nbsp;<input size=\"32\" type=\"text\" name=\"vipName\" value=\"".$tablename->name."\"></label></div>".
		     "<br/><strong>".__('Fields', 'wct').":</strong><br/>".
		     "<input type=\"text\" name=\"id\" value=\"id\" readonly><input type=\"text\" name=\"idtype\" value=\"int(11) UNIQUE\" readonly><br/>".
		     "<input type=\"text\" name=\"status\" value=\"status\" readonly><input type=\"text\" name=\"idtype\" value=\"enum('active','draft','passive')\" readonly><br/>".$feldoutput.
		     "<input type=\"button\" id=\"newFieldBtn\" value=\"". __('Add new Field', 'wct') ."\">&nbsp;".
		     "<br/><br/><input type=\"checkbox\" name=\"wctheaderline\" value=\"1\" id=\"wctheaderline\"";
		if ($tablename->headerline == '1') { echo " checked"; }
		echo "> ". __('Show Headerline','wct')."<br/><input type=\"checkbox\" name=\"wctoverlay\" value=\"1\" id=\"wctoverlay\"";
		if ($tablename->overlay == '1') { echo " checked"; }
		echo "> ". __('Overlay Function','wct')."<br/>";
		if ($this->prem_chk() == true) {
			echo __('Enable Table download as','wct').": <input type=\"checkbox\" name=\"wctdle\" value=\"1\"";
			if ($tablename->dl == '1' OR $tablename->dl == '3') { echo " checked"; }
			echo ">Excel <input type=\"checkbox\" name=\"wctdlc\" value=\"1\"";
			if ($tablename->dl == '2' OR $tablename->dl == '3') { echo " checked"; }
			echo ">CSV<br/><input type=\"checkbox\" name=\"wctglobaledit\" value=\"1\" id=\"wctglobaledit\"";
			if ($tablename->globaledit == '1') { echo " checked"; }
			echo "> ". __('Enable global edit on Edit Content Tab','wct')."<br/>
			". __('Link to Formpage','wct').": <input size=\"25\" type=\"text\" name=\"wceditlink\" value=\"".$tablename->editlink."\" id=\"wceditlink\"><br/>".
			__('Show as new Menu point','wct').": <input size=\"16\" type=\"text\" name=\"wcmen\" value=\"".$tablename->menu."\" id=\"wcmen\"><br/>";

		}
		echo "<select name=\"wctsheme\"><option value=\"0\"";
		if ($tablename->sheme != '1') { echo " selected"; }
		echo ">". __('Black','wct') ."</option><option value=\"1\"";
		if ($tablename->sheme == '1') { echo " selected"; }
		echo ">". __('White','wct') ."</option></select>". __('color for activated sort buttons', 'wct')."<br/><input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\">
		
		
		
		
		
		
		</form>";


		echo "</div><div><h2>" . __('Instructions', 'wct') . "</h2>".
		     __('Please use only Alphanumberic Characters for all Fieldnames.', 'wct')."<br/>".
		     __('The field `id` cannot be deleted and is needed in the database.', 'wct')."<br/><br/>".
		     __('Fields can have following definitions:', 'wct')."<table>".
		     "<tr><td>varchar(34)</td><td>";
		printf( __('This Field can save Text with a length of %s Characters', 'wct'), '32');
		echo "</td></tr><tr><td>varchar(64)&nbsp;</td><td>";
		printf( __('This Field can save Text with a length of %s Characters', 'wct'), '64');
		echo "</td></tr><tr><td>text</td><td>";
		printf( __('This Field can save Text with a length of %s Characters', 'wct'), 'unlimited');
		echo "</td></tr><tr><td>smallint(6)</td><td>";
		printf( __('This Field can save Numbers from %s to %s', 'wct'), '0','65535');
		echo "</td></tr><tr><td>int(11)</td><td>";
		printf( __('This Field can save Numbers from %s to %s', 'wct'), '0','4294967295');
		echo "</td></tr><tr><td>float(8,2)</td><td>";
		printf( __('This Field can save Numbers from %s to %s', 'wct'), '-65535.00','65535.00');
		echo "</td></tr><tr><td>enum()</td><td>".__('This Field can save text or numbers for selections, mainly used for Categories and Search Indexes', 'wct');
		echo "</td></tr><tr><td>set()</td><td>".__('This Field can save text or numbers for multi selections, mainly used for Categories and Search Indexes', 'wct');
		echo "</td></tr></table><br/>".
		     __('You cannot change the definition of a field, if the field has already been saved. Please delete the field and create a new one with the correct definition.<br/><br/>You can activate the Overlay Function, which will enable a preview of the page, when the user get with the mousecurser over an Entry.','wct');
				if ($tableid != '1') { $g = " id=\"".$tableid."\""; $l ='16'; } else { $l = '8'; }

				if ($_GET['page'] != 'wct_table_create') {
					echo "<br/><br/>";
					printf( __('This Table can be added with %s or %s to the page.', 'wct')."</br>", '<input type=\'text\' value=\'[wctable'.$g.']\' size=\''.$l.'\' readonly/>', "<input type=\"text\" value=\"[wctable id=&quot;".$tableid."&quot; limit=&quot;50&quot; filter=&quot;`Category`='Restaurant'&quot; css=&quot;My&quot; nofilter=&quot;1&quot;]\" size=\"84\" readonly/>");
					printf( __('The Tag %s sets a CSS Filter to define more than one Stylesheet Definition. More Details in Edit CSS Section. The Tag %s sets that no Selection or Search Filter apply to that table. Very usefull if you place more than one table on the page or article.','wct')."<br/><br/>","<input type=\"text\" value=\"css=&quot;SALT&quot;\" size=\"10\" readonly/>","<input type=\"text\" value=\"nofilter=&quot;1&quot;\" size=\"9\" readonly/>");
					printf( __('This Searchform for this table with %s or %s to the page.', 'wct'), '<input type=\'text\' value=\'[wctsearch felder="*" text="sss"]\' size=\'34\' readonly/>', '<input type=\'text\' value=\'[wctsearch]\' size=\'11\' readonly/>');
				}

		echo "</div><div style=\"clear:left;\"></div></div>";
	break;
}

?>
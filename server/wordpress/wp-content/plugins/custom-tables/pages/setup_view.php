<?php

$wcttab2 = $_GET['wcttab2'];

if ($_POST['saveit'] == $tableid AND $_POST['saveit'] != '') {
	if ($_GET['wcttab2'] == 'eview') { $sql = "e_setup"; }
	elseif ($_GET['wcttab2'] == 'oview') {
		$sql = "o_setup";
		$wct_overlay = $_POST['wct_overlay'] ? '1' : '0';
		$zusatz = ", `overlay`='".$wct_overlay."'";
	}
	elseif ($_GET['wcttab2'] == 'tview') {
		$sql = "t_setup";
		if ($_POST['wctdle'] == '1' AND $_POST['wctdlc'] == '1') { $dl = '3'; }
		elseif ($_POST['wctdle'] == '1') { $dl = '1'; }
		elseif ($_POST['wctdlc'] == '1') { $dl = '2'; }
		else { $dl = '0'; }
		
		if ($_POST['wctrc'] != '') { $rc = $_POST['wctrc']; }
		else { $rc = '1'; }

		$zusatz = ", `rowcount`='".mres($rc)."' ,`vortext`='".mres($_POST['wctvortext'])."', `nachtext`='".mres($_POST['wctnachtext'])."', `sort`='".mres($_POST['wctas'])."', `sortB`='".mres($_POST['wctar'])."', `dl`='".$dl."'";
	}
	elseif ($_GET['wcttab2'] == 'theader') {
		foreach($_POST['wctheader'] as $var) { $header .= $var.","; }
		foreach($_POST['wctsort'] as $var) { $sort .= $var.","; }
		$wct_headerline = $_POST['wct_headerline'] ? '1' : '0';

		$zusatz = "`headerline`='".$wct_headerline."', `header`='".mres(substr($header,0,strlen($header)-1))."', `headersort`='".mres(substr($sort,0,strlen($sort)-1))."'";
		if (isset($_SESSION[$tableid.'wct_sdo']) AND $_SESSION[$tableid.'wct_sdo'] != '' AND $_SESSION[$tableid.'wct_sdo'] != '0' AND $this->prem_chk() == true) {
			$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_setup` SET ".$zusatz." WHERE `table_id`='".$tableid."' AND `id`='".mres($_SESSION[$tableid.'wct_sdo'])."' LIMIT 1;");
		}
		else {
			$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET ".$zusatz." WHERE `id`='".$tableid."' LIMIT 1;");
		}

	}

	if ($sql != '') {
		if (isset($_SESSION[$tableid.'wct_sdo']) AND $_SESSION[$tableid.'wct_sdo'] != '' AND $_SESSION[$tableid.'wct_sdo'] != '0' AND $this->prem_chk() == true) {
			$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_setup` SET `".$sql."`='".mres(trim($_POST['content'],"\r\n"))."'".$zusatz." WHERE `table_id`='".$tableid."' AND `id`='".mres($_SESSION[$tableid.'wct_sdo'])."' LIMIT 1;");
		}
		else {
			$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `".$sql."`='".mres(trim($_POST['content'],"\r\n"))."'".$zusatz." WHERE `id`='".$tableid."' LIMIT 1;");
		}
	}
}

echo "<div><h2>".__('View Setup','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
$table = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$tableid."' LIMIT 1;");

echo $this->tab_link($wcttab,'Table Setup','setup','tview');
echo $this->tab_link($wcttab,'Headerline Setup','setup','theader');
if ($tableid != '0') { echo $this->tab_link($wcttab,'Entry Setup','setup','eview'); }
echo $this->tab_link($wcttab,'Overlay Setup','setup','oview');

echo "</tr></table>";

if ($_GET['wcttab2'] != '' AND $this->prem_chk() == true) {
	if (isset($_GET['ssdo'])) { $_SESSION[$tableid.'wct_sdo'] = $_GET['ssdo']; }
	$sdo = $_SESSION[$tableid.'wct_sdo'];
	$url = $this->generate_pagelink("/[&?]+ssdo=[0-9]*&/","");
	echo "<script type=\"text/javascript\">
		function selector() {
			var selection = document.getElementById('wctsdo').options[document.getElementById('wctsdo').selectedIndex].value;
			location.href= '".$url."ssdo=' + selection;
		}
		</script><br/><form action=\"admin.php?page=".$_GET['page']."&wcttab=sdo\" method=\"POST\">
		<b>".__('Select Outputdesign for Setup','wct').":</b> <select name=\"wctsdo\" id=\"wctsdo\" name=\"outputstyle\" onChange=\"selector()\"><option value=\"\" ";
	if ($sdo == "") { echo "selected"; }
	echo ">".__('Default','wct')."</option>";
	$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$tableid."';");
	if (count($qry) >= '1') {
		foreach ($qry as $row) {
			echo "<option value=\"".$row->id."\" ";
			if ($sdo == $row->id) { echo " selected"; }
			echo ">".$row->name."</option>";
		}
	}
	echo "</select>&nbsp;<input class=\"button-primary\" type=\"submit\" name=\"t\" value=\"".__('Manage','wct')." ".__('Outputdesigns','wct')."\"></form>";
	if ($sdo != "") {
		$table = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct_setup` WHERE `id`='".mres($sdo)."' AND `table_id`='".$tableid."' LIMIT 1;");
	}
}
elseif ($_GET['wcttab2'] != '') {
	echo "<script type=\"text/javascript\">
		function selector() {
			alert('".__('Premium functionality has not been activated in the plugin. Please check for a valid licence!','wct')."');
			return false;
		}
		</script><br/><b>".__('Select Outputdesign for Setup','wct').":</b> <select name=\"wctsdo\" id=\"wctsdo\" name=\"outputstyle\"><option value=\"\" selected>".__('Default','wct')."</option></select>
	&nbsp;<input class=\"button-primary\" type=\"submit\" onclick=\"return selector()\" name=\"t\" value=\"".__('Manage','wct')." ".__('Outputdesigns','wct')."\">";

}

echo "<table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>
<td width=\"800\" valign=\"top\"><form action=\"admin.php?page=".$_GET['page']."&wcttab=".$_GET['wcttab']."&wcttab2=".$_GET['wcttab2']."\" method=\"POST\">
<input type=\"hidden\" name=\"saveit\" value=\"".$tableid."\" />";

switch($_GET['wcttab2']) {
	case 'eview':
		echo "<h3>".__('Entry Setup', 'wct')."</h3><table><tr><td style=\"width:703px\">";
		the_editor(stripslashes($table->e_setup), $id = 'content', $prev_id = 'title', $media_buttons = false);
		echo "</td></tr></table>";
		$help = "<a href=\"".plugins_url('custom-tables/img/tutorial/Ansicht3.jpg')."\"><img src=\"".plugins_url('custom-tables/img/tutorial/Ansicht3_small.jpg')."\"  alt=\"Tutorial Picture\"></a><br/><br/>".
			 __('All users which will be redirected from Table Setup over the [LINK] will come to this view. You can create here your Page which will be autogenerated.<br/><br/>The <b>blue Fields</b> stays for the availalble fields in the database which you can use. You dont need to use all fields, but its recommented. Fields which are not used in this view, have proberly no usage!', 'wct')."<br/><br/><a href=\"admin.php?page=".$_GET['page']."&wcttab=setup&wcttab2=hints\">".__('More Hints', 'wct')."</a>";
		echo "<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\">";
	break;

	case 'tview':
		echo "<h3>".__('Table Setup', 'wct')."</h3><table><tr><td style=\"width:703px\">";
		echo "<textarea name=\"wctvortext\" style=\"width:720px;\">".stripslashes($table->vortext)."</textarea>";
		if ($table->t_setup == '') { $table->t_setup = "<td></td>"; }
		the_editor(stripslashes($table->t_setup), $id = 'content', $prev_id = 'title', $media_buttons = false);
		echo "<textarea name=\"wctnachtext\" style=\"width:720px;\">".stripslashes($table->nachtext)."</textarea><br/>";
		echo "</td></tr></table>";
		$help = "<a href=\"".plugins_url('custom-tables/img/tutorial/Ansicht1.jpg')."\"><img src=\"".plugins_url('custom-tables/img/tutorial/Ansicht1_small.jpg')."\"  alt=\"Tutorial Picture\"></a><br/><br/>".
		__('The <b>Red TABLE</b> field need to be used for the Table definition for each line which will show the list to filter and search on the mainpage.<br/><br/>The <b>Red LINK</b> field will redirect the user on the Entry Page with can be setupd on the own configuration.<br/>If you dont link it manually, the link will be placed under the complete table line automatically.<br/><br/>The <b>blue Fields</b> stays for the availalble fields in the database. You dont need to use all fields.<br/><br/>The <b>Custom Headline</b> can be left blank if you wish, otherwise please define Name for all Cols with Comma separated.<br/><br/>The <b>Search Form</b> will search on default ot all fields, which can generate a high load on the Database. You can restrict the search to specific fields (Comma separated). Wrong written fields or not existing one will be iognored.<br/><b>*</b> Will search for all fields, possible high load on the database<br/><b>sss</b> This option will use the Search Tag from the choosed language.', 'wct')."<br/><br/><a href=\"admin.php?page=".$_GET['page']."&wcttab=setup&wcttab2=hints\">".__('More Hints', 'wct')."</a>";

		if ($tableid != '0') {
			$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
			$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
			$felder = explode("PRIMARY KEY",$array['Create Table']);
			$felder = array_slice(explode("`",$felder[0]),5);
			for ($x=0;$felder[$x] !='';$x++) {
				if ($felder[$x] != 'status') { $f[] = $felder[$x]; }
				$x++;
			}

			if ($this->prem_chk() == true) {
				echo "<br/>".__('Enable Table download as','wct').": <input type=\"checkbox\" name=\"wctdle\" value=\"1\"";
				if ($table->dl == '1' OR $table->dl == '3') { echo " checked"; }
				echo ">Excel <input type=\"checkbox\" name=\"wctdlc\" value=\"1\"";
				if ($table->dl == '2' OR $table->dl == '3') { echo " checked"; }
				echo ">CSV";
				
				echo "<br/>".__('Show Tabledefinition mutliple times in a row','wct').": <select name=\"wctrc\">";
				$werte = array('1'=>__('No','wct'),'2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','8'=>'8');
				foreach($werte as $var => $wert) {
					echo "<option value=\"".$var."\"".($var == $table->rowcount ? " selected" : "").">".($var != '1'? $wert." ".__('times','wct') : $wert)."</option>";
				}
				echo "</select>";

			}
			echo "<br/>".__('Table main sort', 'wct').": <select name=\"wctas\">
			<option value=\"id\"".($table->sort == 'id' ? " selected" : "").">id</option>
			<option value=\"rand()\"".($table->sort == 'rand()' ? " selected" : "").">random()</option>";
			foreach ($f as $var) {
				echo "<option value=\"".$var."\"";
				if ($table->sort == $var) { echo " selected"; }
				echo ">".$var."</option>";
			}
			echo "</select> <select name=\"wctar\"><option value=\"ASC\"";
			if ($table->sortB != "DESC") { echo " selected"; }
			echo ">".__('ascending','wct')."</option><option value=\"DESC\"";
			if ($table->sortB == "DESC") { echo " selected"; }
			echo ">".__('descending','wct')."</option></select> ";
		}
		echo "<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"><br/><br/>";

		if ($tableid != '1') { $g = " id=\"".$tableid."\""; $l ='16'; } else { $l = '8'; }
		if ($sdo != '0' AND $sdo != '') { $n = " design=&quot;".$sdo."&quot;"; $l = $l + 11; }
		printf( __('This Table can be added with %s or %s to the page.', 'wct')."</br>", "<input type=\"text\" value=\"[wctable id=&quot;".$tableid."&quot; limit=&quot;50&quot; filter=&quot;`Category`='Restaurant'&quot;".$n."]\" size=\"".($l+58)."\" readonly/>", '<input type=\'text\' value=\'[wctable'.$g.$n.']\' size=\''.$l.'\' readonly/>');
		printf( __('This Searchform for this table with %s or %s to the page.', 'wct')."<br/>", '<input type=\'text\' value=\'[wctsearch felder="*" text="sss"]\' size=\'34\' readonly/>', '<input type=\'text\' value=\'[wctsearch]\' size=\'11\' readonly/>');
		printf( __('Dropdown Menus for filtering on Categories can be add with %s or %s to the page.', 'wct')."<br/>", '<input type=\'text\' value=\'[wctselect id="'.$tableid.'" field="???" limit="20" maintext="title"]\' size=\'56\' readonly/>', '<input type=\'text\' value=\'[wctselect field="???"]\' size=\'22\' readonly/>');
		printf( __('The Clear all Filters button can be added with %s to the page.', 'wct'), '<input type=\'text\' value=\'[wctclear]\' size=\'10\' readonly/>');


	break;

	case 'theader':
		echo "<h3>".__('Headerline Setup', 'wct')."</h3><input type=\"checkbox\" name=\"wct_headerline\" value=\"1\"";
		if ($table->headerline == '1') { echo " checked"; }
		echo "> ". __('Show Headerline','wct')."<br/><br/><table><tr><td><b>".__('Your Content','wct')."</b></td><td><b>".__('Field Name','wct')."</b></td><td>&nbsp;</td><td><b>".__('Sort field','wct')."</b></td></tr>";

		$inhalt = str_replace("[wctedit]<td>editlink</td>[/wctedit]","",stripslashes($table->t_setup));
		if (preg_match('/.*-->(.*?)<!--:--.*/',$inhalt)) {
			preg_match('/.*-->(.*?)<!--:--.*/',$inhalt, $treffer);
			$inhalt = $treffer[1];
		}

		if ($tableid != '0') {
			$tablet = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
			$array=array(); foreach($tablet as $member=>$data) { $array[$member]=$data; }
			$felder = explode("PRIMARY KEY",$array['Create Table']);
			$felder = array_slice(explode("`",$felder[0]),5);
			for ($x=0;$felder[$x] !='';$x++) {
				if ($felder[$x] != 'status') { $f[] = $felder[$x]; }
				$x++;
			}
		}
		else {
			$f = array('author','date','title','kategory','comment_count');
		}

		$headerfields = explode(",",$table->header);
		$headerfieldss = explode(",",$table->headersort);

		$y = '0';
		$felderm = array_slice(explode("<td",$inhalt),1);
		foreach ($felderm as $feld) {
			$feld = explode(">",$feld,2);
			$feld = $feld[1];
			echo "<tr><td>".str_replace("</td>","",$feld)."</td><td><input name=\"wctheader[]\" type=\"text\" value=\"".htmlspecialchars(stripslashes($headerfields[$y]),ENT_QUOTES,'UTF-8')."\" size=\"72\"></td>";
			echo "<td>&nbsp;</td><td><select name=\"wctsort[]\"><option value=\"\">-- ".__('none','wct')." --</option>";
			foreach ($f as $var) {
				echo "<option value=\"".$var."\"";
				if ($headerfieldss[$y] == $var) { echo " selected"; }
				echo ">".$var."</option>";
			}
			echo "</select></td></tr>";
			$y++;
		}

		echo "</table>";

		if ($table->headerline != '1') {
			echo "<font color=\"#FF0000\"><strong>".__('Headerline','wct')." ".__('not activated for this table, this setup will have no effect! Please use \'Table Setup\' to activate it.', 'wct')."</strong></font><br/>";
		}

		echo "<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"><br/><br/>";
		printf( __('Dropdown Menus for filtering on Categories can be add with %s or %s to the page.', 'wct'), '<input type=\'text\' value=\'[wctselect id="'.$tableid.'" field="???" limit="20" maintext="title"]\' size=\'56\' readonly/>', '<input type=\'text\' value=\'[wctselect field="???"]\' size=\'22\' readonly/>');

		$help = "<a href=\"".plugins_url('custom-tables/img/tutorial/Ansicht2.jpg')."\"><img src=\"".plugins_url('custom-tables/img/tutorial/Ansicht2_small.jpg')."\"  alt=\"Tutorial Picture\"></a><br/><br/>".
		        "* ".__('<b>Attention:</b> This Option should only be activated on Categories (Bar, Restaurant) or Selectionsfields (City, Country) and not FreeText fields with many diffrent Entries, or Performance and Usability are very bad! Don\'t select if you don\'t know what you are doing.','wct');
	break;

	case 'oview':
		echo "<h3>".__('Overlay Setup', 'wct')."</h3><input type=\"checkbox\" name=\"wct_overlay\" value=\"1\"";
		if ($table->overlay == '1') { echo " checked"; }
		echo "> ". __('Overlay Function','wct')."<br/><br/><table><tr><td style=\"width:703px\">";
		the_editor(stripslashes($table->o_setup), $id = 'content', $prev_id = 'title', $media_buttons = false);
		echo "</td></tr></table>";
		$help = "<a href=\"".plugins_url('custom-tables/img/tutorial/Ansicht4.jpg')."\"><img src=\"".plugins_url('custom-tables/img/tutorial/Ansicht4_small.jpg')."\"  alt=\"Tutorial Picture\"></a><br/><br/>".
			 __('This View will be shown, if a user get with the mousecurser over an entry of the Table. With a click, the user gets redirected to the Entry Page.', 'wct')."<br/><br/><a href=\"admin.php?page=".$_GET['page']."&wcttab=setup&wcttab2=hints\">".__('More Hints', 'wct')."</a>";

		if ($table->overlay != '1') {
			echo "<font color=\"#FF0000\"><strong>".__('Overlay','wct')." ".__('not activated for this table, this setup will have no effect! Please use \'Table Setup\' to activate it.', 'wct')."</strong></font><br/>";
		}
		echo "<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\">";
	break;

	case 'hints':
		echo "<h3>".__('Setup Hints', 'wct')."</h3>";
		echo __('You can customize the all Views with HTML to everything you want. There are no limitations, except your own HTML knowledge. Down here are 2 simple Examples.<br/><br/><b>To add a picture</b><LU><li>Create e.g. a field with the name \'img\' as varchar(64)</li><li>Create e.g. a field with the name \'imgtitle\' as varchar(32)</li><li>Upload the images for all entrys to the Mediathek</li><li>Copy of each image from the Mediathek the Link e.g. http://yourdomain.com/wp-uploads/image-lkd.jpg</li><li>Past this URL to the corresponging \'img\' field</li><li>Define \'imgtitle\' field of all entries</li><li>Use code at the setup page:', 'wct');
		echo '<input type=\'text\' value=\'&lt;img src="[img]" border="0" alt="[imgtitle]" /&gt;\' size=\'50\'></li></LU><br/>';
		echo __('<b>To add a custom link</b><LU><li>Create a DB field e.g. \'link\' as varchar(64)<br/><font color="red">'.__('Please notice, if you call a field \'link\' it will replace the internal page creation functionality and if you click on the table line, it will redirect the user on the new link.!', 'wct').'</font></li><li>Create a DB field e.g. \'linkdescription\' as varchar(32)</li><li>Use code at the setup page:', 'wct');
		echo '<input type=\'text\' value=\'&lt;a href="[links]"&gt;[linkdescription]&lt;/a&gt;\' size=\'40\'></li></LU><br/><b>'.__('Sample what is possible' ,'wct').'</b><br/>';
	 	echo "<a href=\"".plugins_url('custom-tables/img/tutorial/DemoHausDB.jpg')."\"><img src=\"".plugins_url('custom-tables/img/tutorial/DemoHausDB_small.jpg')."\"  alt=\"Demo DB View\"></a>";
	break;

	default:
		echo "<table><tr><td><img src=\"".plugins_url('custom-tables/img/tutorial/pfeil.png')."\" alt=\"\"></td><td>&nbsp;<br/>".__('You can define here which fields are shown and how. Also the Overlay can be defined and the Entry pages.','wct').".<br/>".
		     __('Please check the submenu for more information and detailed instructions.', 'wct')."<br/>".
		     __('For more details as example how to add HTML code, please have a look on','wct').": <a href=\"admin.php?page=".$_GET['page']."&wcttab=setup&wcttab2=hints\">".__('More Hints', 'wct')."</a></td><tr></table>".
		     "<br/><h3>".__('Instructions','wct')."</h3><img src=\"".plugins_url('custom-tables/img/tutorial/Overview.jpg')."\" alt=\"\">";
	break;
}

echo "</form></td><td valign=\"top\">";
if ($help != '') { echo "<h3>" . __('Instructions', 'wct') . "</h3>".$help; }
echo "</td></table></div>";

add_filter('admin_footer', array( &$this, 'wct_quicktag_button'));

?>
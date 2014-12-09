<?php

if ($_POST['wct_new'] != '') {
	$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_form` SET `name`='".mres($_POST['wct_new'])."';");
	$_GET['page'] = "wct_form_".$wpdb->insert_id;
}
if ($_POST['vipIDs'] != '') {
	$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_form` WHERE `id`='".mres($_POST['vipIDs'])."' LIMIT 1;");
}

$wctmp = "admin.php?page=wct_form_";

if ($_GET['page'] != 'wct_editforms') {
	$formid = str_replace("wct_form_","",$_GET['page']);
	if ($_POST['submit'] != '') { include($this->wctpath."pages/save_forms.php"); }

	echo "<div style=\"padding-top:15px;\"><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
				
	echo $this->tab_link($wcttab,'Rights Setup','');
	echo $this->tab_link($wcttab,'Table Setup','tsetup');
	echo $this->tab_link($wcttab,'Entry Setup','eviw');

	echo "</tr></table></div><div style=\"float:left;width:450px;\"><form action=\"".$wctmp.$formid."&wcttab=".$wcttab."\" method=\"POST\">";

	switch ($wcttab) {
		default:
			$myrow = $wpdb->get_row("SELECT `name`,`r_table`,`r_fields`,`rights`,`r_filter`,`htmlview`,`smail` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".mres($formid)."' LIMIT 1;");
			echo "<h3>" . __('Rights Setup','wct'). "</h3><input type=\"hidden\" name=\"rs\" value=\"1\"><table><tr><td valign=\"top\" width=\"290\"><b>".__('Form Name','wct').":</b> <input type=\"text\" size=\"19\" name=\"wct_name\" value=\"".$myrow->name."\"><br/>".
			     "<b>".__('Select Table', 'wct')."</b> <select onChange=\"showfields(this)\" name=\"wct_stable\">";
			if ($myrow->r_table == "") { echo "<option value=\"0\"></option>"; }

			$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
			foreach ($qry as $row) {
				echo "<option value=\"".$row->id."\"";
				if ($myrow->r_table == $row->id) { echo " selected"; }
				echo ">".$row->name."</option>";

				unset($javaout);
				$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
				$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
				$tmp = explode("PRIMARY KEY",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$array['Create Table']));
				$felder = explode(",",$tmp[0]);
				for ($i=3;$felder[$i] != '';$i++) {
					$javaout .= preg_replace("/`(.*)`\s.*?\s.*/","<input type=\"checkbox\" name=\"feld".$row->id."_$1\" value=\"1\"> $1<br/>",$felder[$i-1]);
				}
				
				$jout .= "if (Table.value == '".$row->id."') { document.getElementById(\"wct_".$row->id."\").style.visibility = \"visible\"; document.getElementById(\"wct_".$row->id."\").style.display = \"block\"; } ".
					  "else { document.getElementById(\"wct_".$row->id."\").style.visibility = \"hidden\"; document.getElementById(\"wct_".$row->id."\").style.display = \"none\"; }";
				
				if ($myrow->r_fields != '') {
					$felder = explode(",",$myrow->r_fields);
					foreach ($felder as $f => $feld) {
						$javaout = str_replace("name=\"feld".$row->id."_".$feld."\"","name=\"feld".$row->id."_".$feld."\" checked ",$javaout);
					}
				}

				if ($myrow->r_table == $row->id) {
					$jall .= "<div id=\"wct_".$row->id."\" style=\"display:block;visibility:visible;\"><b>".__('Fields','wct').":</b><br/>".$javaout."</div>\n";
				}
				else {
					$jall .= "<div id=\"wct_".$row->id."\" style=\"display:none;visibility:hidden;\"><b>".__('Fields','wct').":</b><br/>".$javaout."</div>\n";
				}		

			}
			echo "</select><br/><br/><b>".__('Rights','wct').":</b><br/><input type=\"checkbox\" id=\"read\" name=\"read\" value=\"1\""; if ($myrow->rights[0] == '1') { echo " checked"; } echo "> ".__('Read (Can see the content of the table)','wct')."<br/>";
			echo "<input onclick=\"document.getElementById('read').checked = 'true';\" type=\"checkbox\" name=\"write\" value=\"1\""; if ($myrow->rights[1] == '1') { echo " checked"; } echo "> ".__('Write (Can change content of the table)','wct')."<br/>";
			echo "<input type=\"checkbox\" name=\"create\" value=\"1\""; if ($myrow->rights[2] == '1') { echo " checked"; } echo "> ".__('Create (Can add new content of the table)','wct')."<br/>";
			echo "<input onclick=\"document.getElementById('read').checked = 'true';\" type=\"checkbox\" name=\"delete\" value=\"1\""; if ($myrow->rights[3] == '1') { echo " checked"; } echo "> ".__('Delete (Can delete content of the table)','wct')."<br/><br/>";

			echo "</td><td width=\"10\"></td><td valign=\"top\" width=\"300\">".$jall."</td></tr>
				</table><table>";
			echo "<tr><td><b>".__('HTML Editor','wct').":</b></td><td><input type=\"checkbox\" name=\"htmlview\" value=\"1\"";
			if ($myrow->htmlview == '1') { echo " checked"; }
			echo "/> ".__('Enabled for Textfields','wct')."</td></tr><tr><td><b>".__('Approval Needed','wct').":</b></td><td><input type=\"checkbox\" name=\"smail\" value=\"1\"";
			if ($myrow->smail == '1') { echo " checked"; }
			echo "/> ".__('You will become an email on a change to approve','wct')."</td></tr></table>";
			if ($this->settings['wct_unfilteredsql'] == "1") { echo "<b>SQL ".__('Filter', 'wct').":</b> <input type=\"text\" name=\"filter\" size=\"50\" value=\"".stripslashes($myrow->r_filter)."\">"; }
			echo "<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form><script type=\"text/javascript\">function showfields(Table) { ".$jout." } </script>";


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
			echo "<hr><h2>". __('Delete Form', 'wct')."</h2>".
			     "<form action=\"admin.php?page=wct_editforms\" method=\"post\" onSubmit=\"return chkdelete()\" name=\"wctdform\">".
			     "<input type=\"hidden\" name=\"vipIDs\" value=\"".$formid."\"><input type=\"checkbox\" name=\"wctdelete\" value=\"1\" id=\"wctdelete\"> ". __('Yes, delete this table with the complete content.','wct').
			     "<br/><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Delete Table including all content', 'wct') ."\"></div>".
			     "<div>".__('Please select the table which should be accessed from people to modify data in it and which rights should be granted. Please notice that some rights do need read rights also!<br/><br/>Please select also all Fields which should have these rights set.<br>Example with Read/Write rights:<br/>Only fields which are selected are writeable! All fields could be read if the field is set in Table or Entry Setup.','wct')."<br/><br/>";
			printf(__('You can add the Customized Form with following Code %s to your Article or Page.','wct')."</div>", '<input type=\'text\' value=\'[wctform id="'.$formid.'" limit="50"]\' size=\'25\' readonly/>');
			printf(__('If you want that a user can directly create multiple entries use following shortcode %s to add multiple forms within Entry Setup.','wct')."</div>", '<input type=\'text\' value=\'[again]\' size=\'6\' readonly/>');

		break;

		case 'tsetup':
			echo "<h3>" . __('Table Setup','wct'). "</h3><input type=\"hidden\" name=\"ts\" value=\"1\"><table><tr><td><b>".__('Field','wct')."</b></td><td><b>".__('Show','wct')."&nbsp;</b></td><td><b>".__('Rights','wct')."</b></td></tr>";
			$myrow = $wpdb->get_row("SELECT `r_fields`,`t_setup`,`r_table` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".mres($formid)."' LIMIT 1;");			

			$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$myrow->r_table."`;");
			$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
			$felder = explode("PRIMARY KEY",str_replace(array(",","8 ,2","' ,'","\r","\n"),array(" ,","8.2","'.'","",""),$array['Create Table']));

			preg_match_all("/`.*?`/",$felder[0],$treffer);
			$treffer = $treffer[0]; // Shift array one instance lower
			array_shift($treffer); // remove table name
			array_shift($treffer); // remove first field id
			array_shift($treffer); // remove first field status

			$felder2 =  explode(",",$myrow->r_fields);

			foreach ($treffer as $f => $feld) {
				$feld = str_replace("`","",$feld);
				echo "<tr><td>".$feld."</td><td><input type=\"checkbox\" value=\"1\" name=\"feld_".$feld."\"";
				if (strpos($myrow->t_setup, "{".$feld."}") !== false) { echo " checked"; }
				echo "></td><td><font color=\"";
				if (in_array($feld,$felder2)) { echo "#00BF60\">yes"; } else { echo "#FF0000\">no"; }
				echo "</font></td></tr>";
			}

			echo "</table><input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"><br/><br/>";

			echo __('Fields which have no-rights on it, can be read by the User if you want, but not changed or saved (depending on the \'Rights Setup\')','wct');
	
		break;

		case 'eviw':
			$myrow = $wpdb->get_row("SELECT `e_setup` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".mres($formid)."' LIMIT 1;");
			include($this->wctpath."pages/editor_fixes.php");
			echo "<h3>" . __('Entry Setup','wct'). "</h3><input type=\"hidden\" name=\"es\" value=\"1\">";

			the_editor(stripslashes($myrow->e_setup), $id = 'content', $prev_id = 'title', $media_buttons = false);
			echo "<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\">";
			add_filter('admin_footer', array( &$this, 'wct_quicktag_button'));
		break;
	}
	echo "</form>";
}
else {
echo "<script type=\"text/javascript\"> function validate(form) {if (form.elements[1].value == \"\"){ alert(\"". __ ('Please fillout all fields or delete them if not needed!', 'wct')."\"); return false; } else { return true; }}</script>".
	     "<form action=\"admin.php?page=wct_editforms\" method=\"POST\" onSubmit=\"return validate(this)\"><h3>" . __('Create Form','wct'). "</h3>".__('You can create Forms that Visitors or People can edit the content of your table on your own site, without having an account on your WordPress installation.', 'wct')."<br/>";
	printf( __('The Standardform can be added with %s to the page and includes all rights (read, write, delete, create) to edit all Tables.', 'wct'), '<input type="text" size="30" value=\'[wcteditpage table="*" filter=""]\' readonly>');
	echo "<br/>".__('You can use the filter as SQL Filter that not all Entries are shown. The html Tag can be used to enable (1) the HTML Editor or disable it (0).','wct')."<br/><br/>".__('Other forms with other rights and setup can be created here', 'wct').":<br/><b>".__('Form Name','wct').":</b> <input type=\"text\" size=\"8\" name=\"wct_new\" value=\"\"> <input class=\"button-primary\" type=\"submit\" value=\"" . __('Create new Form','wct'). "\"></form>";
}

?>
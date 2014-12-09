<?php

// [wctform id="1" limit="50"] als ausgabe zu Form 1

$form = $wpdb->get_row("SELECT `e_setup`,`t_setup`,`rights`,`r_table`,`r_fields`,`r_filter`,`htmlview`,`smail`,`toapprove` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".$id."' LIMIT 1;");
if ($form->rights[3] == '1' AND $_GET['wctdfid'] != '') {
	if ($form->r_filter != '') { $filter = "AND ".sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
	if ($form->toapprove == '1') {
		do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'update'));
		$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET `status`='passive' WHERE `status` != 'passive' AND `id`='".mres($_GET['wctdfid'])."' ".$filter." LIMIT 1;");
	}
	else {
		do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'delete'));
		$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' AND `id`='".mres($_GET['wctdfid'])."' ".$filter." LIMIT 1;");
	}
	if ($form->smail == '1') {
		wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was deleted','wct'),"Please check the if the Entry can be deleted (located in passive Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=passive&action=edit&wcts=0&rid='.$_GET['wctdfid']));
	}
	$_GET['wctdfid'] = '';
}
elseif ($_GET['wctefid'] == 'save') {
	if (!isset($_POST['multicreate'])) { $_POST['multicreate'] = '0'; }
	for ($a=0;$a <= $_POST['multicreate'];$a++) {
		$tmpvar = $a;
		unset($sqlstring);
		if ($tmpvar == '0') { $tmpvar = ''; }

		foreach ($_POST as $var => $wert) {
			if ($var != 'submit' AND strpos($var,"wct".$tmpvar."f_") !== false) {
				if (is_array($wert)) {
					$set = '';
					foreach ($wert as $wertb) {
						$set .= $wertb.",";
					}
					if ($set != '') { $set = substr($set,0,strlen($set)-1); }
					$wert = $set;
				}
				elseif (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",$wert)) {
					$t = explode("-",$wert);
					$wert = mktime(1,1,1,$t[1],$t[2],$t[0]);
				}
				$sqlstring .= "`".mres(str_replace("wct".$tmpvar."f_","",$var))."`='".mres(str_replace("\r\n","",$wert))."',";
			}
		}

		if ($_FILES) {
			if (!function_exists('wp_generate_attachment_metadata')) {
				require_once(ABSPATH . "wp-admin" . '/includes/admin.php');
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				require_once(ABSPATH . "wp-admin" . '/includes/file.php');
				require_once(ABSPATH . "wp-admin" . '/includes/media.php');
			}
			foreach ($_FILES as $file => $array) {
				if ($_FILES[$file]['error'] == UPLOAD_ERR_OK) {
					$attach_id = media_handle_upload( $file, get_the_ID());
					if (!is_wp_error($attach_id)) {
						$sqlstring .= "`".mres(str_replace("wct".$tmpvar."p_","",$file))."`='".mres(wp_get_attachment_url($attach_id))."',";
					}
				}
			}   
		}
		$sqlstring = substr($sqlstring,0,strlen($sqlstring)-1);
		
		$captcha = $this->captcha('check');
		if ($captcha != '0') {
			if ($_GET['wct'.$tmpvar.'fid'] == '' AND $form->rights[2] == '1') {
				if ($form->smail == '1') {
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'new'));
					$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.", `status`='".($form->toapprove != '1' ? 'active' : 'draft')."';");
					$tableid = $wpdb->insert_id;
					wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was created','wct'),"Please check the if the Entry can be published (located in draft Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=draft&action=edit&wcts=0&rid='.$tableid));
				}
				else {
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'new'));
					$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.", `status`='active';");
				}
			}
			elseif ($_GET['wct'.$tmpvar.'fid'] != '' AND $form->rights[1] == '1') {
				if ($form->smail == '1') {
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'update'));
					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.",`status`='".($form->toapprove != '1' ? 'active' : 'draft')."' WHERE `status`!='passive' AND `id`='".mres($_GET['wct'.$tmpvar.'fid'])."' LIMIT 1;");
					$createid = $wpdb->insert_id;
					if ($createid != '0') { wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was updated','wct'),"Please check the if the Entry can be published (located in draft Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=draft&action=edit&wcts=0&rid='.$createid)); }
				}
				else {
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'update'));
					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring." WHERE `status`!='passive' AND `id`='".mres($_GET['wct'.$tmpvar.'fid'])."' LIMIT 1;");
				}
			}
		}
	}
	$_GET['wctnew'] = $_GET['wct'.$tmpvar.'fid'] = $_GET['wctnew'] = $_GET['wctfid'] = '';
}

if (($_GET['wctfid'] == '' AND $_GET['wctnew'] == '1' AND $form->rights[2] == '1') OR ($_GET['wctfid'] == '' AND $form->rights[2] == '1' AND $form->rights[0] != '1')) {
	if ($_GET['wctefid'] == 'save' AND $captcha != '0') {
		if ($form->smail == '1') {
			echo __('Thanks for the new entry.','wct')." ".__('It will be checked and if everything is ok approved.','wct');
		}
		else {
			echo __('Thanks for the new entry.','wct');
		}
	}
	else {
		
		$url = $this->generate_pagelink(array("/[&?]+wctnew=[0-9]*/","/[&?]+wctefid=save/","/[&?]+wctfid=[0-9]*/"),"");
		echo "<script>function getY (el) {y = el.offsetTop;if (!el.offsetParent) { return y; } else return (y+getY(el.offsetParent)-35);}</script>";

		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$form->r_table."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);
		for ($i=2;$felder[$i] != '';$i++) {
			$x++;
			$feld[$x] =  preg_replace("/.*`(.*?)`.*/","$1",$felder[$i-1]);
			if (strpos ($felder[$i-1]," text") !== false) {
				$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'xxxoooxxx'"),$felder[$i-1]));
			}
			else {
				$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'xxxoooxxx'"),$felder[$i-1]));
			}
		}
		$out .= "<h3>".__('Create Entry','wct')."</h3><form action=\"".$url."wctfid=".$_GET['wctfid']."&wctefid=save".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\" enctype=\"multipart/form-data\">";

		if ($captcha == '0') { $out .= "<h2><font color=\"red\">".__('Please fillout captcha corretly!','wct')."</font></h2>"; }
		
		$inhalt = $form->e_setup;
		$rights = ",".$form->r_fields.",";

		preg_match_all("/\{(.*?)\}/", $inhalt, $matches);

		foreach ($matches[1] as $val => $wert) {
			if (strpos($rights,",".$wert.",") === false) {
				$addon = " style=\"background-color: grey;\" readonly";
			}
			else {
				$addon = "";
				if ($feld2[$wert] == "int(10)") {
					$addon = " id=\"f_date_".$wert."\" style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;\">
					<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('#f_date_".$wert."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});});</script"; 
				}
			}

			if ($feld2[$wert] == "smallint(6)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formint6\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"6\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "int(10)") { 
				if (strpos($rights,",".$wert.",") === false) {
					$inhalt = str_replace("{".$wert."}","<input class=\"wct-formdate\" type=\"text\" name=\"wctn_".$wert."\" value=\"".date("Y-m-d",time())."\" maxsize=\"10\"".$addon.">",$inhalt);
				}
				else {
					$inhalt = str_replace("{".$wert."}","<input class=\"wct-formdate\" type=\"text\" name=\"wctf_".$wert."\" value=\"".date("Y-m-d",time())."\" maxsize=\"10\"".$addon.">",$inhalt);
				}
			}
			elseif ($feld2[$wert] == "int(11)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formint11\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"11\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(32)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar32\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"32\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(64)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar64\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"64\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(128)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar128\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"128\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(160)" OR $feld2[$wert] == "varchar(254)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formpic\" id=\"wctp_".$wert."\" type=\"file\" size=\"50\" name=\"wctp_".$wert."\" value=\"\" />",$inhalt); }
			elseif (substr($feld2[$wert],0,4) == "enum") {
				if ($addon == "") {
					$tmp = "<select style=\"width:120px;\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\">";
					$defs = explode("xxxoooxxx",str_replace("'","",substr($feld2[$wert],6,(strlen(rtrim($feld2[$wert]))-8))));
					foreach ($defs as $posibility) {
						$tmp .= "<option value=\"".$posibility."\">".$posibility."</option>";
					}
					$tmp .= "</select>";
				}
				else {
					$tmp = "<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"32\"".$addon."/>";
				}
				$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
			}
			elseif (substr($feld2[$wert],0,3) == "set") {
				$tmp = '';
				$defs = explode("xxxoooxxx",str_replace("'","",substr($feld2[$wert],5,(strlen(rtrim($feld2[$wert]))-7))));
				$wasjetzt = ",".stripslashes($qry->$feld[$wert]).",";
				foreach ($defs as $posibility) {
					$ji++;
					$tmp .= "<div class=\"set_checkbox\"><input type=\"checkbox\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."[]\" value=\"".$posibility."\">".substr($posibility,0,17)."</div>";
				}
				$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
			}
			elseif ($feld2[$wert] == "float(8.2)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"\" maxsize=\"11\"".$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "text") {
				if ($addon != '') { $addon = " style=\"background-color: #CCC;\" readonly=\"readonly\""; } else { $mytextfelder .= "wctf_".$wert.","; }
				$inhalt = str_replace("{".$wert."}","<textarea class=\"wct-formtext\" id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" style=\"height: 155px;width: 100%;\"".$addon.">".stripslashes($row->$wert)."</textarea>",$inhalt);
			}
		}

		if ($mytextfelder != '') {
			$wct_elements = substr($mytextfelder,0,strlen($mytextfelder)-1);
			global $wuk_tinymce;
			if (class_exists('wuk_tinymce')) {
				$wuk_tinymce->tinymce_getInitJS($wct_elements,$form->htmlview);
			}
		}

		// Create Multiple New Entries
		$menge = substr_count($inhalt,"[again]");
		for ($a=1;$a <= $menge;$a++) {
			$tmp = "tempvar".$a;
			$$tmp = str_replace("\"wct","\"wct".$a,str_replace("[again]","",$inhalt));
		}
		for ($a=1;$a <= $menge;$a++) {
			$tmp = "tempvar".$a;
			$inhalt = preg_replace("/\[again\]/",$$tmp,$inhalt,1);
		}
		if ($menge >= '1') { $out .= "<input type=\"hidden\" name=\"multicreate\" value=\"".$menge."\">"; }

		$cap = $this->captcha();
		$out .= rbr($this->filter_tables($inhalt)).($cap != '1' ? $cap : '')."<br/><input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form>";
		$out = do_shortcode(stripslashes($out));
	}
}
elseif ($_GET['wctfid'] == '' AND ($form->rights[0] == '1' OR $form->rights[3] == '1') AND $def != true) // Read rights needed
{
	$url = $this->generate_pagelink(array("/[&?]+wct[d-e]*fid=.*/","/[&?]+wctefid=[0-9]*/"),"");
	if ($form->t_setup != '') {
		if ($_REQUEST['wctstart'] != '') {
			$start = (integer)$_REQUEST['wctstart'];
			$limit2 = $start.",".$limit;
		} else { $limit2 = $limit; }

		$out .= "<script type=\"text/javascript\">
			function chkconfirm() {
				var answer = confirm('". __ ('Do you really want to delete this record?', 'wct')."');
				if (answer) { return true; } else { return false; }
			}
			</script>";

		if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
		$qry = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='draft' ".$filter." LIMIT ".$limit2.";");
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				$out .= "<h3>".__('draft','wct')." ".__('Entries','wct')."</h3><table name=\"wct-table\" id=\"wct-table\" class=\"wct-table\">";
				$inhalt = preg_replace(array('/<\/td>[\r\n]*<td>/','/<\/td>[\r]*<td>/','/<\/td>[\n]*<td>/'), array('</td><td>','</td><td>','</td><td>'), $form->t_setup);
				if ($color == "1") { $color = "2"; } else { $color = "1"; }
					$out .= "<tr class=\"wct-td".$color."\" id=\"wct_omaster".$row->id."\" ".
					 "onmouseover=\"this.setAttribute('class', 'wct-td-hover')\" onmouseout=\"this.setAttribute('class', 'wct-td".$color."')\" >".
					 rbr(preg_replace("/\{(.*?)\}/e","((\$row->$1 >= '797043723' AND \$row->$1 < '3428195723') ? date('Y-m-d',\$row->$1) : \$row->$1)",$inhalt));

				if ($form->rights[1] == '1') { $out .= "<td><a href=\"".$url."wctfid=".$row->id."\" style=\"text-decoration:none;\">[EDIT]</a></td>"; }
				if ($form->rights[3] == '1') { $out .= "<td><a href=\"".$url."wctdfid=".$row->id."\" onclick=\"return chkconfirm()\" style=\"text-decoration:none;\">[DEL]</a></td>"; }
				$out .= "</tr>";
			}
			$qry = $wpdb->get_row("SELECT count(id) as `anz` FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='draft' ".$filter);
			$menge = ceil($qry->anz / $limit);
			if ($menge > '1') {
				$url = $this->generate_pagelink("/[&?]+wctstart=[0-9]*/","");
				$out .= "<tr><td colspan=\"500\" class=\"wct-errorfield\"><center><b>".__('Page', 'wct').":</b> ";
				for ($x=1;$x <= $menge;$x++) {
					$l = ($limit * ($x - 1)) + 1;
					if($_GET['wctstart'] == $l OR ($l == '1' AND $_GET['wctstart'] == '')) { $out .= $x."&nbsp;"; }
					else {	$out .= "<a href=\"".$url."wctstart=".$l."\">".$x."</a>&nbsp;"; }
				}
				$out .= "</center></td></tr>";
			}
			$out .= "</table>".__('Draft Entries need an approval from an Admin to get published.','wct')."<h3>".__('active','wct')." ".__('Entries','wct')."</h3>";
		}		
		$out .= "<table name=\"wct-table\" id=\"wct-table\" class=\"wct-table\">";
		if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
		$qry = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='active' ".$filter." LIMIT ".$limit2.";");
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				$inhalt = preg_replace(array('/<\/td>[\r\n]*<td>/','/<\/td>[\r]*<td>/','/<\/td>[\n]*<td>/'), array('</td><td>','</td><td>','</td><td>'), $form->t_setup);
				if ($color == "1") { $color = "2"; } else { $color = "1"; }
					$out .= "<tr class=\"wct-td".$color."\" id=\"wct_omaster".$row->id."\" ".
					 "onmouseover=\"this.setAttribute('class', 'wct-td-hover')\" onmouseout=\"this.setAttribute('class', 'wct-td".$color."')\" >".
					 rbr(preg_replace("/\{(.*?)\}/e","((\$row->$1 >= '797043723' AND \$row->$1 < '3428195723') ? date('Y-m-d',\$row->$1) : \$row->$1)",$inhalt));

				if ($form->rights[1] == '1') { $out .= "<td><a href=\"".$url."wctfid=".$row->id."\" style=\"text-decoration:none;\">[EDIT]</a></td>"; }
				if ($form->rights[3] == '1') { $out .= "<td><a href=\"".$url."wctdfid=".$row->id."\" onclick=\"return chkconfirm()\" style=\"text-decoration:none;\">[DEL]</a></td>"; }
				$out .= "</tr>";
			}
			$qry = $wpdb->get_row("SELECT count(id) as `anz` FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='active' ".$filter);
			$menge = ceil($qry->anz / $limit);
			if ($menge > '1') {
				$url = $this->generate_pagelink("/[&?]+wctstart=[0-9]*/","");
				$out .= "<tr><td colspan=\"500\" class=\"wct-errorfield\"><center><b>".__('Page', 'wct').":</b> ";
				for ($x=1;$x <= $menge;$x++) {
					$l = ($limit * ($x - 1)) + 1;
					if($_GET['wctstart'] == $l OR ($l == '1' AND $_GET['wctstart'] == '')) { $out .= $x."&nbsp;"; }
					else {	$out .= "<a href=\"".$url."wctstart=".$l."\">".$x."</a>&nbsp;"; }
				}
				$out .= "</center></td></tr>";
			}
		}
		else {
			$out .= "<tr><td>".__('No entries found', 'wct')."</td></tr>";
		}
		$out .= "</table>\n\n<!-- Custom Tables Plugin 05a1a29bdcae7b12229e651a9fd48b11 -->\n\n";
		if ($form->rights[2] == '1') { $out .= "<form action=\"".$url."wctnew=1".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\"><input type=\"submit\" name=\"submit\" value=\"". __('New Entry', 'wct') ."\"></form>"; }

		}
	else {
		$out = "<p>".__('Form Setup', 'wct')." ".__('not configured', 'wct')."</p>";
	}
	$out = do_shortcode(stripslashes($out));
}
elseif (($_GET['wctfid'] != '' OR $def != false) AND $form->rights[1] == '1') { // write rights needed

	if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
	if ($def != false) {
		$row = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' ".$filter." LIMIT 1;");
		if (count($row) == '1') {
			$entry = $_GET['wctfid'] = (integer)$row->id;
		}
		else {
			if ($form->r_filter != '') {
				$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$filter.", `status`='active';");
				$entry = $_GET['wctfid'] = $wpdb->insert_id;
			}
			else {
				exit(__('ERROR: No entry defined yet and no filter given for autocreate.','wct'));
			}
		}
	}
	else {
		$entry = (integer)$_GET['wctfid'];
	}
	$url = $this->generate_pagelink(array("/[&?]+wctefid=save/","/[&?]+wctfid=[0-9]/","/[&?]+wctnew=[0-9]*/"),array("","","",""));

	echo "<script>function getY (el) {y = el.offsetTop;if (!el.offsetParent) { return y; } else return (y+getY(el.offsetParent)-35);}</script>";

	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$form->r_table."`;");
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
	$tmp = explode("PRIMARY KEY",$array['Create Table']);
	$felder = explode("\n",$tmp[0]);
	for ($i=2;$felder[$i] != '';$i++) {
		$x++;
		$feld[$x] =  preg_replace("/.*`(.*?)`.*/","$1",$felder[$i-1]);
		if (strpos ($felder[$i-1]," text") !== false) {
			$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
		}
		else {
			$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
		}
	}
	$row = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' AND `id`='".mres($entry)."' ".$filter." LIMIT 1;");
	$out .= "<h3>".__('Edit Entry','wct')."</h3><form action=\"".$url."wctfid=".$_GET['wctfid']."&wctefid=save".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\" enctype=\"multipart/form-data\">";

	$inhalt = str_replace("[again]","",$form->e_setup);
	$rights = ",".$form->r_fields.",";

	preg_match_all("/\{(.*?)\}/", $inhalt, $matches);

	foreach ($matches[1] as $val => $wert) {
		if (strpos($rights,",".$wert.",") === false) {
			$addon = " style=\"background-color: #CCC;\" readonly";
		}
		else {
			$addon = "";
			if ($feld2[$wert] == "int(10)") {
				$addon = " id=\"f_date_".$wert."\" style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;\" />".
				     "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('#f_date_".$wert."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});});</script";
			}
		}

		if ($feld2[$wert] == "smallint(6)") { $inhalt = str_replace("{".$wert."}","<input size=\"7\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"6\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "int(10)") {
			if (strpos($rights,",".$wert.",") === false) {
				$inhalt = str_replace("{".$wert."}","<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".date("Y-m-d",$row->$wert)."\" maxsize=\"10\"".$addon.">",$inhalt);
			}
			else {
				$inhalt = str_replace("{".$wert."}","<input size=\"10\" type=\"text\" name=\"wctf_".$wert."\" value=\"".date("Y-m-d",$row->$wert)."\" maxsize=\"10\"".$addon.">",$inhalt);
			}
		}
		elseif ($feld2[$wert] == "int(11)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"11\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(32)") { $inhalt = str_replace("{".$wert."}","<input size=\"34\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"32\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(64)") { $inhalt = str_replace("{".$wert."}","<input size=\"65\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"64\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(128)") { $inhalt = str_replace("{".$wert."}","<input size=\"112\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"128\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(160)" OR $feld2[$wert] == "varchar(254)") { $inhalt = str_replace("{".$wert."}","<input id=\"nix_".$wert."\" type=\"text\" size=\"50\" name=\"nix_".$wert."\" value=\"".stripslashes($row->$wert)."\" readonly/><input id=\"nix2_".$wert."\" type=\"button\" value=\"".__('Browse','wct')."\" onclick=\"javascript:document.getElementById('nix_".$wert."').style.visibility = 'hidden';document.getElementById('nix_".$wert."').style.display = 'none';document.getElementById('wctp_".$wert."').style.visibility = 'visible';document.getElementById('wctp_".$wert."').style.display = 'block';document.getElementById('nix2_".$wert."').style.visibility = 'hidden';document.getElementById('nix2_".$wert."').style.display = 'none';document.getElementById('wctp_".$wert."').click();\"><input size=\"50\" id=\"wctp_".$wert."\" type=\"file\" name=\"wctp_".$wert."\" value=\"".stripslashes($row->$wert)."\" style=\"visibility:hidden;display:none;\"/>",$inhalt); }
		elseif (substr($feld2[$wert],0,4) == "enum") {
			if ($addon == "") {
				$tmp = "<select style=\"width:120px;\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\">";
				$defs = explode(".",str_replace("'","",substr($feld2[$wert],6,(strlen(rtrim($feld2[$wert]))-8))));

				foreach ($defs as $posibility) {
					$tmp .= "<option value=\"".$posibility."\"";
					if ($posibility == stripslashes($row->$wert)) { $tmp .= " selected"; }
					$tmp .= ">".$posibility."</option>";
				}
				$tmp .= "</select>";
			}
			else {
				$tmp = "<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"32\"".$addon."/>";
			}
			$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
		}
		elseif (substr($feld2[$wert],0,3) == "set") {
			$tmp = '';
			$defs = explode("'.'",substr($feld2[$wert],5,(strlen(rtrim($feld2[$wert]))-7)));
			$wasjetzt = ",".stripslashes($row->$wert).",";
			foreach ($defs as $posibility) {
				$ji++;
				$tmp .= "<div style=\"width:135px;float:left;overflow:hidden;\"><input type=\"checkbox\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."[]\" value=\"".$posibility."\"";
				if (stripos($wasjetzt,",".$posibility.",") !== false) { $tmp .= " checked"; }
				$tmp .= ">".substr($posibility,0,17)."</div>";
				if ($ji >= '6') { $tmp .= "<br/>"; $ji = '0'; }
			}
			$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
		}
		elseif ($feld2[$wert] == "float(8.2)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"11\"".$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "text") {
			if ($addon != '') { $addon = " style=\"background-color: #CCC;\" readonly=\"readonly\""; } else { $mytextfelder .= "wctf_".$wert.","; }
			$inhalt = str_replace("{".$wert."}","<textarea id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" style=\"height: 155px;width: 100%;\"".$addon.">".stripslashes($row->$wert)."</textarea>",$inhalt);
		}
		else {
			$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".$feld2[$i]."' AND `special`='0' LIMIT 1;");
			if (count($abfrage) == '1') {
				if (preg_match("/(.*)/",$abfrage->name,$treffer)) {
					echo "<input id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\"  size=\"".($treffer[1]+1)."\" type=\"text\" />";
				}
				echo "<input id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" size=\"112\" type=\"text\" />";
			}
			else {
				echo __('undefinied field type','wct')."<input id=\"wctf_".$wert."\" type=\"hidden\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" />";
			}
		}
	}

	if ($mytextfelder != '') {
		$wct_elements = substr($mytextfelder,0,strlen($mytextfelder)-1);
		global $wuk_tinymce;
		if (class_exists('wuk_tinymce')) {
			$wuk_tinymce->tinymce_getInitJS($wct_elements,$form->htmlview);
		}
	}

	$out .= rbr($this->filter_tables($inhalt))."<br/>";
	
	$out .= "<input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form>\n\n<!-- Custom Tables Plugin 05a1a29bdcae7b12229e651a9fd48b11 -->\n\n";
	$out = do_shortcode(stripslashes($out));
}

?>
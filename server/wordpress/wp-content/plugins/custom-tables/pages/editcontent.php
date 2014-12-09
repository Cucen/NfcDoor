<?php

if ($_POST['wcts2'] != '') { 
	$_GET['wcts'] = (integer)$_POST['wcts2'] * 30 - 30;
}
if ($_GET['action'] == 'del') {
	$qry = $wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct".$tableid."` WHERE `id`='".mres($_GET['rid'])."'LIMIT 1;");
	$_GET['action'] = '';
}
elseif ($_POST['multisave'] == '1') {
	foreach ($_POST as $var => $wert) {
		if (substr($var,0,3) == 'fff') {
			$var = explode("|",$var);
			$wert = preg_replace(
						array(
							"/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/e",
							"/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/e",
							"/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/e"
						),
						array(
							"mktime('1','1','1','$2','$1','$3')",
							"mktime('1','1','1','$2','$3','$1')",
							"mktime('1','1','1','$1','$2','$3')"
						),
						$wert);
			$abfrage = "UPDATE `".$wpdb->prefix."wct".(integer)$var[1]."` SET `".mres($var[3])."`='".mres(trim($wert))."' WHERE `id`='".mres($var[2])."' LIMIT 1;";
			$wpdb->get_row($abfrage);
		}
	}
}
elseif ($_GET['action'] == 'edit2') {

	for ($i=0;$_POST[wctff][$i] != '';$i++) {
		if (substr($_POST[wctf][$i],0,8) == "SpeCSet_") {
			unset($set);
			$tmp = $_POST[wctf][$i];
			if (is_array($_POST[$tmp])) {
				foreach ($_POST[$tmp] as $wert) {
					$set .= $wert.",";
				}
				if ($set != '') { $set = substr($set,0,strlen($set)-1); }
			}
			else { $set = ''; }
			$string .= "`".mres($_POST[wctff][$i])."`='".mres($set)."' ";
		}
		elseif (substr($_POST[wctf][$i],0,8) != "SpeCial_") {
			if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",trim($_POST[wctf][$i]))) {
				$ti = explode("-",$_POST[wctf][$i]);
				$_POST[wctf][$i] = mktime (1,1,1, $ti[1], $ti[2], $ti[0] );
			}
			$string .= "`".mres($_POST[wctff][$i])."`='".mres(trim($_POST[wctf][$i]))."' ";
		}
		else {

		
			$var = "wctfs_".trim(substr($_POST[wctf][$i],8,32000));
			$string .= "`".mres($_POST[wctff][$i])."`='".mres(trim($_POST[$var]))."' ";
		}
	}

	$string = str_replace("' `","', `",$string);
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$tableid."` SET ".$string." WHERE `id`='".mres($_GET['rid'])."' LIMIT 1;");
	$message = __('Changes has been saved', 'wct')."<br/>";
	if ($_POST['submit2'] != '') {
		$_GET['wcttab'] = $_GET['wcttab'];
		$_GET['wcttab2'] = $_GET['wcttab2'];
		$_GET['action'] = '';
	}
	elseif ($_POST['submit5'] != '') {
		$search = $_SESSION[$tableid.'wct_search'];
		if ($search != '') {
			$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
			$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
			$tmp = explode("PRIMARY KEY",$array['Create Table']);
			$felder = explode("\n",$tmp[0]);

			for ($i=4;$felder[$i] != '';$i++) {
				$felde .= preg_replace("/.*`(.*)`.*/","$1",$felder[$i-1]).",";
			}

			$felde = substr($felde,0,strlen($felde)-1);
			$search = " AND lower(concat_ws(".$felde.")) LIKE lower('%".mres($search)."%')";
		}

		if ($_GET['wcttab2'] == 'passive') { $status='passive';  }
		elseif ($_GET['wcttab2'] == 'draft') { $status='draft';}
		else { $status='active'; $_GET['wcttab2'] = 'active'; }

		$qry = $wpdb->get_row("SELECT `id` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `id`>'".mres($_GET['rid'])."' AND `status`='".$status."'".$search." LIMIT 1;");
		$_GET['action'] = 'edit';
		$_GET['rid'] = $qry->id;
		if ($_GET['rid'] == '') { $_GET['action'] = 'new'; }
	}
	else {
		$_GET['action'] = 'edit';
	}
}
elseif ($_GET['action'] == 'new2') {
	for ($i=0;$_POST[wctff][$i] != '';$i++) {
		if (substr($_POST[wctf][$i],0,8) == "SpeCSet_") {
			if (isset($_POST[$_POST[wctf][$i]])) {
				foreach ($_POST[$_POST[wctf][$i]] as $wert) {
					$set .= $wert.",";
				}
				if ($set != '') { $set = substr($set,0,strlen($set)-1); }
			}
			$string .= "`".mres($_POST[wctff][$i])."`='".mres($set)."' ";
		}
		elseif (substr($_POST[wctf][$i],0,8) != "SpeCial_") {
			if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",trim($_POST[wctf][$i]))) {
				$ti = explode("-",$_POST[wctf][$i]);
				$_POST[wctf][$i] = mktime (1,1,1, $ti[1], $ti[2], $ti[0] );
			}
			$string .= "`".mres($_POST[wctff][$i])."`='".mres(trim($_POST[wctf][$i]))."' ";
		}
		else {		
			$var = "wctfs_".trim(substr($_POST[wctf][$i],8,32000));
			$string .= "`".mres($_POST[wctff][$i])."`='".mres(trim($_POST[$var]))."' ";
		}
	}
	$string = str_replace("' `","', `",$string);
	$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$tableid."` SET ".$string.";");
	$_GET['rid'] = $wpdb->insert_id;
	$message = __('Entry has been saved', 'wct')."<br/>";
	if ($_POST['submit2'] != '') {
		$_GET['wcttab'] = $_GET['wcttab'];
		$_GET['wcttab2'] = $_GET['wcttab2'];
		$_GET['action'] = '';
	}
	elseif ($_POST['submit3'] != '') {
		$_GET['action'] = 'new';
	}
	else {
		$_GET['action'] = 'edit';
	}
}
elseif ($_GET['action'] == 'sr2' AND $this->prem_chk() == true) {
	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
	$tmp = explode("PRIMARY KEY",$array['Create Table']);
	$felder = explode("\n",$tmp[0]);
	for ($i=2;$felder[$i] != '';$i++) {
		$x++;
		$feld = preg_replace("/.*`(.*)`.*/","$1",$felder[$i-1]);
		if ($feld != 'id' AND $feld != 'status') {
			$replaceout .= " ".$feld." = REPLACE(".$feld.",'".$_POST['wct_sr1']."','".$_POST['wct_sr2']."'),";
		}
	}
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$tableid."` SET ".substr($replaceout,0,strlen($replaceout)-1).";");
	$msg = __('Search & Replace has been done','wct');
}
elseif ($_GET['action'] == 'resort2') {
	$wpdb->get_row("SET @count = 1452412;");
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$tableid."` SET `".$wpdb->prefix."wct".$tableid."`.`id` = @count:= @count + 1 ORDER BY `".mres($_POST['sortA'])."` ".($_POST['sortB'] == 'DESC' ? 'DESC' : 'ASC').";");
	$wpdb->get_row("SET @count = 0;");
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$tableid."` SET `".$wpdb->prefix."wct".$tableid."`.`id` = @count:= @count + 1 ORDER BY `".mres($_POST['sortA'])."` ".($_POST['sortB'] == 'DESC' ? 'DESC' : 'ASC').";");
	$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".$tableid."` AUTO_INCREMENT = 0;");
}

if ($_GET['wcttab2'] == 'sr') { $_GET['action'] = 'sr'; }
elseif ($_GET['action'] == 'sql2' AND is_admin()) {
	$nonce = $_GET['_wpnonce'];
    	if (!wp_verify_nonce($nonce, 'wct-sql-nonce')) { die("Security check failed"); }
	$wpdb->show_errors();
	$wpdb->get_row(stripslashes($_POST['unfilteredsql']));
	$wpdb->hide_errors();
	$_GET['action'] = 'sql';
}
elseif ($_GET['wcttab2'] == 'sql') { $_GET['action'] = 'sql'; }
elseif ($_GET['wcttab2'] == 'resort') { $_GET['action'] = 'resort'; }

echo "<script>function getY (el) {y = el.offsetTop;if (!el.offsetParent) { if (y <= '30') { y = 30; } return y; } else { y = (y+getY(el.offsetParent)-35);if (y <= '30') { y = 30; }return y;}}</script>";

switch ($_GET['action']) {
	case 'resort':
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='active';");
		$anz_active = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='passive';");
		$anz_passive = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='draft';");
		$anz_draft = $qry->anzahl;

		echo "<div><h2>".__('Edit Content','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
		echo $this->tab_link($wcttab,'active','content','active',' ('.$anz_active.')');
		echo $this->tab_link($wcttab,'passive','content','passive',' ('.$anz_passive.')');
		echo $this->tab_link($wcttab,'draft','content','draft',' ('.$anz_draft.')');
		echo $this->tab_link($wcttab,'Search & Replace','content','sr');
		if ($this->settings['wct_unfilteredsql'] == "1") { echo $this->tab_link($wcttab,'SQL Statement','content','sql'); }
		echo $this->tab_link($wcttab,'Resort','content','resort');
		echo "</tr></table>";
		
		
		echo "<h2>".__('Resort Table Entries','wct')."</h2>";
		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);
		echo "<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=resort2\" method=\"post\">".__('Sort table on field','wct').": <select name=\"sortA\"><option></option>";
		for ($i=4;$felder[$i] != '';$i++) {
			$x++;
			$feld[$x] =  preg_replace("/.*`(.*)`.*/","$1",$felder[$i-1]);
			echo "<option value=\"".$feld[$x]."\">".$feld[$x]."</option>";
		}
		echo "</select> <select name=\"sortB\"><option value=\"ASC\">".__('ascending','wct')."</option><option value=\"DESC\">".__('descending','wct')."</option></select> ";
		echo "<input type=\"submit\" name=\"submit1\" value=\"". __('Save all Changes', 'wct') ."\"></form>";
	break;

	case 'edit':
		echo "<div><h2>".__('Edit Entry','wct')."</h2>";
		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);
		for ($i=2;$felder[$i] != '';$i++) {
			$x++;
			$feld[$x] =  preg_replace("/.*`(.*)`.*/","$1",$felder[$i-1]);
			if (strpos ($felder[$i-1]," text") !== false) {
				$feld2[$x] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
			}
			else {
				$feld2[$x] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
			}
		}

		$qry = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$tableid."` WHERE `id`='".mres($_GET['rid'])."' LIMIT 1;");
		echo $message."<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=edit2&wcts=".$_GET['wcts']."&rid=".$_GET['rid']."\" method=\"post\"><table>";
		for($i=1;$i<=$x;$i++) {
			if ($feld[$i] != 'id') {
				echo "<input type=\"hidden\" name=\"wctff[]\" value=\"".$feld[$i]."\" /><tr><td><strong>".$feld[$i]."</strong>&nbsp;</td><td>";
				if ($feld2[$i] == "smallint(6)") { echo "<input size=\"7\" type=\"text\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" maxsize=\"6\"/>"; }
				elseif ($feld2[$i] == "int(11)") { echo "<input size=\"12\" type=\"text\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" maxsize=\"11\"/>"; }
				elseif ($feld2[$i] == "int(10)") {
					echo "<input style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;\" size=\"14\" type=\"text\" id=\"datefield".$feld[$i]."\" name=\"wctf[]\" value=\"".date("Y-m-d",$qry->$feld[$i])."\"/>
					<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('#datefield".$feld[$i]."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});});</script>"; 
				}
				elseif ($feld2[$i] == "varchar(32)") { echo "<input size=\"34\" type=\"text\" name=\"wctf[]\" value=\"".htmlspecialchars(stripslashes($qry->$feld[$i]), ENT_QUOTES)."\" maxsize=\"32\"/>"; }
				elseif ($feld2[$i] == "varchar(64)") { echo "<input size=\"65\" type=\"text\" name=\"wctf[]\" value=\"".htmlspecialchars(stripslashes($qry->$feld[$i]), ENT_QUOTES)."\" maxsize=\"64\"/>"; }
				elseif ($feld2[$i] == "varchar(128)") { echo "<input size=\"112\" type=\"text\" name=\"wctf[]\" value=\"".htmlspecialchars(stripslashes($qry->$feld[$i]), ENT_QUOTES)."\" maxsize=\"128\"/>"; }
				elseif ($feld2[$i] == "varchar(160)" OR $feld2[$i] == "varchar(254)") {
					echo "<input id=\"upload_image".$feld[$i]."\" type=\"text\" size=\"90\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" /><input id=\"upload_image_button".$feld[$i]."\" type=\"button\" value=\"".__('Upload Image','wct')."\" />";
					$picturefeld[] = $feld[$i];
				}
				elseif ($feld2[$i] == "text") {
					echo "<input type=\"hidden\" name=\"wctf[]\" value=\"SpeCial_".$feld[$i]."\"/>";
					if ($_GET['tableselector'] != '') {
						echo "<textarea id=\"wctfs_".$feld[$i]."\" name=\"wctfs_".$feld[$i]."\" style=\"height: 155px;width: 100%;\">".htmlspecialchars(stripslashes($qry->$feld[$i]), ENT_QUOTES)."</textarea>";
						$mytextfelder .= "wctfs_".$feld[$i].",";
					}
					else {
						the_editor(stripslashes($qry->$feld[$i]), "wctfs_".$feld[$i], $feld[($i-1)], $media_buttons = false);
					}

				}
				elseif (substr($feld2[$i],0,4) == "enum") {
					echo "<select style=\"width:120px;\" name=\"wctf[]\">";
					$defs = explode("'.'",substr($feld2[$i],6,(strlen(rtrim($feld2[$i]))-8)));
					foreach ($defs as $posibility) {
						echo "<option value=\"".$posibility."\"";
						if ($posibility == stripslashes($qry->$feld[$i])) { echo " selected"; }
						echo ">".$posibility."</option>";
					}
					echo "</select>";
				}
				elseif (substr($feld2[$i],0,3) == "set") {
					$defs = explode("'.'",substr($feld2[$i],5,(strlen(rtrim($feld2[$i]))-7)));
					$wasjetzt = ",".stripslashes($qry->$feld[$i]).",";
					echo "<input type=\"hidden\" name=\"wctf[]\" value=\"SpeCSet_".$feld[$i]."\">";
					foreach ($defs as $posibility) {
						$ji++;
						echo "<div style=\"width:135px;float:left;overflow:hidden;\"><input type=\"checkbox\" name=\"SpeCSet_".$feld[$i]."[]\" value=\"".$posibility."\"";
						if (stripos($wasjetzt,",".$posibility.",") !== false) { echo " checked"; }
						echo ">".substr($posibility,0,17)."</div>";
						if ($ji >= '6') { echo "<br/>"; $ji = '0'; }
					}
				}
				elseif ($feld2[$i] == "int(12)") {
					$exists2 = $wpdb->get_row("SELECT `t_table`,`t_field`,`z_field`,`z_field2` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".mres($tableid)."' AND `s_field`='".mres($feld[$i])."' LIMIT 1;");
					if (count($exists2) == '1') {
						$felde = ($exists2->z_field != '' ? $exists2->z_field : $exists2->t_field);
						$felde2 = ($exists2->z_field2 != '' ? ", `".$exists2->z_field2."` as `n2`" : "");

						$abfrage3 = $wpdb->get_results("SELECT id,`".$felde."`".$felde2." FROM `".$wpdb->prefix."wct".$exists2->t_table."` GROUP BY `".$felde."`".($exists2->z_field2 != '' ? ", `".$exists2->z_field2."`" : "").";");
						if (count($abfrage3) >= '1') {
							echo "<select name=\"wctf[]\">option value=\"\"></option>";
							foreach ($abfrage3 as $rel => $te) {
								if (stripslashes($qry->$feld[$i]) == $te->id) { $done = 1; }
								echo "<option value=\"".$te->id."\" ".(stripslashes($qry->$feld[$i]) == $te->id ? " selected" : "").">".$te->$felde.(($te->n2 != $te->$felde AND $te->n2 != '') ? " (".$te->n2.")" : "")."</option>";
							}
							if ($done != '1') { echo "<option value=\"".$qry->$feld[$i]."\" selected>--no change--</option>"; }
							echo "</select> <a href=\"admin.php?page=wct_table_".$exists2->t_table."&wcttab=content&action=edit&rid=".$qry->$feld[$i]."\" style=\"text-decoration:none;\">[EDIT]</a>";
						}
						else {
							echo __('No Entries found in related table','wct');
						}
					} else {
						echo __('Relation not definied yet','wct');
					}
				}
				elseif ($feld2[$i] == "float(8.2)") { echo "<input size=\"12\" type=\"text\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" maxsize=\"11\"/>"; }
				else {
					$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".str_replace(" ,",",",$feld2[$i])."' AND `special`='0' LIMIT 1;");
					if (count($abfrage) == '1') {
						if (preg_match("/\(([0-9]*)[,]{0,1}.*\)/",$abfrage->name,$treffer)) {
							echo "<input size=\"".($treffer[1]+1)."\" type=\"text\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" maxsize=\"".$treffer[1]."\"/>";
						}
						echo "<input size=\"112\" type=\"text\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\"/>";
					}
					else {
						echo __('undefinied field type','wct')."<input type=\"hidden\" name=\"wctf[]\" value=\"".stripslashes($qry->$feld[$i])."\" />";
					}
				}
				echo "</td></tr>";
			}
		}
		if ($_GET['tableselector'] != '' AND $mytextfelder != '' AND $this->prem_chk() == true) {
			$wct_elements = substr($mytextfelder,0,strlen($mytextfelder)-1);
			global $wuk_tinymce;
			if (class_exists('wuk_tinymce')) {
				$wuk_tinymce->tinymce_getInitJS($wct_elements,$html);
			}
		}
		echo "</table><input type=\"submit\" name=\"submit1\" value=\"". __('Save all Changes', 'wct') ."\"> <input type=\"submit\" name=\"submit2\" value=\"". __('Save & back', 'wct') ."\"> <input type=\"submit\" name=\"submit5\" value=\"". __('Save & next', 'wct') ."\"></form>";

		if (is_array($picturefeld)) { add_action('admin_print_footer_scripts', $this->picture_upload($picturefeld), 61); }

	break;

	case 'new':
		echo "<div><h2>".__('Create Entry','wct')."</h2>";
		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);
		for ($i=2;$felder[$i] != '';$i++) {
			$x++;
			$feld[$x] =  preg_replace("/.*`(.*)`.*/","$1",$felder[$i-1]);
			if (strpos ($felder[$i-1]," text") !== false) {
				$feld2[$x] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
			}
			else {
				$feld2[$x] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
			}
		}

		echo $message."<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=new2&wcts=".$_GET['wcts']."\" method=\"post\"><table>";
		for($i=1;$i<=$x;$i++) {
			if ($feld[$i] != 'id') {
				echo "<input type=\"hidden\" name=\"wctff[]\" value=\"".$feld[$i]."\" /><tr><td><strong>".$feld[$i]."</strong>&nbsp;</td><td>";
				if ($feld2[$i] == "smallint(6)") { echo "<input size=\"7\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"6\"/>"; }
				elseif ($feld2[$i] == "int(11)") { echo "<input size=\"12\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"11\"/>"; }
				elseif ($feld2[$i] == "int(10)") {
					echo "<input style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;\" size=\"14\" type=\"text\" id=\"datefield".$feld[$i]."\" name=\"wctf[]\" value=\"\"/>
					<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('#datefield".$feld[$i]."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});});</script>"; 
				}
				elseif ($feld2[$i] == "varchar(32)") { echo "<input size=\"34\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"32\"/>"; }
				elseif ($feld2[$i] == "varchar(64)") { echo "<input size=\"65\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"64\"/>"; }
				elseif ($feld2[$i] == "varchar(128)") { echo "<input size=\"112\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"128\"/>"; }
				elseif ($feld2[$i] == "varchar(160)" OR $feld2[$i] == "varchar(254)") {
					echo "<input id=\"upload_image".$feld[$i]."\" type=\"text\" size=\"90\" name=\"wctf[]\" value=\"\" /><input id=\"upload_image_button".$feld[$i]."\" type=\"button\" value=\"Upload Image\" />";
					$picturefeld[] = $feld[$i];
				}
				elseif ($feld2[$i] == "text") {
					echo "<input type=\"hidden\" name=\"wctf[]\" value=\"SpeCial_".$feld[$i]."\"/>";
					if ($_GET['tableselector'] != '') {
						echo "<textarea name=\"wctfs_".$feld[$i]."\" style=\"height: 155px;width: 100%;\"></textarea>";
						$mytextfelder .= "wctfs_".$feld[$i].",";
					}
					else {
						the_editor('', "wctfs_".$feld[$i], $feld[($i-1)], $media_buttons = false);
					}
				}
				elseif (substr($feld2[$i],0,4) == "enum") {
					echo "<select style=\"width:120px;\" name=\"wctf[]\">";
					$defs = explode("'.'",substr($feld2[$i],6,(strlen(rtrim($feld2[$i]))-8)));
					foreach ($defs as $posibility) {
						echo "<option value=\"".$posibility."\">".$posibility."</option>";
					}
					echo "</select>";
				}
				elseif (substr($feld2[$i],0,3) == "set") {
					$defs = explode("'.'",substr($feld2[$i],5,(strlen(rtrim($feld2[$i]))-7)));
					echo "<input type=\"hidden\" name=\"wctf[]\" value=\"SpeCSet_".$feld[$i]."\">";
					foreach ($defs as $posibility) {
						$ji++;
						echo "<div style=\"width:135px;float:left;overflow:hidden;\"><input type=\"checkbox\" name=\"SpeCSet_".$feld[$i]."[]\" value=\"".$posibility."\">".substr($posibility,0,17)."</div>";
						if ($ji >= '6') { echo "<br/>"; $ji = '0'; }
					}
				}
				elseif ($feld2[$i] == "int(12)") {
					$exists2 = $wpdb->get_row("SELECT `t_table`,`t_field`,`z_field`,`z_field2` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".mres($tableid)."' AND `s_field`='".mres($feld[$i])."' LIMIT 1;");
					if (count($exists2) == '1') {
						$felde = ($exists2->z_field != '' ? $exists2->z_field : $exists2->t_field);
						$felde2 = ($exists2->z_field2 != '' ? ", `".$exists2->z_field2."` as `n2`" : "");

						$abfrage3 = $wpdb->get_results("SELECT id,`".$felde."`".$felde2." FROM `".$wpdb->prefix."wct".$exists2->t_table."` GROUP BY `".$felde."`".($exists2->z_field2 != '' ? ", `".$exists2->z_field2."`" : "").";");
						if (count($abfrage3) >= '1') {
							echo "<select name=\"wctf[]\"><option value=\"\" selected></option>";
							foreach ($abfrage3 as $rel => $te) {
								echo "<option value=\"".$te->id."\">".$te->$felde.(($te->n2 != $te->$felde AND $te->n2 != '') ? " (".$te->n2.")" : "")."</option>";
							}
							echo "</select>";
						}
						else {
							echo __('No Entries found in related table','wct');
						}
					} else {
						echo __('Relation not definied yet','wct');
					}
				}
				elseif ($feld2[$i] == "float(8.2)") { echo "<input size=\"12\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"12\"/>"; }
				else {
					$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".str_replace(" ,",",",$feld2[$i])."' AND `special`='0' LIMIT 1;");
					if (count($abfrage) == '1') {
						if (preg_match("/\(([0-9]*)[,]{0,1}.*\)/",$abfrage->name,$treffer)) {
							echo "<input size=\"".($treffer[1]+1)."\" type=\"text\" name=\"wctf[]\" value=\"\" maxsize=\"".$treffer[1]."\"/>";
						}
						echo "<input size=\"112\" type=\"text\" name=\"wctf[]\" value=\"\"/>";
					}
					else {
						echo __('undefinied field type','wct')."<input type=\"hidden\" name=\"wctf[]\" value=\"\" />";
					}
				}
				echo "</td></tr>";
			}
		}
		if ($_GET['tableselector'] != '' AND $mytextfelder != '' AND $this->prem_chk() == true) {
			$wct_elements = substr($mytextfelder,0,strlen($mytextfelder)-1);
			global $wuk_tinymce;
			if (class_exists('wuk_tinymce')) {
				$wuk_tinymce->tinymce_getInitJS($wct_elements,$html);
			}
		}
		echo "</table><input type=\"submit\" name=\"submit1\" value=\"". __('Save Entry', 'wct') ."\"> <input type=\"submit\" name=\"submit2\" value=\"". __('Save & back', 'wct') ."\"> <input type=\"submit\" name=\"submit3\" value=\"". __('Save & create new', 'wct') ."\"></form>";
		if (is_array($picturefeld)) { add_action('admin_print_footer_scripts', $this->picture_upload($picturefeld), 61); }
	break;

	case 'sr':
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='active';");
		$anz_active = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='passive';");
		$anz_passive = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='draft';");
		$anz_draft = $qry->anzahl;

		echo "<div><h2>".__('Edit Content','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
		echo $this->tab_link($wcttab,'active','content','active',' ('.$anz_active.')');
		echo $this->tab_link($wcttab,'passive','content','passive',' ('.$anz_passive.')');
		echo $this->tab_link($wcttab,'draft','content','draft',' ('.$anz_draft.')');
		echo $this->tab_link($wcttab,'Search & Replace','content','sr');
		if ($this->settings['wct_unfilteredsql'] == "1") { echo $this->tab_link($wcttab,'SQL Statement','content','sql'); }
		echo $this->tab_link($wcttab,'Resort','content','resort');
		echo "</tr></table><h2>".__('Search & Replace','wct')."</h2>";

		if ($this->prem_chk() !== true) { echo __('No valid premium feature license found, please enter serial ','wct')." <a href=\"admin.php?page=wct_settings#premium\">". __('now','wct')."</a>."; }
		else {
			echo "<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=sr2\" method=\"post\">
			".$msg."<table><tr><td><b>".__('Search for','wct').":</b></td><td><input style=\"width:400px;\" type=\"text\" name=\"wct_sr1\" value=\"\"></td></tr>
			<tr><td><b>".__('Replace with','wct').":</b></td><td><input style=\"width:400px;\" type=\"text\" name=\"wct_sr2\" value=\"\"></td></tr></table>
			<input type=\"submit\" name=\"srsr\" value=\"".__('Search & Replace','wct')."\"> ".__('<b>Attention:</b> This action is irreversible!','wct')."</form></div>";
		}
	break;

	case 'sql':
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='active';");
		$anz_active = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='passive';");
		$anz_passive = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='draft';");
		$anz_draft = $qry->anzahl;

		echo "<div><h2>".__('Edit Content','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
		echo $this->tab_link($wcttab,'active','content','active',' ('.$anz_active.')');
		echo $this->tab_link($wcttab,'passive','content','passive',' ('.$anz_passive.')');
		echo $this->tab_link($wcttab,'draft','content','draft',' ('.$anz_draft.')');
		echo $this->tab_link($wcttab,'Search & Replace','content','sr');
		if ($this->settings['wct_unfilteredsql'] == "1") { echo $this->tab_link($wcttab,'SQL Statement','content','sql'); }
		echo $this->tab_link($wcttab,'Resort','content','resort');
		echo "</tr></table><h2>".__('SQL Statement','wct')."</h2>";

		$nonce = wp_create_nonce('wct-sql-nonce');
		echo "<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=sql2&_wpnonce=".$nonce."\" method=\"post\">
		<textarea rows=\"10\" name=\"unfilteredsql\">";

		if ($_POST['unfilteredsql'] != "") { echo stripslashes($_POST['unfilteredsql']); }
		else { echo "UPDATE `".$wpdb->prefix."wct".$tableid."` SET `status`='passive' WHERE ...;"; }
		echo "</textarea><br/>
		<input type=\"submit\" name=\"srsr\" value=\"".__('Send SQL Statement','wct')."\"> ".__('<b>Attention:</b> This action is irreversible!','wct')."</form></div>";
	break;

	default:
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='active';");
		$anz_active = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='passive';");
		$anz_passive = $qry->anzahl;
		$qry = $wpdb->get_row("SELECT Count(id) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` WHERE `status`='draft' OR `status`='';");
		$anz_draft = $qry->anzahl;
		
		$qry = $wpdb->get_row("SELECT `globaledit` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$tableid."' LIMIT 1;");
		$globaledit = $qry->globaledit;

		if ($_GET['wcttab2'] == 'passive') { $status='passive';  }
		elseif ($_GET['wcttab2'] == 'draft') { $status='draft';}
		else { $status='active'; $_GET['wcttab2'] = 'active'; }

		echo "<div><h2>".__('Edit Content','wct')."</h2><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
		echo $this->tab_link($wcttab,'active','content','active',' ('.$anz_active.')');
		echo $this->tab_link($wcttab,'passive','content','passive',' ('.$anz_passive.')');
		echo $this->tab_link($wcttab,'draft','content','draft',' ('.$anz_draft.')');
		if ($wcmenr != '1') {
			echo $this->tab_link($wcttab,'Search & Replace','content','sr');
			if ($this->settings['wct_unfilteredsql'] == "1") { echo $this->tab_link($wcttab,'SQL Statement','content','sql'); }
			echo $this->tab_link($wcttab,'Resort','content','resort');
		}


		echo "</tr></table>
		<script type=\"text/javascript\">
		function chkconfirm() {
			var answer = confirm('". __ ('Do you really want to do this?', 'wct')."');
			if (answer) { return true; } else { return false; }
		}
		function showhide() {
			var answer = document.getElementById('filterform').style.visibility;
			if (answer == 'hidden') {
				document.getElementById('filterform').style.visibility = 'visible';
				document.getElementById('filterform').style.display = 'block';
			}
			else {
				document.getElementById('filterform').style.visibility = 'hidden';
				document.getElementById('filterform').style.display = 'none';
			}
		}
		</script>";

		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);

		$x = 1; $y = 1;
		$feld[1] = 'id';
		$tdd = $td = "<td>&nbsp;<strong>id</strong>&nbsp;</td>";

		if ($_REQUEST['wct_sc'] != '') { session_destroy(); }

		for ($i=4;$felder[$i] != '';$i++) {
			$tmp = preg_replace("/.*`(.*)` ([int\(12\)]*).*/","$1 $2",$felder[$i-1]);
			$tmp = explode(" ",$tmp);
			if ($tmp[1] == "int(12)") { $relationA[($i - 2)] = $tmp[0]; }
			$fff[$i] = $tmp = $tmp[0];
			if ($i <= '8') {
				$x++;
				$feld[$x] = $tmp;
				$td .= "<td>&nbsp;<strong>".$feld[$x]."</strong>&nbsp;".$this->wct_sort($feld[$x],$tableid)."</td>";
			}
			$filter .= "<input style=\"position:relative; top: -2px;\" type=\"checkbox\" name=\"field_".$tmp."\" value=\"1\"";
			$filter2 .= "field_".$tmp."=1&";
			
			if (($_REQUEST['field_'.$tmp] == '1' OR $_SESSION[$tableid.'field_'.$tmp] == '1') AND $_REQUEST['wct_sc'] == '') {
				$y++;
				$feld[$y] = $tmp;
				$tdd .= "<td>&nbsp;<strong>".$feld[$y]."</strong>&nbsp;".$this->wct_sort($feld[$x],$tableid)."</td>";
				$filter .= " checked";
				$_SESSION[$tableid.'field_'.$feld[$y]] = '1';
			}
			else { $_SESSION[$tableid.'field_'.$tmp] = '0'; } 
			$filter .= ">".$tmp."&nbsp; ";
		}

		if ($x >= '7') { $x = '7'; }
		if ($y != '1') { $z = $y; $te = $tdd; } else { $z = $x; $te = $td; }

		if ($_REQUEST['wct_sc'] != '') {
			$_SESSION[$tableid.'wct_search'] = $search = '';
		}
		elseif (isset($_POST['wct_search'])) {
			$_SESSION[$tableid.'wct_search'] = $search = $_POST['wct_search'];
		}
		elseif ($_SESSION[$tableid.'wct_search'] != '') {
			$search = $_SESSION[$tableid.'wct_search'];
		}

		/* How it should be sorted */
		if ($_REQUEST['wctsort'] != '') {
			$order = " ORDER BY `".$tableid."`.`".mres($_REQUEST['wctsort'])."` ";
			if ($_REQUEST['wctinvs'] == '1') { $order .= "ASC"; } else { $order .= "DESC"; }
		}
		else {
			$order = " ORDER BY `".$tableid."`.`id` ASC "; 
		}

		echo "<br/><form action=\"".$wctmp.$tableid."&wcttab=content&action=new&wcts=".$_GET['wcts']."&wcttab2=".$_GET['wcttab2']."\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"". __('New Entry', 'wct') ."\"></form>
		
	<table><tr><td width=\"300\" valign=\"top\"><h2>".__($status,'wct')." ". __('Entries','wct')."</h2></td><td><div style=\"width: 120px;border: 1px dotted #900; background-color:#FFFFD9;\" onclick=\"showhide()\"><center>".__('Show/Hide Filters','wct')."</center></div><div style=\"width: 120px;border: 1px dotted #900; background-color:#FFFFD9;\"><a href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wcts=".$_GET['wcts']."&".$filter2."wct_ss=1\"<center>".__('Show All Fields','wct')."</center></a></div></td></tr></table>
		<div id=\"filterform\" style=\"position:relative;top: -18px;visibility:hidden; display: none; border: 1px dotted #900;width: 785px; background-color:#FFFFD9;padding: 5px;\">
		<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wcts=".$_GET['wcts']."\" method=\"post\">
		<h3>".__('Search / Filters','wct')."</h3>
		<b>".__('Search in Table','wct').":</b> <input style=\"width: 400px;\" type=\"text\" name=\"wct_search\" value=\"".$search."\"> <input type=\"submit\" name=\"wct_ss\" value=\"".__('Apply','wct')."\"> <input onclick=\"return chkconfirm()();\" type=\"submit\" name=\"wct_sc\" value=\"".__('Clear','wct')."\"><br>
		<br/><b>".__('Show Fields','wct').":</b> ".$filter."</form></div>";
		echo "<table cellpadding-left=\"15\" cellpadding-right=\"15\" width=\"1000\"><tbody>";
		
		if (is_numeric($_GET['wcts']) AND $_GET['wcts'] != '') { $starting = (integer)$_GET['wcts']; } else { $starting = '0'; }
		
		if (is_array($relationA)) {
			/* Adding relation to mysql query */
			$relations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$tableid."';");
			if (count($relations) >= '1') {
				foreach ($relations as $relation) {
					$tr = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$relation->t_table."`;");
					$array=array(); foreach($tr as $member=>$data) { $array[$member]=$data; }
					$felder = explode("PRIMARY KEY",$array['Create Table']);
					$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$felder[0]));
					for ($i=1;$felder[$i] != '';$i++) {
						$srel .= preg_replace("/.*`(.*)`\s.*/","`".$relation->t_table."`.`$1` AS `$1---".$relation->t_table."`,",$felder[$i-1]);
					}	
					$abfrage2 = "LEFT JOIN `".$wpdb->prefix."wct".$relation->t_table."` as `".$relation->t_table."` ON `".$tableid."`.`".$relation->s_field."`=`".$relation->t_table."`.`".$relation->t_field."` ";
					$abfrage3 = ", `".$relation->t_table."`.`".$relation->z_field."` as `rel1`".($relation->z_field2 != '' ? ", `".$relation->t_table."`.`".$relation->z_field2."` as `rel2`" : "");
					$abfrage4 = " OR lower(`".$relation->t_table."`.`".$relation->z_field."`) LIKE lower('%".mres($search)."%') ".($relation->z_field2 != '' ? " OR lower(`".$relation->t_table."`.`".$relation->z_field2."`) LIKE lower('%".mres($search)."%')" : "");
				}
			}
			/* finishing up and send query */
		}
		if ($search != '') {
			unset($felder);
			foreach ($fff as $var => $wert) {
				$felder .= " OR lower(`".$tableid."`.`".$wert."`) LIKE lower('%".mres($search)."%')";
			}
			$search = $felder.$abfrage4;
		}
		
		$qry = $wpdb->get_row("SELECT Count(`".$tableid."`.`id`) AS `anzahl` FROM `".$wpdb->prefix."wct".$tableid."` as `".$tableid."` ".$abfrage2." WHERE (`".$tableid."`.`status`='".($status == "draft" ? $status."' OR `".$tableid."`.`status`='" : $status)."')".($search != '' ? " AND (".substr($search,4,strlen($search)).")" : "").";");
		$anz = $qry->anzahl;
		if ($starting > $anz) { $starting = $anz - 30; }
		
		$abfrage = "SELECT `".$tableid."`.*".$abfrage3." FROM `".$wpdb->prefix."wct".$tableid."` AS `".$tableid."` ".$abfrage2." WHERE `".$tableid."`.`status`='".$status."'".($search != '' ? " AND (".substr($search,4,strlen($search)).")" : "")." ".$order." LIMIT ".mres($starting).",30;";
		$qry = $wpdb->get_results($abfrage);
		
		
		$r = ceil($anz / 30);
		if ($r >= '2') {
			echo "<tr><td colspan=\"3\"></td><form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wctsort=".$_GET['wctsort']."&wctinvs=".$_GET['wctinvs']."\" method=\"post\"><td colspan=\"".($i + 1)."\"><div class=\"tablenav\"><div class=\"tablenav-pages\"><span class=\"displaying-num\">".$anz." Elemente</span>
				<span class=\"pagination-links\"><a class=\"first-page".($starting > '29' ? "" : " disabled")."\" title=\"Zur ersten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wctsort=".$_GET['wctsort']."&wctinvs=".$_GET['wctinvs']."\">&laquo;</a>
				<a class=\"prev-page".($starting > '29' ? "" : " disabled")."\" title=\"Zur vorherigen Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".($starting > '30' ? ($starting-30) : '0')."&wcttab2=".$_GET['wcttab2']."&wctsort=".$_GET['wctsort']."&wctinvs=".$_GET['wctinvs']."\">&lt;</a>
				<span class=\"paging-input\"><input class=\"current-page\" title=\"Aktuelle Seite\" name=\"wcts2\" value=\"".(($starting/30)+1)."\" size=\"2\" type=\"text\"> von <span class=\"total-pages\">".$r."</span></span>
				<a class=\"next-page".($starting >= (($r-1)*30) ? " disabled" : "")."\" title=\"Zur nächsten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".($starting >= (($r-1)*30-30) ? (($r-1)*30) : ($starting+30))."&wcttab2=".$_GET['wcttab2']."&wctsort=".$_GET['wctsort']."&wctinvs=".$_GET['wctinvs']."\">&gt;</a>
				<a class=\"last-page".($starting >= (($r-1)*30) ? " disabled" : "")."\" title=\"Zur letzten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".(($r-1)*30)."&wcttab2=".$_GET['wcttab2']."&wctsort=".$_GET['wctsort']."&wctinvs=".$_GET['wctinvs']."\">&raquo;</a></span></div></div></td></form></tr>";
		}	
		
		echo ($globaledit == '1' ? "<form onclick=\"return chkconfirm()\" action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wcts=".$_GET['wcts']."\" method=\"post\">
			<input type=\"hidden\" name=\"multisave\" value=\"1\" />
			<script lang=\"javascript\">
			function altered(i,field)
			{
				i.style.backgroundColor='#FFCCCC';
				i.name=field;
			}
			</script>" : "")."<tr>".$te."<td></td><td></td></tr>";
			
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				$gs++;
				if ($color == "#EEEEEE" ) { $color = "#DDDDDD"; } else { $color = "#EEEEEE"; }
				echo "<tr onMouseOver=\"this.style.backgroundColor='#FFCCCC';\" onMouseOut=\"this.style.backgroundColor='".$color."';\" style=\"background-color:".$color." !important;\">";
				for($i=1;$i<=$z;$i++) {
					echo "<td><div style=\"overflow:hidden;height:".($globaledit == '1' ? "28" : "18")."px;\">&nbsp;";
					/* Date output if number is bigger or smaler than */
					if ($relationA[$i] != '') {
						if ($globaledit == '1') {
							// Noch dropdown einbauen
							echo $row->rel1.(($row->rel1 != $row->rel2 AND $row->rel2 != '') ? " (".$row->rel2.")" : "");
						}
						else {
							echo $row->rel1.(($row->rel1 != $row->rel2 AND $row->rel2 != '') ? " (".$row->rel2.")" : "");
						}
					}
					else {
						if ($globaledit == '1' AND $i >= '2') {
							echo "<input onkeyup=\"altered(this,'fff|".$tableid."|".$row->id."|".$feld[$i]."');\" style=\"width:95%;background-color:".$color.";\" type=\"text\" name=\"fde".$tableid."-".$row->id."\" value=\"";
						}
						if (is_numeric($row->$feld[$i]) AND $row->$feld[$i] >= '700000000' AND $row->$feld[$i] < '3000000000') { echo date("Y-m-d",$row->$feld[$i]); }
						else { echo $row->$feld[$i]; }
						if ($globaledit == '1' AND $i >= '2') { echo "\" />"; }
					}
					echo "&nbsp;</div></td>";
				}

				echo "<td style=\"background-color:#FFFFFF !important;\">&nbsp;<a style=\"text-decoration:none;\" href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=edit&wcts=".$starting."&rid=".$row->id."\">[". __('Edit','wct')."]</a></td>".
				     "<td style=\"background-color:#FFFFFF !important;\"><a style=\"text-decoration:none;\" href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&action=del&wcts=".$starting."&rid=".$row->id."\" onclick=\"return chkconfirm()\">[". __('Del','wct')."]</a></td></tr>";
			}
		}
		else {
			printf( "<tr><td colspan=\"10\">".__('No entries found! Please %sreset the filter%s if you think you might missing entries.','wct')."</td></tr>", "<a href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."&wct_sc=1\">", "</a>");
		}

		if ($r >= '2') {
			echo "<tr><td colspan=\"3\">".($globaledit == '1' ? "<input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\">" : "")."</td>".($globaledit == '1' ? "</form>" : "")."
				<form action=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."\" method=\"post\"><td colspan=\"".($i + 1)."\"><div class=\"tablenav\"><div class=\"tablenav-pages\"><span class=\"displaying-num\">".$anz." Elemente</span>
				<span class=\"pagination-links\"><a class=\"first-page".($starting > '29' ? "" : " disabled")."\" title=\"Zur ersten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcttab2=".$_GET['wcttab2']."\">&laquo;</a>
				<a class=\"prev-page".($starting > '29' ? "" : " disabled")."\" title=\"Zur vorherigen Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".($starting > '30' ? ($starting-30) : '0')."&wcttab2=".$_GET['wcttab2']."\">&lt;</a>
				<span class=\"paging-input\"><input class=\"current-page\" title=\"Aktuelle Seite\" name=\"wcts2\" value=\"".(($starting/30)+1)."\" size=\"2\" type=\"text\"> von <span class=\"total-pages\">".$r."</span></span>
				<a class=\"next-page".($starting >= (($r-1)*30) ? " disabled" : "")."\" title=\"Zur nächsten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".($starting >= (($r-1)*30-30) ? (($r-1)*30) : ($starting+30))."&wcttab2=".$_GET['wcttab2']."\">&gt;</a>
				<a class=\"last-page".($starting >= (($r-1)*30) ? " disabled" : "")."\" title=\"Zur letzten Seite gehen\" href=\"".$wctmp.$tableid."&wcttab=content&wcts=".(($r-1)*30)."&wcttab2=".$_GET['wcttab2']."\">&raquo;</a></span></div></div></td></form></tr>";
		}
		else {
			echo ($globaledit == '1' ? "<tr><td colspan=\"10\"><input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></td></tr>" : "")."
			</tbody>".($globaledit == '1' ? "</form>" : "");
		}
		
		echo "</table><br/><form action=\"".$wctmp.$tableid."&wcttab=content&action=new&wcts=".$_GET['wcts']."&wcttab2=".$_GET['wcttab2']."\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"". __('New Entry', 'wct') ."\"></form>";
	break;
}

echo "</div>";

?>
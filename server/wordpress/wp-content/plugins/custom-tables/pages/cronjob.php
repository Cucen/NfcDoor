<?php

if (!isset($wpdb)) { exit; }

$url = "admin.php?page=wct_cronjob&";

if ($_POST['command'] != '') {
	if (stripos($_POST['command'],$wpdb->prefix."wct") !== false) {
		$wpdb->show_errors();
		ob_start();
		if (strpos($_POST['command'],";") !== false) {
			$einzeln = explode(";",$_POST['command']);
			for($x=0;$einzeln[$x]!='';$x++) {
				if (stripos($einzeln[$x],"LIMIT") !== false) {
					$d = $this->explodei("LIMIT",strtoupper($einzeln[$x]));
					$comm = $d[0]."LIMIT 0;";
					unset($d);
				}
				else {
					$comm = stripslashes($einzeln[$x]." LIMIT 0;");
				}
				$wpdb->get_row($comm);
			}
		}
		else {
			$comm = stripslashes($_POST['command']." LIMIT 0;");
			$wpdb->get_row($comm);
		}
		$fehler = ob_get_clean();
		$wpdb->hide_errors();
	}
	else { $fehler = __('Please use only valid SQL Statements','wct'); }
}

if ($_GET['action'] == 'del') {
	$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_cron` WHERE `id`='".mres($_GET['wct_cid'])."' LIMIT 1");
}
elseif ($_GET['action'] == 'create') {
	if ($_POST['command'] != '') {
		$af = $wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_cron` SET `schedule`='".mres($_POST['schedule'])."', `command`='".mres(stripslashes($_POST['command']))."', active='".mres($_POST['activated'])."', error='".mres(str_replace(" LIMIT 0","",$fehler))."';");
		$_GET['wct_cid'] = $wpdb->insert_id;
	}
	$_GET['action'] = 'edit';
}
elseif ($_GET['action'] == 'save') {
	if ($_POST['command'] != '') {
		$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_cron` SET `schedule`='".mres($_POST['schedule'])."', `command`='".mres(stripslashes($_POST['command']))."', active='".mres($_POST['activated'])."', error='".mres(str_replace(" LIMIT 0","",$fehler))."' WHERE `id`='".mres($_GET['wct_cid'])."' LIMIT 1;");
	}
	$_GET['action'] = 'edit';
}

switch ($_GET['action']) {
	case 'edit':
		echo "<script type=\"text/javascript\">
		function chkconfirm() {
			var answer = confirm('". __ ('Do you really want to do this?', 'wct')."');
			if (answer) { return true; } else { return false; }
		}
		</script><h3>".__('Edit Cronjob','wct')."</h3><form action=\"".$url;
		if ($_GET['wct_cid'] != '') {
			$qry = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct_cron` WHERE `id`='".mres($_GET['wct_cid'])."' LIMIT 1");
			echo "wct_cid=".$_GET['wct_cid']."&action=save";
		}
		else {
			unset($qry);
			echo "wct_cid=".$_GET['wct_cid']."&action=create";
		}
		echo "\" method=\"POST\"><table>
		<tr><td><b>".__('Schedule','wct').":</b></td><td><select name=\"schedule\">
			<option value=\"h\"".((isset($qry) AND $qry->schedule == 'h') ? " selected" : "").">".__('hourly','wct')."</option>
			<option value=\"t\"".((isset($qry) AND $qry->schedule == 't') ? " selected" : "").">".__('twice a day','wct')."</option>
			<option value=\"d\"".((!isset($qry) OR (isset($qry) AND $qry->schedule != 'h' AND $qry->schedule != 't')) ? " selected" : "").">".__('daily','wct')."</option>
		</select></td></tr>
		<tr><td valign=\"top\"><b>SQL ".__('Command','wct').":</b></td><td><textarea name=\"command\" cols=\"75\" rows=\"5\">".(isset($qry) ? stripslashes($qry->command) : "")."</textarea></td></tr>
		<tr><td valign=\"top\"><b>".__('Status','wct').":</b></td><td><input type=\"radio\" name=\"activated\" value=\"1\"".((!isset($qry) OR (isset($qry) AND $qry->active == '1')) ? " checked" : "").">".__('Active','wct')." <input type=\"radio\" name=\"activated\" value=\"1\"".((isset($qry) AND $qry->active != '1') ? " checked" : "").">".__('Passive','wct')."</td></tr>";
		if (isset($qry) AND $qry->error != '') {
			echo "<tr><td valign=\"top\"><b>SQL ".__('Error','wct').":</b></td><td><font color=\"#FF0000\">".$qry->error."</font></td></tr>";
		}
		echo "</table><input type=\"submit\" name=\"doit\" value=\"". __('Save all Changes', 'wct') ."\"></form>";

		if (!isset($qry)) {
			printf( "<br/><br/>".__('Example: %s This code would set all Entries passive where the field date is older than the yesterday!', 'wct'), "<input type=\"text\" size=\"77\" value=\"UPDATE `blog_wct1` SET `status`='passive' WHERE `date`<='time()-1d';\" readonly><br/>");
		}
		else {
			echo "<br/><br/>".__('Command which would run:','wct')." <input type=\"text\" size=\"90\" value=\"".$this->sqldatefilter(stripslashes($qry->command))."\" readonly><br/>";
		}
	break;

	default:
		echo "<script type=\"text/javascript\">
		function chkconfirm() {
			var answer = confirm('". __ ('Do you really want to do this?', 'wct')."');
			if (answer) { return true; } else { return false; }
		}
		</script><h3>".__('Cronjob','wct')."</h3>";
		$qry = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_cron` ORDER BY `nextrun` ASC");
		if (count($qry) >= '1') {
			echo "<table><tr><td width=\"115\"><b>Nextrun</b></td><td width=\"444\"><b>Command</b></td><td><b>Status</b></td><td></td><td></td></tr>";
			foreach ($qry as $row) {
				if ($color == "#EEEEEE" ) { $color = "#DDDDDD"; } else { $color = "#EEEEEE"; }
				echo "<tr onMouseOver=\"this.style.backgroundColor='#FFCCCC';\" onMouseOut=\"this.style.backgroundColor='".$color."';\" style=\"background-color:".$color." !important;\"><td>";
				if ($row->active == '0') { echo __('Passive','wct'); } else { echo date('Y-m-d H:i',$row->nextrun); }
				$command = stripslashes(str_replace(array("\r","\n"),"",$row->command));
				echo "</td><td>".(strlen($command) >= '80' ? trim(substr($command,0,77))."..." : $command)."</td><td><font color=\"".($row->error != '' ? "#FF0000\">".__('Error','wct') : "#008000\">".__('Good','wct'))."</font></td>";
				echo "<td style=\"background-color:#FFFFFF !important;\">&nbsp;<a style=\"text-decoration:none;\" href=\"".$url."wct_cid=".$row->id."&action=edit\">[". __('Edit','wct')."]</a></td>".
				     "<td style=\"background-color:#FFFFFF !important;\"><a style=\"text-decoration:none;\" href=\"".$url."wct_cid=".$row->id."&action=del\" onclick=\"return chkconfirm()\">[". __('Del','wct')."]</a></td></tr>";
			}
			echo "</table>";
		}
		echo "<br/><form action=\"".$url."action=edit\" method=\"POST\"><input type=\"submit\" name=\"doit\" value=\"". __('New Entry', 'wct') ."\"></form>";

	break;
}

?>
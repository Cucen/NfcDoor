<?php

if ($_POST['rs'] == '1') {
	// Update Rights of the Form

	if ($_POST['write'] == '1') { $a = '1'; } else { $a = '2'; }
	if ($_POST['create'] == '1') { $a .= '1'; } else { $a .= '2'; }
	if ($_POST['delete'] == '1') { $a .= '1'; } else { $a .= '2'; }
	if ($_POST['read'] == '1' OR substr($a,0,1) == '1' OR substr($a,2,1) == '1') { $a = '1'.$a; } else { $a = '2'.$a; }
	if ($_POST['htmlview'] == '1') { $htmlview = '1'; } else { $htmlview = '0'; }
	if ($_POST['smail'] == '1') { $smail = '1'; } else { $smail = '0'; }

	foreach($_POST as $var => $wert) {
		if ((substr($var,0,(5 + strlen($_POST['wct_stable'])))) == ("feld".$_POST['wct_stable']."_") AND $wert == '1') {
			$feld .= rtrim(substr($var,(5 + strlen($_POST['wct_stable'])),1024)).",";
		}
	}
	if ($feld != '') { $feld = substr($feld,0,strlen($feld)-1); }

	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_form` SET `name`='".mres($_POST['wct_name'])."', `smail`='".$smail."', `htmlview`='".$htmlview."', `r_table`='".mres($_POST['wct_stable'])."', `rights`='".$a."', `r_filter`='".mres($_POST['filter'])."', `r_fields`='".mres($feld)."' WHERE `id`='".mres($formid)."' LIMIT 1;");
}

elseif ($_POST['ts'] == '1') {
	// Update of the Table Setup
	foreach($_POST as $var => $wert) {
		if (substr($var,0,5) == "feld_" AND $wert == '1') {
			$feld .= "<td>{".rtrim(substr($var,5,1024))."}</td>";
		}
	}
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_form` SET `t_setup`='".mres($feld)."' WHERE `id`='".mres($formid)."' LIMIT 1;");
}

elseif ($_POST['es'] == '1') {
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_form` SET `e_setup`='".mres($_POST['content'])."' WHERE `id`='".mres($formid)."' LIMIT 1;");
}

?>
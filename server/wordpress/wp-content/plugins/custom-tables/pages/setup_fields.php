<?php

if ($this->prem_chk() == true) {
	$possible = array(
		"bit" => "1",
		"int" => "1",
		"bigint" => "1",
		"float" => "2",
		"double" => "2",
		"decimal" => "2",
		"char" => "1",
		"varchar" => "1",
		"longtext" => "0",
		"binary" => "1",
		"varbinary" => "1",
		"blob" => "0",
		"longblob" => "0",
		"date" => "0",
		"datetime" => "0",
		"timestamp" => "0"
	);

	switch ($_GET['action']) {
		case 'new':
		
			$java = "function changeoptions(name) {
			var elSelzv = document.getElementById('definition').options[document.getElementById('definition').selectedIndex].value;
			";
			
			echo "<h3>".__('Create new DB Field definition','wct')."</h3>
			<form method=\"POST\" action=\"admin.php?page=wct_fields&action=add\">
			<table><tr><td><b>".__('Name','wct').":</b></td><td><input type=\"text\" name=\"fieldname\" value=\"\" /></td></tr>
			<tr><td><b>".__('Definition','wct').":</b></td><td><select onchange=\"changeoptions();\" name=\"definition\" id=\"definition\"><option value=\"\"></option>";
			foreach($possible as $e => $f) {
				echo "<option value=\"".$e."\">".$e."</option>";
				$java .= "
				if (elSelzv == '".$e."') { 
					document.getElementById('defa').style.visibility = '".($f >= '1' ? "visible" : "hidden")."';
					document.getElementById('defa').style.display = '".($f >= '1' ? "inline" : "none")."';
					document.getElementById('defb').style.visibility = '".($f >= '2' ? "visible" : "hidden")."';
					document.getElementById('defb').style.display = '".($f >= '2' ? "inline" : "none")."';
				} ";
			}
			$java .= "}";
			echo "</select>(<input style=\"visiblity:hidden;display:none;\" type=\"text\" size=\"4\" name=\"defa\" id=\"defa\"><div id=\"defb\" style=\"visiblity:hidden;display:none;\">,<input type=\"text\" size=\"4\" name=\"defb\"></div>)</td></tr></table><script>".$java."</script>
			<input class=\"button-primary\" type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ." \"></form>";
		break;
		
		case 'add':
			$fieldname = preg_replace("/[^A-Za-z]/", "", $_POST['fieldname']);
			$def = stripslashes($_POST['definition']);		

			$defa = preg_replace("/[^0-9]/", "", $_POST['defa']);
			$defb = preg_replace("/[^0-9]/", "", $_POST['defb']);
			
			if ($fieldname == '') { $error = __('No Name or only special characters delivered','wct'); }
			elseif ($_POST['definition'] == '') { $error = __('No field definition delivered','wct'); }
			elseif ($possible[$def] == '') { $error = __('Unknown definition delivered','wct'); }
			elseif (($possible[$def] == '1' AND $defa != '') AND ($possible[$def] == '2' AND ($defa != '' OR $defb != ''))) { $error = __('Missing sub-definitions','wct'); }
			else {
				$deft = $def;
				if ($possible[$def] >= '1') {
					$deft .= "(".$defa;
					if ($possible[$def] == '2') { $deft .= ",".$defb; }
					$deft .= ")";				
				}
				$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` SET `name`='".mres($fieldname)."', `definition`='".mres($deft)."', special='0';");
				echo __('Changes successfully saved', 'wct');
			}
			echo $error;

		case 'del':
			if ($_GET['did'] != '') {
				$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_fields` WHERE `id`='".mres($_GET['did'])."' AND `special`='0' LIMIT 1;");
				echo __('Changes successfully saved', 'wct');
			}

		default:
			echo "<h3>".__('Own DB Fields','wct')."</h3>";
			$abfrage = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_fields`;");
			if (count($abfrage) >= '1') {
				echo "<table>
				<tr><td width=\"150\"><b>".__('Name','wct').":</b></td><td width=\"150\"><b>".__('Definition','wct').":</b></td><td width=\"100\"></td></tr>";
				foreach($abfrage as $row) {
					if ($color == "#E0E0E0") { $color = "#FFFFFF"; } else { $color = "#E0E0E0"; }
					echo "<tr bgcolor=\"".$color."\"><td>".$row->name."</td><td>".$row->definition."</td><td>".($row->special != '1' ? "<a href=\"admin.php?page=wct_fields&action=del&did=".$row->id."\">".__('DEL','wct')."</a>" : "")."</td></tr>";
				}
				echo "</table><a href=\"admin.php?page=wct_fields&action=new\">".__('Add new','wct')."</a>";
			}
		break;
	}	
}


?>
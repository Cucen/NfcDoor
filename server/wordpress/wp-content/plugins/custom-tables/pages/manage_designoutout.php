<?php

if ($_GET['ddel'] != '') {
	$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$tableid."' AND `id`='".mres($_GET['ddel'])."' LIMIT 1;");	
}

if ($_GET['dnew'] == '1') {
	$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_setup` SET `name`='".mres($_POST['newn'])."', `table_id`='".$tableid."';");
}

echo "<script type=\"text/javascript\">
		function chk() {
			if (document.getElementById('newn').value == \"\") {
				alert('". __ ('Please give the new Design a name', 'wct')."!');
				return false;
			}
			return true;
		}
		function chkconfirm() {
			var answer = confirm('". __ ('Do you really want to do this?', 'wct')."');
			if (answer) { return true; } else { return false; }
		}
		</script><h3>".__('Outputdesigns','wct')."</h3>
	<table width=\"180\"><tr><td><b>ID</b></td><td><b>Name</b></td><td></td></tr>
	<tr><td>0</td><td>Default</td><td></td></tr>";
$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$tableid."';");
if (count($qry) >= '1') {
	foreach ($qry as $row) {
		echo "<tr><td>".$row->id."</td><td>".$row->name."</td><td></td><td><a style=\"text-decoration:none;\" href=\"".$wctmp.$tableid."&wcttab=sdo&ddel=".$row->id."\" onclick=\"return chkconfirm()\">[". __('Del','wct')."]</a></td></tr>";
	}
}
echo "</table>
<h3>".__('New Entry','wct')."</h3><form onSubmit=\"return chk()\" action=\"admin.php?page=".$_GET['page']."&wcttab=sdo&dnew=1\" method=\"POST\">
<b>".__('Name','wct').":</b> <input type=\"text\" id=\"newn\" name=\"newn\" value=\"\"> <input type=\"submit\" name=\"t\" value=\"".__('Save Entry','wct')."\"></form>";

?>
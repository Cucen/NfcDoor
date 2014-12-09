<?php

echo "<div style=\"float:left;width:350px;\"><h2>". __('Edit Table', 'wct') . "</h2>";
$tablename = $wpdb->get_row("SELECT `overlay`,`headerline`,`sheme` FROM `".$wpdb->prefix."wct_list` WHERE `id`='0' LIMIT 1;");
if(count($tablename) == '0') {
	$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` VALUES (0,'Archive','','<td>[date]</td><td>[title]</td><td>[comment_count]</td>','','<b>[date] » [title]</b><br/>\r\n[content]','0','1','1','Datum,Artikel,Kommentare','date,title,comment_count',NULL,'','','post_date','DESC');");
	$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `id`=0 WHERE `name`='Archive' LIMIT 1;");
}

echo "<form action=\"admin.php?page=".$_GET['page']."\" method=\"post\" onSubmit=\"return validate(this)\" name=\"wctform\">
<input type=\"hidden\" name=\"viptID\" value=\"0\">
<input type=\"checkbox\" name=\"wctheaderline\" value=\"1\" id=\"wctheaderline\"";
if ($tablename->headerline == '1') { echo " checked"; }
echo "> ". __('Show Headerline','wct')."<br/><input type=\"checkbox\" name=\"wctoverlay\" value=\"1\" id=\"wctoverlay\"";
if ($tablename->overlay == '1') { echo " checked"; }
echo "> ". __('Overlay Function','wct')."<br/><select name=\"wctsheme\"><option value=\"0\"";
if ($tablename->sheme != '1') { echo " selected"; }
echo ">". __('Black','wct') ."</option><option value=\"1\"";
if ($tablename->sheme == '1') { echo " selected"; }
echo ">". __('White','wct') ."</option></select>". __('color for activated sort buttons', 'wct')."<br/>
<input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\" class=\"button-primary\" /></form><br/>";

echo "</div><div><h2>" . __('Instructions', 'wct') . "</h2>". __('The article archive DB cannot be modified, because the data will be get from the article db itself in realtime when needed, cached if possible.<br/>You can only adjust the style and output of the table here.','wct')."<br/><br/>";

printf( __('This Table can be added with %s or %s to the page.', 'wct')."</br>", '<input type=\'text\' value=\'[wctarchive limit="50"]\' size=\'27\' readonly/>', '<input type=\'text\' value=\'[wctarchive]\' size=\''.$l.'\' readonly/>');
printf( __('The Datelist for the archive can be added with %s to the page.', 'wct'), '<input type=\'text\' value=\'[wctdate]\' size=\'9\' readonly/>');
echo "</div";

?>
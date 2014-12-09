<?php

if ($_POST['submit'] != '') {
	$this->settings['ads_code'] = trim($_POST['adcode']);
	$this->settings['ads_line'] = trim($_POST['adline']);
	$this->settings['ads_active'] =($_POST['adcode'] != '' AND $_POST['adsa'] == '1' ? '1' : '0' );

	update_option('wuk_custom_tables', $this->settings);
	$this->getOptions();
	echo "<br/><b>".__('Changes successfully saved', 'wct')."</b><br/><br/>";
}

if ($this->settings['ads_line'] == '') { $this->settings['ads_line'] = '10'; }

echo "<h3>".__('Advertisment','wct')."</h3>
<form action=\"admin.php?page=".$_GET['page']."\" method=\"post\"  name=\"wctform\">
<input type=\"checkbox\" name=\"adsa\" value=\"1\"".($this->settings['ads_active'] == '1' ? ' checked' : '')." /> <b>".__('Ads activated','wct')."</b><br/><br/>
<b>Ad Code:</b><br/><textarea name=\"adcode\" rows=\"10\" cols=\"80\">".stripslashes($this->settings['ads_code'])."</textarea><br/><b>";

printf( __('Show Code at %s line within the table', 'wct'), '<input type="text" name="adline" value="'.(integer)$this->settings['ads_line'].'" size="3" />');

echo "</b><br/><input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\" /></form>";

?>
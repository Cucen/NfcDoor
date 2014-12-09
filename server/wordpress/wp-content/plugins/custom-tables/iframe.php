<?php

if ($_GET['key'] != '' AND !preg_match('/^[a-f0-9]{32}$/', $_GET['key'])) { $_GET['key'] = ''; }

if ($_GET['s'] == '1') {
	echo "<h3>CSV Importer</h3>
	<b>Attention:</b> This Function is external hosted by web updates kmu.<br/>
	If you want to import unknown CSV Files, please <a target=\"iframe\" href=\"http://wuk-custom-tables.com/wct_csvumwandler.php?key=sDESsk-l2&key2=".$_GET['key']."\">click here</a>.<br/>
	<br/>";
	if ($_GET['key'] == '') {
		echo "Limits:<UL>
			<li>Only 30 Colums can be imported</li>
			<li>Only 1'000 Rows can be imported</li>
		</UL>For no limits please buy Premium Licence.";
	}
}

?>
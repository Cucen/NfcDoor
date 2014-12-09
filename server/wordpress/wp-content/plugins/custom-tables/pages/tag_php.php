<?php

// do not allow this page without the load of wordpress!
if (WCT_PHP_ON !== true) { exit; }

$zusatz = "";

if (strpos($content,"strftime") !== false) {
	if(!function_exists('qtrans_getLanguage')){function qtrans_getLanguage(){}}

	if (qtrans_getLanguage() != '') {
		$lang = substr(qtrans_getLanguage(),0,2);
	}
	else {
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
	}

	if(!ini_get('safe_mode')){
		if ($lang == "en") {
			$zusatz = "putenv('LC_ALL=en_US.utf8');\nsetlocale(LC_ALL, 'en_US.utf8');\n";
		}
		elseif($lang == "de"){
			$zusatz = "putenv('LC_ALL=de_DE.utf8');\nsetlocale(LC_ALL, 'de_DE.utf8');\n";
		}
	}
}

$befehl = str_replace(array("&gt;","&lt;","<br/>","&#8216;","&#8220;","return "),array(">","<","","'","\"","echo "),$content);
if (strpos($befehl,";") === false) { $befehl .= ";"; }
if (stripos($befehl,"echo ") === false AND stripos($befehl,"return ") === false) { $befehl = "echo ".$befehl; }

global $userdata, $wpdb;
get_currentuserinfo();
if (is_object($userdata)) {
	$preset = $wpdb->prefix."capabilities";
	if ($userdata->{$preset}['administrator'] == '1' AND $userdata->user_level == '0') { $userdata->user_level = '10'; }
	$username = $userdata->data->user_login;
}

// eval is used for the wctphp smarttag
eval($zusatz."\nob_start();\n".str_replace("USERNAME",$username,$befehl)."\n\$out = ob_get_clean();");

?>
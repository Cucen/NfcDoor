<?php

/* Generate Permalink without page_id or other IDs */
$pos = strpos(get_permalink(),"?");
if ($pos !== FALSE) {
	$permalink = trim(substr(get_permalink(),0,$pos));
}
else {
	$permalink = get_permalink();
}

/* Generate Values to attach */
$pos = strpos($_SERVER[REQUEST_URI],"?");
if ($pos !== FALSE) {
	$URI = str_replace(array("_","%20","?","&&"),array("xxooxx","xxxoooxxx","&","&"),trim(substr($_SERVER[REQUEST_URI],$pos,2048)));
	if (substr($URI,strlen($URI)-1,strlen($URI)) != "&") { $URI .= "&"; }
}
else {
	$URI = '';
}

/* Generate finish URL */
$url = str_replace(array("xxooxx","xxxoooxxx"),array("_","%20"),preg_replace($arrayA,$arrayB,$permalink.$URI));

$pos = strpos($url, "&");
if ($pos !== false) { $url = substr_replace($url, "?", $pos, 1); }
if (strpos($url,"?") === false) { $url .= "?"; } elseif (substr($url, -1) != "?") { $url .= "&"; }


?>
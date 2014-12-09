<?php

$url = $this->generate_pagelink(array("/[&?]+".$salt."wctdrof=.*&/","/[&?]+".$salt."wctdrop=.*&/","/[&?]+wctstart=[0-9]*/"),array("","&",""));

$out2 = "<script type=\"text/javascript\">function selector".$salt.$jsname."(field,fieldb) {".
		"var selection = document.getElementById('".$salt."wctdrop_' + field).options[document.getElementById('".$salt."wctdrop_' + field).selectedIndex].value;".
		"location.href= '".$url.$salt."wctdrof=' + fieldb + '&".$salt."wctdrop=' + selection;".
	"}</script>";

?>

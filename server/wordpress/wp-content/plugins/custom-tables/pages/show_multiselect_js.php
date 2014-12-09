<?php

// http://www.erichynds.com/jquery/jquery-ui-multiselect-widget/

$url = $this->generate_pagelink(array("/[&?]+".$salt."wctmudro(p|f)=.*&/","/[&?]+wctstart=[0-9]*/"),array("&",""));
$out2 = "<script type=\"text/javascript\">".
"jQuery(document).ready(function(){jQuery(\"#".$salt."wctmudrop_".$field.$feldnameaddon."\").multiselect({".
"	checkAllText:\"".__('Check all','wct')."\",".
"	uncheckAllText:\"".__('Uncheck all','wct')."\",".
"	minWidth:".$width.",".
"	close: function(event, ui) {".
"		var values = jQuery(\"#".$salt."wctmudrop_".$field.$feldnameaddon."\").val();".
"		var selection = values.join(\",\");".
"		location.href= '".$url.$salt."wctmudrof=".$field."&".$salt."wctmudrop=' + selection;".
"	}";
if ($maintext != '') { $out2 .= ",noneSelectedText:\"".$maintext."\",selectedText:\"".$maintext."\",selectedList:false"; }
if ($showheader != 'true' AND $showheader != '') {  $out2 .= ",header:false"; }
$out2 .= "});});</script>";

?>
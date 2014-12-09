<?php

$fp = fopen(plugin_dir_path( __FILE__ ).'../readme.txt',"r");
$inhalt = fread($fp,filesize(plugin_dir_path( __FILE__ ).'../readme.txt'));
fclose($fp);
$ch = explode("== Changelog ==",$inhalt);

$changelog = "<div><h2>Changelog</h2>".preg_replace("/\* (.*?)\n/","<li style=\"margin:0 0;\">$1</li>",str_replace(array("<",">"),array("&lt;","&gt;"),$ch[1]));
$changelog = preg_replace("/\[Bugfix\]/","<span style=\"background-color: #FFC6C6;\"><i>[Bugfix]</i>",$changelog);
$changelog = preg_replace("/\[Feature\]/","<span style=\"background-color: #D9FFD9;\"><i>[Feature]</i>",$changelog);
$changelog = preg_replace("/\[Change\]/","<span style=\"background-color: #FFFFD5;\"><i>[Change]</i>",$changelog);
$changelog = preg_replace("/\[Premium Feature\]/","<span style=\"background-color: #D9D9FF;\"><i>[Premium Feature]</i>",$changelog);
$changelog = preg_replace("/= (.*?) =/","</span></lu><br/><strong>= $1 =</strong><lu>",$changelog);
$changelog = preg_replace("/`(.*?)`/","<span style=\"background-color: #E1E1E1;\">$1</span>",$changelog);

$changelog = preg_replace("/\[(.*?)\]\((.*?)\"(.*?)\"\)/","<a href=\"$2\" rel=\"external nofollow\" alt=\"$3\">$1</a>",$changelog);

echo str_replace(
	array("\r","\n","</h2></span></lu><br/>"),
	array("","","</h2>"),
	$changelog)."</lu>";

?>

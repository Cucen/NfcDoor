<?php

if (substr($field,0,3) == "GET") {
	$field = $_GET[rtrim(substr($field,3,1024))];
}
elseif (substr($field,0,4) == "POST") {
	$field = $_POST[rtrim(substr($field,4,1024))];
}
elseif (substr($field,0,7) == "REQUEST") {
	$field = $_POST[rtrim(substr($field,7,1024))];
}

if ($check == "==") {
	if($field == $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == "!=") {
	if($field != $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == ">") {
	if($field > $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == ">=") {
	if($field >= $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == "<") {
	if($field < $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == "<=") {
	if($field <= $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == "===") {
	if($field === $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}
elseif ($check == "!==") {
	if($field !== $var) { $out = $content; }
	elseif ($else != '') { $out = $else; }
}

?>
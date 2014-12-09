<?php

$url = $this->generate_pagelink(array("/[&?]+wct(s|sf|sa)=.*/","/[&?]+wctstart=[0-9]*/"),array("",""));

/* cache hack because of issue, see trac http://core.trac.wordpress.org/ticket/16541 */
ob_start();
get_search_form();
$out = ob_get_clean();

if ($text == 'sss') { $text = __('Search', 'wct'); }
if ($text != '') { $text = "<b>".$text.":</b>&nbsp;"; }

// Change the Form for our functionality

unset($zusatz);
if ($_GET['page_id'] != '') {
	$zusatz .= "<input type=\"hidden\" name=\"page_id\" value=\"".$_GET['page_id']."\" />";
}
if ($exact != '') {
	$zusatz .= "<input type=\"checkbox\" name=\"exact\" value=\"1\" ".($_GET['exact'] == '1' ? " checked" : "")."/> ". __('Exact search','wct');
}

$out = str_replace(
		array("name=\"search\"","</form>","name=\"s\"","value=\"\"","<div class=\"search\">"),
		array("name=\"wctsa\"","<input type=\"hidden\" value=\"".$felder."\" name=\"wctsf\" />".$zusatz."</form>","name=\"wcts\" class=\"wct-search\"","value=\"".$_GET['wcts']."\"","<div class=\"search\">".$text),
		preg_replace("/action=\"(.*?)\"/","action=\"".$url."\"",$out)
	);

?>
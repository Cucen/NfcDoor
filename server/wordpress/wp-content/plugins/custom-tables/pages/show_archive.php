<?php

$out = wp_cache_get( 'wct_archive' , 'wct');
if ($out == false) {

	$qry = $wpdb->get_results("SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month, post_title,guid FROM `".$wpdb->prefix."posts` WHERE post_type='post' AND  post_status='publish' ORDER BY year DESC, month DESC;");
	foreach ($qry as $row) {
		if ($last != $row->year.$row->month) {
			if ($last != '') { $out .= "</UL>"; }
			$out .= "<h4 class=\"wctarchiveheader\" id=\"a_".$row->year."_".$row->month."\">".date("F Y",mktime(0, 0, 0, $row->month, '5', $row->year))."</h4><UL class=\"wctarchiveul\">";
			$last = $row->year.$row->month;
		}
		$out .= "<li class=\"wctarchiveli\"><a class=\"wctarchivea\" href=\"".$row->guid."\">".$row->post_title."</a></li>";
	}
	wp_cache_set( 'wct_archive', $out, 'wct', $this->settings['wct_cachetime']);
}

?>
<?php

$out = wp_cache_get( 'wct_date' , 'wct');
if ($out == false) {

	$qry = $wpdb->get_results("SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month FROM `".$wpdb->prefix."posts` WHERE post_type='post' AND  post_status='publish' ORDER BY year DESC, month ASC;");
	foreach ($qry as $row) {
		$y[$row->year]['n'] = $row->year;
		$y[$row->year][$row->month] = '1';
	}

	/* list years befor */
	$y = array_reverse($y);

	/* list dates */
	foreach ($y as $row) {
		$out .= "<b>".$row['n'].":</b>";
		for ($x=1;$x<=12;$x++) {
			$out .= "&nbsp;";
			if ($row[$x] == '1') { $out .= "<a class=\"wctarchivea\" href=\"#a_".$row['n']."_".$x."\">"; }
			$out .= date("M",mktime(0, 0, 0, $x, '5', $row->year));
			if ($row[$x] == '1') { $out .= "</a>"; }
		}
		$out .= "<br/>";
	}
	wp_cache_set( 'wct_date', $out, 'wct', $this->settings['wct_cachetime']);
}

?>
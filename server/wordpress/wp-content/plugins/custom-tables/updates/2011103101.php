<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` VALUES (0,'Archive','','<td>{date}</td><td>{title}</td><td>{comment_count}</td>','','<b>{date} » {title}</b><br/>\r\n{content}','0','1','1','Datum,Artikel,Kommentare','date,title,comment_count','','','post_date','DESC');");
$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `id`=0 WHERE `name`='Archive' LIMIT 1;");
$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `name`='Archive' AND `id`!='0';");

$qry = $wpdb->get_results("SELECT `id` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0';");
if (count($qry) >= '1') {
	foreach ($qry as $row) {
		$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".$row->id."` ADD COLUMN `status` enum('active','draft','passive') NOT NULL DEFAULT 'active' AFTER `id`;");
	}
}

?>
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `definition` varchar(32) DEFAULT NULL,
  `special` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100;");

$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (1,'varchar(32)','varchar(32)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (2,'varchar(64)','varchar(64)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (3,'varchar(128)','varchar(128)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (4,'smallint(6)','smallint(6)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (5,'date','int(10)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (6,'int(11)','int(11)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (7,'text','text','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (8,'float(8,2)','float(8,2)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (9,'enum','enum','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (10,'set','set','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (11,'picture','varchar(160)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (12,'varchar(254)','varchar(254)','1');");
$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_fields` VALUES (13,'relationship','int(12)','1');");

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_fields` ADD UNIQUE INDEX `def` (`definition`(32));");
 
$qry = $wpdb->get_results("SELECT `id` FROM `".$wpdb->prefix."wct_list` WHERE `id` != '0';;");
if (count($qry) >= '1') {
	foreach ($qry as $row) {
		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		if (strpos($array['Create Table'],"varchar(160)")) {
			preg_match_all("/`(.*)` varchar\(160\)/",$array['Create Table'],$treffer);
			foreach($treffer[1] as $ee) {
				$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct".$row->id."` CHANGE COLUMN `".$ee."` `".$ee."` varchar(254) NULL DEFAULT NULL;");				
			}
		}
	}
}


?>
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `t_setup` text DEFAULT NULL,
  `e_setup` text DEFAULT NULL,
  `r_fields` text DEFAULT NULL,
  `r_table` text DEFAULT NULL,
  `r_filter` text DEFAULT NULL,
  `rights` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$qry = $wpdb->get_results("SELECT `id` FROM `".$wpdb->prefix."wct1` LIMIT 1");
if (count($qry) == '1') {
	$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct_list` VALUES ('1','Demo DB','".md5('wcf'.time())."','<td>{Kategory}</td><td>{City}</td><td>{Companyname}</td>','<strong>Category:</strong> {Kategory}<br/><strong>Name:</strong> {Companyname}<br/><strong>Street:</strong> {Street}<br/><strong>City:</strong> {PoBox} {City}<br/><strong>ID:</strong> <em>{id}</em><br/>[BACK]','<em>Overlay Demo</em><br/><br/><strong>{Companyname}</strong><br/>{Street}<br/>{PoBox} {City}','0','1','1','[wctselect field=\"Kategory\" maintext=\"Category\"],City,Company Name','Kategory,City,Companyname','[wctsearch felder=\"*\"]\nPlease find here the list of all companies:','Note: This list is on the internet available for all with number and mail, I take only not so high private data from it.','id','ASC');");
}

?>
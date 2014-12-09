<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT 'Default',
  `table_id` int(11) NOT NULL,
  `t_setup` text,
  `e_setup` text,
  `o_setup` text,
  `sheme` enum('0','1') NOT NULL DEFAULT '0',
  `overlay` enum('0','1') NOT NULL DEFAULT '0',
  `headerline` enum('0','1') NOT NULL DEFAULT '1',
  `header` text,
  `headersort` text,
  `vortext` text,
  `nachtext` text,
  `sort` varchar(32) NOT NULL DEFAULT 'id',
  `sortB` enum('ASC','DESC') NOT NULL DEFAULT 'ASC',
  `searchaddon` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

?>
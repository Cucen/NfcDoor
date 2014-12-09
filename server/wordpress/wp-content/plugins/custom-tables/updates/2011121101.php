<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule` enum('h','t','d') NOT NULL DEFAULT 'd',
  `command` text NOT NULL,
  `nextrun` int(11) NOT NULL DEFAULT 0,
  `error` text DEFAULT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

?>
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list` ADD COLUMN `searchaddon` varchar(120) NULL DEFAULT NULL;");

?>
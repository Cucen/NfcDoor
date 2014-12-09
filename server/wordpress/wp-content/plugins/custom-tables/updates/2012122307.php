<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE  `".$wpdb->prefix."wct_list` ADD COLUMN `globaledit` enum('0','1') DEFAULT '0';");

?>

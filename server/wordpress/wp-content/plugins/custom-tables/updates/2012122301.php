<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list`
    ADD COLUMN `dl` enum('0','1','2','3') NOT NULL DEFAULT '0';");

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_setup`
    ADD COLUMN `dl` enum('0','1','2','3') NOT NULL DEFAULT '0';");

?>
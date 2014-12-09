<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list`
    ADD COLUMN `editlink` varchar(64) DEFAULT NULL;");

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_setup`
    ADD COLUMN `editlink` varchar(64) DEFAULT NULL;");

?>
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list`
    ADD COLUMN `rowcount` int(2)  DEFAULT '1';");

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_setup`
    ADD COLUMN `rowcount` int(2)  DEFAULT '1';");

?>
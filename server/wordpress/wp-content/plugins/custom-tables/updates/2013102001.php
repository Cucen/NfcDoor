<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_list`
    ADD COLUMN `menu` varchar(32) NULL DEFAULT NULL;");

?>
  
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE  `".$wpdb->prefix."wct_relations` ADD COLUMN `z_field2` varchar(32) NULL DEFAULT NULL;");

?>

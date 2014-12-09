<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE  `".$wpdb->prefix."wct_form` ADD COLUMN `toapprove` enum('0','1') DEFAULT '1';");

?>

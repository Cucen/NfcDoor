<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_form`
  ADD COLUMN `htmlview` enum('0','1') NOT NULL DEFAULT '0',
  ADD COLUMN `smail` enum('0','1') NOT NULL DEFAULT '1';");

$wpdb->get_row("UPDATE `".$wpdb->prefix."wct_list` SET `id`=0 WHERE `name`='Archive' LIMIT 1;");
$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct_list` WHERE `name`='Archive' AND `id` != '0';");

?>
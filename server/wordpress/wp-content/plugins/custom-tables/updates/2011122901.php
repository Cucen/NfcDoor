<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_setup` ADD UNIQUE INDEX `name` (`name`(32));");

?>
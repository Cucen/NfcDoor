<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_relations` (
  ADD UNIQUE INDEX `singlerel` (`s_table`,`t_table`);");

?>

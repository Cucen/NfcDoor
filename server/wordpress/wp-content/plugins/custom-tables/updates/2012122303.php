<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("CREATE TABLE `".$wpdb->prefix."wct_relations` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_table` int(11) NOT NULL,
  `s_field` varchar(32)  NOT NULL,
  `t_table` int(11)  NOT NULL,
  `t_field` varchar(32)  NOT NULL,
  `z_field` varchar(32)  NOT NULL,
  PRIMARY KEY (`r_id`)
);");

?>
<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET t_setup = replace(t_setup, '[', '{');");
$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET t_setup = replace(t_setup, ']', '}');");

$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET o_setup = replace(o_setup, '[', '{');");
$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET o_setup = replace(o_setup, ']', '}');");

$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET e_setup = replace(e_setup, '[', '{');");
$wpdb->get_row("UPDATE ".$wpdb->prefix."wct_list SET e_setup = replace(e_setup, ']', '}');");

?>
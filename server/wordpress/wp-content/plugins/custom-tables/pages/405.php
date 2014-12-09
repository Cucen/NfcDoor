<?php

do_action('admin_page_access_denied');
wp_die( __('You do not have sufficient permissions to access this page.') );

?>
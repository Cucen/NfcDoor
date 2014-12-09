<?php
$out = '1';
$title = '[Premium Support] ';

$addon = '<tr>
			<th><label for="support_payed">Paypal Transaction ID:</label></th>
			<td><input id="support_paypal" type="text" name="paypal" value="" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_wp_login"><acronym title="WordPress">WP</acronym> Admin login:</label></th>
			<td><input id="support_wp_login" type="text" name="wp_login" value="'.$current_user->user_login.'" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_wp_password"><acronym title="WordPress">WP</acronym> Admin password:</label></th>
			<td><input id="support_wp_password" type="text" name="wp_password" value="" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_ftp_host"><acronym title="Secure Shell">SSH</acronym> / <acronym title="File Transfer Protocol">FTP</acronym> host:</label></th>
			<td><input id="support_ftp_host" type="text" name="ftp_host" value="" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_ftp_login"><acronym title="Secure Shell">SSH</acronym> / <acronym title="File Transfer Protocol">FTP</acronym> login:</label></th>
			<td><input id="support_ftp_login" type="text" name="ftp_login" value="" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_ftp_password"><acronym title="Secure Shell">SSH</acronym> / <acronym title="File Transfer Protocol">FTP</acronym> password:</label></th>
			<td><input id="support_ftp_password" type="text" name="ftp_password" value="" size="80" /></td>
		</tr>';
		
?>
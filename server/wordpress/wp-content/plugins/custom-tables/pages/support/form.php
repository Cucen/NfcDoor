<h2><?php _e('Send Request','wct'); ?></h2><?php

if (file_exists($this->wctpath."pages/support/form/".str_replace("/","",$_POST['request_type']).".php")) {
	include($this->wctpath."pages/support/form/".str_replace("/","",$_POST['request_type']).".php");
}
if ($out == '1') {
	global $current_user;
	get_currentuserinfo();	
	if ($preise != '') {
		?><table class='widefat' style="width: 640px;"><thead><tr><th scope='col' colspan="2"><?php _e('Payment Informations', 'wct'); ?></th></thead>
		<tbody id='the-list'>
			<tr>
				<td><?php
				include($this->wctpath."pages/paypal.php");
				?></td>
				<td><?php echo $preise; ?></td>
			</tr>
		</tbody></table><br/><?
	}
	
	?><form id="support_form" action="admin.php?page=wct_support" method="post">
	<input type="hidden" name="request_type" value="<?php echo $_POST['request_type']; ?>" /><table class='widefat' style="width: 640px;"><thead><tr><th scope='col' colspan="2"><?php _e('Required Information', 'wct'); ?></th></thead>
	<tbody id='the-list'>
		<tr>
			<th><label for="support_url">Site <acronym title="Uniform Resource Locator">URL</acronym>:</label></th>
			<td><input id="support_url" type="text" name="url" value="<?php echo get_bloginfo('url'); ?>" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_name"><?php _e('Name', 'wct'); ?>:</label></th>
			<td><input id="support_name" type="text" name="name" value="<?php echo (($current_user->user_firstname." ".$current_user->user_lastname) == ' ' ? $current_user->display_name : $current_user->user_firstname." ".$current_user->user_lastname); ?>" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_email"><?php _e('eMail', 'wct'); ?>:</label></th>
			<td><input id="support_email" type="text" name="email" value="<?php echo $current_user->user_email; ?>" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_subject"><?php _e('Subject', 'wct'); ?>:</label></th>
			<td><input id="support_subject" type="text" name="subject" value="<?php echo $title; ?>" size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_description"><?php _e('Description', 'wct'); ?>:</label></th>
			<td><textarea id="support_description" name="description" cols="70" rows="8"></textarea></td>
		</tr><?php
		echo $addon;
	?></tbody></table><br /><?php
	if ($optional != '') {
		?><table class='widefat' style="width: 640px;"><thead><tr><th scope='col' colspan="2"><?php _e('Optional Information', 'wct'); ?></th></thead>
			<tbody id='the-list'>
				<?php echo $optional; ?>
		</tbody></table><br /><?php
	}
	wp_nonce_field('wctsubmitform','wctsubmitform');
	?><input name="formsubm" type="submit" class="button-primary" value="<?php _e('Submit request', 'wct'); ?>" />
	<input id="support_cancel" type="button" value="<?php _e('Cancel', 'wct'); ?>" /></form><?php
}
elseif ($paypal != '') {
	?>To get the support, please follow following steps:
	<ol>
		<li>Make the payment of the requested chat time to paypal:<table><tr><td>
			<table class='widefat' style=\"width: 200px;\"><thead><tr><th scope='col' colspan=\"2\">Prices</th></thead>
			<tbody id='the-list'>
				<tr><th>15 mins</th><td>25 &euro;</td></tr>
				<tr><th>30 mins</th><td>42 &euro;</td></tr>
				<tr><th>1 hour</th><td>80 &euro;</td></tr>
			</tbody></table></td><td><?
			include($this->wctpath."pages/paypal.php");
			?></td></table></li>
		<li>Please have the following informations ready:
			<form id="support_form" action="admin.php?page=wct_support" method="post">
			<table class='widefat' style="width: 640px;"><thead><tr><th scope='col' colspan="2"><?php _e('Required Information', 'wct'); ?></th></thead>
			<tbody id='the-list'>
				<tr>
					<th><label for="support_payed">Paypal Transaction ID:</label></th>
					<td><input id="support_paypal" type="text" name="paypal" value="" size="80" /></td>
				</tr>
				<tr>
					<th><label for="support_url">Site <acronym title="Uniform Resource Locator">URL</acronym>:</label></th>
					<td><input id="support_url" type="text" name="url" value="<?php echo get_bloginfo('url'); ?>" size="80" /></td>
				</tr>
				<tr>
				<th><label for="support_wp_login"><acronym title="WordPress">WP</acronym> Admin login:</label></th>
					<td><input id="support_wp_login" type="text" name="wp_login" value="<?php echo $current_user->user_login; ?>" size="80" /></td>
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
				</tr>
			</tbody>
			</table>
		</li>
		<li>Go to <a target=\"_blank\" href=\"http://wuk-custom-tables.com/\">wuk-custom-tables.com</a>, you will find the Chat at the bottom right (after some secounds).</li>
		<li>Should I'm not Online, please deliver following informations:
		<table class='widefat' style="width: 640px;"><thead><tr><th scope='col' colspan="2"><?php _e('Required Information', 'wct'); ?></th></thead>
			<tbody id='the-list'>
			<tr>
			<th><label for="support_subject"><?php _e('Subject', 'wct'); ?>:</label></th>
			<td><input id="support_subject" type="text" name="subject" value="[Chat Support] " size="80" /></td>
		</tr>
		<tr>
			<th><label for="support_description"><?php _e('Description', 'wct'); ?>:</label></th>
			<td><textarea id="support_description" name="description" cols="70" rows="8"></textarea></td>
		</tr>
		</tbody></table><br />
		<input type="hidden" name="request_type" value="chatsupport2" /><input name="formsubm" type="submit" class="button-primary" value="<?php _e('Submit request', 'wct'); ?>" />	
		</form>
	</li>
	</ol><?php
}
?>

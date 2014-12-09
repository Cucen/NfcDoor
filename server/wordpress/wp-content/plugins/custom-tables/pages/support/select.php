<h2>Custom Tables Support</h2>
<div id="support_container">
	<div class="metabox-holder">
	<div class="postbox "><div class="handlediv" title="Click to toggle"><br /></div><h3 class="hndle"><span><?php _e('Choose Request Type', 'wct'); ?></span></h3>
	<div class="inside">
	<label for="support_request_type"><?php _e('Request type:', 'wct'); ?></label><br/>
	<form action="admin.php?page=wct_support" method="post">
	<select onchange="this.form.submit()" id="support_request_type" name="request_type">
		<option value=""><?php _e('-- Choose Type --', 'wct'); ?></option>
		<optgroup label="<?php _e('Free Requests','wct') ?>:">
			<option style="background-color:#B7FFB7;" value="ticketsupport"><?php echo __('Support','wct')." - ".__('Free support with no garanteed reaction time and only be accessible over ticketsystem.','wct'); ?></option>.
			<option value="bugreport"><?php echo __('Bugreport','wct')." - ".__('We will fix it as soon as possible.','wct'); ?></option>
			<option value="featurerequest"><?php echo __('Feature Request','wct')." - ".__('New Idea? We would love it to hear!','wct'); ?></option>
		</optgroup>
		<optgroup label="<?php _e('Premium Support') ?>:">
			<option style="background-color:#FFBFBF;" value="chatsupport"><?php echo __('Support','wct')." - ".__("Chat support (immediately when I'm online)",'wct')." | ".__('Costs','wct').": 20&euro;/15m"; ?></option>
			<option value="plugin-config"><?php echo __('Setup','wct')." - ". __('Professional Plugin configuration','wct'); echo " | ".__('Costs','wct').": 80&euro;/h"; ?></option>
			<option value="addon-programming"><?php echo __('Programming','wct')." - ".__('Additional features to implement','wct'). " | ".__('Costs','wct').": 85&euro;/h"; ?></option>
		</optgroup>
	</select>
	</form>
</div></div></div>
</div>
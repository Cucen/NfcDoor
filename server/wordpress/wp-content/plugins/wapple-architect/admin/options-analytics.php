<?php 
if (isset($_POST['info_update'])) 
{
	$updateOption = false;
	
	// Google Tracking ID
	if(architect_save_option('architect_analytics_google_tracking_code')) $updateOption = true;
	// Use analyticator
	if(architect_save_option('architect_analytics_use_analyticator')) $updateOption = true;
}

if(isset($updateOption) && $updateOption == true)
{
	echo "<div class='updated fade'><p><strong>Settings saved</strong></p></div>";
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<div class="wrap">';
	echo '<form method="post" action="admin.php?page=architect-analytics" enctype="multipart/form-data">';
	echo architect_admin_header('2', 'Wapple Architect Analytics Settings');
} else
{	
	echo '<h3>Analytics Settings</h3>';
}

echo '<h3>Manual Input</h3>';
echo architect_table_start();
// Google Analytics Tracking ID - manual input
echo architect_admin_option('input', array('label' => 'Google Analytics Tracking ID', 'name' => 'architect_analytics_google_tracking_code', 'value' => get_option('architect_analytics_google_tracking_code'), 'description' => 'Google Analytics Tracking ID - get one from <a href="https://www.google.com/analytics" target="_new">https://www.google.com/analytics</a>'));
echo '</table>';


if(function_exists('is_plugin_active') AND is_plugin_active('google-analyticator/google-analyticator.php'))
{
	echo '<h3>Other Plugins : Google Analyticator</h3>';
	echo architect_table_start();
	
	$plugin_ga_value = 0;
	$ga_uid = get_option('ga_uid');
	if($ga_uid AND get_option('ga_status') == 'enabled')
	{
		$plugin_ga_value = $ga_uid;
	}
	
	echo architect_admin_option('input', array('label' => 'Google Analyticator Tracking ID', 'readonly' => 'readonly', 'name' => 'google_analyticator_tracking_id', 'value' => $plugin_ga_value, 'description' => 'GA Tracking ID entered with Google Analyticator'));
	
	$ga_use_analyticator = get_option('architect_analytics_use_analyticator');
	if($ga_use_analyticator === false AND !get_option('architect_analytics_google_tracking_code'))
	{
		echo '<p>Looks like you have Google Analyticator installed - going to assume you want to use it!</p>';
		
		// Not set - assume we want to use it
		if(get_option('ga_uid') AND get_option('ga_status') == 'enabled')
		{
			$ga_use_analyticator = 1;
		}
	}
	echo architect_admin_option('select', array('label' => 'Use Google Analyticator Tracking', 'name' => 'architect_analytics_use_analyticator', 'options' => array('1' => 'Yes', '0' => 'No'), 'value' => $ga_use_analyticator));
	echo '</table>';
}

if(!isset($oldVersion) OR $oldVersion == false)
{
	echo '<table class="form-table" cellspacing="2" cellpadding="5" width="100%"><tr><td><p class="submit"><input class="button-primary" type="submit" name="info_update" value="Save Changes" /></p></td></tr></table>';
	echo '</form></div>';
}
<?php
$options = $this->get_option('general_settings');
?>
<div class="icon32" id="icon-options-general"><br></div>
<h2>CP Designer Setting</h2>
<form method="post">
	<h3>Mail Setting</h3>
	<table class="form-table">
		<tbody>  
			<tr>
				<th scope="row">From Address</th>
				<td><input type="text" name="mail_fromaddr" id="mail_fromaddr" value="<?php echo $options['mail_fromaddr']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row">To Address</th>
				<td><input type="text" name="mail_toaddr" id="mail_toaddr" value="<?php echo $options['mail_toaddr']; ?>" /></td>
			</tr>    
			<tr>
				<th scope="row">CC</th>
				<td><input type="text" name="mail_cc" id="mail_cc" value="<?php echo $options['mail_cc']; ?>" /></td>
			</tr> 
			<tr>
				<th scope="row">Subject</th>
				<td><input type="text" name="mail_subject" id="captcha_pubkey" value="<?php echo $options['mail_subject']; ?>" /></td>
			</tr>                         			
		</tbody>	
	</table>	
	<h3>Messages</h3>
	<table class="form-table">
		<tbody>                                            			        
			<tr>
				<th scope="row">Success Message</th>
				<td><input type="text" name="success_msg" id="success_msg" value="<?php echo $options['success_msg']; ?>" /></td>
			</tr>                         
			<tr>
				<th scope="row">Error Message</th>
				<td><input type="text" name="error_msg" id="error_msg" value="<?php echo $options['error_msg']; ?>"/></td>
			</tr>                         
		</tbody>	
	</table>
	<br/>
	<h3>Popup Setting</h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"></th>
				<td><input type="checkbox" name="popup_status" id="popup_status" value="1" <?php if( $options['popup_status']== '1' )echo 'checked'; ?> /> Enable Show Popup Window</td>
			</tr>
			<tr <?php  if( $options['popup_status'] != '1' )echo "style='display:none;'"; ?>>
				<th scope="row"></th>
				<td>Template :
					<select style="width:190px;" id="template" name="template" >
						<?php
							require_once( 'includes/template.php' );
							$templates = ContactFormTemplate::get_templates();
							for( $i = 0; $i < count( $templates ); $i++ ){
								$tmp_name = trim($templates[$i]->tmp_name);print_r($tmp_name);
								if( $tmp_name == $options['template']  )
									echo "<option value='{$tmp_name}' selected>{$tmp_name}</option>";
								else
									echo "<option value='{$tmp_name}'>{$tmp_name}</option>";
							}
						?>
					</select>
				</td>
			</tr>  
			<tr <?php  if( $options['popup_status'] != '1' )echo "style='display:none;'"; ?>>
				<th scope="row"></th>
				<td>Event HTML DOM ID : <input style="width:190px;" type="text" name="popup_source" id="popup_source" value="<?php echo $options['popup_source'];?>" /></td>
			</tr>                         
			<tr <?php  if( $options['popup_status'] != '1' )echo "style='display:none;'"; ?>>
				<th scope="row"></th>
				<td><input type="checkbox" name="auto_display" id="auto_display" <?php if( $options['auto_display']== '1' )echo 'checked'; ?>  value="1"/> Auto Display When Home Page is Loaded</td>
			</tr>
		</tbody>	
	</table>
	<br/>
	<br/>
	<input type="hidden" name="cp_designer" value="update-setting"/>
	<input type="submit" value="Save Changes" name="update-button" id="update-button" class="button-primary" />                        
</form>
<script>
	jQuery('#popup_status').click(function(){
		if( jQuery( this ).attr( 'checked' ) != 'checked' ){
			jQuery( this ).parent().parent().siblings().hide();			
		}else{
			jQuery( this ).parent().parent().siblings().show();
		}
	})
</script>
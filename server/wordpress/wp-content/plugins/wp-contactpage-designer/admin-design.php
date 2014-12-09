<style type="text/css">
	#wpcontent {
		background-color: #EEEEEE;
	}
	.donate-button {
		float: right;
	}
</style>
<div class="donate-button" >
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="sipingsoft@hotmail.com">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="item_name" value="CP Designer Free Version">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
</div>
<div class="CPD">
    <div class="Main">
        <!--<div id="Fullscreen"><span>Full Screen</span></div>-->
        <div class="Toolbar"> 
            <h1 id="Toolbar_move_handle" title="Click to move">Tools Panel</h1>
            <div class="Toolbar_move_handle_scroll">
                <!-- Tools List -->
                <ul class="ToolsList">
                    <li id="createLabel" title="Drag to Workflow"><span></span>Label</li>
                    <li id="createField" title="Drag to Workflow"><span></span>Input Field</li>
                    <li id="createMailField"  title="Drag to Workflow"><span></span>E-Mail Field</li>
					<li id="createTextarea" title="Drag to Workflow"><span></span>Text Area</li>                    
					<li id="createParagraph" title="Drag to Workflow"><span></span>Paragraph</li>                    
                    <li id="createSubmit" title="Drag to Workflow"><span></span>Submit Button</li>                                                 
					<li id="createMap" title="Drag to Workflow"><span></span>Map</li>
					<li id="createDate" title="Drag to Workflow"><span></span>Date</li>                    
					<li id="createImg" title="Drag to Workflow" class="disable"><span></span>Image</li>
					<li id="createSelect" title="Drag to Workflow" class="disable"><span></span>Drop down</li>
					<li id="createCheckbox" title="Drag to Workflow" class="disable"><span></span>Checkbox</li>
					<li id="createMultipleChoice" title="Drag to Workflow" class="disable"><span></span>Multiple Choice</li>					
                    <li id="createAddress" title="Drag to Workflow" class="disable"><span></span>Address</li>
					<li id="createCaptcha" title="Drag to Workflow" class="disable"><span></span>Captcha</li>                    
                    <li id="createFacebook" title="Drag to Workflow" class="disable"><span></span>Facebook</li>
                    <li id="createTwitter" title="Drag to Workflow" class="disable"><span></span>Twitter</li>
					<li id="createPrice" title="Drag to Workflow" class="disable"><span></span>Price</li>
                    <li id="createQuantity" title="Drag to Workflow" class="disable"><span></span>Quantity</li>
                    <li id="createTotal" title="Drag to Workflow" class="disable"><span></span>Total</li>
                    <li id="createPaypal" title="Drag to Workflow" class="disable"><span></span>Paypal</li>
					<li id="createTime" title="Drag to Workflow" class="disable"><span></span>Time</li>
                </ul>
                <!-- /Tools List -->
            </div>
        </div>

        <div class="Workflow"> 
            <h1 id="Workflow_move_handle" title="Click to move">Workflow</h1>
<!--            <div id="MakeDefault" title="Set Default Template"> </div>-->
            <div id="NewTemplate" title="New Template"> </div>
            <div id="SaveTemplate" title="Save Template"> </div>
            <div id="selectTemplate" title="Load Template"> </div>
			<div id="editTemplate" title="Configure Template"> </div>

            <div class="Workflow_Wrapper"> 
                <ul> </ul>
                <!-- Handles Info & Elements Toolbox -->
                <div id="Workflow_resize_handle" title="Resize"> </div>
                <div id="Workflow_resize_coords"> </div>
                <div id="elementTools">
                    <div class="elementTools">
                        <div class="move" title="Move"> </div>
                        <div class="edit" title="Edit"> </div>
                        <div class="delete" title="Delete"> </div>
                    </div>
                </div>
                <!-- /Handles And Info -->
            </div>
        </div>
    </div>

    <div class="BlackBox"> </div>

    <div class="TemplateProperties"> 
        <h4 title="Click to move">Template Properties<span>Close</span></h4>
        <label>Template Name</label>
        <input name="tmp_name" type="text" value="" />
        <div class="separate"> </div>

        <input type="button" value="Save Template" />
    </div>

    <div class="SelectTemplate">
        <h4 title="Click to move">Load Template<span>Close</span></h4>
        <i>if you want to delete template please click double on the element</i>
        <ul>

        </ul>
    </div>

    <div class="ElementEditor">

        <h4 title="Click to move">Settings<span>Close</span></h4>

		<div class="EditTemplate">

            <?php print_size_property();?>

            <div class="separate"> </div>
            <label>Font Color</label>
            <input name="color" type="text" placeholder="Font Color" value="" />
            <div class="colorPalette" title="Pick Color"> </div>
            <div class="separate"> </div>

            <label>Background Color</label>
            <input name="bgcolor" type="text" placeholder="BG Color" value="" />
            <div class="colorPalette" title="Pick Color"> </div>
            <div class="separate"> </div>

            <label>Background Image</label>
            <input name="bgimage" type="text" placeholder="Source" value="" />
            <div class="separate"> </div>
			
			<label>Background Repeat</label>
            <select name="bgrepeat">
				<option value="no-repeat">no-repeat</option>
				<option value="repeat-x">repeat-x</option>
				<option value="repeat-y">repeat-y</option>
				<option value="repeat">repeat</option>
			</select>
            <div class="separate"> </div>

            <input type="button" value="Apply Changes" />
        </div>
		
        <div class="EditImg">
			<?php print_position_property();?>
            <?php print_size_property();?>

            <label>Image Source</label>
            <input name="Source" type="text" placeholder="Source" value="" />
            <div class="separate"> </div>

            <input type="button" value="Apply Changes" />
        </div>

		<div class="EditMap">
            <?php print_position_property();?>
            <?php print_size_property();?>

            <label>Location</label>
            <input name="location" type="text" placeholder="Map Location" value="" />
            <div class="separate"> </div>

            <label>Map Type</label>
            <select class="MapType">
                <option value="terrain">Terrain</option>
                <option value="roadmap">Road Map</option>
                <option value="satellite">Satellite</option>
                <option value="hybrid">Hybrid</option>
            </select>
            <div class="separate"> </div>

            <label>Map Zoom</label>
            <select class="zoom">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
            </select>
            <div class="separate"> </div>

            <input type="button" value="Apply Changes" />
        </div>
		
        <div class="EditParagraph">
            <label>Paragraph Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

            <?php print_position_property();?>

            <label>Width</label>
            <input name="width" type="text" placeholder="Width" value="" />
            <label style="text-indent:10px">px</label>
            <div class="separate"> </div>

            <div class="widthSlider" style="width:100%; margin-bottom:5px;"> </div>
            <div class="separate"> </div>

            <?php print_font_property();?>

            <input type="button" value="Apply Changes" />
        </div>

        <div class="EditLabel">

            <label>Label Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

            <?php print_position_property();?>

            <?php print_font_property();?>
            <input type="button" value="Apply Changes" />

        </div>


        <div class="EditEmailField">

            <label>E-Mail Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

            <label>Placeholder</label>
            <input class="placeholder" type="text" val="" />
            <div class="separate"> </div>

            <label>Input Name</label>
            <input class="name" type="text" val="" />
            <div class="separate"> </div>

            <label>Required</label>
            <input class="required" type="checkbox" />
            <div class="separate"> </div>

            <?php print_position_property();?>
			<?php print_size_property();?>
            <?php print_font_property();?>
            <?php print_background_property();?>

            <input type="button" value="Apply Changes" />
        </div>


        <div class="EditInputText">
            <label>Input Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

            <label>Placeholder</label>
            <input class="placeholder" type="text" val="" />
            <div class="separate"> </div>

            <label>Input Name</label>
            <input class="name" type="text" val="" />
            <div class="separate"> </div>


            <label>Required</label>
            <input class="required" type="checkbox" />
            <div class="separate"> </div>
			
			<?php print_position_property();?>
			<?php print_size_property();?>
            <?php print_font_property();?>
			<?php print_background_property();?>
            <input type="button" value="Apply Changes" />
        </div>

        <div class="EditInputSubmit">

            <label>Button Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

			<?php print_position_property();?>
			<?php print_size_property();?>
            <?php print_background_property();?>
            <?php print_font_property();?>

            <input type="button" value="Apply Changes" />

        </div>

        <div class="EditTextarea">
            <label>Area Text</label>
            <div class="separate"> </div>
            <textarea name="text" type="text">  </textarea>
            <div class="separate"> </div>

			<label>Placeholder</label>
            <input class="placeholder" type="text" val="" />
            <div class="separate"> </div>
			
            <label>Input Name</label>
            <input class="name" type="text" val="" />
            <div class="separate"> </div>

            <label>Required</label>
            <input class="required" type="checkbox" />
            <div class="separate"> </div>

            <?php print_position_property();?>
            <?php print_size_property();?>

            <label>Background Color</label>
            <input name="bgcolor" type="text" placeholder="BG Color" value="" />
            <div class="colorPalette" title="Pick Color"> </div>
            <div class="separate"> </div>

            <label>Border Color</label>
            <input name="brcolor" type="text" placeholder="Border Color" value="" />
            <div class="colorPalette" title="Pick Color"> </div>
            <div class="separate"> </div>

            <?php print_font_property();?>

            <input type="button" value="Apply Changes" />
        </div>
		
		<div class="EditDate">
			<label>Required</label>
            <input class="required" type="checkbox" />
            <div class="separate"> </div>
			
			<label>Date Name</label>
            <input class="name" type="text" val="" />
            <div class="separate"> </div>
			
			<label>Date Format</label>
			<select name="date_format" id="date_format">
				<option value="mm/dd/yy">Default - mm/dd/yy</option>
				<option value="dd/mm/yy">dd/mm/yy</option>
				<option value="yy-mm-dd">ISO 8601 - yy-mm-dd</option>
				<option value="d M, y">Short - d M, y</option>
				<option value="d MM, y">Medium - d MM, y</option>
				<option value="DD, d MM, yy">Full - DD, d MM, yy</option>
				<option value="'day' d 'of' MM 'in the year' yy">With text - 'day' d 'of' MM 'in the year' yy</option>
			</select>			
			<div class="separate"> </div>
			
			<?php print_position_property();?>
			<?php print_size_property();?>
            <?php print_font_property();?>
			
            <input type="button" value="Apply Changes" />
        </div>
		<!-- end EditDate-->
    </div>
</div>
<div id="purchase-box" style="display: none;">	
	<p>You can not use this function in free version.</p>
	<p>To use this function, purchase premium version by clicking <a href="http://www.wpcontactpage.com/pricing-and-products" target="_blank">here</a></p>
</div>
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function(){
        CPD = new CPD();
        CPD.init({
            baseUrl: <?php echo '"' .plugins_url('/', __FILE__) .'"';?>,
            ajaxUrl: <?php echo '"' .get_bloginfo('url') .'/wp-admin/admin-ajax.php"';?>
        });
    });
</script>
<?php
function print_font_property() {
	?>
	<label>Font Family</label>
	<select class="FontFamilies">
		<option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
		<option value='Georgia,"Times New Roman",Times,serif'>Georgia, "Times New Roman", Times, serif</option>
		<option value='"Courier New",Courier,monospace'>"Courier New", Courier, monospace</option>
		<option value="Arial,Helvetica,sans-serif">Arial, Helvetica, sans-serif</option>
		<option value="Tahoma,Geneva,sans-serif">Tahoma, Geneva, sans-serif</option>
		<option value='"Trebuchet MS",Arial,Helvetica,sans-serif'>"Trebuchet MS", Arial, Helvetica, sans-serif</option>
		<option value='"Arial Black",Gadget,sans-serif'>"Arial Black", Gadget, sans-serif</option>
		<option value='"Times New Roman",Times,serif'>"Times New Roman", Times, serif</option>
		<option value='"Lucida Sans Unicode","Lucida Grande",sans-serif'>"Lucida Sans Unicode", "Lucida Grande", sans-serif</option>
		<option value='"Comic Sans MS",cursive'>"Comic Sans MS", cursive</option>
	</select>
	<div class="separate"> </div>

	<label>Font Size</label>
	<input name="font-size" type="text" placeholder="Font Size" value="" />
	<label style="text-indent:10px">px</label>
	<div class="separate"> </div>

	<div class="fontSlider" style="width:100%; margin-bottom:5px;"> </div>
	<div class="separate"> </div>

	<label>Font Weight</label>
	<select class="FontWeight">
		<option value="400">Normal</option>
		<option value="700">Bold</option>
	</select>
	<div class="separate"> </div>
	
	<label>Alignment</label>
	<select class="Alignment">
		<option value="left">Left</option>
		<option value="right">Right</option>
		<option value="center">Center</option>
	</select>
	<div class="separate"> </div>

	<label>Transform</label>
	<select class="Transform">
		<option value="none">None</option>
		<option value="uppercase">Uppercase</option>
		<option value="lowercase">Lowercase</option>
	</select>
	<div class="separate"> </div>
			
	<label>Font Color</label>
	<input name="color" type="text" placeholder="Font Color" value="" />
	<div class="colorPalette" title="Pick Color"> </div>
	<div class="separate"> </div>
	<?php
}

function print_position_property() {
	?>
	<label>Left</label>
	<input name="left" type="text" placeholder="Left" value="" />
	<label style="text-indent:10px">px</label>
	<div class="separate"> </div>

	<label>Top</label>
	<input name="top" type="text" placeholder="Top" value="" />
	<label style="text-indent:10px">px</label>
	<div class="separate"> </div>
	<?php
}

function print_size_property() {
	?>
	<label>Height</label>
	<input name="height" type="text" placeholder="Height" value="" />
	<label style="text-indent:10px">px</label>
	<div class="separate"> </div>

	<div class="heightSlider" style="width:100%; margin-bottom:5px;"> </div>
	<div class="separate"> </div>

	<label>Width</label>
	<input name="width" type="text" placeholder="Width" value="" />
	<label style="text-indent:10px">px</label>
	<div class="separate"> </div>

	<div class="widthSlider" style="width:100%; margin-bottom:5px;"> </div>
	<div class="separate"> </div>
	
	<?php
}
function print_background_property() {
	?>
	<label>Background Color</label>
	<input name="bgcolor" type="text" placeholder="BG Color" value="" />
	<div class="colorPalette" title="Pick Color"> </div>
	<div class="separate"> </div>

	<label>Border Color</label>
	<input name="brcolor" type="text" placeholder="Border Color" value="" />
	<div class="colorPalette" title="Pick Color"> </div>
	<div class="separate"> </div>
	<?php
}
?>
function CPD() {
    var CPD     = this;
    CPD.tmpname = null;
    CPD.baseUrl = null;
    CPD.ajaxUrl = null;
	CPD.isElementMove = false;
    
    this.init = function(params) {
        CPD.baseUrl = params.baseUrl;
        CPD.ajaxUrl = params.ajaxUrl;
        
        // Initiallize handle controls & listeners
        CPD.handles();
        CPD.ToolsIntercation();
        CPD.WorkflowIntercation();
        CPD.saveTemplate();
        CPD.selectTemplate();
        CPD.makeDefault();
		CPD.editTemplate();
        
        // Init ColorPicker
        jQuery('.ElementEditor .colorPalette').ColorPicker({
            eventName: 'click',
            onSubmit: function(hsb, hex, rgb, el) {
                jQuery(el).prev().val('#'+hex);
            }
        });
    }
    
	this.purchasePremium = function() {
//		jQuery('#purchase-link').trigger('click');
		tb_show('Purchase premium version', '#TB_inline?&width=500&height=200&inlineId=purchase-box');
	}
	
    this.handles = function() {
        
        // Move Handle for Load Template
        jQuery('.SelectTemplate').draggable({
            handle: '.SelectTemplate h4',
            containment: '.CPD .Main'
        });
        
        // Move Handle for Template Properties
        jQuery('.TemplateProperties').draggable({
            handle: '.TemplateProperties h4',
            containment: '.CPD .Main'
        });
        
        // Move Handle for the Main Toolbar
        jQuery('.CPD .Toolbar').draggable({
            handle: '#Toolbar_move_handle',
            containment: '.CPD .Main'
        });
        
        // ToolBar Toggle Hide/Show
        jQuery('#Toolbar_move_handle').dblclick(function(){
            jQuery(this).parent().find('ul.ToolsList').toggle()
        });
        
        // Move Handle for the Workflow
        jQuery('.CPD .Workflow').draggable({
            handle: '#Workflow_move_handle',
            containment: '.CPD .Main'
        });
        
        // Resize Handle for the Workflow 
        jQuery('.CPD .Workflow_Wrapper').resizable({
            handles:'se,s,e',
            minWidth:70,
            minHeight:20,
            start: function() {
                jQuery('#Workflow_resize_coords').fadeIn();
            },
            resize: function(event, ui){
                var x = Math.round(jQuery(this).outerWidth());
                var y = Math.round(jQuery(this).outerHeight());
                jQuery('#Workflow_resize_coords').text(x + 'px : ' + y + 'px');
                jQuery('#Workflow_resize_coords').css({
                    left:  jQuery(this).outerWidth()  / 2 - jQuery('#Workflow_resize_coords').outerWidth()  / 2,
                    top:   jQuery(this).outerHeight() / 2 - jQuery('#Workflow_resize_coords').outerHeight() / 2
                });
                
            },
            stop: function() {
                jQuery('#Workflow_resize_coords').fadeOut();
            }
        });
        
        // FullScreen Button on off
        jQuery('.CPD #Fullscreen').click(function(){
            if (jQuery('.CPD .Main').css('position') == 'absolute') {
                jQuery('.CPD .Main').css({
                    width:'inherit',
                    minHeight:'600px',
                    position:'relative',
                    zIndex:  '1'
                });
            } else {
                jQuery('.CPD .Main').css({
                    width: '100%',
                    height:'100%',
                    position:'absolute',
                    top:0,
                    left:0,
                    zIndex: '10000'
                });
            }
        });
    }
	
	this.datePicker = function() {
		jQuery('.CPD div.date').each(function(){
			var format = jQuery(this).attr('format');
			if (format == undefined || format == '')
				format = 'mm/dd/yy';
			
			jQuery(this).find('input').datepicker({
				dateFormat: format,
				showOn: "button",
				buttonImage: CPD.baseUrl + "css/img/calendar.png",
				buttonImageOnly: true
			});
		});
	}
	
    this.WorkflowIntercation = function() {
        jQuery('.Workflow_Wrapper').click(function(e){
            e.stopPropagation();
            jQuery(this).find('.elementTools').hide();
        });
        
        jQuery('.BlackBox').click(function(){
            jQuery(this).hide();
            jQuery('.SelectTemplate').hide();
            jQuery('.TemplateProperties').hide();
            jQuery('.ElementEditor > div').hide();
            jQuery('.ElementEditor > h4').hide();
            jQuery('.ElementEditor').hide();
        });
    }
    
    this.ToolsIntercation = function() {
        // User tools interaction; Drag Tools to the Workflow
        
        // Close button for ETI Settings
        jQuery('.CPD .ElementEditor h4 span').live('click', function(){
            jQuery('.BlackBox').hide();
            jQuery('.ElementEditor').hide();
            jQuery('.ElementEditor > div').hide();
            jQuery('.ElementEditor > h4').hide();
        });
        
        jQuery('.CPD .ElementEditor').draggable({
            containment:'window',
            handle:'h4'
        });
        
//        jQuery('ul.ToolsList li').draggable({
//            helper: 'clone',
//            revert:'invalid',
//            containment: '.CPD .Main'
//        });
        jQuery('ul.ToolsList').sortable({
            helper: 'clone',
            revert:'invalid',
            containment: '.CPD .Main',
			items: "li:not(.disable)"
		});
		
		jQuery('ul.ToolsList li.disable').mousedown(function(){
			CPD.purchasePremium();
		});
        
        jQuery('.Workflow_Wrapper').droppable({
            accept: ".ToolsList li",
            drop: function(event, ui){
                var wPos = jQuery('.Workflow_Wrapper ul').offset();
                var pos  = jQuery(ui.helper).offset();
                var y    = pos.top  - wPos.top;
                var x    = pos.left - wPos.left;
                
                var createElement;
                
                switch(ui.draggable.attr('id')) {
                    
                    case 'createParagraph' :
                        createElement = '<p>New Paragraph</p>';
                        break;
                    case 'createLabel' :
                        createElement = '<label>New Label</label>';
                        break;
                    case 'createField' :
                        createElement = '<input type="text" />';
                        break;                    
                    case 'createMailField' :
                        createElement = '<input type="email" />';
                        break;
                    case 'createTextarea' :
                        createElement = '<textarea></textarea>';
                        break;
                    case 'createSubmit' :
                        createElement = '<input type="submit" value="Submit" />';
                        break;
                    case 'createImg' :
                        createElement = '<img class="image" src="#" alt="Image" />';
                        break;
                    
                    case 'createMap' :
                        createElement = '<img class="map" src="http://maps.googleapis.com/maps/api/staticmap?center=London&zoom=10&size=250x250&maptype=terrain&sensor=false" title="gmap" />';
                        break;
                    case 'createDate':
                        createElement = '<div id="date" class="date" data="CreateDate" format="mm/dd/yy"><input type="text" value=""/></div>';
                        break;
                }
                
                
                // Attach tools to the element
                var elementTools = jQuery('#elementTools').html();
                // Creating Dragged element
                jQuery('<li>'+elementTools+createElement+'</li>').css({
                    position:'absolute',
                    top:  y,
                    left: x,
                    cursor: 'pointer'
                }).appendTo('.Workflow_Wrapper ul');
			
				if (ui.draggable.attr('id') == 'createDate')
					CPD.datePicker();
                // Create Element tools interaction (ETI)
                CPD.ETI(jQuery('.Workflow_Wrapper ul li:last > .elementTools'));
            }
        });
    }
    
    this.ETI = function(th){
        // Element tools interaction (ETI) (This Element)
        
        // Hide & Show Tools
        th.parent('li').click(function(e){
            e.stopPropagation();
            jQuery('.Workflow_Wrapper ul li .elementTools').hide();
            jQuery(this).find('.elementTools').show();
        });
		
		th.parent('li').mouseover(function(e){
            e.stopPropagation();
			if (!CPD.isElementMove) {
				jQuery(this).find('.elementTools').show();
				jQuery(this).css('z-index', '10000');
			}
        });
		th.parent('li').mouseout(function(e){
            e.stopPropagation();
			if (!CPD.isElementMove) {
				jQuery(this).find('.elementTools').hide();
				jQuery(this).css('z-index', '0');
			}
        });
     
        // Move element
        th.parents('li').draggable({
            containment: '.Workflow_Wrapper ul',
            snap: true,			
            snapTolerance: 5,
            handle:'.elementTools .move',
            grid: [5,5],
			start: function(event, ui) {
				CPD.isElementMove = true;
			},
			stop: function(event, ui) {
				CPD.isElementMove = false;
				if (jQuery(this).draggable('option', 'helper') == 'clone') {
					jQuery(ui.helper).clone(true).removeClass('box ui-draggable ui-draggable-dragging').appendTo('.CPD .Workflow_Wrapper ul');
					CPD.ETI(jQuery('.Workflow_Wrapper ul li:last > .elementTools'));
					// hide old elements
					jQuery(this).find('.elementTools').hide();
				}
			}
        }).mousedown(function(event){
			jQuery(this).draggable('option', { helper : event.ctrlKey ? 'clone' : 'original'});
		});
        
        // Delete element
        th.find('.delete').click(function(){
            jQuery(th).parents('li').remove();
        });
        
        // Edit element
        th.find('.edit').click(function(){
            CPD.editElement(th.next());
        });
        
    }
    
	// Show Element Editor
	this.showEditor = function(element) {
		jQuery('.BlackBox').show();
		jQuery('.ElementEditor > div').hide();

		jQuery('.ElementEditor').show();
		jQuery('.ElementEditor .'+element).show();
		jQuery('.ElementEditor > h4').show();

		jQuery('.ElementEditor').css({
			// Position Editor
			left:  jQuery(window).outerWidth()  / 2 - jQuery('.ElementEditor').outerWidth()  / 2,
			top:   jQuery(window).outerHeight() / 2 - jQuery('.ElementEditor').outerHeight() / 2
		});
	}
	
	// generate price html code
	this.getPriceHtml = function(currency, value, hideDecimal) {
		var html = [];
		var symbol, dollar, cent;
		
		switch (currency) {
			case 'USD':
				symbol = '$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "EUR":
				symbol = '€';dollar = 'Euros';cent = 'Cents';
				break;
			case "GBP":
				symbol = '£';dollar = 'Pounds';cent = 'Pence';
				break;
			case "AUD":
				symbol = 'AU$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "JPY":
				symbol = '¥';dollar = 'Yen';cent = 'Sen';
				break;
			case "CAD":
				symbol = 'CA$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "NZD":
				symbol = 'NZ$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "HKD":
				symbol = 'HK$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "SGD":
				symbol = 'SG$';dollar = 'Dollars';cent = 'Cents';
				break;
			case "MXN":
				symbol = '$';dollar = 'Pesos';cent = 'Centavos';
				break;
			case "DKK":
				symbol = 'KR';dollar = 'Kronor';cent = 'Ore';
				break;
			case 12:
				symbol = '';dollar = '';cent = '';
				break;
			case "NOK":
				symbol = 'KR';dollar = 'Kronor';cent = 'Ore';
				break;
			case "MYR":
				symbol = 'RM';dollar = 'Ringgt';cent = 'Sen';
				break;
			case "TWD":
				symbol = 'NT$';dollar = 'Dollars';cent = 'Jiao';
				break;
		}
		var values = value.split('.', 2);
		if (values.length == 1)
			values[1] = '00';
//		html.push('<span class="currency">', symbol, '</span>');
//		html.push('<span class="dollar"><input type="text" readonly="readonly" value="', values[0], '" /><br/>');
//		html.push(dollar, '</span>');
//		if (!hideDecimal) {
//			html.push('<span>.</span>');
//			html.push('<span class="cent"><input type="text" readonly="readonly" value="', values[1], '" /><br/>');
//			html.push(cent, '</span>');
//		}
//		html.push('<div class="clear"></div>');
		html.push('<span class="currency">', symbol, '</span>');
		html.push('<span class="dollar">', values[0], '</span>');
		if (!hideDecimal)
			html.push('<span class="cent">.', values[1], '</span>');
//		html.push('<div class="clear"></div>');
		return html.join('');
	}
		
    this.editElement = function(th) {
        // Edit Element Properties
		this.getCommonParamsFromElement = function(element) {
			param            = new Array();
			param.Name       = element.attr('name');
			param.Title       = element.attr('title');
			param.Text       = element.text();
			param.Value      = element.val();
			param.Left       = Math.round(element.parents('li').position().left);
			param.Top        = Math.round(element.parents('li').position().top);
			param.Width      = Math.round(element.width());
			param.Height     = Math.round(element.height());
			param.Font       = element.css('font-family');
			param.fontWeight = element.css('font-weight');			
			param.Color      = element.css('color');
			param.FontSize   = element.css('font-size').replace('px','');
			param.Align      = element.css('text-align');
			param.Transform  = element.css('text-transform');
			param.bgColor    = element.css('backgroundColor');
			param.brColor    = element.css('border-left-color');
			param.Required   = element.hasClass('required');
			param.Max   = element.attr('max');
			
			return param;
		}
		
		this.getCommonParamsFromEdit = function(edit) {
			param            = new Array();
			param.Name		 = edit.find('input.name').val();
			param.Text       = edit.find('textarea[name=text]').val();
			param.Value      = edit.find('textarea[name=text]').val();
			param.Left       = Number(edit.find('input[name=left]').val());
			param.Top        = Number(edit.find('input[name=top]').val());
			param.Width      = edit.find('input[name=width]').val();
			param.Height     = edit.find('input[name=height]').val();			
			param.Font       = edit.find('select.FontFamilies').val();
			param.fontWeight = edit.find('select.FontWeight').val();			
			param.Color      = edit.find('input[name=color]').val();
			param.FontSize   = edit.find('input[name=font-size]').val() + 'px';
			param.Align      = edit.find('select.Alignment').val();
			param.Transform  = edit.find('select.Transform').val();
			param.bgColor    = edit.find('input[name=bgcolor]').val();
			param.brColor    = edit.find('input[name=brcolor]').val();
			param.Required   = edit.find('input.required').is(':checked');
			param.Max   = edit.find('input.max').val();
			
			return param;
		}
		
		// Set Position
		this.setNameToEdit = function(edit, param) {
			edit.find('input.name').val(param.Name);
		}
		this.setNameToElement = function(element, param) {
			if (param.Name != "" && jQuery('.CPD .Workflow_Wrapper ul li [name="'+param.Name+'"]').not(element).length) {
				alert('Name: '+param.Name+' is reserved! Pick different name!');
				return false;
			}
            element.attr('name', param.Name);
		}
		
		// Set Position
		this.setPositionToEdit = function(edit, param) {
			edit.find('input[name=left]').val(param.Left);
			edit.find('input[name=top]').val(param.Top);
		}
		this.setPositionToElement = function(element, param) {
			element.parent().css({
				left: Number(param.Left),
				top:  Number(param.Top)
			});
		}
		
		// Set Size
		this.setSizeToEdit = function(edit, param) {
			edit.find('input[name=width]').val(param.Width);
			edit.find('input[name=height]').val(param.Height);
		}
		this.setSizeToElement = function(element, param) {
			element.css({
				width:           param.Width,
				height:          param.Height
			});
		}
		
		// Set Font
		this.setFontToEdit = function(edit, param) {
			edit.find('input[name=color]').val(param.Color);
			edit.find('input[name=font-size]').val(param.FontSize);

			edit.find('select.FontFamilies option').removeAttr('selected');
			edit.find('select.FontFamilies option[value="'+param.Font+'"]').attr('selected','selected');

			edit.find('select.FontWeight option').removeAttr('selected');
			edit.find('select.FontWeight option[value="'+param.fontWeight+'"]').attr('selected','selected');

			edit.find('select.Alignment option').removeAttr('selected');
			edit.find('select.Alignment option[value="'+param.Align+'"]').attr('selected','selected');

			edit.find('select.Transform option').removeAttr('selected');
			edit.find('select.Transform option[value="'+param.Transform+'"]').attr('selected','selected');
		}
		this.setFontToElement = function(element, param) {
			element.css({
				color:           param.Color,
				fontFamily:      param.Font,
				fontWeight:      param.fontWeight,
				textAlign:       param.Align,
				textTransform:   param.Transform,
				fontSize:        param.FontSize
			});
		}
		
		this.setRequiredToEdit = function(edit, param) {
			edit.find('input.required').prop("checked", param.Required);
		}
		this.setRequiredToElement = function(element, param) {
			if (param.Required) {
				element.addClass('required');
				element.parent().addClass('required');
			} else {
				element.removeClass('required');
				element.parent().removeClass('required');
			}
		}
		
		this.setBackgroundToEdit = function(edit, param) {
			edit.find('input[name=bgcolor]').val(param.bgColor);
			edit.find('input[name=brcolor]').val(param.brColor);
		}
		this.setBackgroundToElement = function(element, param) {
			element.css({
				backgroundColor: param.bgColor,
				borderColor:     param.brColor
			});
		}
		
		// get instance
		var editElement = this;
        // Get Tag Type
        var elementType = (th.get(0).tagName);
		var element = jQuery(th);		
        var param = editElement.getCommonParamsFromElement(element);
		var elemClass = element.attr('class');
        
        switch (elementType) {
            case "IMG" :
                if (elemClass == 'map') {
                    jQuery('.ElementEditor > h4').text('Map Settings');
                    CPD.showEditor('EditMap');

					edit =  jQuery('.ElementEditor .EditMap');
						
					editElement.setPositionToEdit(edit, param);
					editElement.setSizeToEdit(edit, param);
                   
                    CPD.makeSlider('.ElementEditor .EditMap .outerWidthSlider','.ElementEditor .EditMap input[name=width]');
                    CPD.makeSlider('.ElementEditor .EditMap .outerHeightSlider','.ElementEditor .EditMap input[name=height]');

                    // Apply Changes       
                    jQuery('.ElementEditor .EditMap input[type=button]').unbind('click').click(function(){
						param = editElement.getCommonParamsFromEdit(edit);
							
						editElement.setPositionToElement(element, param);
                        element.parent().css({
                            left: Number(jQuery('.ElementEditor .EditMap input[name=left]').val()),
                            top:  Number(jQuery('.ElementEditor .EditMap input[name=top]').val())
                        });
                        element.attr('src','http://maps.googleapis.com/maps/api/staticmap?center=' + jQuery('.ElementEditor .EditMap input[name=location]').val() + '&zoom=' + jQuery('.ElementEditor .EditMap select.zoom').val() + '&size=' + param.Width + 'x' + param.Height + '&maptype=' + jQuery('.ElementEditor .EditMap select.MapType').val() + '&sensor=false');
                        jQuery('.BlackBox').trigger('click');
                    });
                }
                
                
                if (elemClass == 'image') {
                    jQuery('.ElementEditor > h4').text('Image Settings');
                    CPD.showEditor('EditImg');

					edit =  jQuery('.ElementEditor .EditImg');
						
					editElement.setPositionToEdit(edit, param);
					editElement.setSizeToEdit(edit, param);
                    
                    param.Source     = element.attr('src');

                    edit.find('input[name=Source]').val(param.Source);

                    CPD.makeSlider('.ElementEditor .EditImg .outerWidthSlider','.ElementEditor .EditImg input[name=width]');
                    CPD.makeSlider('.ElementEditor .EditImg .outerHeightSlider','.ElementEditor .EditImg input[name=height]');

                    // Apply Changes       
                    edit.find('input[type=button]').unbind('click').click(function(){
						param = editElement.getCommonParamsFromEdit(edit);
							
						editElement.setPositionToElement(element, param);
						editElement.setSizeToElement(element, param);
                        
                        element.attr('src', edit.find('input[name=Source]').val());
                        
                        jQuery('.BlackBox').trigger('click');
                    });
                }
				
                break;
            
            case "P" :
                // Edit Paragraph
                jQuery('.ElementEditor > h4').text('Paragraph Settings');
                CPD.showEditor('EditParagraph');
                
				edit =  jQuery('.ElementEditor .EditParagraph');
						
				editElement.setPositionToEdit(edit, param);
				editElement.setFontToEdit(edit, param);
				
                // Assign Current Parameters
                edit.find('textarea[name=text]').val(param.Text);
                edit.find('input[name=width]').val(param.Width);
				
                // Width Slider
                CPD.makeSlider('.ElementEditor .EditParagraph .outerWidthSlider','.ElementEditor .EditParagraph input[name=width]');
                // Font-Size Slider
                CPD.makeSlider('.ElementEditor .EditParagraph .fontSlider','.ElementEditor .EditParagraph input[name=font-size]');
                
                // Apply Changes
                jQuery('.ElementEditor .EditParagraph input[type=button]').unbind('click').click(function(){
					param = editElement.getCommonParamsFromEdit(edit);
					editElement.setPositionToElement(element, param);
					editElement.setFontToElement(element, param);
					
                    element.css({width:         param.Width});
					element.text(param.Text);
                    jQuery('.BlackBox').trigger('click');
                });
                // End of Edit Paragraph
                break;
            
            case "LABEL" :
				// Edit Label
				jQuery('.ElementEditor > h4').text('Label Settings');
				CPD.showEditor('EditLabel');

				edit =  jQuery('.ElementEditor .EditLabel');

				editElement.setPositionToEdit(edit, param);
				editElement.setFontToEdit(edit, param);
				edit.find('textarea[name=text]').val(param.Text);

				// Font-Size Slider
				CPD.makeSlider('.ElementEditor .EditLabel .fontSlider','.ElementEditor .EditLabel input[name=font-size]');

				// Apply Changes
				jQuery('.ElementEditor .EditLabel input[type=button]').unbind('click').click(function(){
					param = editElement.getCommonParamsFromEdit(edit);
					editElement.setPositionToElement(element, param);
					editElement.setFontToElement(element, param);

					element.text(param.Text);
					jQuery('.BlackBox').trigger('click');
				});
                break;
            case "INPUT" :
								
                // Check Input Type
                switch (th.attr('type')) {
                    case 'email' :
                        // Edit Email fied
                        jQuery('.ElementEditor > h4').text('Email Field Settings');
                        CPD.showEditor('EditEmailField');
                
						edit =  jQuery('.ElementEditor .EditEmailField');
						
						editElement.setNameToEdit(edit, param);
						editElement.setPositionToEdit(edit, param);
						editElement.setSizeToEdit(edit, param);
						editElement.setFontToEdit(edit, param);
						editElement.setBackgroundToEdit(edit, param);
						editElement.setRequiredToEdit(edit, param);
						
                        edit.find('textarea[name=text]').val(param.Text);
                        edit.find('.placeholder').val(element.attr('placeholder'));
                
                
                        // Width Slider
                        CPD.makeSlider('.ElementEditor .EditEmailField .outerWidthSlider','.ElementEditor .EditEmailField input[name=width]');
                                 
                        // Height  Slider
                        CPD.makeSlider('.ElementEditor .EditEmailField .outerHeightSlider','.ElementEditor .EditEmailField input[name=height]');
               
                        // Font-Size Slider
                        CPD.makeSlider('.ElementEditor .EditEmailField .fontSlider','.ElementEditor .EditEmailField input[name=font-size]');
                
                        // Apply Changes
                        edit.find('input[type=button]').unbind('click').click(function(){
							
							param = editElement.getCommonParamsFromEdit(edit);
							
                            editElement.setNameToElement(element, param);
                            editElement.setPositionToElement(element, param);
							editElement.setSizeToElement(element, param);
							editElement.setFontToElement(element, param);
							editElement.setBackgroundToElement(element, param);
							editElement.setRequiredToElement(element, param);
							
                            element.attr('placeholder',edit.find('.placeholder').val());
                            jQuery('.BlackBox').trigger('click');
                            return true;
                        });
                        break;
                    
                    case 'text' :
						if (element.hasClass('quantity')) {
							// Edit Input Text
							jQuery('.ElementEditor > h4').text('Quantity Settings');
							CPD.showEditor('EditQuantity');

							edit =  jQuery('.ElementEditor .EditQuantity');

							editElement.setNameToEdit(edit, param);
							editElement.setPositionToEdit(edit, param);
							editElement.setSizeToEdit(edit, param);
							editElement.setFontToEdit(edit, param);
							editElement.setBackgroundToEdit(edit, param);
							editElement.setRequiredToEdit(edit, param);

							edit.find('.max').val(param.Max);
							edit.find('.placeholder').val(element.attr('placeholder'));


							// Width Slider
							CPD.makeSlider('.ElementEditor .EditQuantity .outerWidthSlider','.ElementEditor .EditQuantity input[name=width]');
							// Height  Slider
							CPD.makeSlider('.ElementEditor .EditQuantity .outerHeightSlider','.ElementEditor .EditQuantity input[name=height]');
							// Font-Size Slider
							CPD.makeSlider('.ElementEditor .EditQuantity .fontSlider','.ElementEditor .EditQuantity input[name=font-size]');

							// Apply Changes
							edit.find('input[type=button]').unbind('click').click(function(){

								param = editElement.getCommonParamsFromEdit(edit);

								editElement.setNameToElement(element, param);
								editElement.setPositionToElement(element, param);
								editElement.setSizeToElement(element, param);
								editElement.setFontToElement(element, param);
								editElement.setBackgroundToElement(element, param);
								editElement.setRequiredToElement(element, param);                           

								element.attr('max', param.Max);	
								element.attr('placeholder', edit.find('.placeholder').val());								
								jQuery('.BlackBox').trigger('click');
								return true;
							});
						} else if (elemClass == 'total') {
						} else {
							// Edit Input Text
							jQuery('.ElementEditor > h4').text('Input Settings');
							CPD.showEditor('EditInputText');

							edit =  jQuery('.ElementEditor .EditInputText');

							editElement.setNameToEdit(edit, param);
							editElement.setPositionToEdit(edit, param);
							editElement.setSizeToEdit(edit, param);
							editElement.setFontToEdit(edit, param);
							editElement.setBackgroundToEdit(edit, param);
							editElement.setRequiredToEdit(edit, param);

							edit.find('textarea[name=text]').val(param.Text);
							edit.find('.placeholder').val(element.attr('placeholder'));


							// Width Slider
							CPD.makeSlider('.ElementEditor .EditInputText .outerWidthSlider','.ElementEditor .EditInputText input[name=width]');

							// Height  Slider
							CPD.makeSlider('.ElementEditor .EditInputText .outerHeightSlider','.ElementEditor .EditInputText input[name=height]');

							// Font-Size Slider
							CPD.makeSlider('.ElementEditor .EditInputText .fontSlider','.ElementEditor .EditInputText input[name=font-size]');

							// Apply Changes
							edit.find('input[type=button]').unbind('click').click(function(){

								param = editElement.getCommonParamsFromEdit(edit);

								editElement.setNameToElement(element, param);
								editElement.setPositionToElement(element, param);
								editElement.setSizeToElement(element, param);
								editElement.setFontToElement(element, param);
								editElement.setBackgroundToElement(element, param);
								editElement.setRequiredToElement(element, param);                           

								element.attr('placeholder', edit.find('.placeholder').val());								
								element.val(edit.find('textarea[name=text]').val());
								element.text(edit.find('textarea[name=text]').val());
								jQuery('.BlackBox').trigger('click');
								return true;
							});
						}
                        break;   
                    
                    case 'submit' :
                        // Edit Submit Button
                        jQuery('.ElementEditor > h4').text('Submit Button Settings');
                        CPD.showEditor('EditInputSubmit');
                        
						edit =  jQuery('.ElementEditor .EditInputSubmit');
						
						editElement.setPositionToEdit(edit, param);
						editElement.setSizeToEdit(edit, param);
						editElement.setFontToEdit(edit, param);
						editElement.setBackgroundToEdit(edit, param);
						
                        jQuery('.ElementEditor .EditInputSubmit textarea[name=text]').val(param.Value);
                
                        // Width Slider
                        CPD.makeSlider('.ElementEditor .EditInputSubmit .outerWidthSlider','.ElementEditor .EditInputSubmit input[name=width]');
                                       
                        // Height  Slider
                        CPD.makeSlider('.ElementEditor .EditInputSubmit .outerHeightSlider','.ElementEditor .EditInputSubmit input[name=height]');
               
                        // Font-Size Slider
                        CPD.makeSlider('.ElementEditor .EditInputSubmit .fontSlider','.ElementEditor .EditInputSubmit input[name=font-size]');
                
                        // Apply Changes
                        jQuery('.ElementEditor .EditInputSubmit input[type=button]').unbind('click').click(function(){
                    
							param = editElement.getCommonParamsFromEdit(edit);
                            editElement.setPositionToElement(element, param);
							editElement.setSizeToElement(element, param);
							editElement.setFontToElement(element, param);
							editElement.setBackgroundToElement(element, param);
							
                            element.css({
                                lineHeight:      param.Height + 'px'
                            });
                            element.val(param.Text);
                            jQuery('.BlackBox').trigger('click');
                        });
                        break;
                }				
                break;
            case "TEXTAREA" :
                // Edit Text Area
                jQuery('.ElementEditor > h4').text('Text Area Settings');
                CPD.showEditor('EditTextarea');
                
                edit =  jQuery('.ElementEditor .EditTextarea');
						
				editElement.setNameToEdit(edit, param);
				editElement.setPositionToEdit(edit, param);
				editElement.setSizeToEdit(edit, param);
				editElement.setFontToEdit(edit, param);
				editElement.setBackgroundToEdit(edit, param);
				editElement.setRequiredToEdit(edit, param);
                
                        
                // Assign Current Parameters
                jQuery('.ElementEditor .EditTextarea textarea[name=text]').val(param.Text);
                jQuery('.ElementEditor .EditTextarea .placeholder').val(element.attr('placeholder'));
                
                // Width Slider
                CPD.makeSlider('.ElementEditor .EditTextarea .outerWidthSlider','.ElementEditor .EditTextarea input[name=width]');
               
                // Height  Slider
                CPD.makeSlider('.ElementEditor .EditTextarea .outerHeightSlider','.ElementEditor .EditTextarea input[name=height]');
               
                // Font-Size Slider
                CPD.makeSlider('.ElementEditor .EditTextarea .fontSlider','.ElementEditor .EditTextarea input[name=font-size]');
                
                // Apply Changes
                jQuery('.ElementEditor .EditTextarea input[type=button]').unbind('click').click(function(){
					param = editElement.getCommonParamsFromEdit(edit);
							
					editElement.setPositionToElement(element, param);
					editElement.setSizeToElement(element, param);
					editElement.setFontToElement(element, param);
					editElement.setBackgroundToElement(element, param);
					editElement.setNameToElement(element, param);
                    
                    element.attr('placeholder', edit.find('.placeholder').val());
                    element.val(param.Text);
                    element.text(param.Text);
                    jQuery('.BlackBox').trigger('click');
                    return true;
                });
                break;
                
            case 'DIV':
                var Divid = element.attr('id');
                if (element.hasClass('date')) {
                    jQuery('.ElementEditor > h4').text('Date Settings');
                    CPD.showEditor('EditDate');

					edit =  jQuery('.ElementEditor .EditDate');
					
					var dateParam = editElement.getCommonParamsFromElement(element.find('input'));
					editElement.setPositionToEdit(edit, param);
					editElement.setFontToEdit(edit, dateParam);
					editElement.setSizeToEdit(edit, dateParam);
					editElement.setNameToEdit(edit, dateParam);
					editElement.setRequiredToEdit(edit, dateParam);
					// set format
					edit.find('#date_format').val(element.attr('format'));
					
                    edit.find('input[type=button]').unbind('click').click(function(){
						param = editElement.getCommonParamsFromEdit(edit);
						
						var dateEdit = element.find('input');
						editElement.setPositionToElement(element, param);						
						editElement.setSizeToElement(dateEdit, param);
						editElement.setFontToElement(dateEdit, param);
						editElement.setNameToElement(dateEdit, param);
						if (param.Required) {
							dateEdit.addClass('required');
							dateEdit.parents('li').addClass('required');
						} else {
							dateEdit.removeClass('required');
							dateEdit.parents('li').removeClass('required');
						}
						// set format
						element.attr('format', edit.find('#date_format').val());
						dateEdit.datepicker( "option", "dateFormat", element.attr('format') );
						
                        jQuery('.BlackBox').trigger('click');
                    });
                }
                break; 
        }
        // append the Close button
        jQuery('.ElementEditor > h4').html(jQuery('.ElementEditor > h4').html() + '<span title="close">Close</span>');
    }
    
    this.makeSlider = function(slider, element) {
        if (jQuery(element).val() < 0) {
            // Prevent negative values
            jQuery(element).val(0);
        }
        jQuery(slider).slider({
            range: "min",
            min: 0,
            max:   jQuery(element).val() <= 0 ? 100 : jQuery(element).val() * 2,
            value: jQuery(element).val(),
            slide: function(event, ui) { 
                jQuery(element).val((ui.value));
            }
        });
        jQuery(element).unbind('change').change(function(){
            jQuery(slider).slider({
                max:   jQuery(element).val() <= 0 ? 100 : jQuery(element).val() * 2,
                value: jQuery(element).val() <  0 ? 0 : jQuery(element).val()
            });
        });
    }
    
    this.saveTemplate = function() {
        // Close Without Saving
        jQuery('.TemplateProperties h4 span').live('click', function() {
            jQuery('.BlackBox').trigger('click');
        });
        jQuery('#SaveTemplate').click(function(){
            // Black Box
            jQuery('.BlackBox').show();
            // Open Properties
            jQuery('.TemplateProperties').css({
                left: jQuery(window).outerWidth()  / 2 - jQuery('.TemplateProperties').outerWidth()  / 2,
                top:  jQuery(window).outerHeight() / 2 - jQuery('.TemplateProperties').outerHeight() / 2
            }).show();
        });
        
        // Save template
        jQuery('.TemplateProperties input[type=button]').click(function(){
            
            var elements = {};
            elements['tmp_name'] = jQuery('.CPD .TemplateProperties input[name=tmp_name]').val();
            
            if (jQuery.trim(elements['tmp_name']) == "") {
                jQuery('.CPD .TemplateProperties input[name=tmp_name]').css({
                    border:'1px solid #F00'
                });
                return false;
            }
            
			var workflow_wrapper = jQuery('.CPD .Workflow_Wrapper');
			workflow_wrapper.css('width', workflow_wrapper.width());
			workflow_wrapper.css('height', workflow_wrapper.height());
			elements['tmp_css'] = workflow_wrapper.attr('style');
            
            jQuery('.CPD .Workflow ul li').each(function(k){
                elements[k] = {};
				
				var lastChild = jQuery(this).children(':last');
				var tag = lastChild.get(0).tagName;
				var dataType = lastChild.attr('data');
				var attrNames = [];
                
                if (lastChild.css('border-left-style') != 'none' ) {
                    // The Element has visible border
                    // Compensate 2 pixels for certain elements
                    
                    if (lastChild.attr('type') != 'submit' ) {
                        jQuery(this).outerWidth(jQuery(this).outerWidth()   - 2);
                        jQuery(this).outerHeight(jQuery(this).outerHeight() - 2);
                    }
                }                
                if (tag == 'SELECT')
                    elements[k]['text']   = lastChild.html();
                else
                    elements[k]['text']   = lastChild.text();
				
                if (tag == 'DIV')
                    elements[k]['value']  = lastChild.attr('value');                 
                else
                    elements[k]['value']  = lastChild.val();                 
                
                elements[k]['param']  = 'tag::'              + lastChild.get(0).tagName           + "||";
				// register attributes
				attrNames.push('src');
				attrNames.push('class');
				attrNames.push('data');
				attrNames.push('type');                
                
				var name;
                // Param name::
                if (tag == 'INPUT' || tag == 'TEXTAREA' || tag == "SELECT") {
					// add placeholder
					attrNames.push('placeholder');     
					// generate name
                    name = lastChild.attr('name');
                    if (!name) {
                        name = 'field'+k+'_'+ Math.floor(Math.random() * 1000);
						lastChild.attr('name', name);
					}
                    attrNames.push('name');     
                }
				if (tag == 'DIV') {				
					var divClass = lastChild.attr('class');
					
					if (divClass == 'checkbox')
						name = lastChild.attr('name');
					else
						name = lastChild.find('input:last').attr('name');
					if (!name)
                        name = 'field'+k+'_'+ Math.floor(Math.random() * 1000);
					
					if (divClass == 'date' || divClass == 'time') {
						elements[k]['param'] += '||name::' + name;
						attrNames.push('format');
						if (lastChild.find('input').hasClass('required'))
							elements[k]['param'] += '||required::required';
					}
				}
				for(var i in attrNames) {
					var attrVal = lastChild.attr(attrNames[i]);
					elements[k]['param'] += '||' + attrNames[i] + '::' + (attrVal == undefined ? '' : attrVal);
				}
				
				//except for date and time
				if (tag == 'DIV' && (lastChild.hasClass('date') || lastChild.hasClass('time')))
					lastChild = lastChild.find('input');
                
                // CSS Style
                elements[k]['css']    = 'left::'             + Math.round(jQuery(this).position().left) + 'px'         + "||";
                elements[k]['css']   += 'top::'              + Math.round(jQuery(this).position().top)  + 'px'         + "||";
                elements[k]['css']   += 'width::'            + Math.round(lastChild.width())      + 'px'         + "||";
                elements[k]['css']   += 'height::'           + Math.round(lastChild.height())     + 'px'         + "||";
                elements[k]['css']   += 'color::'            + lastChild.css('color')             + "||";
                elements[k]['css']   += 'background-color::' + lastChild.css('backgroundColor')   + "||";
                elements[k]['css']   += 'border::'           + '1px ' + lastChild.css('border-left-style') + ' ' + lastChild.css('border-left-color')  + "||";
                elements[k]['css']   += 'font-family::'      + lastChild.css('font-family')       + "||";
                elements[k]['css']   += 'font-size::'        + lastChild.css('font-size')         + "||";
                elements[k]['css']   += 'font-weight::'      + lastChild.css('font-weight')       + "||";
                elements[k]['css']   += 'text-align::'       + lastChild.css('text-align')        + "||";
                elements[k]['css']   += 'text-transform::'   + lastChild.css('text-transform')    + "||";
                elements[k]['css']   += 'border-radius::'    + lastChild.css('border-top-left-radius');
            });
            jQuery.ajax({
                type: 'POST',
                async: true,
                url: CPD.ajaxUrl + '?action=cp_designer_save_template',
                data: elements,
                beforeSend: function() {
                },
                error: function() {
                    alert('Error Saving Template!');
                },
                success: function(data){
                    alert('Template Saved');
                    jQuery('.BlackBox').trigger('click');
                    jQuery('.CPD #Workflow_move_handle').text('Workflow (Current template: ' + elements['tmp_name'] + ')');
                    CPD.tmpname = elements['tmp_name'];
                },
                dataType: 'html'
            });
            return true;
        });
    }
    
    this.selectTemplate = function() {
        // Close 
        jQuery('.SelectTemplate h4 span').click(function() {
            jQuery('.BlackBox').trigger('click');
        });
        
        jQuery('#selectTemplate').click(function(){
            // Black Box
            jQuery('.BlackBox').show();
            
            jQuery.ajax({
                type: 'POST',
                async: true,
                url: CPD.ajaxUrl + "?action=cp_designer_get_templates&format=xml",
                beforeSend: function() {
                    jQuery('.SelectTemplate ul').empty();
                },
                error: function() {
                    alert('Error Loading Template List');
                },
                success: function(data){
                    // Open Properties
                    jQuery(data).find('response template').each(function(){
                        var tmp_id   = jQuery(this).find('id').text();
                        var tmp_name = jQuery(this).find('name').text();
                        var tmp_act  = jQuery(this).find('active').text();
                        jQuery('<li onDblClick="if(confirm(\'Are you sure you want to delete this form?\')) return CPD.deleteForm('+tmp_id+'); else return false;" id="tmpid_'+tmp_id+'">'+tmp_name+'</li>').appendTo('.SelectTemplate ul');
                    });
                },
                complete: function(){
                    jQuery('.SelectTemplate').css({
                        left: jQuery(window).outerWidth()  / 2 - jQuery('.SelectTemplate').outerWidth() / 2,
                        top:  jQuery(window).outerHeight() / 2 - jQuery('.SelectTemplate').outerHeight() / 2
                    }).show();
                    
                    jQuery('.SelectTemplate ul li').click(function(){
                        var tmp_id = (jQuery(this).attr('id'));
                        CPD.loadTemplateElements(tmp_id);
                    });
                },
                dataType: 'xml'
            });
        });
    }
    
    this.loadTemplateElements = function(tmp_id) {
        var id = parseInt(tmp_id.replace('tmpid_',''),10);
         
        jQuery.ajax({
            type: 'POST',
            async: true,
            url: CPD.ajaxUrl + "?action=cp_designer_get_template&format=xml",
            data: "tmpid=" + id,
            beforeSend: function() {
                jQuery('.CPD .Workflow_Wrapper ul').empty();
            },
            error: function() {
                alert('Error Loading Template');
            },
            success: function(data){
                var name   = jQuery(data).find('tmp_name').text();
//                var width  = jQuery(data).find('tmp_size width').text();
//                var height = jQuery(data).find('tmp_size height').text();
				var css = jQuery(data).find('tmp_css').text();
                
                CPD.tmpname = name;
                
                jQuery('.CPD #Workflow_move_handle').text('Workflow (Current template: ' + name + ')');
                jQuery('.CPD .TemplateProperties input[name=tmp_name]').val(name);
//                jQuery('.CPD .Workflow_Wrapper').css({
//                    width: width,
//                    height: height
//                });
                jQuery('.CPD .Workflow_Wrapper').attr('style', css);
				
                jQuery(data).find('element').each(function(){
                    var el = jQuery(this).text();
                    var elementTools = jQuery('#elementTools').html();
                    jQuery(el).appendTo('.CPD .Workflow_Wrapper ul');
                    
                    // Append Tool Box
                    jQuery(elementTools).prependTo('.CPD .Workflow_Wrapper ul li:last').children(':first');
                    
                    // Create Element tools interaction (ETI)
                    CPD.ETI(jQuery('.Workflow_Wrapper ul li:last > .elementTools'));
                });
				
				// date, time picker enable
				CPD.datePicker();
				CPD.timePicker();
            },
            dataType: 'xml'
        });
    }
    
    this.makeDefault = function() {
        
//        jQuery('#MakeDefault').click(function(){
//            
//            if (!CPD.tmpname) {
//                alert('Save the template first!');
//                return false;
//            }
//            
//            jQuery.ajax({
//                type: 'POST',
//                async: true,
//                url: CPD.ajaxUrl + "?action=cp_designer_make_default&format=xml",
//                data: 'tmpname=' + CPD.tmpname,
//                success: function(data){
//                    alert('Default template set to: ' + CPD.tmpname);
//                },
//                error: function() {
//                    alert('Error setting template');  
//                }
//            //                dataType: 'xml'
//            });
//            
//            return true;
//        });
		jQuery('#NewTemplate').click(function(){
			if (jQuery('.CPD .Workflow_Wrapper ul').html().length > 0) {
				if (!confirm('Your work will be lost. Will you continue?'))
					return;
			}
			jQuery('.CPD .Workflow_Wrapper ul').html('');
			jQuery('.CPD .Workflow_Wrapper').width(600);
			jQuery('.CPD .Workflow_Wrapper').height(400);
			jQuery('.CPD .Workflow_Wrapper').removeAttr('style');
		});
    }
	
	this.editTemplate = function() {
		
		jQuery('#editTemplate').click(function(){
			jQuery('.ElementEditor > h4').text('Template Settings');
			CPD.showEditor('EditTemplate');

			var template = jQuery('.Workflow_Wrapper');
			
			// Get Current Parameters
			param				  = new Array();
			param.outerWidth      = Math.round(template.width());
            param.outerHeight     = Math.round(template.height());
			param.color			  = template.css('color');
            param.backColor       = template.css('background-color');
            param.backImage       = template.css('background-image');
            param.backRepeat      = template.css('background-repeat');
			
			//remove url from background image
			if (param.backImage.indexOf('url(') == 0)
				param.backImage = param.backImage.substring(4, param.backImage.length - 1);
			if (param.backImage == 'none')
				param.backImage = '';
			// Assign Current Parameters
			
			jQuery('.ElementEditor .EditTemplate input[name=width]').val(param.outerWidth);
			jQuery('.ElementEditor .EditTemplate input[name=height]').val(param.outerHeight);
			jQuery('.ElementEditor .EditTemplate input[name=color]').val(param.color);
			jQuery('.ElementEditor .EditTemplate input[name=bgcolor]').val(param.backColor);
			jQuery('.ElementEditor .EditTemplate input[name=bgimage]').val(param.backImage);
			jQuery('.ElementEditor .EditTemplate select').val(param.backRepeat);
			// Apply Changes       
			jQuery('.ElementEditor .EditTemplate input[type=button]').unbind('click').click(function(){
				var backImage = jQuery('.ElementEditor .EditTemplate input[name=bgimage]').val();
				if (backImage != '')
					backImage = 'url(' + jQuery('.ElementEditor .EditTemplate input[name=bgimage]').val() + ')';
				else
					backImage = 'none';
				template.css({
					width:				jQuery('.ElementEditor .EditTemplate input[name=width]').val(),
					height:				jQuery('.ElementEditor .EditTemplate input[name=height]').val(),
					color:				jQuery('.ElementEditor .EditTemplate input[name=color]').val(),
					backgroundColor:	jQuery('.ElementEditor .EditTemplate input[name=bgcolor]').val(),
					backgroundImage:	backImage,
					backgroundRepeat:	jQuery('.ElementEditor .EditTemplate select').val()
				});
				console.log(jQuery('.ElementEditor .EditTemplate select').val());
				jQuery('.BlackBox').trigger('click');
			});
			jQuery('.ElementEditor > h4').html(jQuery('.ElementEditor > h4').html() + '<span title="close">Close</span>');
		});
	}
    
    this.htmlAddress = function(){
        var html = ''; 
        html += '<div id="AddressGenerate" class="required" data="addressModified" value="world-states">';
        
        html += '<p>';
        html += '<label for="streetAddress">Street Address</label>';    
        html += '<input value="" name="street_address" id="streetAddress" />';
        html += '</p>';
        
        html += '<p>';
        html += '<label for="streetAddress2">Address Line 2</label>';    
        html += '<input value="" name="street_address2" id="streetAddress2" />';
        html += '</p>';
        
        html += '<p class="float_left w_50">';
        html += '<label for="cityAddress">City</label>';    
        html += '<input value="" name="cityAddress" id="cityAddress" />';
        html += '</p>';
        
        html += '<p class="float_left w_50">';
        html += '<label for="zipCodeAddress">Postal / zipcode</label>';    
        html += '<input value="" name="zipCodeAddress" id="zipCodeAddress" />';
        html += '</p>';
        
        html += '<p class="float_left w_50">';
        html += '<label for="regionAddress">State/Province/Region</label>';
        html += '<input value="" name="regionAddress" id="regionAddress" />';
        html += '</p>';
        
        html += '<p class="float_left w_50">';
        html += '<label for="CountryAddress">Country</label>';    
        html += '<select name="CountryAddress" id="CountryAddress" ></select>';
        html += '</p>';
        
        html += '</div>';
        return html;
    }
    
    this.SelectCountrySeparate = function(value){
        var boxArs =  jQuery.trim(jQuery(".CountryType_"+value).html()); 
        var sp = boxArs.split(',');
        var html = '';
        for(var i=0; i<sp.length; i++){
            html += sp[i]+'\n';
        }
        jQuery('.CountryEditAddress-choise').html(html);
    }
    this.deleteForm = function(form){
        jQuery.ajax({
            type: 'POST',
            async: false,
            url: CPD.ajaxUrl + "?action=cp_designer_delete_template&format=raw",
            data: {
                form : form
            },
            beforeSend: function() {
            },
            error: function() {
                alert('Error deleting Template!');
            },
            success: function(){
                jQuery('#tmpid_'+form).fadeOut('slow',function(){
                    jQuery('#tmpid_'+form).remove()
                //                    jQuery('.Workflow_Wrapper').empty();
                //                    jQuery('#Workflow_move_handle').html('Workflow');
                });
            }
        });
    }
    this.UpdateChildren  = function(ob,CssName,value){
        var obj = jQuery(ob).children('p').children('label');
        for(var i=0; i<obj.length; i++){
            var el = jQuery(obj[i]);
            if(CssName == 'fontSize'){
                el.css('fontSize' , value.val() + 'px');
            }
            if(CssName == 'fontWeight'){
                el.css('fontWeight' , value.val());
            }
        }
        jQuery(ob).removeClass(CssName+'__'+value.attr('class'));
        jQuery(ob).addClass(CssName+'__'+value.val());
        value.attr('class',value.val());
    }
    
    this.ShowImportMenu = function(){
        var box = jQuery('.selectChoiseDropDown');
        if(box.is(":visible")){
            box.fadeOut('slow');
            return false;
        }else {
            box.fadeIn('slow');
            return false;
        }
    }   
    this.importchoices = function(choise){
        var boxArs =  jQuery.trim(jQuery(".importChoise_"+choise).html());
        var sp = boxArs.split(',');
        var html = '';
        for(var i=0; i<sp.length; i++){
            html += sp[i]+'\n';
        }
        jQuery('#dropdownOption').html(html);
    }
}
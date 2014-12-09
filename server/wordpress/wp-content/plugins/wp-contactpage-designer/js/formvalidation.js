function CPD(){
	 var CPD     = this;
     CPD.tmpname = null;
     CPD.baseUrl = null;
	 CPD.ajaxUrl = null;
	 CPD.isPopup = 0;
	 this.init = function(params) {
        CPD.isPopup = params.isPopup;
		CPD.baseUrl = params.baseUrl;
		CPD.ajaxUrl = params.ajaxUrl;
		CPD.datePicker();
    }
	
    this.valudateForm = function(id){
        formId = jQuery("div#cpd_page_container form#"+id + " .required:not(li)");
		if( CPD.isPopup == "1" ){
			formId = jQuery("div.fancybox-wrap form#"+id + " .required:not(li)");
		}
        var AddressFields = jQuery('#AddressGenerate');
		var isAddressNotExist = AddressFields.size() == 0 ;
        var count = 0;		
        for(var i=0; i<formId.length; i++){
			var type =  jQuery(formId[i]);
            var attr_type = type.attr('type');
            if(attr_type == 'submit' || attr_type=='button'){
                type.attr('disabled','disabled');
                type.addClass('cpdFieldSubmitButton');
            }
            //if((type.is('input') || type.is('textarea')) && attr_type != "hidden" && attr_type != 'submit' ){
            if(isAddressNotExist || AddressFields.attr('id') != type.attr('id')){								                				
                var clasName = 'cpdFieldPositionClass_'+i;
				if(type.hasClass('hasDatepicker') || type.hasClass('hasTimepicker'))
					type.parent().addClass(clasName);				
				else
					type.addClass(clasName);				
				var value = type.val();
                if(value == ''){
                    this.ShowError(clasName,'The Field is required');
                    count++
                }else if(attr_type == 'email'){
                    if(!this.validateEmail(value)){
                        this.ShowError(clasName,'Please enter an email address');
                        count++
                    }
                }
            }
        // }
        }
        //captcha
        var captcha = jQuery("#recaptcha_response_field");
        
        if(captcha.length > 0){
            if(captcha.val() == ''){
                captcha.val('The Field is  required');
                count += 1 
            }
        }
        //address 
       
        if(AddressFields && AddressFields.hasClass('required') ){
            var getInputField = AddressFields.children('p').children('input');
            for(var s = 0; s < getInputField.length; s++){
                var addressField = jQuery(getInputField[s]);
                if(addressField.attr('name') != 'street_address2' && addressField.val() == ''){
                    this.ShowErrorAddress(addressField.attr('id'),' The Field is required');
                    count++
                }
            }
            
        }
        if(count == 0){
			if( CPD.isPopup == "1" ){
				var data = "action=popup_ajax&"+jQuery("div.fancybox-wrap form#"+id).serialize();
				jQuery.ajax({
					url: CPD.ajaxUrl, 
					type: 'POST',
					data: data, 
					dataType: 'json',
					success: function( response ) {
						if( response.success == "OK" ){
							alert(response.msg);
							jQuery.fancyboxrun.close();
						}else{
							alert(response.msg);
							jQuery.fancyboxrun.close();
						}
					}
				})
				return false;
			}
            return true;
        }else{
            return false;
        }
    }
    
    
    this.ShowError = function(cls,text){
        var parent = jQuery("."+cls).parent('li');
        var children = jQuery("."+cls);
        //        var pos = parent.position();
        var nameErrorId = 'ErrorObject'+cls;
        if(jQuery("#"+nameErrorId).length == 0){
            var html = '<div id="'+nameErrorId+'" class="hidden cpd_errorFrondEnd">';
            html += '<div class="cpd_errorArrow_left">&nbsp;</div>';
            html += '<div class="cpd_errorArrow_repeat">'+text+'</div>';
            html += '<div class="cpd_errorArrow_right">&nbsp;</div>';
            html += '</div>';
            parent.append(html);
        }
        var w = children.width();
        var h = children.height();
        var ObjError = jQuery("#"+nameErrorId);
        if(ObjError.is(':animated')){
            return false;
        }
        var center = parseInt(h)/2 - parseInt(ObjError.height())/2;
        ObjError.css('left',w);
        ObjError.css('top',center);
        ObjError.show('bounce',{
            times:3,
            direction:'right'
        },500,function(){
            ObjError.delay('1000').hide('bounce',{
                times:3,
                direction:'right'
            },500,function(){
                jQuery('.cpdFieldSubmitButton').removeAttr('disabled');
                ObjError.remove();
            });
        });                                
    }
    
    this.ShowErrorAddress = function(id,text){
        var parent = jQuery("#"+id).parent('p');
        var children = jQuery("#"+id);
        var nameErrorId = 'ErrorObject'+id;
        if(jQuery("#"+nameErrorId).length == 0){
            var html = '<div id="'+nameErrorId+'" class="hidden cpd_errorFrondEnd">';
            html += '<div class="cpd_errorArrow_left">&nbsp;</div>';
            html += '<div class="cpd_errorArrow_repeat">'+text+'</div>';
            html += '<div class="cpd_errorArrow_right">&nbsp;</div>';
            html += '</div>';
            parent.append(html);
        }
        var pos = children.position();
        var w = children.width();
        //        var h = children.height();
        //        
        var ObjError = jQuery("#"+nameErrorId);
        if(ObjError.is(':animated')){
            return false;
        }
        
        //        
        //        var center = parseInt(h)/2;
        //        
        ObjError.css('left',pos.left + w);
        ObjError.css('top',pos.top);
        ObjError.show('bounce',{
            times:3,
            direction:'right'
        },500,function(){
            ObjError.delay('1000').hide('bounce',{
                times:3,
                direction:'right'
            },500,function(){
                jQuery('.cpdFieldSubmitButton').removeAttr('disabled');
                ObjError.remove();
            });
        });                        
        
    }
    
    this.validateEmail = function(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
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
}
jQuery(document).ready(function(){
//    CPD = new CPD
    var captcha = jQuery("#recaptcha_response_field");
    if(captcha){
        captcha.addClass('required');
    }
    
    var input =  jQuery("#cpdFormSumit input");

    for(var i=0; i<input.length; i++){
        var  el = jQuery(input[i]);
        var attr_type = el.attr('type');
        var getAttrTitle = el.attr('title');
        if(attr_type != "hidden" || attr_type != 'submit' || attr_type != 'button'){
            if(jQuery.trim(getAttrTitle) != ''){
                var textId  = 'cpd_field_type_input_'+i;
                el.attr('id',textId);
            }
            var id = jQuery("#"+textId);
            var h = id.height();
            var  label = '<label style="top:'+parseInt(h)/4+'px !important; line-height:'+h+'px  !important;" class="cpd_append_label" id="idLabel_'+textId+'" for="'+textId+'">'+getAttrTitle+'</label>';
            var appObject = jQuery('#idLabel_'+textId);
            if(appObject.length == 0){
                id.parent('li').append(label);
            }
        }
    }
    jQuery('.CPD label').inFieldLabels();
	setTimeout(function() {
		jQuery('#cpdFormSumit .submit-success').fadeOut(3000);
		jQuery('#cpdFormSumit .submit-error').fadeOut(3000);
	}, 500);	
});


$(function(){

	$("#submit-button").click(function(){
		
		$("#loading").fadeIn(100).show();
		
		var from = $("#from").val();
		var to = $("#to").val();
		var subject = $("#subject").val();
		var content = $("#content").val();
		
		var data = "from=" + from + "&to=" + to + "&subject=" + subject + "&content=" + content;
		
		if(to == ""){
			
			$("#error-to").fadeIn(700).show();
			$("#loading").fadeOut(100).hide();
			
		}else if(from == ""){
			
			$("#error-from").fadeIn(700).show();
			$("#loading").fadeOut(100).hide();
			
		}else if(subject == ""){
			
			$("#error-subject").fadeIn(700).show();
			$("#loading").fadeOut(100).hide();
			
		}else if(content == ""){
			
			$("#error-content").fadeIn(700).show();
			$("#loading").fadeOut(100).hide();
			
		}else{
			
			$.ajax({
				type: "POST",
				url: "send.php",
				data: data,
				success: function(){
					
					$("#loading").fadeOut(100).hide();
					$('#message-sent').fadeIn(500).show();
					
				}
			});
			
		}
		
	});	
	
});
var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#product" ).serialize();
	var code = parseInt($( "input[name='code']" ).val());
	if (code == 0){
		$.post( api, formData , function(data){			
			alert("product has been inserted");
			window.location.href = target;
		}).fail(function(){
			alert('error');
		});	
	} else {
		api = $( "#api" ).attr("url") + '/' + $(this).attr('code');
		$.ajax({url: api, type: 'PUT', data: formData}).done(function(data){
			alert("product has been updated");
			window.location.href =  target;
		}).fail(function(){
			alert('error');
		});
	}	
};

$(document).ready(function(){
	$("#save").click(save);
});
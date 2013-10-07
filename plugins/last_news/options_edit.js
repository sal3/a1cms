$(document).ready(function(){
	$( "#configform" ).on( "submit", function( event ) {
		event.preventDefault();
		SaveNewsOptions ( $(this).serialize() );
	});	
})

function SaveNewsOptions (sdata) {
// 	alert(sdata);
	$.ajax({
		url: site_path+"/plugins/related/options_save_ajax.php",
		type: "POST",
		data: sdata,
		dataType: "json",
		success: function(data)
		{
			if(data.result==1)
				showAlert(data.resultmessage, "ui-state-success");
			else
				showAlert(data.resultmessage, "ui-state-error");
		}
	})
}
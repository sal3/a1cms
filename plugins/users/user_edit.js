$(document).ready(function(){
	$( "#userform" ).on( "submit", function( event ) {
		event.preventDefault();
		SaveNewsOptions ( $(this).serialize() );
	});
	$( "#avatar_edit" ).click(function(){
		alert('тут будет окно редактирования авы');
		return false;
	});
})

function SaveNewsOptions (sdata) {
// 	alert(sdata);
	$.ajax({
		url: site_path+"/plugins/users/user_edit_save_ajax.php",
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
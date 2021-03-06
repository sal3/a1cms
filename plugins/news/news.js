$(document).ready(function(){
	$( "#configform" ).on( "submit", function( event ) {
		event.preventDefault();
		SaveNewsOptions ( $(this).serialize() );
	});	
})

function SaveNewsOptions (sdata) {
// 	alert(sdata);
	$.ajax({
		url: site_path+"/plugins/news/options_save_ajax.php",
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

//само удаление
function NewsDelExec(id, redirto)
{
	$.getJSON(site_path+'/plugins/news/newsdel.php', {action: 'del', id: id/*, redirto:redirto*/},function(data){
		
		if(data.result==0)
		{
			$("#myModalLabel").html(data.title);
			$("#myModalBody").html(data.resultmessage);
			$("#myModal #myModalOkBtn").remove();
		}
		else
		{
// 			$("#myModal").modal('hide');
// 			$('#post-id-'+id).slideUp('slow');
			
// 			var deleted = $('#post-id-'+id).animate( {"height": "0", "opacity": 0}, 1000 );
// 			setTimeout(function(){deleted.remove();}, 1000 );
			window.location.replace(site_path+'/admin/index.php?plugin=news&mod=newslist');

		}
	});
}

//диалог удаления
function NewsDel(id)
{
	modalCreate();

	$.getJSON(site_path+'/plugins/news/newsdel.php', {action: 'form', id: id, dialog:1},function(data)
	{
		if(data.result==0)
		{
			//ошибка
			$("#myModalLabel").html("Ошибка");
			$("#myModalBody").html(data.resultmessage);
			$("#myModal").modal('show');
		}
		else
		{
			$("#myModalLabel").html(data.title);
			$("#myModalBody").html(data.body);
			$("#myModal input:first").attr('checked','checked');
			$("#myModal #myModalOkBtn").html(data.okbtn).click(function()
			{
				var redirto=$("#myModal input:checked").val();
				NewsDelExec(id,redirto);
				$("#myModal").modal('hide');
			});
			$("#myModal").css("width","660px");
			$("#myModal").modal('show');
		}
	})
}
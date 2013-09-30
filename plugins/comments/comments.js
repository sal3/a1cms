function commAdd(news_id)
{
 	var comm_submit_btn=$('#comm_submit_btn');
 	var text = $('#comment').val();

 	if(comm_submit_btn.attr('disabled')=='disabled')
 		showAlert('Waiting', 'ui-state-error');
	else
 	{
 		comm_submit_btn.attr('disabled', 'disabled');
		$.getJSON(site_path+'/plugins/comments/comment_edit_ajax.php', {action: 'add', news_id: news_id, text: text},function(data){
			if(data.error)
			{
				showAlert(data.message, "ui-state-error");
				comm_submit_btn.removeAttr('disabled');
			}
			else
			{
				var added = $(data.comment).insertAfter('div#commentform')
				.hide()
				.slideDown("slow");

				$('#comment').val('');
				comm_submit_btn.removeAttr('disabled');
			}
		});
 	}
}

function CommEdit(id)
{
	$.getJSON(site_path+'/plugins/comments/comment_edit_ajax.php', {action: 'edit', id: id},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
	{
		var edit = $('#comm-body-id-'+id).fadeOut(310);
		setTimeout(function(){
			edit.html(data.comment).fadeIn(300);
			//FIXME!! костыль
			$("textarea").click(function(){
				window.lasttextarea=this.id;
			});
		}, 300 );
	}
});
}

function CommEditCancel(id)
{
	$.getJSON(site_path+'/plugins/comments/comment_edit_ajax.php', {action: 'cancel', id: id},function(data)
	{
		if(data.error)
			showAlert(data.message, "ui-state-error");
		else
		{
			var edit = $('#comm-body-id-'+id).fadeOut(310);
			setTimeout(function()
			{
				edit.html(data.comment).fadeIn(300);
			}, 300 );
		}
	}
	);
}

function CommEditSave(id,texareaId)
{
	var text = $('#'+texareaId).val();
//	alert(texareaIdtext);
	$.getJSON(site_path+'/plugins/comments/comment_edit_ajax.php', {action: 'save', id: id, text: text},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
		{
			var edit = $('#comm-body-id-'+id).fadeOut(310);
			setTimeout(function()
			{
				edit.html(data.comment).fadeIn(300);
			}, 300 );
		}
	});
}

function CommDel(id)
{
	if (confirm("Удалить комментарий?"))
	{
	$.getJSON(site_path+'/plugins/comments/comment_edit_ajax.php', {action: 'delete', id: id},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
		{
			var deleted = $('#comm-id-'+id).animate( {"height": "0", "opacity": 0}, 1000 );
			setTimeout(function(){deleted.remove();}, 1000 );
			showAlert(data.message, "ui-state-success");
		}
	}, "json");
	}
}
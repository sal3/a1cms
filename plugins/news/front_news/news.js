function NewsEdit(news_id, story)
{
	$.getJSON(site_path+'/plugins/news/front_news/news_edit_ajax.php', {action: 'edit', news_id: news_id, story: story},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
	{
		var edit = $('#n-id-'+news_id).fadeOut(310);
		setTimeout(function(){
			edit.html(data.news).fadeIn(300);
			//FIXME!! костыль
			$("textarea").click(function(){
				window.lasttextarea=this.id;
			});
		}, 300 );
	}
});
}

function NewsEditCancel(news_id, story)
{
	$.getJSON(site_path+'/plugins/news/front_news/news_edit_ajax.php', {action: 'cancel', news_id: news_id, story: story},function(data)
	{
		if(data.error)
			showAlert(data.message, "ui-state-error");
		else
		{
			var edit = $('#n-id-'+news_id).fadeOut(310);
			setTimeout(function()
			{
				edit.html(data.news).fadeIn(300);
			}, 300 );
		}
	}
	);
}

function NewsEditSave(news_id, texareaId, story)
{
	var text = $('#'+texareaId).val();
//	alert(texareaIdtext);
	$.getJSON(site_path+'/plugins/news/front_news/news_edit_ajax.php', {action: 'save', news_id: news_id, text: text, story: story},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
		{
			var edit = $('#n-id-'+news_id).fadeOut(310);
			setTimeout(function()
			{
				edit.html(data.news).fadeIn(300);
			}, 300 );
		}
	});
}

function NewsDel(news_id)
{
	if (confirm("Удалить новость?"))
	{
	$.getJSON(site_path+'/plugins/news/newsdel.php', {action: 'del', id: news_id},function(data){
	if(data.error)
		showAlert(data.message, "ui-state-error");
	else
		{
			window.location.replace(site_path+'/index.php');
			//var deleted = $('#n-'+news_id).animate( {"height": "0", "opacity": 0}, 1000 );
			//setTimeout(function(){deleted.remove();}, 1000 );
// 			showAlert(data.message, "ui-state-success");
		}
	}, "json");
	
	
	}
}
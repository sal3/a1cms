$(document).ready(function(){
	
	//определяем в какой категории находимся
	var hashes = [],genre1;
	hashes=getUrlDirs();
	genre1=decodeURIComponent(hashes[1]);
	window.genre2=decodeURIComponent(hashes[2]);
	
	//инициализация списка родительских категорий
	$.getJSON(site_path+'/plugins/catlist/ajax.php', function(data) {
		  $("select#cats").html(data.cats);
	
		if(genre1 != '')
			$('select#cats option[value="'+genre1+'"]').attr('selected', 'selected');
		if(window.genre2 !=  'undefined')
			$('select#cats').change();
	});
	
	//динамическая подгрузка подкатегорий в select
	$("select#cats").change(function(){
		$.getJSON(site_path+'/plugins/catlist/ajax.php', {catname:$('select#cats option:selected').val()}, function(subdata) {
			//если подкатегорий нет
			if(subdata.cats==null)
				$("select#subcats").hide();
			else
			{
				$("select#subcats").show();
				$("select#subcats").html(subdata.cats);
				
				if(window.genre2)
					$('select#subcats option[value="'+window.genre2+'"]').attr('selected', 'selected');
			}
				
			href=$('select#cats option:selected').val();
			
			if(href != "#")
			{
				href=site_path+"/"+href+"/";
				$('#catbtn').attr('href', href).removeAttr('disabled');
			}
		})
	});

	//изменение подкатегории
	$("select#subcats").change(function(){
		href=site_path+"/"+$('select#cats option:selected').val()+"/"+$('select#subcats option:selected').val()+"/";
		$('a#catbtn').attr('href', href);
	});
});
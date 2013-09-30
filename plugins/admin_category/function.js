$(document).ready(function(){
	$('#CategoryModal').modal({ show: false });
	$('.sortable').nestedSortable({
		handle: 'div',
		items: 'li',
		toleranceElement: '> div'
	});
});

function categorySort(){
	var cats = $('ol.sortable').nestedSortable('serialize');
	var url = "category=sort&"+cats;
	$.post('/plugins/admin_category/ajax.php', url, function(data){
		showAlert(data.info, data.style);
	},
	"json");
}

var categoryID=0;
function categoryEdit(id){
	categoryID = id;
	$('#cat_name').removeClass("border-color_red");
	$('#cat_url_name').removeClass("border-color_red");
	if(id==0) {
		$('#CategoryModalLabel').html("Добавление категории");
		$('#cat_name').val("");
		$('#cat_url_name').val("");
		$("#cat_parentid option:selected").attr("selected", false);
		$('#cat_description').val("");
		$('#cat_keywords').val("");
		$('#CategoryModal').modal('show');
	} else {
		$('#CategoryModalLabel').html("Редактирование категории");
		$.post('/plugins/admin_category/ajax.php',
			{category:'edit', id:id},
			function(data){
				$('#cat_name').val(data.name);
				$('#cat_url_name').val(data.url_name);
				$('#cat_parentid option').each(function(){
					if( $(this).val() == id ) $(this).attr('disabled', 'disabled');
					else $(this).attr('disabled', false);
					if( $(this).val() == data.parentid ) this.selected=true;
					else this.selected=false;
				});
				$('#cat_description').val(data.description);
				$('#cat_keywords').val(data.keywords);
				$('#CategoryModal').modal('show');
			},
		"json");
	}
}

var categoryDelTimer = [];
function categoryDel(id) {
	$('#catFunc_'+id).animate({ right:'108px' }, 500);
	categoryDelTimer[id] = setTimeout(function() {
		$('#catFunc_'+id).animate({ right:'0px' }, 500);
	}, 10000);
}
function categoryDelCancel(id) {
	clearTimeout(categoryDelTimer[id]);
	$('#catFunc_'+id).animate({ right:'0px' }, 500);
}
function categoryDelConfirm(id) {
	$.post('/plugins/admin_category/ajax.php',
		{category:'del', id:id},
		function(data){
			$('#cat_parentid').html(data.parentid);
			$('#cat_sortable').html(data.sortable);
			showAlert(data.info, data.style);
		},
	"json");
}

function categorySave() {
	var error = false;
	var name = $('#cat_name').val();
	if( $.trim(name) == "" ) {
		error = true;
		$('#cat_name').addClass("border-color_red");
	} else {
		$('#cat_name').removeClass("border-color_red");
	}
	var url_name = $('#cat_url_name').val();
	var parentid = $("#cat_parentid option:selected").val();
	var description = $('#cat_description').val();
	var keywords = $('#cat_keywords').val();
	if(error===false) {
		$.post('/plugins/admin_category/ajax.php',
			{category:'save', id:categoryID, name:name, url_name:url_name, parentid:parentid, description:description, keywords:keywords},
			function(data){
				if(data.error) {
					$('#cat_url_name').val(data.url_name);
					$('#cat_url_name').addClass("border-color_red");
					showAlert(data.error, data.style);
				} else {
					$('#CategoryModal').modal('hide');
					$('#cat_parentid').html(data.parentid);
					$('#cat_sortable').html(data.sortable);
					showAlert(data.info, data.style);
				}
			},
		"json");
	}
}
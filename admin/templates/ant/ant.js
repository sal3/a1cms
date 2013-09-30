$(document).ready(function(){
	$('.ant_tooltip').tooltip();

	var activeMenuGroup = $.cookie("activeMenuGroup");
	if(activeMenuGroup!=null) {
		$("#MenuAccordion .collapse").removeClass('in');
		$("#"+activeMenuGroup).addClass('in');//collapse("show");
	}
	$("#MenuAccordion").bind('shown', function() {
		var activeMenuGroup=$("#MenuAccordion .in").attr('id');
		$.cookie('activeMenuGroup', activeMenuGroup);
	});

	$(".chzn-select").chosen();
	$(".datepicker").datetimepicker({
		language: 'ru'
	});
});

// плюшка удаления
var DelTimer = [];
function itemDel(id) {
	$('.itemDel_'+id).animate({ right:'96px' }, 500);
	DelTimer[id] = setTimeout(function() {
		$('.itemDel_'+id).animate({ right:'0px' }, 500);
	}, 10000);
}
function itemDelCancel(id) {
	clearTimeout(DelTimer[id]);
	$('.itemDel_'+id).animate({ right:'0px' }, 500);
}
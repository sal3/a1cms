$(document).ready(function(){
	getPluginsTable('active');
});

function pluginDelConfirm(pluginname)
{
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'del'},function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			$('.plugin_'+pluginname).remove();
			//regreshPluginsTable();
		}
		else
		{
			showAlert(data.message, 'alert-error');
		}
	});
}

function getPluginsTable(state) {
	$.get(site_path+'/plugins/admin_pluginmanager/pluginmanager-table-ajax.php', {state: state},function(data){
		$("#pluginsTable").html(data);
		$(".nav-tabs li.active").removeClass('active');
		$(".nav-tabs #"+state).addClass('active');
		
		$('.ant_tooltip').tooltip();
	});
}

function regreshPluginsTable() {
	var state = $(".nav-tabs li.active").attr('id');
	getPluginsTable(state);
}


function pluginEdit(id) {
	pluginname=id;
	pluginEditGetVals();
	$("#pluginConfigModal").modal('show');
}

function pluginInfo(plugin_name) {
	modalCreate();

	$.ajax({
		url: site_path+'/plugins/'+plugin_name+'/info.html', 
		type: 'get',
		error: function(){
			$("#myModalLabel").html("Ошибка");
			$("#myModalBody").html('Файл с информацией о плагине <b>'+plugin_name+'</b> не найден');
		},
		success: function(data){
			$("#myModalLabel").html('Информация о плагине '+plugin_name);
			$("#myModalBody").html(data);
		},
		complete: function(data){
			$("#myModal #myModalOkBtn").remove();
			// $("#myModal").css("width","660px");
			$("#myModal").modal('show');
		}
	});
	
	
// 	$.get(site_path+'/plugins/'+plugin_name+'/info.txt',function(data)
// 	{
// 		alert(data);
// 		if(data==undefined)
// 		{
// 			//ошибка
// 			$("#myModalLabel").html("Ошибка");
// 			$("#myModalBody").html('Файл с информацией не найден');
// 		}
// 		else
// 		{
// 			$("#myModalLabel").html('Информация о плагине '+plugin_name);
// 			$("#myModalBody").html(data);
// 		}
// 		$("#myModal").modal('show');
// 	})
}

function pluginEditCleanVals() {
		$("#pluginConfigModal #plugin_on").removeClass('active').removeClass('disabled').unbind('click');
		$("#pluginConfigModal #plugin_off").removeClass('active').removeClass('disabled').unbind('click');
		$("#pluginConfigModal #pluginConfigLabel").html('');
		$("#pluginConfigModal #pluginVersion").val('');
		$("#pluginConfigModal #pluginSite").val('');
		$("#pluginConfigModal #pluginPriority").val('');
		$("#pluginConfigModal #pluginIcon").val('');
// 		$("#pluginConfigModal #pluginAllowedUsers").val('');
		$("#pluginConfigModal #pluginType").val('');
		$("#pluginConfigModal #plugin_installed").removeClass('active').removeClass('disabled').unbind('click');
		$("#pluginConfigModal #plugin_uninstalled").removeClass('active').removeClass('disabled').unbind('click');
		//$("#pluginConfigModal #modal-body-wait").html('');
		//$("select#pluginType option:selected").prop("selected", null);
// 		$("select#pluginGroups option:selected").prop("selected", null);

}

function pluginEditGetVals() {
	$("#pluginConfigModal").on('hidden', function () {
		pluginEditCleanVals();
	});

	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'get'},function(data){
		pluginEditCleanVals();
		$("#pluginConfigModal #pluginConfigLabel").html(data.title);
		$("#pluginConfigModal #pluginVersion").val(data.version);
		$("#pluginConfigModal #pluginSite").val(data.site);
		$("#pluginConfigModal #pluginType").val(data.cat);
		//$('select#pluginType option[value="' + data.cat + '"]').prop('selected','selected');
		$("#pluginConfigModal #pluginPriority").val(data.priority);
		$("#pluginConfigModal #pluginIcon").val(data.icon);
// 		$("#pluginConfigModal #pluginAllowedUsers").val(data.allowed_users);



		if(data.install_state==1)
		{
			$("#pluginConfigModal #plugin_installed").addClass('active');
			if(data.state==1)
			{
				$("#pluginConfigModal #plugin_on").addClass('active');
				$("#plugin_off").click(function() {
					pluginOff();
				});
			}
			else
			{
				$("#pluginConfigModal #plugin_off").addClass('active');
				$("#plugin_on").click(function() {
					pluginOn();
				});
			}
			$("#plugin_uninstalled").click(function() {
				pluginUnInstall();
			});
		}
		else if(data.install_state==0)
		{
			$("#pluginConfigModal #plugin_uninstalled").addClass('active');
			$("#pluginConfigModal #plugin_on").addClass('disabled');
			$("#pluginConfigModal #plugin_off").addClass('disabled');
			$("#pluginConfigModal #plugin_installed").attr('disabled');
			$("#plugin_installed").click(function() {
				pluginInstall();
			});
		}
		else if(data.install_state==2) {
			$("#pluginConfigModal #plugin_installed").addClass('disabled');
			$("#pluginConfigModal #plugin_uninstalled").addClass('disabled');
			if(data.state==1)
			{
				$("#pluginConfigModal #plugin_on").addClass('active');
				$("#plugin_off").click(function() {
					pluginOff();
				});
			}
			else
			{
				$("#pluginConfigModal #plugin_off").addClass('active');
				$("#plugin_on").click(function() {
					pluginOn();
				});
			}
		}

// 		$.each(data.allowed_groups,  function(ind, val)   {
// 			//console.log(val);
// 			$('select#pluginGroups option[value="' + val + '"]').prop('selected','selected');
// 		});
	});
}
/*
function modalBlock() {
	$('.modal-body-items').animate({ right:'560px' }, 300);
}

function modalBlockCancel() {
	$('.modal-body-items').animate({ right:'0px' }, 300);
	$("#pluginConfigModal #modal-body-wait").html('');
}*/
function pluginOn() {
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'on'},function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			pluginEditGetVals();
			regreshPluginsTable();
		}
		else
		{
			showAlert(data.message, 'alert-error');
			pluginEditGetVals();
		}
	});
}
function pluginOff() {
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'off'},function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			pluginEditGetVals();
			regreshPluginsTable();
		}
		else
		{
			showAlert(data.message, 'alert-error');
			pluginEditGetVals();
		}
	});
}

function pluginSave() {
	var priority = $("#pluginConfigModal #pluginPriority").val();
	var icon = $("#pluginConfigModal #pluginIcon").val();
	//var cat = $("select#pluginType").val();
// 	var allowed_users = $("#pluginConfigModal #pluginAllowedUsers").val();
// 	var allowed_groups = $("select#pluginGroups").val();
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'set', priority: priority}/*, icon: icon, cat: cat, *//*allowed_groups: allowed_groups, allowed_users:allowed_users}*/,function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			pluginEditGetVals();
		}
		else
		{
			showAlert(data.message, 'alert-error');
		}
	});
}
function pluginInstall() {
	$("#pluginConfigModal #plugin_installed").button('loading');
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'install'},function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			$("#pluginConfigModal #plugin_installed").button('reset');
			pluginEditGetVals();
			regreshPluginsTable();
		}
		else
		{
			showAlert(data.message, 'alert-error');
			$("#pluginConfigModal #plugin_installed").button('reset');
			pluginEditGetVals();
		}
	});
}

function pluginUnInstall() {
	$("#pluginConfigModal #plugin_uninstalled").button('loading');
	$.getJSON(site_path+'/plugins/admin_pluginmanager/pluginmanager-ajax.php', {id: pluginname, action: 'uninstall'},function(data){
		if(data.error==0)
		{
			showAlert(data.message, 'alert-success');
			$("#pluginConfigModal #plugin_uninstalled").button('reset');
			pluginEditGetVals();
			regreshPluginsTable();
		}
		else
		{
			showAlert(data.message, 'alert-error');
			$("#pluginConfigModal #plugin_uninstalled").button('reset');
			pluginEditGetVals();
		}
	});
}
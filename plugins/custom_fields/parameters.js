$(document).ready(function(){
	getParameterTable();

	$("#parameterModal").on('hidden', function () {
		parameterCleanVals();
	})
});

function parameterEdit(id) {
	pid=id;
	parameterGetVals();
	$("#parameterModal #parameterType").hide();
	$("#parameterModal #parameterLabel").html(editLabel);
	$("#parameterModal #okButton").html(okSaveName);
	$("#parameterModal").modal('show');
	$("#parameterModal #okButton").click(function() {
		parameterSave();
	});
}
function parameterAdd() {
	//parameterCleanVals();
	$("#parameterModal #parameterLabel").html(addLabel);
	$("#parameterModal #okButton").html(okAddName);
	$("#parameterModal").modal('show');
	$("#parameterModal #okButton").click(function() {
		parameterInsert();
	});

}

function parameterCleanVals() {
	$("#parameterModal #parameterType").show();
	$("#parameterModal #parameterName").val('');
	$("#parameterModal #okButton").unbind('click');
}

function parameterGetVals() {
	$.getJSON(site_path+'/plugins/custom_fields/parameters_ajax.php', {id: pid, action: 'get'},function(data){
		if(data.error==1)
			showAlert(data.message, 'alert-error');
		else
			$("#parameterModal #parameterName").val(data.name);
	});
}

function parameterSave() {
	var name = $("#parameterModal #parameterName").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameters_ajax.php', {id: pid, action: 'set', name: name},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			//parameterGetVals();
			getParameterTable();
		}
	});
}

function parameterInsert() {
	var name = $("#parameterModal #parameterName").val();
	var type = $("select#parameterTypeSelect").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameters_ajax.php', {action: 'insert', name: name, type: type},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
// 			parameterCleanVals();
			$("#parameterModal #parameterName").val('');
			getParameterTable();
		}
	});
}


function getParameterTable() {
// 	$.get(site_path+'/plugins/custom_fields/admin_custom_fields_table_ajax.php', function(data){
// 		//alert(data);
//  		$('#custom_fields_parameters').html(data);
//  	});
	$('#custom_fields_parameters').load(site_path+'/plugins/custom_fields/parameters_table_ajax.php');
}


function parameterDelConfirm(parameter_id)
{
	$.getJSON(site_path+'/plugins/custom_fields/parameters_ajax.php', {id: parameter_id, action: 'del'},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			$('.parameter_'+parameter_id).remove();
			//regreshPluginsTable();
		}
	});
}
$(document).ready(function(){
	getparameterValueTable();

	$("#parameterValueModal").on('hidden', function () {
		parameterValueCleanVals();
	})
});

function parameterValueEdit(id) {
	pvid=id;
	parameterValueGetVals();
// 	$("#parameterValueModal #parameterValueType").hide();
	$("#parameterValueModal #parameterValueLabel").html(editLabel);
	$("#parameterValueModal #okButton").html(okSaveName);
	$("#parameterValueModal").modal('show');
	$("#parameterValueModal #okButton").click(function() {
		parameterValueSave();
	});
}
function parameterValueAdd() {
	//parameterValueCleanVals();
	$("#parameterValueModal #parameterValueLabel").html(addLabel);
	$("#parameterValueModal #okButton").html(okAddName);
	$("#parameterValueModal").modal('show');
	$("#parameterValueModal #okButton").click(function() {
		parameterValueInsert();
	});

}

function parameterValueCleanVals() {
// 	$("#parameterValueModal #parameterValueType").show();
	$("#parameterValueModal #parameterValueName").val('');
	$("#parameterValueModal #okButton").unbind('click');
}

function parameterValueGetVals() {
	$.getJSON(site_path+'/plugins/custom_fields/parameter_values_ajax.php', {id: pvid, action: 'get'},function(data){
		if(data.error==1)
			showAlert(data.message, 'alert-error');
		else
			$("#parameterValueModal #parameterValueName").val(data.value);
	});
}

function parameterValueSave() {
	var value = $("#parameterValueModal #parameterValueName").val();
// alert(pvid+name);
	$.getJSON(site_path+'/plugins/custom_fields/parameter_values_ajax.php', {id: pvid, action: 'set', value: value},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			//parameterValueGetVals();
			getparameterValueTable();
		}
	});
}

function parameterValueInsert() {
	var value = $("#parameterValueModal #parameterValueName").val();
	//var parameter_id = $("select#parameter").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameter_values_ajax.php', {action: 'insert', value: value, parameter_id: parameterID},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
// 			parameterValueCleanVals();
			$("#parameterValueModal #parameterValueName").val('');
			getparameterValueTable();
		}
	});
}


function getparameterValueTable() {
	//alert(parameterID);
// 	$.get(site_path+'/plugins/custom_fields/admin_custom_fields_table_ajax.php', function(data){
// 		//alert(data);
//  		$('#custom_fields_parameterValues').html(data);
//  	});
	$('#custom_fields_parameterValues').load(site_path+'/plugins/custom_fields/parameter_values_table_ajax.php', {parameterID: parameterID});
}


function parameterValueDelConfirm(parameterValueId)
{
	$.getJSON(site_path+'/plugins/custom_fields/parameter_values_ajax.php', {id: parameterValueId, action: 'del'},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			$('.parameterValue_'+parameterValueId).remove();
			//regreshPluginsTable();
		}
	});
}
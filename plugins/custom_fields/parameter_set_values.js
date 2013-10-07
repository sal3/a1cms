$(document).ready(function(){
	getparameter_setValueTable();

	$("#parameter_setValueModal").on('hidden', function () {
		parameter_setValueCleanVals();
	})
});

// function parameter_setValueEdit(id) {
// 	pvid=id;
// 	parameter_setValueGetVals();
// // 	$("#parameter_setValueModal #parameter_setValueType").hide();
// 	$("#parameter_setValueModal #parameter_setValueLabel").html(editLabel);
// 	$("#parameter_setValueModal #okButton").html(okSaveName);
// 	$("#parameter_setValueModal").modal('show');
// 	$("#parameter_setValueModal #okButton").click(function() {
// 		parameter_setValueSave();
// 	});
// }
function parameter_setValueAdd() {
	//parameter_setValueCleanVals();
	$("#parameter_setValueModal #parameter_setValueLabel").html(addLabel);
	$("#parameter_setValueModal #okButton").html(okAddName);
	$("#parameter_setValueModal").modal('show');
	$("#parameter_setValueModal #okButton").click(function() {
		parameter_setValueInsert();
	});

}

function parameter_setValueCleanVals() {
// 	$("#parameter_setValueModal #parameter_setValueType").show();
	$("#parameter_setValueModal #parameter_setValueName").val('');
	$("#parameter_setValueModal #okButton").unbind('click');
}

// function parameter_setValueGetVals() {
// 	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_values_ajax.php', {id: pvid, action: 'get'},function(data){
// 		if(data.error==1)
// 			showAlert(data.message, 'alert-error');
// 		else
// 			$("#parameter_setValueModal #parameter_setValueName").val(data.value);
// 	});
// }

// function parameter_setValueSave() {
// 	var value = $("#parameter_setValueModal #parameter_setValueName").val();
// // alert(pvid+name);
// 	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_values_ajax.php', {id: pvid, action: 'set', value: value},function(data){
// 		if(data.error==1)
// 		{
// 			showAlert(data.message, 'alert-error');
// 		}
// 		else
// 		{
// 			showAlert(data.message, 'alert-success');
// 			//parameter_setValueGetVals();
// 			getparameter_setValueTable();
// 		}
// 	});
// }

function parameter_setValueInsert() {
	//var value = $("#parameter_setValueModal #parameter_setValueName").val();
	var parameter_id = $("select#parametersList").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_values_ajax.php', {action: 'insert', parameter_id: parameter_id, category_id: category_id},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
// 			parameter_setValueCleanVals();
			$("#parameter_setValueModal #parameter_setValueName").val('');
			getparameter_setValueTable();
		}
	});
}


function getparameter_setValueTable() {
	//alert(category_id);
// 	$.get(site_path+'/plugins/custom_fields/admin_custom_fields_table_ajax.php', function(data){
// 		//alert(data);
//  		$('#custom_fields_parameter_setValues').html(data);
//  	});
	$('#custom_fields_parameter_setValues').load(site_path+'/plugins/custom_fields/parameter_set_values_table_ajax.php', {category_id: category_id});
}


function parameter_setValueDelConfirm(parameter_setValueId)
{
	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_values_ajax.php', {id: parameter_setValueId, action: 'del'},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			$('.parameter_setValue_'+parameter_setValueId).remove();
			//regreshPluginsTable();
		}
	});
}
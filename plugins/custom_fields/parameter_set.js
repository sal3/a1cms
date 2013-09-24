$(document).ready(function(){
	getparameter_setTable();

// 	$("#parameter_setModal").on('hidden', function () {
// 		parameter_setCleanVals();
// 	})
});
/*
function parameter_setEdit(id) {
	psid=id;
	parameter_setGetVals();
	$("#parameter_setModal #parameter_setType").hide();
	$("#parameter_setModal #parameter_setLabel").html(editLabel);
	$("#parameter_setModal #okButton").html(okSaveName);
	$("#parameter_setModal").modal('show');
	$("#parameter_setModal #okButton").click(function() {
		parameter_setSave();
	});
}
function parameter_setAdd() {
	//parameter_setCleanVals();
	$("#parameter_setModal #parameter_setLabel").html(addLabel);
	$("#parameter_setModal #okButton").html(okAddName);
	$("#parameter_setModal").modal('show');
	$("#parameter_setModal #okButton").click(function() {
		parameter_setInsert();
	});

}

function parameter_setCleanVals() {
	$("#parameter_setModal #parameter_setType").show();
	$("#parameter_setModal #parameter_setName").val('');
	$("#parameter_setModal #okButton").unbind('click');
}

function parameter_setGetVals() {
	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_ajax.php', {id: psid, action: 'get'},function(data){
		if(data.error==1)
			showAlert(data.message, 'alert-error');
		else
			$("#parameter_setModal #parameter_setName").val(data.name);
	});
}

function parameter_setSave() {
	var name = $("#parameter_setModal #parameter_setName").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_ajax.php', {id: psid, action: 'set', name: name},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
			//parameter_setGetVals();
			getparameter_setTable();
		}
	});
}

function parameter_setInsert() {
	var name = $("#parameter_setModal #parameter_setName").val();
	var type = $("select#parameter_setTypeSelect").val();

	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_ajax.php', {action: 'insert', name: name, type: type},function(data){
		if(data.error==1)
		{
			showAlert(data.message, 'alert-error');
		}
		else
		{
			showAlert(data.message, 'alert-success');
// 			parameter_setCleanVals();
			$("#parameter_setModal #parameter_setName").val('');
			getparameter_setTable();
		}
	});
}*/


function getparameter_setTable() {
// 	$.get(site_path+'/plugins/custom_fields/admin_custom_fields_table_ajax.php', function(data){
// 		//alert(data);
//  		$('#custom_fields_parameter_set').html(data);
//  	});
	$('#custom_fields_parameter_set').load(site_path+'/plugins/custom_fields/parameter_set_table_ajax.php');
}


// function parameter_setDelConfirm(parameter_set_id)
// {
// 	$.getJSON(site_path+'/plugins/custom_fields/parameter_set_ajax.php', {id: parameter_set_id, action: 'del'},function(data){
// 		if(data.error==1)
// 		{
// 			showAlert(data.message, 'alert-error');
// 		}
// 		else
// 		{
// 			showAlert(data.message, 'alert-success');
// 			$('.parameter_set_'+parameter_set_id).remove();
// 			//regreshPluginsTable();
// 		}
// 	});
// }
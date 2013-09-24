$(document).ready(function(){
	get_custom_fields();
	
	$("#cat").on('change', function () {
		get_custom_fields();
	});
});

function get_custom_fields ()
{
	cats=$("#cat").val();
	newsid=$("#newsid").val();
	
	if(newsid>0)
		$('#custom_parameters').load(site_path+'/plugins/custom_fields/custom_fields_parameter_newsform_ajax.php', {cats: cats, newsid: newsid});
	else
		$('#custom_parameters').load(site_path+'/plugins/custom_fields/custom_fields_parameter_newsform_ajax.php', {cats: cats});
}
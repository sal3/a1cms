<?

if (!defined('a1cms'))
	die('Access denied to custom_fields!');

	$uninstall_query = "DROP TABLE IF EXISTS `{P}_parameters`;";
	query($uninstall_query) or $error[] = "Ошибка деинсталляции _parameters";
	
	$uninstall_query2 = "DROP TABLE IF EXISTS `{P}_parameters_relation;";
	query($uninstall_query2) or $error[] = "Ошибка деинсталляции _parameters_relation";
	
	$uninstall_query3 = "DROP TABLE IF EXISTS `{P}_parameter_set_values`;";
	query($uninstall_query3) or $error[] = "Ошибка деинсталляции _parameter_set_values";
	
	$uninstall_query4 = "DROP TABLE IF EXISTS `{P}_parameter_types`;";
	query($uninstall_query4) or $error[] = "Ошибка деинсталляции _parameter_types";
	
	$uninstall_query5 = "DROP TABLE IF EXISTS `{P}_parameter_values`;";
	query($uninstall_query5) or $error[] = "Ошибка деинсталляции _parameter_values";
?>

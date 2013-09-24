<?

if (!defined('a1cms'))
	die('Access denied to custom_fields!');

if($_GET['action']=='parameters')
{
	$parameter_types_query = "SELECT `id`, `typename` from `{P}_parameter_types` ORDER by `typename`";
	$parameter_types_sql = query($parameter_types_query);
// 	$parameter_typesList="<option value='0'>Ни одной из групп</option>";
	while($parameter_types_row = fetch_assoc($parameter_types_sql))
	{
		$parameter_typesList.="<option value=\"{$parameter_types_row['id']}\">{$parameter_types_row['typename']}</option>";
	}
	
	$tpl=get_template('custom_fields_parameters',1);
	$parse_admin['{module}']=parse_template($tpl, array('{editLabel}'=>'Редактирование параметра',
	'{addLabel}'=>'Добавление параметра',
	'{okAddName}'=>'Добавить',
	'{okSaveName}'=>'Сохранить',
	'{parameter_typesList}'=>$parameter_typesList,
	));
	
	
}
elseif($_GET['action']=='parameter_values')
{
	$parameters_query = "SELECT id, name from {P}_parameters ORDER by `name`";
	$parameters_sql = query($parameters_query);
// 	$parametersList="<option value='0'>Ни одной из групп</option>";
	while($parameters_row = fetch_assoc($parameters_sql))
	{
		$parametersList.="<option value=\"{$parameters_row['id']}\">{$parameters_row['name']}</option>";
	}


	$tpl=get_template('custom_fields_parameter_values',1);
	$parse_admin['{module}']=parse_template($tpl, array('{editLabel}'=>'Редактирование параметра',
	'{addLabel}'=>'Добавление значения параметра',
	'{okAddName}'=>'Добавить значение параметра',
	'{okSaveName}'=>'Сохранить значение параметра',
	'{parameterID}'=>$_GET['id'],
	'{parametersList}'=>$parametersList,
	));
}
elseif($_GET['action']=='parameter_set')
{
	$tpl=get_template('custom_fields_parameter_set',1);
	$parse_admin['{module}']=parse_template($tpl, array(/*'{editLabel}'=>'Редактирование набора',
	'{addLabel}'=>'Новый набор',
	'{okAddName}'=>'Добавить',
	'{okSaveName}'=>'Сохранить',*/
	));
}
elseif($_GET['action']=='parameter_set_values')
{
	$parameters_query = "SELECT id, name from {P}_parameters ORDER by `name`";
	$parameters_sql = query($parameters_query);
// 	$parametersList="<option value='0'>Ни одной из групп</option>";
	while($parameters_row = fetch_assoc($parameters_sql))
	{
		$parametersList.="<option value=\"{$parameters_row['id']}\">{$parameters_row['name']}</option>";
	}


	$tpl=get_template('custom_fields_parameter_set_values',1);
	$parse_admin['{module}']=parse_template($tpl, array('{editLabel}'=>'Редактирование параметра',
	'{addLabel}'=>'Добавление значения параметра',
	'{okAddName}'=>'Добавить значение параметра',
	'{okSaveName}'=>'Сохранить значение параметра',
	'{category_id}'=>$_GET['id'],
	'{parametersList}'=>$parametersList,
	));
}
else
{
	$tpl=get_template('custom_fields',1);
	$parse_admin['{module}']=parse_template($tpl, $custom_fields);
}

?>
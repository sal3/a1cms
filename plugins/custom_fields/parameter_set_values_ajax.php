<?php
define('root', substr(dirname( __FILE__ ), 0, -22));

include_once root.'/ajax/ajax_init.php';
include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array($_SESSION['user_group'], $custom_fields_config['allow_cf_control']))
	die("Access denied to custom_fields!");

/*if($_GET['action']=='get') {
	if($_GET['id'])
	{
		$parameters_query = "SELECT value from {P}_parameter_set_values where id=i<id>;";
		$parameters_row = single_query($parameters_query,array('id'=>$_GET['id'])) or $error[]='Не удалось получить данные с БД';
		if(!$error)
			echo json_encode($parameters_row);
	}
	else
		$error[]='Нет id';
}
elseif($_GET['action']=='set') {
	if($_GET['id'] and $_GET['value'])
	{
		$value = preg_replace('/[^a-zA-Zа-яА-ЯIіЇїЄєҐґ\-’,;:0-9\s\.\']/siu','',$_GET['value']);
		if($value != $_GET['value'])
			$error[]='В имени значения параметра обнаружены недопустимые символы';
		else
		{
			$parameters_query = "update {P}_parameter_set_values set value=<value> where id=i<id>;";
			query($parameters_query,array('id'=>$_GET['id'],'value'=>$value)) or $error[]='Не удалось сохранить данные в БД';
			if(!$error)
				echo json_encode(array('error'=>0,'message'=>'Сохранено успешно'));
		}
	}
	else
		$error[]='Нет id или value';
}
else*/
if($_GET['action']=='insert') {
	if($_GET['category_id'] and $_GET['parameter_id'])
	{
		$parameters_query = "insert into {P}_parameter_set_values (category_id, parameter_id) values (i<category_id>, i<parameter_id>);";
		query($parameters_query,array('category_id'=>$_GET['category_id'],'parameter_id'=>$_GET['parameter_id'])) or $error[]='Не удалось сохранить данные в БД';
		if(!$error)
			echo json_encode(array('error'=>0,'message'=>'Добавлено успешно'));
	}
	else
		$error[]='Нет category_id или parameter_id';
}
elseif($_GET['action']=='del') {
	if($_GET['id'])
	{
		$vars['id']=$_GET['id'];

// 		$parameters_query = "DELETE from {P}_parameters where id=i<id>;";
// 		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

// 		$parameters_query = "DELETE from {P}_parameters_relation where parameter_value_id=i<id>;";
// 		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		$parameters_query = "DELETE from {P}_parameter_set_values where id=i<id>;";
		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

// 		$parameters_query = "DELETE from {P}_parameter_set_values where parameter_id=i<id>;";
// 		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		if(!$error)
			echo json_encode(array('error'=>0,'message'=>'Удалено успешно'));
	}
	else
		$error[]='Нет id';
}

if($error)
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));
?>

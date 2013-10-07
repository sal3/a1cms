<?php
define('root', substr(dirname( __FILE__ ), 0, -22));

include_once root.'/ajax/ajax_init.php';
include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array($_SESSION['user_group'], $custom_fields_config['allow_cf_control']))
	die("Access denied to custom_fields!");

if($_GET['action']=='get') {
	if($_GET['id'])
	{
		$parameter_set_query = "SELECT name from {P}_parameter_set where id=i<id>;";
		$parameter_set_row = single_query($parameter_set_query,array('id'=>$_GET['id'])) or $error[]='Не удалось получить данные с БД';
		if(!$error)
			echo json_encode($parameter_set_row);
	}
	else
		$error[]='Нет id';
}
elseif($_GET['action']=='set') {
	if($_GET['id'] and $_GET['name'])
	{
		$name = preg_replace('/[^a-zA-Zа-яА-ЯIіЇїЄєҐґ\-’,;:0-9\s\.\']/siu','',$_GET['name']);
		if($name != $_GET['name'])
			$error[]='В имени параметра обнаружены недопустимые символы';
		else
		{
			$parameter_set_query = "update {P}_parameter_set set name=<name> where id=i<id>;";
			query($parameter_set_query,array('id'=>$_GET['id'],'name'=>$name)) or $error[]='Не удалось сохранить данные в БД';
			if(!$error)
				echo json_encode(array('error'=>0,'message'=>'Сохранено успешно'));
		}
	}
	else
		$error[]='Нет id или name';
}
elseif($_GET['action']=='insert') {
	if($_GET['name'])
	{
		$name = preg_replace('/[^a-zA-Zа-яА-ЯIіЇїЄєҐґ\-’,;:0-9\s\.\']/siu','',$_GET['name']);

		if($name != $_GET['name'])
			$error[]='В имени параметра обнаружены недопустимые символы';
		else
		{
			$parameter_set_query = "insert into {P}_parameter_set (name) values (<name>);";
			query($parameter_set_query,array('name'=>$name)) or $error[]='Не удалось сохранить данные в БД';
			if(!$error)
				echo json_encode(array('error'=>0,'message'=>'Добавлено успешно'));
		}
	}
	else
		$error[]='Нет name';
}
elseif($_GET['action']=='del') {
	if($_GET['id'])
	{
		$vars['id']=$_GET['id'];

		$parameter_set_query = "DELETE from {P}_parameter_set where id=i<id>;";
		query($parameter_set_query,$vars) or $error[]='Не удалось удалить данные с БД';

		$parameter_set_query = "DELETE from {P}_parameter_set_values where parameter_set_id=i<id>;";
		query($parameter_set_query,$vars) or $error[]='Не удалось удалить данные с БД';

		if(!$error)
			echo json_encode(array('error'=>0,'message'=>'Удалено успешно'));
	}
	else
		$error[]='Нет id';
}

if($error)
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));
?>
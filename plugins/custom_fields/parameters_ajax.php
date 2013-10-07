<?php
error_reporting(7);
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname( __FILE__ ), 0, -22));

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array($_SESSION['user_group'], $custom_fields_config['allow_cf_control']))
	die("Access denied to custom_fields!");

if($_GET['action']=='get') {
	if($_GET['id'])
	{
		$parameters_query = "SELECT name from {P}_parameters where id=i<id>;";
		$parameters_row = single_query($parameters_query,array('id'=>$_GET['id'])) or $error[]='Не удалось получить данные с БД';
		if(!$error)
			echo json_encode($parameters_row);
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
			$parameters_query = "update {P}_parameters set name=<name> where id=i<id>;";
			query($parameters_query,array('id'=>$_GET['id'],'name'=>$name)) or $error[]='Не удалось сохранить данные в БД';
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
			$parameters_query = "insert into {P}_parameters (name, type) values (<name>, i<type>);";
			query($parameters_query,array('name'=>$name,'type'=>$_GET['type'])) or $error[]='Не удалось сохранить данные в БД';
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

		$parameters_query = "DELETE from {P}_parameters where id=i<id>;";
		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		$parameters_query = "DELETE from {P}_parameters_relation where parameter_id=i<id>;";
		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		$parameters_query = "DELETE from {P}_parameter_values where parameter_id=i<id>;";
		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		$parameters_query = "DELETE from {P}_parameter_set_values where parameter_id=i<id>;";
		query($parameters_query,$vars) or $error[]='Не удалось удалить данные с БД';

		if(!$error)
			echo json_encode(array('error'=>0,'message'=>'Удалено успешно'));
	}
	else
		$error[]='Нет id';
}

if($error)
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));
?>

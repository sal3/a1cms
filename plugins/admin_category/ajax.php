<?php

error_reporting(0);
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname(__FILE__), 0, -23));

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';


$id = intval($_POST['id']);

#*** Сохранение сортировки категорий ***#
if(!in_array ($_SESSION['user_group'], $cats_config['allow_control']))
	echo 'нет прав';
elseif($_POST['category']=="sort") 
{
	if(!count($_POST['list'])) die("error");
	$i=0;
	$sql_v = array();
	foreach($_POST['list'] as $c => $pid) 
	{
		if($c) 
		{
			$i++;
			$sql_q[] = "(".intval($c).", ".intval($pid).", ".intval($i).")";
		}
	}
	$sql = "INSERT INTO {P}_categories (`id`, `parentid`, `position`) VALUES ".implode(", ", $sql_q)." ON DUPLICATE KEY UPDATE parentid = VALUES(parentid), position = VALUES(position)";
	query($sql, array('none'=>'none'));

	@unlink(root.'/cache/cats/categorys.tmp');
	$alert = "Категории отсортированны!";
	echo "{\"info\":\"".sjson_encode($alert)."\", \"style\":\"".sjson_encode("alert-success")."\"}";

#*** Удаление категории ***#
}
elseif($_POST['category']=="del") 
{
	if($id==0) die("{\"info\":\"".sjson_encode("Не выбрана категория!")."\", \"style\":\"".sjson_encode("alert-error")."\"}");

	$row = single_query("SELECT id FROM {P}_categories WHERE parentid=i<id>", array('id'=>$id));
	if($row['id']) die("{\"info\":\"".sjson_encode("Выбранная категория содержит подкатегории!<br>Переместите все подкатегории прежде чем удалять категорию!")."\", \"style\":\"".sjson_encode("alert-error")."\"}");


	query("DELETE FROM {P}_categories WHERE id=i<id>", array('id'=>$id));

	@unlink(root.'/cache/cats/categorys.tmp');

	include_once "function.php";
	$category = CategoriesGet();
	$sortable = CategoriesSort();
	$parentid = "<option value=\"0\"></option>".CategoriesSelect();
	$alert = "Категория удалена!";
	echo "{\"parentid\":\"".sjson_encode($parentid)."\", \"info\":\"".sjson_encode($alert)."\", \"sortable\":\"".sjson_encode($sortable)."\", \"style\":\"".sjson_encode("alert-success")."\"}";

#*** Сохранение при редактировании/добавлении категории ***#
}
elseif($_POST['category']=="save") 
{
	$name = trim(strip_tags($_POST['name']));
	if($name == "" OR !$name) die("{\"error\":\"".sjson_encode("Не указано имя категории!")."\", \"style\":\"".sjson_encode("alert-error")."\"}");

	$url_name = trim(strip_tags($_POST['url_name']));
	if($url_name == "" OR !$url_name) $url_name = $name;

	$url_name = preg_replace("/\s+/ms", "-", $url_name);
	$url_name = str_replace("/", "-", $url_name);
	$url_name = preg_replace('#[\-]+#i', '-', $url_name);
	$url_name = preg_replace('#[.]+#i', '.', $url_name);
	$url_name = mb_strtolower($url_name, 'UTF-8');
	$url_name = str_ireplace(".php", "", $url_name);

	if($id>0) 
	{
		$row=single_query("SELECT id, name, url_name FROM {P}_categories WHERE url_name=<url_name> AND id<>i<id>", array('url_name'=>$url_name, 'id'=>$id));
	} 
	else 
	{
		$row = single_query("SELECT id FROM {P}_categories WHERE url_name=<url_name>", array('url_name'=>$url_name));
	}
	
	if($row['id'])
		die("{\"error\":\"".sjson_encode("<b>Такое альтернативное имя уже есть!</b><br>Категория: {$row['name']}<br>Альтнайм: {$row['url_name']}")."\", \"style\":\"".sjson_encode("alert-error")."\", \"url_name\":\"".sjson_encode($url_name)."\"}");

	if($id>0)
	{
		$sql_q = "UPDATE {P}_categories SET
			`parentid`=i<parentid>,
			`name`=<name>,
			`url_name`=<url_name>,
			`description`=<description>,
			`keywords`=<keywords>
			 WHERE `id`=i<id>";
		$sql_v = array(
			'parentid'=>$_POST['parentid'],
			'name'=>$name,
			'url_name'=>$url_name,
			'description'=>$_POST['description'],
			'keywords'=>$_POST['keywords'],
			'id'=>$id
		);
		
		query($sql_q, $sql_v);
		
		$alert = "Отредактировано успешно";
	} 
	else 
	{
		$sql_q = "INSERT INTO {P}_categories (`parentid`, `position`, `name`, `url_name`, `description`, `keywords`) VALUES (i<parentid>, i<position>, <name>, <url_name>, <description>, <keywords>)";
		$sql_v = array(
			'parentid'=>$_POST['parentid'],
			'position'=>$_POST['position'],
			'name'=>$name,
			'url_name'=>$url_name,
			'description'=>$_POST['description'],
			'keywords'=>$_POST['keywords']
		);
		
		query($sql_q, $sql_v);
		
		$alert = "Добавлено успешно";
	}
	@unlink(root.'/cache/cats/categorys.tmp');

	include_once "function.php";
	$category = CategoriesGet();
	$sortable = CategoriesSort();
	$parentid = "<option value=\"0\"></option>".CategoriesSelect();
	echo "{\"parentid\":\"".sjson_encode($parentid)."\", \"info\":\"".sjson_encode($alert)."\", \"sortable\":\"".sjson_encode($sortable)."\", \"style\":\"".sjson_encode("alert-success")."\"}";

#*** Вывод информации для редактирования категории ***#
}
elseif($_POST['category']=="edit") 
{
	if($id==0) die("error");
	$row = single_query("SELECT * FROM {P}_categories WHERE id=i<id>", array('id'=>$id));

	$category = CategoriesGet();
	$parentid = "<option value=\"0\"></option>".CategoriesSelect($row['parentid']);

	echo "{\"id\":\"{$row['id']}\", \"parentid\":\"{$row['parentid']}\", \"position\":\"{$row['position']}\", \"name\":\"".sjson_encode($row['name'])."\", \"url_name\":\"".sjson_encode($row['url_name'])."\", \"description\":\"".sjson_encode($row['description'])."\", \"keywords\":\"".sjson_encode($row['keywords'])."\"}";
}
else 
{
	echo "Ошибка запроса!";
}
?>
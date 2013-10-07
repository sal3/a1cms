<?php

header('Content-type: application/json; charset=utf-8');
error_reporting(0);
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))
    session_start();
    
include_once root.'/sys/engine.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/categories.php';

$parentcatname=safe_text($_GET['catname']);

if($engine_config['cache_enable']=='1')
{
	if(!$parentcatname and file_exists($engine_config['json_cat_tree_cache_file']))
	{
		$json_cat_menu_string = file_get_contents($engine_config['json_cat_tree_cache_file']);
		$debug[]= "json дерево родительских категорий взято с кеша.";
	}
	elseif($parentcatname and file_exists($engine_config["json_subcat_tree_cache_file"].$parentcatname.".tmp"))
	{
		$json_cat_menu_string = file_get_contents($engine_config["json_subcat_tree_cache_file"].$parentcatname.".tmp");
		$debug[]= "json дерево подкатегорий категории $parentcatname взято с кеша.";
	}
}
if(!$parentcatname and !isset($json_cat_menu_string))
{
	foreach ($cat_array as $k=>$v)
	{
		if($v['parentid']==0)
		{
			if(in_array($v['url_name'],$cat_parent_altnames_array))
				$b=" &rsaquo;&rsaquo;";
			else
				unset($b);
			$json_cat_menu_string.="<option value=\"".$v['url_name']."\">".htmlspecialchars($v['name'], ENT_QUOTES, 'utf-8').$b."</option>\r\n";
		}
	}
	$json_cat_menu_string="<option selected=\"selected\" disabled=\"disabled\" value=\"#\">Категории</option>\r\n".$json_cat_menu_string;

	$json_cat_menu_string = json_encode(array('cats' =>$json_cat_menu_string));

	if($engine_config['cache_enable']=='1')
	{
		file_put_contents($engine_config['json_cat_tree_cache_file'], $json_cat_menu_string);
		$debug[]= "json дерево родительских категорий записано в кеш.";
	}
}
elseif($parentcatname and !isset($json_cat_menu_string))
{
	foreach ($cat_array as $k=>$v)
	{
		if($v['parent_url_name']==$parentcatname)
		{
			$json_cat_menu_string.="<option value=\"".$v['url_name']."\">".htmlspecialchars($v['name'], ENT_QUOTES, 'utf-8')."</option>\r\n";
		}
	}

	if($json_cat_menu_string)
		$json_cat_menu_string="<option selected=\"selected\" disabled=\"disabled\" value=\"#\">Выберите подкатегорию</option>\r\n".$json_cat_menu_string;

	$json_cat_menu_string = json_encode(array('cats' =>$json_cat_menu_string));

	if($engine_config['cache_enable']=='1')
	{
		file_put_contents($engine_config["json_subcat_tree_cache_file"].$parentcatname.".tmp", $json_cat_menu_string);
		$debug[]= "json дерево дочерних категорий записано в кеш.";
	}
}

echo $json_cat_menu_string;

?>
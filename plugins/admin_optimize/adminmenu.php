<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

// 	if(in_array($_SESSION['user_group'],$optimize_config['allow_control']))
// 	{
// 		$admin_menu[]=array(
// 		'pluginname'=>'admin_optimize',
// 		'cat' => 'administration',
// 		'title'=>'Пересоздать sitemap',
// 		'get_params'=>'&undermod=sitemap',
// 		'position'=>50,
// 		'icon'=>"sitemap_color.png",
// 		);
// 	}
	
	if(in_array($_SESSION['user_group'],$optimize_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'admin_optimize',
		'cat' => 'administration',
		'title'=>'Очистить кэш',
		'get_params'=>'&undermod=clear_cache',
		'position'=>50,
		'icon'=>"lightning.png",
		);
	}
	if(in_array($_SESSION['user_group'],$optimize_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'admin_optimize',
		'cat' => 'administration',
		'title'=>'Пересчитать статистику',
		'get_params'=>'&undermod=stat_recount',
		'position'=>50,
		'icon'=>"chart_bar.png",
		);
	}
		
?>


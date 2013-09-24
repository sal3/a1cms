<?php

if (!defined('a1cms'))
	die('Access denied to sitemap!');

	if(in_array($_SESSION['user_group'],$sitemap_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'sitemap',
		'cat' => 'administration',
		'title'=>'Пересоздать sitemap',
		'get_params'=>'&action=rebuild',
		'position'=>50,
		'icon'=>"sitemap_color.png",
		);
	}
	if(in_array($_SESSION['user_group'],$sitemap_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'sitemap',
		'cat' => 'configuration',
		'title'=>'Настройки sitemap',
		'get_params'=>'&action=options_edit',
		'position'=>50,
		'icon'=>"sitemap_color.png",
		);
	}
?>


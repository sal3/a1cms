<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$pluginmanager_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'admin_pluginmanager',
		'cat' => 'administration',
		'title'=>'Плагин-менеджер',
		'get_params'=>'',
		'position'=>50,
		'icon'=>"plugin.png",
		);
	}
		
?>


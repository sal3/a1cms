<?php

if (!defined('a1cms'))
	die('Access denied to admin_config!');

	if(in_array($_SESSION['user_group'],$cats_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'admin_config',
		'cat' => 'configuration',
		'title'=>'Настройки сайта',
		'get_params'=>'',
		'position'=>10,
		'icon'=>"wrench_orange.png",
		);
	}
		
?>
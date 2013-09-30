<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$custom_fields_config['allow_cf_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'custom_fields',
		'cat' => 'content',
		'title'=>'Пользовательские поля',
		'get_params'=>'',
		'position'=>50,
		'icon'=>"brick.png",
		);
	}
		
?>


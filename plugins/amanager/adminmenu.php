<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$ad_config['allow_config_ad']))
	{
		$admin_menu[]=array(
		'pluginname'=>'amanager',
		'cat' => 'content',
		'title'=>'Реклама',
		'get_params'=>'',
		'position'=>50,
		'icon'=>"rainbow.png",
		);
	}
		
?>


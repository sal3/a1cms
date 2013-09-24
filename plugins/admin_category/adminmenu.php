<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$cats_config['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'admin_category',
		'cat' => 'content',
		'title'=>'Категории',
		'get_params'=>'',
		'position'=>50,
		'icon'=>"book.png",
		);
	}
		
?>


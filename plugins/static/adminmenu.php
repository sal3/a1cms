<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$static_config['allow_static_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'static',
		'cat' => 'content',
		'title'=>'Статические страницы',
		'get_params'=>'',
		'position'=>50,
		'icon'=>"page_white_text.png",
		);
	}
		
?>


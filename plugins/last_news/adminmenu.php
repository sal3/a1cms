<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$last_news_options['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'last_news',
		'cat' => 'configuration',
		'title'=>'Настройки последних новостей',
		'get_params'=>'&mod=options_edit',
		'position'=>50,
		'icon'=>"last_news.gif",
		);
	}
		
?>


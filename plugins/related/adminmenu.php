<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$related_options['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'related',
		'cat' => 'configuration',
		'title'=>'Настройки похожих новостей',
		'get_params'=>'&mod=options_edit',
		'position'=>50,
		'icon'=>"related.gif",
		);
	}
		
?>


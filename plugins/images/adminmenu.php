<?php

if (!defined('a1cms'))
	die('Access denied to images!');

	if(in_array($_SESSION['user_group'],$image_options['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'images',
		'cat' => 'configuration',
		'title'=>'Настройка заливки изображений',
		'get_params'=>'&mod=options_edit',
		'position'=>100,
		'icon'=>"picture_edit.png",
		);
	}
?>
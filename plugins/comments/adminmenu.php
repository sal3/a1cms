<?php

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	if(in_array($_SESSION['user_group'],$comment_options['allow_control']))
	{
		$admin_menu[]=array(
		'pluginname'=>'comments',
		'title'=>'Настройки комментариев',
		'cat' => 'configuration',
		'get_params'=>'&mod=options_edit',
		'position'=>100,
		'icon'=>'comments.png',
		);
	}
		
?>



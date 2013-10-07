<?php
	if(in_array($_SESSION['user_group'],$users_plugin_options['allow_edit_own_profile']))
	{
		$admin_menu[]=array(
		'pluginname'=>'users',
		'cat' => 'users',
		'title'=>'Ваш профиль',
		'get_params'=>'&undermod=own_profile',
		'position'=>10,
		'icon'=>"icons/vcard.png",
		);
	}

	if(in_array($_SESSION['user_group'],$users_plugin_options['allow_edit_users']))
	{
		$admin_menu[]=array(
		'pluginname'=>'users',
		'cat' => 'users',
		'title'=>'Пользователи',
		'get_params'=>'&undermod=users',
		'position'=>15,
		'icon'=>"icons/user.png",
		);
	}

	if(in_array($_SESSION['user_group'],$users_plugin_options['allow_control_usergroups']))
	{
		$admin_menu[]=array(
		'pluginname'=>'users',
		'cat' => 'users',
		'title'=>'Группы пользователей',
		'get_params'=>'&undermod=groups',
		'position'=>20,
		'icon'=>"icons/group.png",
		);
	}

	if(in_array($_SESSION['user_group'],$users_plugin_options['allow_configure_plugin']))
	{
		$admin_menu[]=array(
		'pluginname'=>'users',
		'cat' => 'configuration',
		'title'=>'Настройки пользователей',
		'get_params'=>'&undermod=options',
		'position'=>100,
		'icon'=>"icons/group_gear.png",
		);
	}
?>
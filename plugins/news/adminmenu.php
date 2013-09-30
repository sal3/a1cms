<?php
	if(in_array($_SESSION['user_group'],$news_config['allow_add_posts']))
	{
		$admin_menu[]=array(
		'pluginname'=>'news',
		'cat' => 'content',
		'title'=>'Добавить новость',
		'get_params'=>'',
		'position'=>10,
		'icon'=>"icons/page_white_add.png",
		);
	}

	if(in_array($_SESSION['user_group'],$news_config['allow_edit_own_posts']) or in_array($_SESSION['user_group'],$news_config['allow_edit_all_posts']))
	{
		$admin_menu[]=array(
		'pluginname'=>'news',
		'cat' => 'content',
		'title'=>'Список новостей',
		'get_params'=>'&mod=newslist',
		'position'=>20,
		'icon'=>"icons/table.png",
		);
	}

	if(in_array($_SESSION['user_group'],$news_config['allow_configure_news']))
	{
		$admin_menu[]=array(
		'pluginname'=>'news',
		'cat' => 'configuration',
		'title'=>'Настройки новостей',
		'get_params'=>'&mod=options_edit',
		'position'=>30,
		'icon'=>"icons/page_white_gear.png",
		);
	}
?>
<?php

if (!defined('a1cms'))
	die('Access denied to news init!');

if ($WHEREI['main']==true)
{	
	event_register('plugin_init_by_uri','news_init');

	function news_init($_URI)
	{
		include_once root.'/plugins/news/options.php';
		$cat_altnames=array_keys(CategoriesGetAltnames());
		
		
		if(end($_URI['path_params'])=='rss.xml')
			include_once 'rss.php';
		else
		{
			//var_dump($_URI['path_params']);
			
			if ($news_config['news_on_main'] and ($_URI['request_uri'] == '/' or $_URI['request_uri']=='/index.php'))
			{
				$view_short_type='index';
			}
			elseif($_URI['path_params'][1]=='страница')
			{
				$view_short_type='index';
				$page=$_URI['path_params'][2];
			}
				
			elseif(preg_match('#(\d+)-#ui',end($_URI['path_params']), $out))
			{
				$newsid=$out[1];
				include_once 'front_news/view_full.php';
			}
			elseif(in_array($_URI['path_params'][1],$cat_altnames))
			{
				$page=get_page_from_path_params($_URI['path_params']);
				$view_short_type='cat';
			}
			
			// elseif ($_URI['path_params'][1]=="новости-пользователя")
			// 
			
			if($view_short_type)
				include_once 'front_news/view_short.php';
		}
	}

	function get_page_from_path_params($path_params)
	{
		foreach ($path_params as $key=>$path_param)
		{
			if($path_param=='страница')
				return $path_params[$key+1];
		}
	}
}
elseif ($WHEREI['admincenter']==true and $_GET['plugin']=='news')
{
	if($_GET['mod']=='newslist')
		include_once 'admin_newslist/admin_newslist.php';
	elseif($_GET['mod']=='options_edit')
	{
		$parse_admin['{meta-title}']='Настройки новостей';
		include_once 'options_edit.php';
	}
	else
		include_once 'admin_news/admin_index.php';
}

?>
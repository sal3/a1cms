<?php

define('root', substr(dirname( __FILE__ ), 0, -13));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
// include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
$result=array('result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

$options_path=root.'/plugins/news/options.php';

include_once $options_path;

$plugin_options_name='news_config';
$plugin_options_array=$$plugin_options_name;

$bool_options_arr=array('use_cache','news_on_main','require_poster','redirect_to_rigth_news_path','always_regenerate_meta','cache_news_views','rss_enable','site_short_title_to_rsstitle');
$array_options_arr=array('allow_add_posts','allow_edit_own_posts','allow_edit_all_posts','allow_post_main','allow_post_wout_moderation','allow_configure_news');

session_start();
if(!in_array ($_SESSION['user_group'], $plugin_options_array['allow_configure_news']))
{
	$result['resultmessage']='Нет прав для настройки данного плагина';
}
else
{
// 	 var_dump($_POST);
	//$editarr=$_POST;

	if (!is_writable($options_path))
		$error[]='Файл options.php не найден либо недоступен для записи';
	else
	{
		$plugin_options_array_keys=array_keys($plugin_options_array);
		foreach($_POST as $k=>$v)
		{
			if(!in_array($k, $plugin_options_array_keys))
				$error[]='Обнаружены новые опции. Редактированием конфига нельзя добавить новые опции.';
		}
	
		foreach($bool_options_arr as $v)
		{
				if($_POST[$v]==true)
					$editarr[$v]=true;
				else
					$editarr[$v]=false;
		}
		
		foreach($array_options_arr as $v)
		{
				if(!is_array($_POST[$v]))
					$error[]='Опция "'.$v.'" должна быть массивом.';
				else
					$editarr[$v]=$_POST[$v];
		}
		
		if (!is_numeric($_POST['news_on_page']) or $_POST['news_on_page']<=0)
			$error[]="Опция 'Новостей на странице' должна быть положительным числом.";
		else
			$editarr['news_on_page']=intval($_POST['news_on_page']);
			
		if (!is_numeric($_POST['pagelinks']) or $_POST['pagelinks']<=0)
			$error[]="Опция 'Cтраниц в меню навигации' должна быть положительным числом.";
		else
			$editarr['pagelinks']=intval($_POST['pagelinks']);
			
		if (!is_numeric($_POST['news_in_admin_on_page']) or $_POST['news_in_admin_on_page']<=0)
			$error[]="Опция 'Новостей на страницу в админке' должна быть положительным числом.";
		else
			$editarr['news_in_admin_on_page']=intval($_POST['news_in_admin_on_page']);
		
		if (!is_numeric($_POST['short_cache_time']) or $_POST['short_cache_time']<=0)
			$error[]="Опция 'Время жизни кеша короткой новости' должна быть положительным числом.";
		else
			$editarr['short_cache_time']=intval($_POST['short_cache_time']);
			
		if (!is_numeric($_POST['full_cache_time']) or $_POST['full_cache_time']<=0)
			$error[]="Опция 'Время жизни кеша полной новости' должна быть положительным числом.";
		else
			$editarr['full_cache_time']=intval($_POST['full_cache_time']);
			
		if (!is_numeric($_POST['min_title_length']) or $_POST['min_title_length']<=0)
			$error[]="Опция 'Минимальная длина названия новости' должна быть положительным числом.";
		else
			$editarr['min_title_length']=intval($_POST['min_title_length']);
			
		if (!is_numeric($_POST['max_title_length']) or $_POST['max_title_length']<=0)
			$error[]="Опция 'Максимальная длина названия новости' должна быть положительным числом.";
		else
			$editarr['max_title_length']=intval($_POST['max_title_length']);
			
		if (!is_numeric($_POST['max_poster_size']) or $_POST['max_poster_size']<=0)
			$error[]="Опция 'Максимальный размер постера' должна быть положительным числом.";
		else
			$editarr['max_poster_size']=intval($_POST['max_poster_size']);
			
		if (!is_numeric($_POST['min_full_text']) or $_POST['min_full_text']<=0)
			$error[]="Опция 'Минимально символов в полной новости' должна быть положительным числом.";
		else
			$editarr['min_full_text']=intval($_POST['min_full_text']);
			
		if (!is_numeric($_POST['news_views_taskperiod']) or $_POST['news_views_taskperiod']<=0)
			$error[]="Опция 'Период обновления просмотров' должна быть положительным числом.";
		else
			$editarr['news_views_taskperiod']=intval($_POST['news_views_taskperiod']);
			
		if (!is_numeric($_POST['rss_limit']) or $_POST['rss_limit']<=0)
			$error[]="Опция 'Количество новостей в RSS' должна быть положительным числом.";
		else
			$editarr['rss_limit']=intval($_POST['rss_limit']);
		
		if(!$error)
		{
			$plugin_options_array=array_merge($plugin_options_array,$editarr); // защита от поломки конфига - новое накатывается поверх старого массива
			$file=file_get_contents ($options_path);
			$file=preg_replace('/\$'.$plugin_options_name.'\s*=\s*array\s*\((.*?)\)\s*;/siu', '$'.$plugin_options_name.'='.var_export($plugin_options_array, TRUE).';',$file);
			if(file_put_contents ($options_path, $file))
				$result=array('result'=>1,'resultmessage'=>'Сохранено успешно');
		}
	}
}
if($error)
	$result=array('result'=>0,'resultmessage'=>implode('<br />',$error));

echo json_encode($result);

?>
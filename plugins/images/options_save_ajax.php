<?php

define('root', substr(dirname( __FILE__ ), 0, -15));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
// include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
$result=array('result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

$options_path=root.'/plugins/images/options.php';

include_once $options_path;

$plugin_options_name='image_options';
$plugin_options_array=$$plugin_options_name;

$bool_options_arr=array('site_work');
$array_options_arr=array('allow_control');
$text_options_arr=array('view_one_width','view_multi_width','mimes','template_name','curl_user_agent',);

session_start();
if(!in_array ($_SESSION['user_group'], $plugin_options_array['allow_control']))
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
		
		foreach($text_options_arr as $v)
		{
			$editarr[$v]=safe_text($_POST[$v]);
			if(!$editarr[$v])
				$error[]='Опции не могут быть пустыми';
		}
		
		foreach($array_options_arr as $v)
		{
				if(!is_array($_POST[$v]))
					$error[]='Опция "'.$v.'" должна быть массивом.';
				else
					$editarr[$v]=$_POST[$v];
		}
		
		if (!is_numeric($_POST['max_size_mb']) or $_POST['max_size_mb']<=0)
			$error[]="Опция 'Максимальный размер изображения' должна быть положительным числом.";
		else
			$editarr['max_size_mb']=intval($_POST['max_size_mb']);
		
		if (!is_numeric($_POST['max_height']) or $_POST['max_height']<=0)
			$error[]="Опция 'Максимальная высота изображения' должна быть положительным числом.";
		else
			$editarr['max_height']=intval($_POST['max_height']);
			
		if (!is_numeric($_POST['max_width']) or $_POST['max_width']<=0)
			$error[]="Опция 'Максимальная ширина изображения' должна быть положительным числом.";
		else
			$editarr['max_width']=intval($_POST['max_width']);
			
		if (!is_numeric($_POST['quality']) or $_POST['quality']<=0)
			$error[]="Опция 'Уменьшать качество изображения' должна быть положительным числом.";
		else
			$editarr['quality']=intval($_POST['quality']);
		
		if (!is_numeric($_POST['curl_timeout']) or $_POST['curl_timeout']<=0)
			$error[]="Опция 'Ширина изображения после мультизагрузки' должна быть положительным числом.";
		else
			$editarr['curl_timeout']=intval($_POST['curl_timeout']);
			
		if (!is_numeric($_POST['random_str_quantity']) or $_POST['random_str_quantity']<=0)
			$error[]="Опция 'Длина автогенерируемого имени изображея' должна быть положительным числом.";
		else
			$editarr['random_str_quantity']=intval($_POST['random_str_quantity']);
			
		if (!is_numeric($_POST['cache_time']) or $_POST['cache_time']<=0)
			$error[]="Опция 'Время кеширования количества загруженных изображений' должна быть положительным числом.";
		else
			$editarr['cache_time']=intval($_POST['cache_time']);
		
		
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
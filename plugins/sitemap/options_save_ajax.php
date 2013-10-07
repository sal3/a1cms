<?php

define('root', substr(dirname( __FILE__ ), 0, -15));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
// include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
$result=array('result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

$options_path=root.'/plugins/sitemap/options.php';

include_once $options_path;

$plugin_options_name='sitemap_config';
$plugin_options_array=$$plugin_options_name;

session_start();
if(!in_array ($_SESSION['user_group'], $plugin_options_array['allow_control']))
{
	$result['resultmessage']='Нет прав для настройки данного плагина';
}
else
{
// 	 var_dump($_POST);

	if (!is_writable($options_path))
		$error[]='Файл options.php не найден либо недоступен для записи';
	else
	{
		$bool_options_arr=explode(',', $_POST['bool_options']);
		unset($_POST['bool_options']);
		
		
		foreach($bool_options_arr as $v)
		{
			if($v)
			{
				if($_POST[$v]==true)
					$_POST[$v]=true;
				else
					$_POST[$v]=false;
			}
		}
		
	 	$plugin_options_array=array_merge($plugin_options_array,$_POST); // защита от поломки конфига - новое накатывается поверх старого массива
		$file=file_get_contents ($options_path);
		$file=preg_replace('/\$'.$plugin_options_name.'\s*=\s*array\s*\((.*?)\)\s*;/siu', '$'.$plugin_options_name.'='.var_export($plugin_options_array, TRUE).';',$file);
		if(file_put_contents ($options_path, $file))
			$result=array('result'=>1,'resultmessage'=>'Сохранено успешно');
	}
}
if($error)
	$result=array('result'=>0,'resultmessage'=>implode('<br />',$error));

echo json_encode($result);

?>
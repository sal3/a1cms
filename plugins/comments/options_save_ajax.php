<?

define('root', substr(dirname( __FILE__ ), 0, -17));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
// include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
$result=array('result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

$options_path=root.'/plugins/comments/options.php';

include_once $options_path;

$plugin_options_name='comment_options';
$plugin_options_array=$$plugin_options_name;

$bool_options_arr=array('enable_add_new_comments','signature_enable');
$array_options_arr=array('allow_add_comments','allow_edit_own_comments','allow_edit_all_comments','allow_control');
$text_options_arr=array();

session_start();
if(!in_array ($_SESSION['user_group'], $plugin_options_array['allow_control']))
{
	$result['resultmessage']='Нет прав для настройки данного плагина';
}
else
{
// 	 var_dump($_POST);
	//$editarr=$_POST;

	if (!file_exists($options_path))
		$error[]='Файл options.php не найден';
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
		
		if ($_POST['comments_on_page']<=0)
			$error[]="Опция 'Комментариев на страницу' должна быть положительным числом.";
		else
			$editarr['comments_on_page']=intval($_POST['comments_on_page']);
		
		
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
<?
header("Content-Type: text/plain; charset=utf-8");//FIXME: перейти на json и вынести в ajax_init

error_reporting(0);
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname( __FILE__ ), 0, -24));

include_once '../options.php';
include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';

// echo root;

if(!$_GET['id'] and !$_GET['news_id'])
	die("Нет id или news_id");


$text=trim($_GET['text']);


if ($_GET['story']=='full')
	$text_type='full_text';
elseif ($_GET['story']=='short')
	$text_type='short_text';

$vars=array(
// 	'user_id'=>$_SESSION['user_id'],
// 	'user_name'=>$_SESSION['user_name'],
	'news_id'=>$_GET['news_id'],
 	'text'=>$text,
	);



if($_GET['action'] == 'edit')
{

	$query = "SELECT `$text_type`, `{P}_news`.`id` newsid
	FROM `{P}_news`
	WHERE `{P}_news`.`id` =  i<news_id>";
	$result = query($query, $vars) or $error[] = "Ошибка выборки";

	$row = fetch_assoc($result);
	
        if(!$error)
        {
		$template = get_template('editform');
		$parse['{toolbar}']=edToolbar();
 		$parse['{ok_button_action}']='NewsEditSave('.$row['newsid'].','.'\'news-'.$row['newsid'].'\', \''.$_GET['story'].'\');return!1;';
 		$parse['{cancel_button_action}']='NewsEditCancel('.$row['newsid'].', \''.$_GET['story'].'\');return!1;';
		$parse['{textareaid}']='news-'.$row['newsid'];
		$parse['{text}']=stripslashes($row[$text_type]);
		$form = parse_template($template, $parse);
		$news=$form;
        }
}
//отмена редактирования
elseif($_GET['action'] == 'cancel')
{

	$query = "SELECT `$text_type`, `{P}_news`.`id` newsid
	FROM  `{P}_news`
	WHERE `{P}_news`.`id` = i<news_id>";
	$result = query($query, $vars) or $error[] = "Ошибка выборки";

	$row = fetch_assoc($result);

        $news=function_bbcode_to_html(stripslashes($row[$text_type]));
}

//сохраняем
elseif($_GET['action'] == 'save')
{

// 	$query = "SELECT `user_id`, `news_id`
// 		FROM  `{P}_comments`
// 		WHERE `{P}_comments`.`id` = i<comm_id>";
// 	$result = query($query, $vars) or $error[] = "Ошибка выборки";
// 
// 	$row = fetch_assoc($result);

	//проверяем права
	if((in_array ($_SESSION['user_group'], $news_config['allow_edit_all_posts'])) //если разрешено редактирование любого камента
	or
	(in_array ($_SESSION['user_group'], $news_config['allow_edit_own_posts'])) //или разрешено редактировать свои
	)
	{
	
	
// 	echo $text_type;
// 	echo "__".$text;
// 	echo "**".$_GET['news_id'];
	
		//обновляем каммент
		if($text)
			query("UPDATE `{P}_news` SET `$text_type`=<text> WHERE `id`=i<news_id>", $vars) or $error[] = 'Ошибка сохранения изменений';
		else
			$error[] = "Нельзя сохранить пустую новость!";

			$news=function_bbcode_to_html(stripslashes($text));
	}
	else
		$error[] = "Error: Доступ запрещен";
}

if(!$error)
	echo json_encode(array('error'=>0,'message'=>$message, 'news'=> $news));
else
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));
?>
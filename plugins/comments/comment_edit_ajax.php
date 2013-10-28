<?
header("Content-Type: text/plain; charset=utf-8");//FIXME: перейти на json и вынести в ajax_init

error_reporting(0);
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname( __FILE__ ), 0, -17));

include_once 'options.php';
include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
include_once 'comments.php';

if(!$_GET['id'] and !$_GET['news_id'])
	die("Нет id или news_id");

$text=trim($_GET['text']);

$vars=array(
	'news_id'=>$_GET['news_id'],
	'user_id'=>$_SESSION['user_id'],
	'user_name'=>$_SESSION['user_name'],
	'comm_id'=>$_GET['id'],
	'text'=>$text,
	);

// 	var_dump($comment_options);
	
if($_GET['action'] == 'add')
{
	if (in_array($_SESSION['user_group'], $comment_options['allow_add_comments']))
	{
		if($_GET['text'])
			query("insert into `{P}_comments` (`news_id`, `user_id`, `date`, `user_name`, `text`)
			values (i<news_id>, i<user_id>, NOW(), <user_name>, <text>)", $vars)
			or $error[] = 'Ошибка добавления';
		else
			$error[] = "Нельзя добавить пустой комментарий!";

		if(!$error)
		{
			$com['news_row']['commentid'] = insert_id();
			//увеличиваем пользователю количество каментов в профиле
			query("update `{P}_users` set `comments_quantity`=`comments_quantity`+1 where `user_id` = i<user_id>", $vars);
			query("update `{P}_news` set `comments_quantity`=`comments_quantity`+1 where `id` = i<news_id>", $vars);

			$comment=comments($com);
		}
	}
	else
		$error[] = "Вам не разрешено добавлять комментарий.";
}
//вытягиваем каммент на редактирование
elseif($_GET['action'] == 'edit')
{

	$query = "SELECT `text`, `{P}_comments`.`id` commentid
	FROM `{P}_comments`
	WHERE `{P}_comments`.`id` =  i<comm_id>";
	$result = query($query, $vars) or $error[] = "Ошибка выборки";

	$row = fetch_assoc($result);

        if(!$error)
        {
		$template = get_template('editform');
		$parse['{toolbar}']=edToolbar();
		$parse['{ok_button_action}']='CommEditSave('.$row['commentid'].','.'\'comment-'.$row['commentid'].'\');return!1;';
		$parse['{cancel_button_action}']='CommEditCancel('.$row['commentid'].');return!1;';
		$parse['{textareaid}']='comment-'.$row['commentid'];
		$parse['{text}']=stripslashes($row['text']);
		$form = parse_template($template, $parse);
		$comment=$form;
        }
}

//отмена редактирования
elseif($_GET['action'] == 'cancel')
{

	$query = "SELECT `text`, `{P}_comments`.`id` commentid
	FROM  `{P}_comments`
	WHERE `{P}_comments`.`id` = i<comm_id>";
	$result = query($query, $vars) or $error[] = "Ошибка выборки";

	$row = fetch_assoc($result);

        $comment=function_bbcode_to_html(stripslashes($row['text']));
}

//сохраняем камент
elseif($_GET['action'] == 'save')
{

	$query = "SELECT `user_id`, `news_id`
		FROM  `{P}_comments`
		WHERE `{P}_comments`.`id` = i<comm_id>";
	$result = query($query, $vars) or $error[] = "Ошибка выборки";

	$row = fetch_assoc($result);

	//проверяем права
	if((in_array ($_SESSION['user_group'], $comment_options['allow_edit_all_comments'])) //если разрешено редактирование любого камента
	or
	(in_array ($_SESSION['user_group'], $comment_options['allow_edit_own_comments']) and ($row['user_id']==$_SESSION['user_id'])) //или разрешено редактировать свои
	)
	{
		//обновляем каммент
		if($text)
			query("UPDATE `{P}_comments` SET `text`=<text> WHERE `id`=i<comm_id>", $vars) or $error[] = 'Ошибка сохранения изменений';
		else
			$error[] = "Нельзя сохранить пустой комментарий!";

			$comment=function_bbcode_to_html(stripslashes($text));
	}
	else
		$error[] = "Error: Доступ запрещен";
}
elseif($_GET['action'] == 'delete')
{
	//вытягиваем автора
	$query = "SELECT `user_id`, `news_id`, `id`, `date`, `user_name`
		FROM  `{P}_comments`
		WHERE `{P}_comments`.`id` =  i<comm_id>";
		$result = query($query, $vars) or $error[] = "Ошибка выборки автора";
		$row = fetch_assoc($result);

	$vars['user_id']=$row['user_id'];
	$vars['news_id']=$row['news_id'];

	if(!$row['user_id'])
		$error[] = "Ошибка user_id";
	elseif(in_array ($_SESSION['user_group'], $comment_options['allow_edit_all_comments'])
	or (in_array ($_SESSION['user_group'], $comment_options['allow_edit_own_comments']) and $row['user_name']==$_SESSION['user_name'])
	)
		{
			query("delete from `{P}_comments` where `id` = i<comm_id>", $vars) or $error[] = 'Ошибка удаления';
			if(!$error)
			{
				//уменьшаем пользователю количество каментов в профиле
				query("update `{P}_users` set `comments_quantity`=`comments_quantity`-1 where `user_id` = i<user_id>", $vars);
				query("update `{P}_news` set `comments_quantity`=`comments_quantity`-1 where `id` = i<news_id>", $vars);

				//записываем в лог
				//logger($_SESSION['name']." удалил комментарий №".$row['id']." созданный ".$row['user_name']." ". relative_date($row['date']) );

				$message="Комментарий удален";
			}
		}
	else
		$error[] = "Доступ запрещен";
}

if(!$error)
	echo json_encode(array('error'=>0,'message'=>$message, 'comment'=> $comment));
else
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));
?>
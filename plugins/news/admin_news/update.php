<?
if (!defined('a1cms')) 
	die('Access denied!');
if(!in_array($_SESSION['user_group'], $news_config['allow_edit_all_posts']) or !in_array($_SESSION['user_group'], $news_config['allow_edit_own_posts']))
	die("Access denied news_update!");
	
event ('before_news_update',$_POST);

//обновляем описание
$general_sql_update = "UPDATE `{P}_news`
SET
`user_name`=<user_name>, `date`=<date>, `poster`=<poster>,`short_text`=<short_description>, `full_text`=<full_description>,
`title`=<title>, `description`=<meta_description>, `keywords`=<meta_keywords>, `category_id`=<cats_id>, `url_name`=<url_name>,
`allow_comments`='{$allow_comments}', `show_on_main`='{$show_on_main}', `approved`='{$approved}', `pinned`='{$pinned}', `on_moderation`='{$on_moderation}', `approver`=<approver>, `editor`=<editor>, `editdate`=now(),
`edit_reason`=<edit_reason>
WHERE
`id`=i<newsid>";
$result_general_sql_update = query($general_sql_update, $variables)
	or $error[]="Не удалось отредактировать новость в базе сайта";


//сброс кеша  FIXME: получать старый список категорий
if(!$error)
{
//записываем в лог, обязательно перед destroy_session_by_id !! ))
	logger($_SESSION['user_name']." обновил новость '".$_POST['title']."' №".$_REQUEST['newsid']." созданную ".$_POST['user_name']." ". relative_date($_POST['date']) );

	del_cache($_POST['newsid'],  $cats_id);

	if($_POST['user_name']!=$_POST['old_user_name'])
	{
		$post_old_count_query="UPDATE `{P}_users` SET `news_quantity`=`news_quantity`-1 WHERE `user_name`=<old_user_name>";
			query($post_old_count_query, $variables);
		destroy_session_by_id(0,$_POST['old_user_name']);//для подержания в сессии пользователя актуального количества новостей
		
		$post_new_count_query="UPDATE `{P}_users` SET `news_quantity`=`news_quantity`+1 WHERE `user_name`=<user_name>";
			query($post_new_count_query, $variables);
		destroy_session_by_id(0,$_POST['user_name']);//для подержания в сессии пользователя актуального количества новостей
	}

	event('after_news_update',$_POST);
	
$text = "<center>
	Отредактировано успешно!<br />
	<br />
	<a href='".$engine_config['site_path']."/{$_POST['newsid']}-$url_name'>Просмотреть новость на сайте</a><br />
	<a href='".$engine_config['site_path']."/admin/index.php?plugin=news&mod=editnews&action=editnews&newsid={$_POST['newsid']}'>Вернуться к редактированию</a><br />
	<a href='".$engine_config['site_path']."/admin/index.php?plugin=news'>Добавить новость</a><br />
	<a href='".$engine_config['site_path']."/admin/index.php?plugin=news&mod=admin_newslist&action=list'>Перейти к списку новостей</a><br />
	</center>";

	$parse_admin['{module}']=showinfo('', $text, "success", 1);
}
?>
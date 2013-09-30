<?
if (!defined('a1cms')) 
	die('Access denied!');
if(!in_array($_SESSION['user_group'], $news_config['allow_add_posts']))
	die("Access denied news_insert!");

//закидываем описание
$general_sql_insert = "INSERT INTO {P}_news
(user_name, date, createdate, poster, short_text, full_text, title, description,
keywords, category_id, url_name, allow_comments, show_on_main, approved, pinned, on_moderation, approver,editor,edit_reason)
VALUES
(<user_name>, <date>, now(), <poster>, <short_description>, <full_description>, <title>, <meta_description>,
<meta_keywords>, <cats_id>, <url_name>, '{$allow_comments}', '{$show_on_main}', '{$approved}', '{$pinned}', 
			'{$on_moderation}', <approver>, <editor>, <edit_reason>)";

//echo $general_sql_insert;

$result_general_sql_insert = query($general_sql_insert, $variables)
or $error[]="Не удалось внести новость в базу сайта";

//вытягиваем последний id
$newsid = insert_id();
$_POST['newsid']=$newsid; // для event

//увеличиваем количество постов в профиле автора
$post_count_query="UPDATE `{P}_users` SET `news_quantity`=`news_quantity`+1 WHERE `user_name`=<user_name>";
	query($post_count_query, $variables);
	
event('after_news_insert',$_POST);
	
destroy_session_by_id(0,$_POST['user_name']);//для подержания в сессии пользователя актуального количества новостей

                        
//сброс кеша
if(!$error)
del_cache(false, $cats_id); 

if(count($error)==0)
{
$text = "<center>
	Добавлено успешно!<br />
			<br />
			<a href='".$engine_config['site_path']."/{$newsid}-$url_name'>Просмотреть новость на сайте</a><br />
			<a href='".$engine_config['site_path']."/admin/index.php?plugin=news&mod=editnews&action=editnews&newsid={$newsid}'>Вернуться к редактированию</a><br />
			<a href='".$engine_config['site_path']."/admin/index.php?plugin=news'>Добавить еще</a><br />
			<a href='".$engine_config['site_path']."/admin/index.php?plugin=news&mod=admin_newslist&action=list'>Перейти к списку новостей</a><br />
	</center>";

$parse_admin['{module}']=showinfo('', $text, "success", 1);
}
?>

<?php

if (!defined('a1cms'))
	die('Access denied to news admin_index.php!');
	
// if(!in_array($_SESSION['user_group'], $plugin_list[$pluginname]['allowed_groups']))
// 	die("Access denied!");
	
// include_once root.'/sys/categories.php';//нужно для очистки кеша
// include_once 'config.php';
include_once root.'/plugins/news/options.php';

//форма добавления
if($_GET['action']=='' and check_add_rights())
{
	$WHEREI['addnews']=true;
	$parse_admin['{meta-title}']='Добавление новости';
	include_once 'form.php';
}
elseif($_GET['action']=='editnews' and check_edit_rights($_REQUEST['newsid']))
{
	$WHEREI['editnews']=true;
	$parse_admin['{meta-title}']='Редактирование новости';
	include_once 'select.php';
	include_once 'form.php';
}
elseif($_GET['action']=='insert')
{
	include_once 'news_prepare.php';
	
	if($error)
	{
		include_once 'form.php';
	}
	else
	{
		// Добавление. Закидываем в базу
		if (!$_POST['newsid'] and check_add_rights())
			include_once 'insert.php';

		// Редактирование. Обновляем в базе
		elseif ($_POST['newsid'] and check_edit_rights($_REQUEST['newsid']))
			include_once 'update.php';
	}
}
elseif($_GET['action']=='preview')
{
	include_once 'news_prepare.php';
	
	$prev_parse['{title}'] = $_POST['title'];
	$prev_parse['{poster}'] = $_POST['poster'];
	$prev_parse['{short_description}'] = function_bbcode_to_html($short_description);
	$prev_parse['{full_description}'] = function_bbcode_to_html($full_description);
	$prev_parse['{title}'] = $_POST['title'];
	//$prev_parse['{THEME}'] = $engine_config['template_path_http'];

	$parse_admin['{module}'] .= parse_template(get_template('news_preview',1),  $prev_parse);
}


//права на редактирование
function check_edit_rights ($newsid)
{
	global $news_config, $error;
	
// 	if(!$_SESSION['approved'])
// 		$error[]='Ваш аккаунт еще не активирован';
	if (in_array ($_SESSION['user_group'], $news_config['allow_edit_all_posts']))
		return true;
	else
	{
		//для журналистов и младше - вытягиваем имя автора, чтоб узнать, свою ли новость он хочет редактировать
		$author_query = "SELECT user_name,approved FROM {P}_news WHERE id=i<newsid>";
		$author_variables=array('newsid'=>$newsid);

		$author_row = fetch_assoc(query($author_query, $author_variables));

		if(in_array ($_SESSION['user_group'], $news_config['allow_edit_own_posts']) and $author_row['user_name']==$_SESSION['user_name'])
			return true;
	}

	if(!$allow_edit)
		$error[]= 'Вам не разрешено редактировать эту новость!';
}

function check_add_rights ()
{
	global $news_config, $error;
	//права на добавление
	if(in_array ($_SESSION['user_group'], $news_config['allow_add_posts']) and $_SESSION['approved'])
		return true;
// 	elseif(!$_SESSION['approved'] and $engine_config['register_activate']=="hands")
// 		$error[]= 'Вы не можете добавлять новости, т.к. ваш аккаунт еще не активирован. Модераторы активируют ваш аккаунт в ближайшее время.';
// 	elseif(!$_SESSION['approved'] and $engine_config['register_activate']=="mail")
// 		$error[]='Вы не можете добавлять новости, т.к. ваш аккаунт еще не активирован. Зайдите на свою почту и активируйте его.';
// 	elseif(!$_SESSION['approved'])
// 		$error[]='Ваш аккаунт еще не активирован';
	else
		$error[]= 'Вам не разрешено добавлять новости!';
	}
?>
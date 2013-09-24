<?php

if (!defined('a1cms'))
	die('Access denied to comments!');

if($WHEREI['main']==true)
{
	event_register('plugin_init_before_fullnews_parse','comments_add_form');

	function comments_add_form($data)
	{
		global $parse_plugins, $comment_options, $engine_config;
		
		include_once 'options.php';

		if ($data['news_row']['newsid'] and $data['news_row']['newscomments_quantity'])
		{
			include_once root.'/plugins/comments/comments.php';
			$comments=comments($data);
		}
		else
			$comments='';

		//форма добавления
		if(!$comment_options['enable_add_new_comments'])
			$commentsadd = showinfo("Добавление комментария:", "Добавление новых комментариев отключено.");
		elseif($data['news_row']['allow_comments'] and in_array($_SESSION['user_group'], $comment_options['allow_add_comments']) /*and (!$engine_config['register_activate'] or $_SESSION['approved'])*/)
		{
			$template = get_template('commentform');
			$parse['{toolbar}']=edToolbar();
			$parse['{button_action}']='commAdd('.$data['news_row']['newsid'].');return!1;';
			$template = preg_replace("/\[cancel_button\](.*?)\[\/cancel_button\]/isu", '', $template);

			$commentsadd = parse_template($template, $parse);
		}
		elseif(!$_SESSION['user_id'])
			$commentsadd = showinfo("Добавление комментария:", "Только зарегистрированные пользователи могут оставлять комментарии. Зарегистрируйтесь или войдите, если вы уже зарегистрированы на нашем сайте.");
			
// 		elseif(!$_SESSION['approved'] and $engine_config['register_activate'])
// 		{
// 			if($engine_config['register_activate']=="mail")
// 				$commentsadd = showinfo("Добавление комментария:", "Вы не можете добавлять комментарии, т.к. ваш аккаунт еще не активирован. Зайдите на свою почту и активируйте его.");
// 			elseif($engine_config['register_activate']=="hands")
// 				$commentsadd = showinfo("Добавление комментария:", "Вы не можете добавлять комментарии, т.к. ваш аккаунт еще не активирован. Модераторы активируют аккаунт в ближайшее время.");
// 		}
		elseif($data['news_row']['allow_comments']==0)
			$commentsadd = showinfo("Добавление комментария:", "Модераторы запретили оставлять комментарии к данной новости.");
// 		elseif($_SESSION['add_comment_restrict_description'])
// 			$commentsadd = showinfo("Добавление комментария:", "Модераторы запретили вам оставлять комментарии к публикациям. Причина: {$_SESSION['add_comment_restrict_description']}");
		elseif(!in_array($_SESSION['user_group'], $comment_options['allow_add_comments']))
			$commentsadd = showinfo("Добавление комментария:", "Вашей группе пользователей запрещено добавлять комментарии.");

		$parse_plugins['{plugin=comments}'] .= '<script src="'.$engine_config['site_path'].'/plugins/comments/comments.js" type="text/javascript"></script>'.$commentsadd.$comments;
	}
}
elseif ($WHEREI['admincenter']==true and $_GET['plugin']=='comments')
{

	if($_GET['mod']=='options_edit')
	{
		$parse_admin['{meta-title}']='Настройки комментариев';
		include_once 'options_edit.php';
	}
}
?>
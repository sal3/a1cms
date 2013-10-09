<?php
if (!defined('a1cms'))
	die('Access denied to comments!');

// include_once 'config.php';

function comments ($data)
{
	global $comment_options, $LANG, $error, $engine_config; //$headers,

	if(isset($data['news_row']['newsid']) and $data['news_row']['newsid'])//выборка каментов к конкретной новости
	{
		$comments_query_array['variables']['newsid']=$comments_count_query_array['variables']['newsid']=$data['news_row']['newsid'];
		
		$comm_view_type='by news';
		$comments_query_array['where'][]='`{P}_comments`.`news_id` = i<newsid>';
	}
	elseif(isset($data['news_row']['commentid']) and $data['news_row']['commentid'])//вытягиваем конкретный камент
	{
		$comments_query_array['variables']['commentid']=$comments_count_query_array['variables']['commentid']=$data['news_row']['commentid'];
	
		$comm_view_type='one comment';
		$comments_query_array['where'][]='`{P}_comments`.`id` = i<commentid>';
	}
	elseif(isset($data['news_row']['author']) and $data['news_row']['author'])//каменты конкретного автора
	{
		$comments_query_array['variables']['author']=$comments_count_query_array['variables']['author']=$data['news_row']['author'];
	
		$comm_view_type='by author';
		$comments_query_array['select']=array('`{P}_news`.`id` newsid', '`{P}_news`.`category_id`',  '`{P}_news`.`title`', '`{P}_news`.`url_name`');
		$comments_query_array['where'][]='`{P}_comments`.`user_name` = <author>';
		$comments_query_array['join']['left'][]='`{P}_news` on (`{P}_comments`.`news_id` = `{P}_news`.`id`';

		$parse_main['{meta-title}']="Комментарии пользователя ".$data['news_row']['author'];
		$parse_main['{meta-description}']="Комментарии пользователя ".$data['news_row']['author'];
		$parse_main['{meta-keywords}']="комментарии, comments";

	}
	elseif(isset($data['news_row']['newsauthor']) and $data['news_row']['newsauthor'])//каменты к новостям конкретного автора
	{
		$comments_query_array['variables']['news_author']=$comments_count_query_array['variables']['news_author']=$data['news_row']['newsauthor'];
	
		$comm_view_type='by news author';
		$comments_query_array['select']=array('`{P}_news`.`id` newsid', '`{P}_news`.`category_id`',  '`{P}_news`.`title`', '`{P}_news`.`url_name`');
		$comments_query_array['join']['left'][]='`{P}_news` on (`{P}_comments`.`news_id` = `{P}_news`.`id`';
		$comments_query_array['where'][]='`{P}_news`.`user_name` = <news_author>';

		$parse_main['{meta-title}']="Комментарии к новостям пользователя ".$data['news_row']['newsauthor'];
		$parse_main['{meta-description}']="Комментарии к новостям пользователя ".$data['news_row']['newsauthor'];
		$parse_main['{meta-keywords}']="комментарии, comments";

	}
	else//вытягиваем последние каменты
	{
		$comm_view_type='last comments';
		$comments_query_array['select']=array('`{P}_news`.`id` newsid', '`{P}_news`.`category_id`',  '`{P}_news`.`title`', '`{P}_news`.`url_name`');
		$comments_query_array['join']['left'][]='`{P}_news` on (`{P}_comments`.`news_id` = `{P}_news`.`id`';
		$comments_query_array['where'][]='`{P}_news`.`approved` = 1';
		
		$parse_main['{meta-title}']="Последние комментарии";
		$parse_main['{meta-description}']="Последние комментарии";
		$parse_main['{meta-keywords}']="комментарии, comments";
	}
	
	// comments_query_array
	$comments_select=array('`{P}_comments`.`id` commentid', '`{P}_comments`.`news_id`','`{P}_comments`.`user_id`', '`{P}_comments`.`date`', '`{P}_comments`.`user_name`', '`{P}_comments`.`text`', '`{P}_users`.`user_name`',  '`{P}_users`.`signature`', '`{P}_users`.`avatar`', '`{P}_users`.`comments_quantity`', '`{P}_users`.`news_quantity`', '`{P}_users`.`registration_date`', '`{P}_groups`.`icon`', '`{P}_groups`.`group_name`', '`{P}_users`.`city`', '`{P}_groups`.`id` usergroupid');
	
	if(isset($comments_query_array['select']) and $comments_query_array['select'])
		$comments_query_array['select']=array_merge((array) $comments_query_array['select'],$comments_select);
	else
		$comments_query_array['select']=$comments_select;
	
	$comments_query_array['from']='`{P}_comments`';
	$comments_query_array['join']['left'][]='`{P}_users` on (`{P}_comments`.`user_name` = `{P}_users`.`user_name`)';
	$comments_query_array['join']['left'][]='`{P}_groups` on (`{P}_groups`.`id` = `{P}_users`.`user_group`)';
	$comments_query_array['order_by'][]='`{P}_comments`.`date` DESC';
	
	// comments_count_query_array
	$comments_count_select=array('count(*) commentsquantity');
	if(isset($comments_count_query_array['select']) and $comments_count_query_array['select'])
		$comments_count_query_array['select']=array_merge((array) $comments_count_query_array['select'],$comments_count_select);
	else
		$comments_count_query_array['select']=$comments_count_select;
		
	$comments_count_query_array['from']='`{P}_comments`';
	$comments_count_query_array['where']=$comments_query_array['where'];
	$comments_count_query_array['join']=$comments_query_array['join'];

	if($data['page']>1)
		$comments_query_array['limit'] = ($data['page']-1)*$comment_options['comments_on_page'].",".$comment_options['comments_on_page'];
	else
		$comments_query_array['limit'] = $comment_options['comments_on_page'];


	$comments_count_query = make_query($comments_count_query_array);
	$comments_count_row = single_query($comments_count_query, $comments_count_query_array['variables']) or $error[]="Ошибка определения количества новостей.";
	$commentsquantity = $comments_count_row['commentsquantity'];

	if($commentsquantity > 0)
	{
		//вытягиваем шаб в переменную
		$template = get_template('comments');

		if(!isset($data['news_row']['commentid']) or !$data['news_row']['commentid'])
		{
		
			//Вывод постраничной навигации
			if($commentsquantity > $comment_options['comments_on_page'])
			{
				if($data['news_row']['newsid'])
				{
					$before_page_number = ','.$LANG['page'].',1,';
					$now_url=$data['news_row']['newsid'].'-'.$data['news_row']['url_name'];
					$after_page_number = '#comments';//.'.html'

				}
				else
				{
					if($comm_view_type=='by author')
					$now_url = "/".$LANG['user']."/".rawurlencode($data['news_row']['author'])."/".$LANG['comments']."/";
					elseif($comm_view_type=='by news author')
					$now_url = "/".$LANG['user']."/".rawurlencode($data['news_row']['newsauthor'])."/".$LANG['newscomments']."/";
					else
					$now_url = "/".$LANG['lastcomments']."/";

					$before_page_number=$LANG['page'].'/';
					$after_page_number='/';
				}
			$linkbar = universal_link_bar($commentsquantity, $data['page'], $now_url, $comment_options['comments_on_page'],$comment_options['pagelinks'],$before_page_number , $after_page_number);
			}
		}
		
		$comments_query=make_query($comments_query_array);
		$comments_result=query($comments_query, $comments_query_array['variables']) or $error[]="Ошибка выборки коментариев.";

		$comment_content='';
		while ($comments_row = fetch_assoc($comments_result))
		{
			$current_template=$template;

			if ($comm_view_type=='last comments')
			{
				$parse_main['{meta-title}']="Последние комментарии";
				$parse_main['{meta-description}']="Последние комментарии";
				$parse_main['{meta-keywords}']="комментарии, comments";
			}
			elseif ($comm_view_type=='by author')
			{
				$parse_main['{meta-title}']="Комментарии пользователя ".$comments_row['user_name'];
				$parse_main['{meta-description}']="Комментарии пользователя ".$comments_row['user_name'];
				$parse_main['{meta-keywords}']="комментарии, comments";
			}
			elseif ($comm_view_type=='by news author')// мы просматриваем последние комментарии
			{
				$parse_main['{meta-title}']="Комментарии к новостям пользователя ".$comments_row['user_name'];
				$parse_main['{meta-description}']="Комментарии к новостям пользователя ".$comments_row['user_name'];
				$parse_main['{meta-keywords}']="комментарии, comments";
			}
			
			if($comments_row['avatar'])
				$avatar=$engine_config['http_avatar_path'].$comments_row['avatar'];
			else
				$avatar=$engine_config['default_avatar_path'];
				

			$parse['{avatar}'] = $avatar;

			$parse['{author}'] = $comments_row['user_name'];
			$parse['{author_encoded}'] = rawurlencode($comments_row['user_name']);
			$parse['{author-url}'] = $engine_config['site_path']."/".$LANG['user']."/".$parse['{author_encoded}'];

			if($comm_view_type=='last comments'  or $comm_view_type=='by author' or $comm_view_type=='by news author')
				$parse['{news_title}'] = "&gt;&gt;&nbsp;".stripslashes ($news_title);
			else
					$parse['{news_title}'] = '';
					
			$parse['{date}'] = relative_date($comments_row['date']);

			if($comments_row['icon'])
				$parse['{group-icon}'] = "<img src='".str_replace("{THEME}", $engine_config['template_path_http'], $comments_row['icon'])."' alt='".$comments_row['group_name']."' />";
			else
				$parse['{group-icon}'] = '';

			if($comments_row['signature'] and $comment_options['signature_enable'])
			{
				$parse['{signature}'] = stripslashes($comments_row['signature']);

				$parse['[signature]'] = '';
				$parse['[/signature]'] = '';
			}
			else
				$current_template = preg_replace("/\[signature\](.*?)\[\/signature\]/isu", '', $current_template);

			$parse['[fast][ Цитировать ][/fast]'] = '';//FIXME: сделать быстрое цитирование
			$parse['{comments}'] = $comments_row['comments_quantity'];
			$parse['{news}'] = $comments_row['news_quantity'];
			$parse['{registered}'] = date('d.m.Y', strtotime($comments_row['registration_date']));
			$parse['{city}'] = $comments_row['city'];
			$parse['{group_name}']=$comments_row['group_name'];
			$parse['{group_id}']=$comments_row['usergroupid'];
			$parse['{commentid}']=$comments_row['commentid'];
			$parse['{comment_delete}']="javascript:CommDel(".$comments_row['commentid'].");return!1;";
			$parse['{comment_edit}']="javascript:CommEdit(".$comments_row['commentid'].");return!1;";

			if(
				(isset($_SESSION['user_group']) and in_array ($_SESSION['user_group'], $comment_options['allow_edit_all_comments']))
				or 
				(isset($_SESSION['user_group']) and in_array ($_SESSION['user_group'], $comment_options['allow_edit_own_comments']) and $comments_row['user_name']==$_SESSION['user_name'])
			)
				$parse['[com-edit]']=$parse['[/com-edit]']='';
			else
				$current_template = preg_replace("/\[com-edit\](.*?)\[\/com-edit\]/isu", '', $current_template);

			$parse['{comment}'] = "<div id='comm-body-id-".$comments_row['commentid']."' class='comm-body'>". function_bbcode_to_html(stripslashes($comments_row['text'])) ."</div>\r\n";
			$comment_content .= "<div id='comm-id-".$comments_row['commentid']."'>". parse_template($current_template,$parse) ."</div>\r\n"; //собственно парсим шаблон
		}
		
		if(isset($linkbar))
			$comment_content .= $linkbar;
	}
	elseif(!$data['news_row']['newsid'])//иначе - каментов нет
	{
		$parse_main['{meta-title}']="Внимание, обнаружена ошибка &raquo; ";
		header("HTTP/1.0 404 Not Found");
		$error[]="Комментариев по заданным критериям не найдено";
	}
		return $comment_content;
}
?>
<?php

if (!defined('a1cms'))
	die('Access denied newslist!');
// include_once root.'/sys/categories.php';
include_once root.'/plugins/news/options.php';

//если хотим видеть список, и есть права видеть список всех или хотя бы своих новостей
if(in_array($_SESSION['user_group'],$news_config['allow_edit_all_posts']) or in_array($_SESSION['user_group'],$news_config['allow_edit_own_posts']))
{
	//если есть права на редактирование только своих новостей
	if(!in_array($_SESSION['user_group'],$news_config['allow_edit_all_posts']) and in_array($_SESSION['user_group'],$news_config['allow_edit_own_posts']))
	{
		$where[] = "`user_name` = '".$_SESSION['user_name']."'";
	}
	
	if($_GET['moder']=='user')
		$where[] = "`on_moderation` = 0 and `approved` = 0 and `user_name` = '".$_SESSION['user_name']."'";
	elseif($_GET['moder']=='check')
		$where[] = "`on_moderation` = 1 and `approved` = 0";

	//тут надо будет сделать обработку для поиска новостей
	if(!empty($where))
	$where_expression = "WHERE ". implode (" and ", $where);

	$news_query = "SELECT `id`, `user_name`, `date`, `title`, `approved`, `pinned`, `url_name`, `category_id`, `on_moderation`
		from `{P}_news`
		$where_expression
		ORDER BY `pinned` DESC, `approved`, `date` DESC
		";

	$news_count_query = "SELECT count(*) `postsquantity`
		FROM `{P}_news`
		$where_expression
		";

	if($_GET['page'])
		$page = $_GET['page'];
	else
		$page = 1;

	if($page>1)
	{
		$limit = ($page-1)*$news_config['news_in_admin_on_page'].",".$news_config['news_in_admin_on_page'];
	}
	else
	{
		$limit = $news_config['news_in_admin_on_page'];
	}

	$news_query .= "LIMIT $limit";

		
		//Считаем количество постов
		$news_count_result = query($news_count_query);
		$news_count_row = fetch_assoc($news_count_result) or $error[]="Ошибка определения количества новостей";
		$postsquantity = $news_count_row['postsquantity'];
		//конец Считаем количество постов

	//если есть новости
	if($postsquantity > 0)
	{
		$news_result = query($news_query);
		while ($row = fetch_assoc($news_result))
		{
			$date = date('d.m.Y', strtotime($row['date']));

			$news_url = '/admin/index.php?plugin=news&mod=editnews&action=editnews&newsid='.$row['id'];

			if($row['pinned'])
				$pinned_flag = "<font color='red'>Закреплено:</font>";

			$view_link=$engine_config['site_path'].make_news_link ($row['id'], $row['url_name'], $row['category_id']);

			if($row['approved'])
				$approved_flag = "<font color='green'>да</font>";
			else
			{
				$approved_flag = "<font color='red'>нет</font>";
				if($row['on_moderation'])
					$approved_flag .= " / <font color='green'>оформлено</font>";
				else
					$approved_flag .= " / <font color='red'>в работе</font>";
			}

			$row_tpl=get_template('newslist_row',1);

			$parse_rows['{date}']=$date;
			$parse_rows['{pinned_flag}']=$pinned_flag;
			$parse_rows['{news_url}']=$news_url;
			$parse_rows['{news_title}']=stripslashes($row['title']);
			$parse_rows['{view_link}']=$view_link;
			$parse_rows['{approved_flag}']=$approved_flag;
			$parse_rows['{user_name}']=$row['user_name'];

			unset($pinned_flag);

			$news_rows.=parse_template($row_tpl, $parse_rows);
		}

		$newslist_tpl=get_template('newslist',1);
		$parse_newslist['{news_rows}']=$news_rows;
		//постраничка
		$parse_newslist['{linkbar}'] = universal_link_bar($postsquantity, $page, 'index.php?plugin=news&mod=newslist&action=list', $news_config['news_in_admin_on_page'], $pagelinks, '&page=', $after_page_number);

		$parse_admin['{module}']=parse_template($newslist_tpl, $parse_newslist);

	}
//иначе - новостей нет
	else
		$error[]="Внимание, новостей, доступных Вам для редактирования, не найдено";

}
else
	$error[]="Нет новостей доуступных к редактированию.";
?>
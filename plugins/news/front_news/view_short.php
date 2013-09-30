<?php

if (!defined('a1cms'))
	die('Access denied view_short.php!');
	
	include_once root.'/plugins/news/options.php';
	//include_once 'config.php';
	
	global $engine_config, $debug, $error, $parse_main, $LANG;
// 	global $error, $parse_main, $no_cache, $LANG, $news;
	
	$templatename = 'shortstory_row';
	$data=array('query_variables'=>array(), 'news_row'=>array(), 'parse'=>array(), 'tpl'=>'', 'page'=>$page);
	
	// пагинация. Дефолтные значения
	$pagination['before_page_number']='/'.$LANG['page'].'/';
	$pagination['after_page_number']='';
	$pagination['now_url']=$engine_config['site_path'];
	
	$news_query_array=array('variables'=>array());
	$news_count_query_array=array('variables'=>array());

	
	if(!$data['page'])
	{
		if(isset($_GET['page']))
			$data['page']=intval($_GET['page']);
		else
			$data['page']=1;
	}

	// разбираемся что вытягивать
	if($view_short_type=='index')
	{
		// для редиректа
		if($data['page']>1)
			$link=$engine_config['site_path'].$pagination['before_page_number'].$data['page'].$pagination['after_page_number'];
		else
			$link=$engine_config['site_path'].'/';
	}
	elseif($view_short_type=='cat')
	{
	
		$cat_by_altnames=CategoriesGetAltnames();
		foreach($_URI['path_params'] as $param)
		{
			// вытягиваем категории с адреса
			if(in_array($param,$cat_altnames))
				$cat=$cat_by_altnames[$param];// берем последнюю категорию
		}
		$cat_plus_childs=get_child_cats($cat);
		$cat_plus_childs[]=$cat;
		$cat_plus_childs_line=implode('|',$cat_plus_childs);
		$news_query_array['where'][] = $news_count_query_array['where'][] = "`category_id` REGEXP '[[:<:]](".$cat_plus_childs_line.")[[:>:]]'";
		
		
		//meta
		global $_CAT;
		if(!$_CAT)
			$_CAT=CategoriesGet();
			
		$parse_main['{meta-title}']=$_CAT[$cat]['name'];
		$parse_main['{meta-description}'] = $_CAT[$cat]['description'];
		$parse_main['{meta-keywords}'] = $_CAT[$cat]['keywords'];
		
		//пагинация
		$correct_path=make_cat_link($cat); //также для кеша
		$pagination['now_url'] = $engine_config['site_path'].'/'.$correct_path;
		
		// для редиректа
		if($data['page']>1)
			$link=$pagination['now_url'].$pagination['before_page_number'].$data['page'].$pagination['after_page_number'];
		else
			$link=$pagination['now_url'];
	}
	elseif($view_short_type=='getparams')
	{
		$query_array=parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
		$now_url="index.php?$query_array";
		
		$pagination['now_url']=preg_replace('#\&page=\d*#','',$now_url);
		$pagination['before_page_number']="&page=";
	}
	
	$current_link = $engine_config['site_path'].$_SERVER['REQUEST_URI'];
	
	//если адрес не соответствует действительному - редиректим.
	if($news_config['redirect_to_rigth_news_path'] and ($link != $current_link) and $view_short_type!='getparams')
	{
		header("HTTP/1.1 301");
		header ("Location: ".$link);
		die("Ваш браузер не поддерживает переадресацию или он заблокировал ее.<br />
		Перейдите на целевую страницу сами: <a href='".$link."'>".$link."</a>!");
	}

	
	// пробуем вытянуть с кеша
	if($engine_config['cache_enable']==1 and $news_config['use_cache']==1)
	{
		$file_cache_name = get_short_text_cache_name ($correct_path, $data['page']);
		$short_text_content = get_cache($file_cache_name,$news_config['short_cache_time']);
	}

	if(!isset($short_text_content) or !$short_text_content)
	{
		// лимит
		if($data['page']>1)
			$news_query_array['limit'] = ($data['page']-1)*$news_config['news_on_page'].",".$news_config['news_on_page'];
		else
			$news_query_array['limit'] = $news_config['news_on_page'];
		
		
		// стандартные параметры для выборки количества
		$postquantity_select=array('count(*) postsquantity');
		if(isset($news_count_query_array['select']) and $news_count_query_array['select'])
			$news_count_query_array['select']=array_merge((array) $news_query_array['select'],$postquantity_select);
		else
			$news_count_query_array['select']=$postquantity_select;

		$news_count_query_array['from']='`{P}_news`';
		$news_count_query_array['where'][]='`approved`=1';
		
		
		// параметры для выборки новостей
		$news_select=array('`{P}_news`.`id` newsid' ,'`title`', '`url_name`', '`category_id`', '`{P}_news`.`date`', '`poster`', '`short_text`', '`user_name`','`{P}_news`.`comments_quantity`', '`views`');
		if(isset($news_query_array['select']) and $news_query_array['select'])
			$news_query_array['select']=array_merge((array) $news_query_array['select'],$news_select);
		else
			$news_query_array['select']=$news_select;
			
		$news_query_array['from']='`{P}_news`';
		$news_query_array['where'][]='`approved`=1';
		$news_query_array['order_by'] = array('`pinned` DESC', '`{P}_news`.`date` DESC');
		
		$news_query_array=filter('short_news_query', $news_query_array);
		$news_count_query_array=filter('short_news_count_query', $news_count_query_array);
		
		// считаем колличество новостей
		$news_count_query=make_query($news_count_query_array);
// 		echo $news_count_query;
		$news_count_row = single_query($news_count_query, $news_query_array['variables']) 
		or $error[]="Ошибка определения количества новостей";
// 		$postsquantity = $news_count_row['postsquantity'];
		
// 		var_dump($news_query_array['variables']);
		//если есть новости
		if(ceil($news_count_row['postsquantity']/$news_config['news_on_page']) >= $data['page'])//ceil - округляем в бОльшую сторону, чтоб работала последняя страница
		{
			$news_query = make_query($news_query_array);
			$news_result = query($news_query, $news_query_array['variables']) or $error[]="Ошибка выборки новостей";
			$global_shortstory_tpl=get_template($templatename);
			
			while ($data['news_row'] = fetch_assoc($news_result))
			{
				$data['tpl']=$global_shortstory_tpl;
				unset ($data['parse']);
				unset ($cat_links);

				$cat_links = make_cat_links($data['news_row']['category_id']);
				
				$data=filter('filter_before_shortnews_parse', $data);
				//var_dump($res);
				$data['parse']['{link-category}'] = $cat_links;
				$data['parse']['{full-link}']=$engine_config['site_path'].make_news_link ($data['news_row']['newsid'], $data['news_row']['url_name'], $data['news_row']['category_id']);
				$data['parse']['{date}']=relative_date($data['news_row']['date']);
				$data['parse']['{title}'] = stripslashes($data['news_row']['title']);
				$data['parse']['{safe_title}'] = safe_text($data['parse']['{title}']);
				$data['parse']['{poster}'] = stripslashes($data['news_row']['poster']);
				$data['parse']['{newsid}'] = $data['news_row']['newsid'];
				$data['parse']['{short-story}'] = function_bbcode_to_html_short(/*stripslashes(*/$data['news_row']['short_text']/*)*/, $data['news_row']['title']);
				$data['parse']['{author_link}'] = "/".$LANG['user']."/".rawurlencode($data['news_row']['user_name']);
				$data['parse']['{author_name}'] = $data['news_row']['user_name'];
				$data['parse']['{comments-num}'] = $data['news_row']['comments_quantity'];
				$data['parse']['{views}'] = $data['news_row']['views'];
// 				$data['parse']['{author_group_id}'] = $data['news_row']['user_group'];
				
// 				preg_match("/\[poster\](.*?)\[\/poster\]/isu", $data['tpl'], $poster);
// 				if($data['news_row']['poster'])
// 					$data['tpl'] = str_replace($poster['0'], $poster['1'], $data['tpl']);
// 				else
// 					$data['tpl'] = str_replace($poster['0'], '', $data['tpl']);

				// парсим шаблон
				if(isset($tmp_content))
					$tmp_content .= parse_template($data['tpl'],$data['parse']);
				else
					$tmp_content = parse_template($data['tpl'],$data['parse']);
			}//конец цикла while ($data['news_row'] = mysql_fetch_array($news_result))
			
			if(isset($short_text_content))
				$short_text_content .= parse_template(get_template('shortstory'),array('{rows}'=>$tmp_content));
			else
				$short_text_content = parse_template(get_template('shortstory'),array('{rows}'=>$tmp_content));

			//пагинация
			$short_text_content .= universal_link_bar($news_count_row['postsquantity'],$data['page'],$pagination['now_url'],$news_config['news_on_page'],$news_config['pagelinks'],$pagination['before_page_number'],$pagination['after_page_number']);
		}
		
		if($engine_config['cache_enable']==1 and $news_config['use_cache']==1)
			set_cache ($file_cache_name, $short_text_content);
	}

	if(isset($short_text_content) and $short_text_content)
	{
		while(preg_match("/\[edit\|(.*?)\](.*?)\[\/edit\]/isu", $short_text_content, $post))
		{
			if($news_config['allow_edit_all_posts'] or ($post['2']==$_SESSION['user_name'] and in_array($_SESSION['user_name'],$news_config['allow_edit_own_posts'])))
				$short_text_content = str_replace($post['0'], $post['2'], $short_text_content);
			else
				$short_text_content = str_replace($post['0'], '', $short_text_content);
		}
	
		$parse_main['{content}'] =  $short_text_content;
	}
	else
		$parse_main['{content}'] ='';
?>
<?php

if (!defined('a1cms'))
	die('Access denied front_view_full!');
	
	include_once root.'/plugins/news/options.php';
	
	global $engine_config, $debug, $error, $parse_main, $LANG;
	
	$news_query_array=array();
	$variables=array();
	$templatename = 'fullstory';
	$data=array('news_row'=>array(), 'parse'=>array(), 'tpl'=>'', 'page'=>$page);
	
	// пагинация. Дефолтные значения
	$pagination['before_page_number']=$LANG['page'].'/';
	$pagination['after_page_number']='/';
	$pagination['now_url']='/';

	// пробуем вытянуть с кеша
	if($engine_config['cache_enable']==1 and $news_config['use_cache']==1)
	{
// 		$cacheenabled=1;// потом проверяется для записи в кеша
		
		$file_cache_name = get_full_text_cache_name ($newsid, $cat_url_name);
		$data['full_text_content'] = get_cache ($file_cache_name,$news_config['full_cache_time']);

		if($data['full_text_content'])
		{
			//вытягиваем с кеша сохраненные переменные
			preg_match("#\<saved-options\>(.*?)\</saved-options\>#u", $data['full_text_content'], $saved_array);
			$saved_array=unserialize($saved_array['1']);
			foreach($saved_array as $key => $value) {
				$$key = $value; //значения массива в переменные
			}
			$data['full_text_content']=preg_replace("#\<saved-options\>.*?\</saved-options\>#u", '', $data['full_text_content']);

			//если адрес не соответствует действительному - редиректим. FIXME: формировать ссылку с $page
			if($news_config['redirect_to_rigth_news_path'] and ($link != $_SERVER['REQUEST_URI']) and $page<=1)
			{
				header("HTTP/1.1 301");
				header ("Location: ".$engine_config['site_path'].$link);
				die("Ваш браузер не поддерживает переадресацию или он заблокировал ее.<br />
				Перейдите на целевую страницу сами: <a href='".$engine_config['site_path'].$link."'>".$engine_config['site_path'].$link."</a>!");
			}
		}
	}

	if(!isset($data['full_text_content']))
	{
		// параметры для выборки новостей
		$news_select=array('`{P}_news`.`id` newsid, `title`, `url_name`, `category_id`, `{P}_news`.`date` newsdate, `poster`, `full_text`, `short_text`, `user_name`, `{P}_news`.`comments_quantity` newscomments_quantity, `allow_comments`, `views`, `description`, `keywords`, `approved`');
		if(isset($news_query_array['select']) and $news_query_array['select'])
			$news_query_array['select']=array_merge((array) $news_query_array['select'],$news_select);
		else
			$news_query_array['select']=$news_select;
		$news_query_array['from']='`{P}_news`';
		$news_query_array['where'][]='`{P}_news`.`id` = i<newsid>';
		$news_query_array['limit'] = 1;

		$news_query = make_query($news_query_array);
		$data['news_row'] = single_query($news_query, array('newsid'=>$newsid)) /*or $error[]="Ошибка выборки новостей"*/;
		
		if($data['news_row']['newsid'])
		{
			$data['tpl']=get_template($templatename);

			unset ($parse);
			unset ($cat_links);

			$cat_links = make_cat_links($data['news_row']['category_id']);
			$maked_link = make_news_link ($data['news_row']['newsid'], $data['news_row']['url_name'], $data['news_row']['category_id']);
			
			//если адрес не соответствует действительному - редиректим. FIXME: формировать ссылку с $page
			if($news_config['redirect_to_rigth_news_path'] and ($maked_link != $_SERVER['REQUEST_URI']) and $page<=1)
			{
				header("HTTP/1.1 301");
				header ("Location: ".$engine_config['site_path'].$maked_link);
				die("Ваш браузер не поддерживает переадресацию или он заблокировал ее.<br />
				Перейдите на целевую страницу сами: <a href='".$engine_config['site_path'].$maked_link."'>".$engine_config['site_path'].$maked_link."</a>!");
			}
			
			if($data['news_row']['full_text'])
				$story = function_bbcode_to_html(stripslashes($data['news_row']['full_text']), $data['news_row']['title']);
			else
				$story = function_bbcode_to_html(stripslashes($data['news_row']['short_text']), $data['news_row']['title']);

			//$data=$news_row;
			//$data['page']=$page;
			//global $parse, $news_tpl;
			event('plugin_init_before_fullnews_parse', $data);
			$data=filter('filter_before_fullnews_parse', $data);

			$data['parse']['{link-category}'] = $cat_links;
			$data['parse']['{full-link}']=$engine_config['site_path'].$maked_link;
			$data['parse']['{date}']=relative_date($data['news_row']['newsdate']);
			$data['parse']['{title}'] = stripslashes($data['news_row']['title']);
			$data['parse']['{safe_title}'] = safe_text($data['parse']['{title}']);
			$data['parse']['{poster}'] = stripslashes($data['news_row']['poster']);
			$data['parse']['{newsid}'] = $data['news_row']['newsid'];
			$data['parse']['{full-story}'] = function_bbcode_to_html(/*stripslashes(*/$data['news_row']['full_text']/*)*/, $data['news_row']['title']);
			$data['parse']['{author_link}'] = "/".$LANG['user']."/".rawurlencode($data['news_row']['user_name']);
			$data['parse']['{author_name}'] = $data['news_row']['user_name'];
			$data['parse']['{comments-num}'] = $data['news_row']['newscomments_quantity'];
			$data['parse']['{views}'] = $data['news_row']['views'];
// 			$data['parse']['{author_group_id}'] = $data['news_row']['user_group'];
			
			
			$parse_main['{meta-title}']=$data['news_row']['title'];
			$parse_main['{meta-description}'] = $data['news_row']['description'];
			$parse_main['{meta-keywords}'] = $data['news_row']['keywords'];
			
// 			preg_match("/\[poster\](.*?)\[\/poster\]/isu", $data['tpl'], $poster);
// 			if($data['news_row']['poster'])
// 				$data['tpl'] = str_replace($poster['0'], $poster['1'], $data['tpl']);
// 			else
// 				$data['tpl'] = str_replace($poster['0'], '', $data['tpl']);

			if(isset($data['full_text_content']))
				$data['full_text_content'] .= parse_template($data['tpl'],$data['parse']);
			else
				$data['full_text_content'] = parse_template($data['tpl'],$data['parse']);
			
			event('plugin_init_after_fullnews_parse', $data);
			$data=filter('filter_after_fullnews_parse', $data);
			
			//пагинация FIXME: отключено в полной новости. Запилить в плагине комментариев.
// 			$data['full_text_content'] .= universal_link_bar($postsquantity,$page,$pagination['now_url'],$news_config['news_on_page'],$news_config['pagelinks'],$pagination['before_page_number'],$pagination['after_page_number']);
			
			//записываем, если кеш включен и новость опубликована
			if($engine_config['cache_enable']==1 and $news_config['use_cache']==1 and $data['news_row']['approved'])
			{
				$saved_options=array('news_title'=>$news_title,'link'=>$maked_link, 'descr'=>$descr, 'keywords' => $keywords, 'allow_comments'=>$data['news_row']['allow_comments'], 'comments_quantity'=>$data['news_row']['comments_quantity'],);
				$cache_story = '<saved-options>'.serialize($saved_options).'</saved-options>'.$data['full_text_content'];
				set_cache ($file_cache_name, $cache_story);
			}
		}
// 		else
// 		{
// 			header("HTTP/1.0 404 Not Found");
// 			$headers['title'] = "Внимание, обнаружена ошибка &rsaquo; ".$engine_config['site_title'];
// 			$data['full_text_content'] = showinfo("Внимание, обнаружена ошибка: 404 Not Found", "Запрашиваемая новость не найдена. Воспользуйтесь поиском чтобы найти ее.", "error");
// 		}
	}
	
	if(isset($data['full_text_content']))
	{
		while(preg_match("/\[edit\|(.*?)\](.*?)\[\/edit\]/isu", $data['full_text_content'], $post))
		{
			if(
			(isset($_SESSION['user_group']) and in_array ($_SESSION['user_group'],$news_config['allow_edit_all_posts'])) 
			or 
			(isset($_SESSION['user_name']) and $post['2']==$_SESSION['user_name'] and in_array($_SESSION['user_name'],$news_config['allow_edit_own_posts'])))
				$data['full_text_content'] = str_replace($post['0'], $post['2'], $data['full_text_content']);
			else
				$data['full_text_content'] = str_replace($post['0'], '', $data['full_text_content']);
		}
	
		$parse_main['{content}'] =  $data['full_text_content'];
	}
?>
<?php

if (!defined('a1cms')) 
	die('Access denied to last_news!');

function last_news ()
{
// 	include_once 'config.php';
	include_once 'options.php';

	global $engine_config, $LANG, $parse_plugins;

	$template='last_news';
	$template_content = get_template($template);
	preg_match("/\[entrie\](.*?)\[\/entrie\]/isu", $template_content, $entrie_out);
	$entrie_tpl=$entrie_out['1'];

	$vars=array(
// 	'related_story'=>strip_tags($data['news_row']['full_text']),
// 	'newsid'=>$data['news_row']['newsid'],
	'limit'=>$last_news_options['limit'],
	);

// 	$last_news_story_query="select concat(`{P}_news`.`title`,' ',`{P}_news`.`short_text`,' ',`{P}_news`.`full_text`) story from `{P}_news` where `{P}_news`.`id` = i<newsid>";
// 	$last_news_story_result = query($last_news_story_query, $vars);
// 	$last_news_story_row = fetch_assoc($last_news_story_result);
	//$vars['last_news_story']=strip_tags($last_news_story_row['story']);

	$query = "SELECT `{P}_news`.`id` newsid, `poster`, `title`, `{P}_news`.`date` newsdate, `category_id`, `url_name`, `user_name`
	FROM `{P}_news`
	WHERE `approved`='1'
	ORDER BY `date` DESC
	LIMIT i<limit>";
	
	$result = query($query, $vars) or $error[] = "Ошибка выборки похожих новостей";

	while($data['last_news_row'] = fetch_assoc($result))
	{
	
		$data['tpl']=$entrie_tpl;
		$data['last_news_row']['title'] = stripslashes($data['last_news_row']['title']);
		//$maked_link=make_news_link($data['last_news_row']['newsid'], $data['last_news_row']['url_name'], $data['last_news_row']['category']);
		//$news_title="<a href='".$engine_config['site_path'].$maked_link."'>" .$data['last_news_row']['title'] . "</a>";

		$data['parse']['{tr_style}']='';
		$data['parse']['{title}']=stripslashes($data['last_news_row']['title']);
		$data['parse']['{poster}']=$data['last_news_row']['poster'];
		$data['parse']['{full-link}']=$engine_config['site_path'].make_news_link ($data['last_news_row']['newsid'], $data['last_news_row']['url_name'], $data['last_news_row']['category_id']);
		
		$data['parse']['{link-category}'] = make_cat_links($data['last_news_row']['category_id']);
		
		$data['parse']['{date}']=relative_date($data['last_news_row']['newsdate']);
		$data['parse']['{newsid}']=$data['last_news_row']['newsid'];
		$data['parse']['{author_group_id}'] = $data['last_news_row']['user_group'];
		$data['parse']['{author_link}'] = "/".$LANG['user']."/".rawurlencode($data['last_news_row']['user_name']);
		$data['parse']['{user_name}'] = $data['last_news_row']['user_name'];
		
		$data=filter('filter_before_last_news_parse', $data);

		$last_news .= parse_template($data['tpl'], $data['parse']);
	}
	
		if($last_news)
			$parse[$entrie_out['0']]=$last_news;
		else
			$parse[$entrie_out['0']]='';

	$parse_plugins['{plugin=last_news}']=parse_template($template_content, $parse);
}

?>
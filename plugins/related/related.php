<?php

if (!defined('a1cms')) 
	die('Access denied to related!');

function related_news ($data)
{
// 	include_once 'config.php';
	include_once 'options.php';

	global $engine_config, $LANG, $parse_plugins;

	$template='related';
	$template_content = get_template($template);
	preg_match("/\[entrie\](.*?)\[\/entrie\]/isu", $template_content, $entrie_out);
	$entrie_tpl=$entrie_out['1'];

	$vars=array(
	'related_story'=>strip_tags($data['news_row']['full_text']),
	'newsid'=>$data['news_row']['newsid'],
	'limit'=>$related_options['limit'],
	);

	$related_story_query="select concat(`{P}_news`.`title`,' ',`{P}_news`.`short_text`,' ',`{P}_news`.`full_text`) story from `{P}_news` where `{P}_news`.`id` = i<newsid>";
	$related_story_result = query($related_story_query, $vars);
	$related_story_row = fetch_assoc($related_story_result);
	$vars['related_story']=strip_tags($related_story_row['story']);

	$query = "SELECT `{P}_news`.`id` newsid, `poster`, `title`, `{P}_news`.`date` newsdate, `category_id`, `url_name`, `user_name`
	FROM `{P}_news`
	WHERE
	MATCH (`short_text`, `full_text`, `title`)  AGAINST (<related_story>)
	AND `{P}_news`.`id` != i<newsid>
	AND `approved`='1'

	LIMIT i<limit>";
	

	$result = query($query, $vars) or $error[] = "Ошибка выборки похожих новостей ";

	while($data['related_row'] = fetch_assoc($result))
	{
	
			//unset ($cat_links);

			$cat_links = make_cat_links($data['related_row']['category_id']);
	
		$data['tpl']=$entrie_tpl;
		$data['related_row']['title'] = stripslashes($data['related_row']['title']);
		//$maked_link=make_news_link($data['related_row']['newsid'], $data['related_row']['url_name'], $data['related_row']['category']);
		//$news_title="<a href='".$engine_config['site_path'].$maked_link."'>" .$data['related_row']['title'] . "</a>";

		$data['parse']['{tr_style}']='';
		$data['parse']['{title}']=stripslashes($data['related_row']['title']);
		$data['parse']['{poster}']=$data['related_row']['poster'];
		$data['parse']['{full-link}']=$engine_config['site_path'].make_news_link ($data['related_row']['newsid'], $data['related_row']['url_name'], $data['related_row']['category_id']);
		
		$data['parse']['{link-category}'] = $cat_links;
		
		$data['parse']['{date}']=relative_date($data['related_row']['newsdate']);
		$data['parse']['{newsid}']=$data['related_row']['newsid'];
		$data['parse']['{author_group_id}'] = $data['related_row']['user_group'];
		$data['parse']['{author_link}'] = "/".$LANG['user']."/".rawurlencode($data['related_row']['user_name']);
		$data['parse']['{user_name}'] = $data['related_row']['user_name'];
		
		$data=filter('filter_before_related_parse', $data);

		$related .= parse_template($data['tpl'], $data['parse']);
	}
		if($related)
			$parse[$entrie_out['0']]=$related;
		else
			$parse[$entrie_out['0']]='';

	$parse_plugins['{plugin=related}']=parse_template($template_content, $parse);
}

?>
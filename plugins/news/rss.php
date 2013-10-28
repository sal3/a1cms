<?php
if(!$news_config['rss_enable'])
    die('RSS disabled.');
    
global $engine_config;

if($news_config['site_short_title_to_rsstitle'])
	$title=$engine_config['site_short_title'];
else
	$title=$engine_config['site_title'];

if ($_URI['request_uri'] == '/rss.xml') // home
{
	$parse_main['{meta-title}']=$title;
	$parse_main['{meta-description}'] = $engine_config['site_description'];;
}
elseif (in_array($_URI['path_params'][1],$cat_altnames))
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
	$rss_query_array['where'][] = $news_count_query_array['where'][] = "`category_id` REGEXP '[[:<:]](".$cat_plus_childs_line.")[[:>:]]'";
	
	//meta
	global $_CAT;
	if(!$_CAT)
		$_CAT=CategoriesGet();
		
	$parse_main['{meta-title}']=$_CAT[$cat]['name'].' &gt; '.$title;
	$parse_main['{meta-description}'] = $_CAT[$cat]['description'];
// 	$parse_main['{meta-keywords}'] = $_CAT[$cat]['keywords'];
}

$rss_query_array=array('variables'=>array());
$rss_select=array('`{P}_news`.`id` newsid' ,'`title`', '`url_name`', '`category_id`', '`{P}_news`.`date`', '`poster`', '`short_text`', '`user_name`');
if(isset($rss_query_array['select']))
	$rss_query_array['select']=array_merge((array) $rss_query_array['select'],$rss_select);
else
	$rss_query_array['select']=$rss_select;
$rss_query_array['from']='`{P}_news`';
$rss_query_array['where'][]='`approved`=1';
$rss_query_array['order_by'] = array('`{P}_news`.`date` DESC');
$rss_query_array['limit']=$news_config['rss_limit'];

$rss_query_array=filter('rss_query', $rss_query_array);

$rss_query = make_query($rss_query_array);
// echo $rss_query;
$result = query($rss_query, $rss_query_array['variables']) or $error[]="Ошибка выборки новостей";


$xml = sprintf('<?xml version="1.0" encoding="%s"?>', $engine_config['charset']) . "\r\n";
$xml .= '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">'. "\r\n";
$xml .= '<channel>'. "\r\n";
$xml .= '<title>'.$parse_main['{meta-title}'].'</title>'. "\r\n";
$xml .= '<link>'.$engine_config['site_path'].'/</link>'. "\r\n";
$xml .= '<language>ru</language>'. "\r\n";
$xml .= '<description>'.$parse_main['{meta-description}'].'</description>'. "\r\n";
$xml .= '<generator>'.$engine_config['engine_name'].' '.$engine_config['engine_version'].'</generator>'. "\r\n";

while($row = fetch_assoc($result))
{
	$row['short_story']="<center><img src='{$row['poster']}' /></center><br />".function_bbcode_to_html($row['short_text']);
	$xml .= "\t" . '<item>' . "\r\n";
	$xml .= "\t\t" . sprintf('<title>%s</title>', $row['title'] . "\r\n");
	$xml .= "\t\t" . sprintf('<guid isPermaLink="true">%s</guid>', $engine_config['site_path'].make_news_link ($row['newsid'], $row['url_name'], $row['category_id'])) . "\r\n";
	$xml .= "\t\t" . sprintf('<link>%s</link>', $engine_config['site_path'].make_news_link ($row['newsid'], $row['url_name'], $row['category_id'])) . "\r\n";
	$xml .= "\t\t" . sprintf('<description><![CDATA[%s]]></description>', $row['short_story']) . "\r\n";
	$xml .= "\t\t" . sprintf('<category><![CDATA[%s]]></category>', preg_replace("#\<.*?\>#u", "", make_cat_links($row['category_id']))) . "\r\n";
	$xml .= "\t\t" . sprintf('<dc:creator>%s</dc:creator>', $row['user_name']) . "\r\n";
	$xml .= "\t\t" . sprintf('<pubDate>%s</pubDate>', date("r", strtotime($row['date']))) . "\r\n";
	$xml .= "\t" . '</item>' . "\r\n";
}
$xml .= '</channel></rss>';
header('Content-Type: text/xml');
echo $xml;

//get_rssxml_from_file();
die();
?>
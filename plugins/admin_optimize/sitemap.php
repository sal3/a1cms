<?php

if (!defined('a1cms'))
	die('Access denied to admin_optimize!');
include_once '../sys/categories.php';

//проход категорий
foreach ($cat_array as $k=>$v)
{
    if($v['parentid']==0)
	$site_catz.="\t<url>\n\t\t<loc>".$engine_config['site_path']."/".rawurlencode($v['url_name'])."/</loc>\n\t\t<lastmod>".date('Y-m-d')."</lastmod>\n\t\t<priority>0.8</priority>\n\t</url>\n";

    else
	$site_catz.="\t<url>\n\t\t<loc>".$engine_config['site_path']."/".rawurlencode($v['parent_url_name'])."/".rawurlencode($v['url_name'])."</loc>\n\t\t<lastmod>".date('Y-m-d')."</lastmod>\n\t\t<priority>0.7</priority>\n\t</url>\n";
}

//проход новостей
$files_query = "SELECT `{P}_news`.`id` postid, `category_id`, `url_name`, `date`, `editdate`
FROM `{P}_news`
WHERE approved = 1"
;
$files_result = query($files_query);

while($files_row = fetch_assoc($files_result))
{
	if($files_row['editdate'])
		$date=substr($files_row['editdate'], 0, 10);
	else
		$date=substr($files_row['date'], 0, 10);

	$link .= "\t<url>\n\t\t<loc>".$engine_config['site_path'].make_news_link ($files_row['postid'], $files_row['url_name'], $files_row['category'],1)."</loc>\n\t\t<lastmod>$date</lastmod>\n\t\t<priority>0.5</priority>\n\t</url>\n";
	$links_quantity++;
}

// вывод результатов
$result =file_put_contents('../sitemap.xml',
'<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$site_catz.$link.'</urlset>');

if($result)
{
	//пингуем поисковики, уведомляя о новом sitemap
	$google = file_get_contents("http://www.google.com/webmasters/sitemaps/ping?sitemap=".$engine_config['site_path']."/sitemap.xml");
	$yandex = file_get_contents("http://ping.blogs.yandex.ru/ping?sitemap=".$engine_config['site_path']."/sitemap.xml");
	$bing = file_get_contents("http://www.bing.com/webmaster/ping.aspx?siteMap=".$engine_config['site_path']."/sitemap.xml");

	$parse_admin['{module}'] = "Sitemap сформирован. В файл занесено $links_quantity ссылок(а)";
}
?>
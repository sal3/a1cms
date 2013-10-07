<?php

if (!defined('a1cms'))
	die('Access denied to engine.php!');

define('root', substr(dirname( __FILE__ ), 0, -4));
include_once root.'/sys/config.php';

$FC = array();

//ip пользователя. В базе не хранить! Используется для бана по ip
$FC['ip']=getenv("HTTP_X_FORWARDED_FOR");
if (empty($FC['ip']) || $FC['ip']=='unknown')
	$FC['ip']=getenv("REMOTE_ADDR");

$FC['useragent'] = $_SERVER['HTTP_USER_AGENT'];
$FC['iplabel'] =md5($FC['ip'].$FC['useragent']);


$engine_config['engine_name']="A1 CMS";
$engine_config['engine_version']="0.1";

if (!$engine_config['site_short_title'])
	$engine_config['site_short_title']=$engine_config['site_title'];

// define('root', $_SERVER['DOCUMENT_ROOT'].$engine_config['subfolder']);
$engine_config['site_path']= 'http://'.$_SERVER['HTTP_HOST'].$engine_config['subfolder'];
$engine_config['http_avatar_path']=$engine_config['site_path'].'/uploads/avatar/';

//шаблон
//блок должен располагаться после путей
$engine_config['template_path'] = $template_path = root.'/templates/'.$engine_config['template_name'];// FIXME: оставить одну переменную
$engine_config['template_path_http'] = $engine_config['site_path'].'/templates/'.$engine_config['template_name'];

//шаб админки
$engine_config['admincenter_tpl_path'] = root.'/admin/templates/'.$engine_config['admin_template_name'];
$engine_config['admin_template_path_http'] = $engine_config['site_path'].'/admin/templates/'.$engine_config['admin_template_name'];

//директории
$engine_config['avatar_dir']= root.$engine_config['avatar_dir_config'];
// $engine_config['files_dir']= root.'/uploads/files/';
$engine_config['images_dir']= root.$engine_config['images_dir_config'];
$engine_config['images_path_http']= $engine_config['site_path'].$engine_config['images_dir_config'];

$engine_config['cache_dir']= root.$engine_config['cache_dir_config'];


// $engine_config['current_month']= date ('Y-m');//текущий год-месяц для заброса в path/каталог //FIXME! должно называться current_dir
// //FIXME!
// if (!is_dir ($engine_config['files_dir'].$engine_config['current_month']))
//     mkdir ($engine_config['files_dir'].$engine_config['current_month'], 0777, 1);


if(is_writable(root))
{
	if (!file_exists(root.'/uploads'))
		mkdir(root.'/uploads', 0777);

	if (!file_exists($engine_config['cache_dir']))
		mkdir($engine_config['cache_dir'], 0777);

	if (!file_exists($engine_config['images_dir']))
		mkdir($engine_config['images_dir'], 0777);

	if (!file_exists($engine_config['avatar_dir']))
		mkdir($engine_config['avatar_dir'], 0777);
		
	$engine_config['cat_cache_dir']=$engine_config['cache_dir'].'/cats';
	if (!file_exists($engine_config['cat_cache_dir']))
		mkdir($engine_config['cat_cache_dir'], 0777);
		
		
	$engine_config['cat_array_cache_file'] = $engine_config['cat_cache_dir'].'/categories_array.tmp';
	$engine_config['cat_url_names_cache_file'] = $engine_config['cat_cache_dir'].'/categories_altnames_array.tmp';
	$engine_config['cat_parent_altnames_array'] = $engine_config['cat_cache_dir'].'/cat_parent_altnames_array.tmp';
}
else
	$error[]="Нет прав для создания системных каталогов";

if($engine_config['cache_enable'] == 1)
{
	$engine_config['cache_time'] = 60*24;//время жизни кеша в мин.
	$engine_config['stats_cache_time'] = 360; //кешировать статистику на 60 мин

	$engine_config['cat_tree_cache_file'] = $engine_config['cat_cache_dir'].'/categories_tree_array.tmp';

	$engine_config['json_cat_tree_cache_file'] = $engine_config['cat_cache_dir'].'/json_cat_tree_cache_file.tmp';
	$engine_config['json_subcat_tree_cache_file'] = $engine_config['cat_cache_dir'].'/json_cat_tree_cache_file_';
}


	

//реклама
// $engine_config['ad_enable'] = 1;

// //похожие
// $engine_config['related'] = array(
//         'on' => 1,
//         'limit' => 10);

//ЛС
$engine_config['pm_enable'] = 1;
$engine_config['pm_messages_on_page'] = 10;
$engine_config['pm_taskperiod'] = 24*60;

// //top 10 posts of week
// $engine_config['top_posts']['enable']=1;
// $engine_config['top_posts']['limit']=50;
// $engine_config['top_posts']['cache_time']=60; //кешировать топ недели на 60 мин\

// //top 10 releasers of week
// $engine_config['top_users']['enable']=1;
// $engine_config['top_users']['limit']=10;
// $engine_config['top_users']['cache_time']=60; //кешировать топ релизеров недели на 60 мин

// //команда сайта
// $engine_config['sitestaff']['enable']=1;
// $engine_config['sitestaff']['limit']=500;
// $engine_config['sitestaff']['cache_time']=60; //кешировать команду сайта на 60 мин

$engine_config['default_avatar_path']=$engine_config['template_path_http'].$engine_config['default_avatar_path_config'];


//FIXME: вынести в отдельный файл
$LANG['user']=rawurlencode("пользователь");
$LANG['page']=rawurlencode("страница");
$LANG['news']=rawurlencode("новости");
$LANG['comments']=rawurlencode("комментарии");
$LANG['lastcomments']=rawurlencode("последние-комментарии");
$LANG['news-list']=rawurlencode("список-новостей");
$LANG['search']=rawurlencode("поиск");

$LANG['newscomments']=rawurlencode("комментарии-к-новостям");
$LANG['subscribe_rss']="Подписаться на RSS-ленту новостей";







?>

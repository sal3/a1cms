<?php

if (!defined('a1cms'))
	die('Access denied to stats!');

global $engine_config, $parse_main;

if($engine_config['cache_enable']=='1')
{

	$stats_cache_file = $engine_config['cache_dir'].'/stats.tmp';;

	if(file_exists($stats_cache_file))
	{
		$modif=time()-@filemtime ($stats_cache_file);

		if ($modif<$engine_config['stats_cache_time'])
		{
				$stats_content = file_get_contents($stats_cache_file);
				if($_SESSION['user_id']==1)
				$debug[]= "Статистика взята с кеша.";
		}
	}
}
if(!isset($stats_content))
{
	$stats_template = get_template('stats');

	//новостей всего, за сутки, неделю, месяц
	$row_stat_news_all = single_query("SELECT COUNT(*) AS count FROM {P}_news WHERE approved=1");
	$parse['{news_all}'] = $row_stat_news_all['count'];

	$row_stat_news1day = single_query("SELECT COUNT(*) AS count FROM {P}_news where `createdate` > NOW() - INTERVAL 1 DAY and approved=1");
	$parse['{news1day}'] = $row_stat_news1day['count'];

	$row_stat_news7day = single_query("SELECT COUNT(*) AS count FROM {P}_news where `createdate` > NOW() - INTERVAL 7 DAY and approved=1");
	$parse['{news7day}'] = $row_stat_news7day['count'];

	$row_stat_news_month = single_query("SELECT COUNT(*) AS count FROM {P}_news where `createdate` > NOW() - INTERVAL 1 MONTH and approved=1");
	$parse['{news_month}'] = $row_stat_news_month['count'];

	//по пользователям: всего, за последние сутки, неделю, месяц
	$row_stat_users_all = single_query("SELECT COUNT(*) AS count FROM {P}_users WHERE approved=1");
	$parse['{users}'] = $row_stat_users_all['count'];

	$row_stat_users_1day = single_query("SELECT COUNT(*) AS count FROM {P}_users where FROM_UNIXTIME(registration_date) > NOW() - INTERVAL 1 DAY and approved=1");
	$parse['{users1day}'] = $row_stat_users_1day['count'];

	$row_stat_users_7day = single_query("SELECT COUNT(*) AS count FROM {P}_users where FROM_UNIXTIME(registration_date) > NOW() - INTERVAL 7 DAY and approved=1");
	$parse['{users7day}'] = $row_stat_users_7day['count'];

	$row_stat_users_month = single_query("SELECT COUNT(*) AS count FROM {P}_users where FROM_UNIXTIME(registration_date) > NOW() - INTERVAL 1 MONTH and approved=1");
	$parse['{users_month}'] = $row_stat_users_month['count'];

	//каменты: все, за день, неделю, месяц
	$row_comments = single_query("SELECT COUNT(*) comments FROM {P}_comments");
	$parse['{comments}'] = $row_comments['comments'];

	$row_comments1day = single_query("SELECT COUNT(*) comments FROM {P}_comments where `date` > NOW() - INTERVAL 1 DAY");
	$parse['{comments1day}'] = $row_comments1day['comments'];

	$row_comments7day = single_query("SELECT COUNT(*) comments FROM {P}_comments where `date` > NOW() - INTERVAL 7 DAY");
	$parse['{comments7day}'] = $row_comments7day['comments'];

	$row_comments_month = single_query("SELECT COUNT(*) comments FROM {P}_comments where `date` > NOW() - INTERVAL 1 MONTH");
	$parse['{comments_month}'] = $row_comments_month['comments'];


	$stats_content1=parse_template($stats_template, $parse);
	$stats_content=showinfo("Статистика сайта", $stats_content1);

	if($engine_config['cache_enable']=='1')
	{
		file_put_contents($stats_cache_file, $stats_content);
		if($_SESSION['user_id']==1)
			$debug[]="Статистика записана в кеш.";
	}
}

$parse_main['{meta-title}']="Статистика";
$parse_main['{meta-description}']="Статистика сайта";
$parse_main['{meta-keywords}']="статистика, stats";

$parse_main['{content}'] = $stats_content;
?>

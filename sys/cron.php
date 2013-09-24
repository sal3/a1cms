<?php
if (!defined('a1cms'))
	die('Access denied to cron.php!');

$cronmarks_dir=root.'/cronmarks';

if (!file_exists($cronmarks_dir))
	mkdir($cronmarks_dir, 0777);

// Назначение news_views: обновление количества просмотров с таблицы views
if($engine_config['cache_news_views'])
{
$news_views_taskfile = $cronmarks_dir.'/news_views';

if (!file_exists($news_views_taskfile))
	touch($news_views_taskfile);

$news_views_execute=check_task($news_views_taskfile, $engine_config['news_views_taskperiod']);

    if($news_views_execute)
    {
    $result = query ("SELECT COUNT(`news_id`) views, `news_id` FROM `{P}_views` GROUP BY `news_id`");

    while($row = fetch_assoc($result))
	    {
		if($pieces)
		    $pieces.=', ';

		$pieces .= "(".$row['news_id'].", '".$row['views']."')";
	    }

	    $qery_piece = "INSERT INTO `{P}_news` (`id`, `views`) VALUES ".$pieces."
		ON DUPLICATE KEY UPDATE `views`=`views`+ VALUES(`views`)";
	    query($qery_piece,array('none'=>'none'));
	    query('TRUNCATE TABLE `{P}_views`');
	    touch($news_views_taskfile);

	    $debug[]="CRON: Задание news_views выполнено";
    }

$debug[]="До обновления просмотров c кеша осталось ".($engine_config['news_views_taskperiod'] - (time()-filemtime($news_views_taskfile)))." сек.";
}


// Назначение pm_delete: удаление осиротевших сообщений
if($engine_config['pm_enable'])
{
$pm_taskfile = $cronmarks_dir.'/pm_delete';
if (!file_exists($pm_taskfile))
	touch($pm_taskfile);

$pm_execute=check_task($pm_taskfile, $engine_config['pm_taskperiod']);

    if($pm_execute)
    {

	    touch($pm_taskfile);
	    query("DELETE
                   FROM  `{P}_pm_messages`
                   WHERE  `messageid` NOT IN
                       (SELECT DISTINCT `{P}_pm`.`messageid`
                       FROM  `{P}_pm`)
                   ");


	    $debug[]="CRON: Задание pm_delete выполнено";
    }

$debug[]="До удаления осиротевших сообщений осталось ".($engine_config['pm_taskperiod'] - (time()-filemtime($pm_taskfile)))." сек.";
}


// Назначение old_cache_delete: удаление устаревшего кеша
// if($engine_config['cache_enable'])
// {
// $old_cache_delete_taskfile = $cronmarks_dir.'/old_cache_delete';
// if (!file_exists($old_cache_delete_taskfile))
// 	touch($old_cache_delete_taskfile);
//
// $old_cache_delete_execute=check_task($old_cache_delete_taskfile, $engine_config['cache_time']);
//
//     if($old_cache_delete_execute)
//     {
// 	    shell_exec("find ".$engine_config['cache_dir']." -mmin +".($engine_config['cache_time']*60)." -print -delete");
// 	    touch($old_cache_delete_taskfile);
//
// 	    $debug[]="CRON: Задание old_cache_delete выполнено";
//     }
//
//     $debug[]="До удаления старых файлов кеша осталось ".($engine_config['cache_time'] - (time()-filemtime($old_cache_delete_taskfile)))." сек.";
// }
?>
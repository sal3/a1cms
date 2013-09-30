<?php

if (!defined('a1cms'))
	die('Access denied to admin_optimize!');

//обнуляем
query("UPDATE `{P}_users` SET `news_quantity`=0, `comments_quantity`=0",array('none'=>'none'));
query("UPDATE `{P}_news` SET `comments_quantity`=0",array('none'=>'none'));

//посты
$news_result= query("SELECT COUNT(*) news_quantity, `user_name` FROM  `{P}_news` GROUP BY user_name");
while($news_row = fetch_assoc($news_result))
{
	if($news_row['user_name'] != '')
		query("UPDATE `{P}_users` SET `news_quantity`={$news_row['news_quantity']} WHERE `user_name`='{$news_row['user_name']}'",array('none'=>'none'));
		$i++;
}

//комментарии
if ($plugin_list['comments']['state']==1)
{
	$comm_result= query("SELECT COUNT(*) comm_quantity, `user_name` FROM `{P}_comments` GROUP BY `user_name`");
	while($comm_row = fetch_assoc($comm_result))
	{
		if($comm_row['user_name'] != '')
			query("UPDATE `{P}_users` SET `comments_quantity`={$comm_row['comm_quantity']} WHERE `user_name`='{$comm_row['user_name']}'",array('none'=>'none'));
			$j++;
	}

	//комментарев в постах
	$comm_result2= query("SELECT COUNT(*) comm_quantity, `news_id` FROM `{P}_comments` GROUP BY `news_id`");
	while($comm_row2 = fetch_assoc($comm_result2))
	{
		if($comm_row2['news_id'] != '')
			query("UPDATE `{P}_news` SET `comments_quantity`={$comm_row2['comm_quantity']} WHERE `id`='{$comm_row2['news_id']}'",array('none'=>'none'));
			$k++;
	}
}

$parse_admin['{module}'] = "Пересчитано $i авторов, $j комментаторов и $k комментированных новостей."

?>
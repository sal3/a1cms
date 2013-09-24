<?php

if (!defined('a1cms')) 
	die('Access denied to stats!');

event_register('plugin_init_by_uri','stats_init');

function stats_init($_URI) 
{
	if($_URI['path_params'][1]=='статистика')
	{
		include_once 'stats.php';
	}
}

?>
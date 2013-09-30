<?php
if (!defined('a1cms')) 
	die('Access denied to static!');

event_register('plugin_init_by_uri','static_init');

function static_init($_URI) 
{
	include_once 'options.php';
	include_once 'config.php';
	
	if(!$_URI['path_params'][2]) // если нет продолжения или подкатегорий
	{
		if($_URI['path_params'][1]=='')
		{
			include_once 'general.php';
		}
	}
}
?>
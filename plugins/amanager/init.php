<?php
if (!defined('a1cms')) 
	die('Access denied to amanager!');

if($WHEREI['main']==true)
{
	event_register('plugin_init_by_uri','ad_init');

	function ad_init($_URI)
	{
		global $parse_main, $debug;
		include_once 'options.php';
		include_once 'config.php';

		include_once 'ad.php';
	}
}
?>
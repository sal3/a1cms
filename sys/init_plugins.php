<?php

if (!defined('a1cms'))
	die('Access denied to init_plugins.php!');

$dir=scandir(root.'/plugins');
foreach ($dir as $file)
{
	if($file!='.' and $file!='..' and file_exists(root."/plugins/".$file."/config.php")) {
		include_once root."/plugins/".$file."/config.php";
	}
}

if($plugin_list)
{
	foreach ($plugin_list as $pluginname => $plugin)
	{
		$priority[$pluginname] = $plugin['priority'];
	}
	array_multisort($priority, SORT_ASC, $plugin_list);

	foreach ($plugin_list as $pluginname => $plugin)
	{
		if(/*$plugin['front']==1 and*/ $plugin['state']==1)
		{
			$current_plugin_time = microtime(true);
			$_current_pluginname=$pluginname;
			include_once root."/plugins/".$pluginname."/init.php";
			$debug[]= "Плагин $pluginname выполнен за ".number_format(microtime(true) - $current_plugin_time, 5).' сек';
			unset($_current_pluginname);
			unset($current_plugin_time);
		}
	}
}
else
	$debug[]="Плагины не найдены";

?>
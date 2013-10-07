<?php
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname( __FILE__ ), 0, -28));

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array ($_SESSION['user_group'], $pluginmanager_config['allow_control']))
	die('Access denied to admin_pluginmanager!');

	$dir=scandir(root.'/plugins');
	foreach ($dir as $file) {
		if($file!='.' and $file!='..') {
			include_once root."/plugins/".$file."/config.php";
		}
	}

	foreach ($plugin_list as $pluginname => $plugin)
	{
		//$name[$pluginname] = $plugin['name']; // сортировка по англ названию плагина 
		$name[$pluginname] = $plugin['title']; // сортировка по рус названию плагина 
	}
 	array_multisort($name, SORT_ASC, $plugin_list);

 	$plugins_table=get_template('pluginmanager_table',1);
 	preg_match("/\[item\](.*?)\[\/item\]/isu", $plugins_table, $entrie_out);
	$plugin_item_tpl=$entrie_out[1];
	$plugin_item_parse=$entrie_out[0];

 	foreach ($plugin_list as $pluginname => $plugin_item) 
 	{
		$plugin_item_tpl_current=$plugin_item_tpl;

		$parse_item=array(
		'{name}'=>$pluginname,
		'{title}'=>$plugin_item['title'],
		'{version}'=>$plugin_item['version'],
		'{cat}'=>$plugin_item['cat'],
		'{site}'=>$plugin_item['site'],
		'{icon}'=>$plugin_item['icon'],
		);

		if($plugin_item['state']==1)
		{
			$parse_item['{state}']='Активен';//label-success
			$parse_item['{state-style}']='plugin-active';//label-success
		}
		else
		{
			$parse_item['{state}']='Отключен';//label
			$parse_item['{state-style}']='plugin-inactive';
		}

		if($plugin_item['install_state']==0) 
		{
			$parse_item['{install-state}']='Не инсталлирован';//class="label"\
			$parse_item['{install-state-style}']='plugin-not-installed';
			$parse_item['{delete-button-style}']='';
			$parse_item['[not-disable]']=$parse_item['[/not-disable]']='';
		}
		elseif($plugin_item['install_state']==1) 
		{
			$parse_item['{install-state}']='Инсталлирован';//class="label label-success
			$parse_item['{install-state-style}']='plugin-installed';
			$parse_item['{delete-button-style}']='disabled';
			$plugin_item_tpl_current=preg_replace("/\[not-disable\](.*?)\[\/not-disable\]/isu", '', $plugin_item_tpl_current);
		}
		elseif($plugin_item['install_state']==2) 
		{
			$parse_item['{install-state}']='Не требуется';//class="label label-info"
			$parse_item['{install-state-style}']='plugin-not-need-install';
			$parse_item['{delete-button-style}']='';
			$parse_item['[not-disable]']=$parse_item['[/not-disable]']='';
		}

		$item=parse_template($plugin_item_tpl_current,$parse_item);

		if($_GET['state']=='all')
			$parse_items.=$item;
		elseif($_GET['state']=='active' and $plugin_item['state']==1)
			$parse_items.=$item;
		elseif($_GET['state']=='inactive' and $plugin_item['state']==0)
			$parse_items.=$item;
		elseif($_GET['state']=='installed' and $plugin_item['install_state']==1)
			$parse_items.=$item;
		elseif($_GET['state']=='uninstalled' and ($plugin_item['install_state']==0 or $plugin_item['install_state']==2))
			$parse_items.=$item;
 	}

 	echo parse_template($plugins_table,array($plugin_item_parse=>$parse_items));
?>
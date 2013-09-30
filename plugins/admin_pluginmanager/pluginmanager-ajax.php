<?php
//error_reporting(7);
error_reporting(0);
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

$pluginname= preg_replace('/[^a-z0-9_-]/siu','', $_GET['id']);
$cfg_path=root.'/plugins/'.$pluginname.'/config.php';
include_once $cfg_path;

function save_config($editarr, $message) 
{
	global $pluginname, $error, $plugin_list, $cfg_path;

	if (!file_exists($cfg_path))
		$error[]='Файл config.php не найден';

	if(!$error)
	{
		$plugin_list[$pluginname]=array_merge($plugin_list[$pluginname],$editarr);
		$file=file_get_contents ($cfg_path);
		$file=preg_replace('/\$plugin_list\s*\[\s*(\'|")'.$pluginname.'(\'|")\s*\]\s*=\s*array\s*\((.*?)\)\s*;/siu', '$plugin_list[\''.$pluginname.'\']='.var_export($plugin_list[$pluginname], TRUE).';',$file);
		file_put_contents ($cfg_path, $file);
		echo json_encode(array('error'=>0,'message'=>$message));
	}
}

if($_GET['action']=='get') {
	if (file_exists($cfg_path)) {
		if(!$error)
			echo json_encode($plugin_list[$pluginname]);
	}
	else
		$error[]='Файл config.php не найден';
}
elseif($_GET['action']=='install')
{
	$install_path=root.'/plugins/'.$pluginname.'/install.php';
	if($plugin_list[$pluginname]['install_state']==2)
		$error[]='Данный плагин не требует инсталяции';

	elseif (file_exists($install_path)) {
		include_once $install_path;
		if(!$error)
		{
			$editarr['install_state']=1;
			save_config($editarr,'Плагин '.$pluginname.' успешно инсталирован');
		}
	}
	else
		$error[]='Файл install.php не найден';
}
elseif($_GET['action']=='uninstall')
{
	$uninstall_path=root.'/plugins/'.$pluginname.'/uninstall.php';
	if($plugin_list[$pluginname]['install_state']==2)
		$error[]='Данный плагин не требует деинсталяции';

	elseif (file_exists($uninstall_path)) {
		include_once $uninstall_path;
		if(!$error)
		{
			$editarr['install_state']=0;
			$editarr['state']=0;
			save_config($editarr,'Плагин '.$pluginname.' успешно деинсталирован');
		}
	}
	else
		$error[]='Файл uninstall.php не найден';
}
elseif($_GET['action']=='on') {
	$editarr['state']=1;
	save_config($editarr,'Плагин '.$pluginname.' включен');
}
elseif($_GET['action']=='off') {
	$editarr['state']=0;
	save_config($editarr,'Плагин '.$pluginname.' выключен');
}
elseif($_GET['action']=='set') {
	$editarr['priority']=intval($_GET['priority']);
// 	$editarr['icon']=preg_replace('/[^\.a-z0-9_-]/siu','', $_GET['icon']);
	//$editarr['cat']=preg_replace('/[^a-z]/siu','', $_GET['cat']);

// 	foreach ($_GET['allowed_groups'] as $val)
// 		$editarr['allowed_groups'][]=intval($val);

// 	$allowed_users=preg_replace('/\s+/siu','', $_GET['allowed_users']);
// 	$allowed_users=explode(',',$allowed_users);

// 	foreach ($allowed_users as $username)
// 		$editarr['allowed_users'][]=safe_text($username);

	save_config($editarr,'Настройки плагина '.$pluginname.' успешно сохранены');
}
elseif($_GET['action']=='del') {
	if($plugin_list[$pluginname]['install_state']==1)
		$error[]='Нельзя удалять инсталированный плагин';
	elseif($pluginname and is_dir(root.'/plugins/'.$pluginname))
		//$error[]=root.'/admin/plugins/'.$pluginname. ' удален';
		rmdir_recursive(root.'/plugins/'.$pluginname);
		echo json_encode(array('error'=>0,'message'=>'Плагин '.$pluginname.' успешно удален'));
}


if($error)
	echo json_encode(array('error'=>1,'message'=>implode('<br />', $error)));

?>
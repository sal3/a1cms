<?php

define('a1cms', 'energy', true);
define('akina', 'photohost', true);

define('root', substr(dirname( __FILE__ ), 0, -14));

if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

include_once root.'sys/config.php';
include_once root.'sys/engine.php';
include_once root.'sys/functions.php';
include_once 'akinaconfig.php';
include_once 'functions.php';

if(!in_array ($_SESSION['user_group'], $config['allow_control']))
	die('Access denied!');

if ($config['site_work']!=true)
	die ("Проводятся сервисные работы. Сервис временно недоступен.");

$parse_main=array();

$view = isset($_GET['v']) ? (boolean)$_GET['v'] : false;
$action = isset($_POST['action']) ? (string)$_POST['action'] : '';


// if ($_POST)
// {
// 	var_dump ($_POST);
// 	var_dump ($_FILES);
// }

if(!$view && $action=='' && !$_GET['p'])
	$parse_main['{content}']=parse_template(get_img_template('upload'), array());
elseif($action=='upload')
{
	include_once 'engine.php';
	include_once 'upload.php';
	include_once 'view.php';
}
elseif($view)
	include_once 'view.php';
elseif($_GET['p'])
{
	preg_match('/\w+/',$_GET['p'],$matches);
	$page=$config['template_path']."/".$matches['0'].".static.tpl";
	if(is_file($page))
		$parse_main['{content}']= file_get_contents($page);
	else
		include_once 'error404.php';
}
else
	include_once 'error404.php';

$parse_main['{max_height}']=$config['max_height'];
$parse_main['{max_width}']=$config['max_width'];
$parse_main['{max_size_mb}']=$config['max_size_mb'];
$parse_main['{max_quantity}']=ini_get('max_file_uploads');

$parse_main['{template}']=$config['template_url'];
if(is_array($error))
	$parse_main['{error}']=parse_template (get_template('info'), array("{type}" =>'error',"{title}" =>"Ошибка!","{text}" => implode("<br />", $error)));
else
	$parse_main['{error}']='';
	

$cachefile=$config['site_dir']."/cache"; 
if (time()-@filemtime($cachefile)>$config['cache_time'])
{ 
	touch($cachefile);//чтобы только один пользователь запускал подсчет 
	list($size, $images_total, $images_h24)=get_dir_size($config['uploaddir']);
	$size = formatfilesize($size);
	file_put_contents( $cachefile, "$images_total|$size|$images_h24"); 
} 
elseif (file_exists($cachefile))
	list($images_total, $size, $images_h24) = explode("|", file_get_contents($cachefile)); 

$parse_main['{size}']=$size; 
$parse_main['{images}']=$images_total; 
$parse_main['{images24}']=$images_h24;
$parse_main['{site_http_path}']=$config['site_url'];

if(!$parse_main['{content}'])
	$parse_main['{content}']='';

echo parse_template(get_img_template('index'), $parse_main);
// $result_img['result_img']=parse_template(get_img_template('index'), $parse_main);

// echo json_encode($result_img);
?>
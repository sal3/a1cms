<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_NOTICE);
// error_reporting(0);

//подсчет общего времени выполнения скрипта
$script_global_start_time = microtime(true);

define('a1cms', 'energy', true);

if (!$_COOKIE['PHPSESSID'] or (!is_array($_COOKIE['PHPSESSID']) and preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID'])))
session_start();

// глобальные переменные FIXME: в конфиг или хотя бы в engine (init)

$error=$debug=$parse_main=$message=$parse_plugins=$parse_main=array();
$errorsLine='';
$TEMPLATES_PARSE_TIME_COUNTER = (int) 0;
$parse_main=array('{meta-title}'=>'','{meta-description}'=>'','{meta-keywords}'=>'',);

$WHEREI['main']=true;

include_once 'sys/engine.php';
include_once 'sys/mysql.php';
include_once 'sys/functions.php';
include_once 'sys/init_plugins.php';

//FIXME! в плагины
include_once 'sys/cron.php';


$_URI['request_uri']=rawurldecode($_SERVER['REQUEST_URI']);
$_URI['parsed_url']=parse_url($_URI['request_uri']);
$_URI['path_params']=explode('/',$_URI['parsed_url']['path']); // параметры ЧПУ

event('plugin_init_by_uri', $_URI);

$main = get_template('main');
// include_once 'sys/categoriestree.php';
// include_once 'sys/ad.php';

event('before_parse_main', $main);

// var_dump($parse_main['{content}']);
if(!isset($parse_main['{content}']) or !$parse_main['{content}'])
{
	header("HTTP/1.0 404 Not Found");
	$parse_main['{content}'] = showinfo("Внимание, обнаружена ошибка: 404 Not Found",
		"По вашему запросу ничего не найдено.");
	$headers['title'] = "Внимание, обнаружена ошибка &rsaquo; ".$engine_config['site_title'];
}

// include_once 'sys/meta.php';

	if($parse_main['{meta-title}'])
		$parse_main['{meta-title}'] = $parse_main['{meta-title}']." &rsaquo; ".$engine_config['site_short_title'];
	else
		$parse_main['{meta-title}'] = $engine_config['site_title'];
		
	if(!$parse_main['{meta-description}']) $parse_main['{meta-description}'] = $engine_config['site_description'];
	if(!$parse_main['{meta-keywords}']) $parse_main['{meta-keywords}'] = $engine_config['site_keywords'];
	
	$parse_main['{charset}']=$engine_config['charset'];

	$parse_main['{AJAX}']="<script>var THEME='".$engine_config['template_path_http']."'; var site_path='".$engine_config['site_path']."'; var ADMIN_THEME='".$engine_config['admin_template_path_http']."';</script>";
	$parse_main['{ADMIN_THEME}']=$engine_config['admin_template_path_http'];
	$parse_main['{searchform}']=get_template('searchform');

	if($debug)
	{
		$debug[] = 'Запросов: '.$QUERIES_COUNTER;
		if(isset($QUERIES_TIME_COUNTER))
		$debug[] = 'Запросы заняли: '.number_format($QUERIES_TIME_COUNTER, 5).' сек';
		$debug[] = 'Парсинг шаблонов занял: '.number_format($TEMPLATES_PARSE_TIME_COUNTER, 5).' сек';
		$debug[] = 'Скрипт выполнен за: '.number_format(microtime(true) - $script_global_start_time, 5).' сек';
		$parse_main['{debug}'] = implode("<br />\r\n",$debug);
	}
	
	//если были ошибки
	if($error)
	{
		$n=0;
		while($n<count($error))
		{
			//$errorsLine=ShowPopupInfo('Ошибка',$error[$n], "error").$errorsLine;
			$errorsLine.=showinfo('',$error[$n],'error','');
			$n++;
		}
// 		function  showinfo($title=false,$text=false,$type='info',$admin=false)
//  		echo $errorsLine;
// 		var_dump ($error);
		
		$parse_main['{content}'] =$errorsLine.$parse_main['{content}'];
	}
	
	
	if($message)
	{
		$n=0;
		while($n<count($message))
		{
			//$messagesLine=ShowPopupInfo('', $message[$n]).$messagesLine;
			$messagesLine.=showinfo('',$message[$n],'info');
			$n++;
		}
		$parse_main['{content}']=$messagesLine.$parse_main['{content}'];
	}
	
        $main = parse_template ($main, $parse_main);
        $main = parse_template ($main, $parse_plugins);
        //$main = preg_replace("#{banner_.*?}#u", "", $main);//костыль против тегов неопубликованных баннеров
	echo $main;
?>
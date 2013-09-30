<?
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('a1cms', 'energy', true);

$WHEREI['admincenter']=true;
include_once '../sys/engine.php';
include_once '../sys/mysql.php';
include_once '../sys/functions.php';
include_once '../sys/init_plugins.php';

if(!isset($_SESSION['user_id']) or empty($_SESSION['user_id']))
{
	 $parse_admin['{module}'] = get_template('login',1);
	 $parse_admin['{menu}'] = $parse_admin['{enter_info}'] = '';
}
else //есть юзерайди и доступ в админку разрешен
	include 'menu.php';

// 	if(isset($_GET['plugin']))
// 	{
// 		$pluginname = preg_replace("#[^A-z0-9_-]#u", '', $_GET['plugin']);
// 		if($pluginname)
// 		{
// 			if($_SESSION['user_group']
// 			and $plugin_list[$pluginname]['state']==1
// 			and ( in_array($_SESSION['user_name'], $plugin_list[$pluginname]['allowed_users']) or in_array($_SESSION['user_group'], $plugin_list[$pluginname]['allowed_groups']) )
// 			)
// 				include_once root.'/plugins/'.$pluginname.'/index.php';
// 			else
// 				$parse_admin['{module}'] = "Доступ запрещен!";
// 		}
// 	}

	if($_SESSION['user_name']) //если залогинен
	{
		$logged_in_tpl=get_template('logged_in',1);
		$enter_info=parse_template($logged_in_tpl, array('{user_name}'=>$_SESSION['user_name'],'{group_name}'=>$_SESSION['group_name'],));
	}

	$parse_admin['{title}']=$title;
	$parse_admin['{AJAX}']="<script>
	var THEME='".$engine_config['template_path_http']."';
	var site_path='".$engine_config['site_path']."';
	var ADMIN_THEME='".$engine_config['admin_template_path_http']."';
	var IN_ADMIN=1;
	</script>";
	//$parse_admin['{module}']=$module;

	$parse_admin['{enter_info}']=$enter_info;
	
	if($parse_admin['{meta-title}'])
		$parse_admin['{meta-title}'].=' &rsaquo; ';
	$parse_admin['{meta-title}'].='Админцентр';
	

	if($error)
		$parse_admin['{module}'] = showinfo (false, implode('<br />', $error), 'error', 1)
		.$parse_admin['{module}'];

	if (!$parse_admin['{module}'])
		$parse_admin['{module}']='Привет, '.$_SESSION['user_name'].'! Добро пожаловать в админпанель.';
		
	if($debug)
	{
		$debug[]= "Запросов: ".$QUERIES_COUNTER;
		$debug[]= "Запросы заняли: ".substr($QUERIES_TIME_COUNTER, 0,5);
		$parse_admin['{debug}']=implode("<br />",$debug);
	}

	$template = get_template('main',1);
	$result = parse_template($template,$parse_admin);// собственно парсим шаблон

	echo $result;
?>
<?php

if (!defined('a1cms'))
	die('Access denied to online!');
	
event_register('before_user_logout','event_before_user_logout');

function event_before_user_logout()
{
	@query ("DELETE FROM `{P}_online` WHERE `user_id`=i<user_id>", array('user_id'=>$_SESSION['user_id']));
}

if($WHEREI['main']==true)
{
	include_once 'config.php';

	if(!$_SESSION['user_id']) //залогиненым не нужны ip
	{
		//определяем ip //$ip=$_SERVER['REMOTE_ADDR'];
		//$online['md5ip']=md5(md5(getenv("HTTP_X_FORWARDED_FOR")));
		//if (empty($online['md5ip']) || $online['md5ip']=='unknown')
			//$online['md5ip']=md5(md5(getenv("REMOTE_ADDR")));
		$online['md5ip']=$FC['iplabel'];
	}
	else
		$online['md5ip']=$_SESSION['user_id'];

	//$useragent = $_SERVER['HTTP_USER_AGENT'];

	if(!$_SESSION['user_id'])
	{
	// FIXME: в конфиг
	$robots = array(
	'yandex' => "Yandex",
	/*'YandexBot' => "Yandex", //YandexGeneralBot
	'YandexMetrika' => "YandexMetrika",
	'YandexBlogs' => "YandexBlogs",
	'YandexBot/3.0; MirrorDetector' => "YandexMirrorDetector",
	'YandexImages' => "YandexImages",
	'YandexVideo' => "YandexVideo",
	'YandexMedia' => "YandexMedia",
	'YandexAddurl' => "YandexAddurl",
	'YandexFavicons' => "YandexFavicons",
	'YandexDirect' => "YandexDirect",
	'YandexDirect/2.0; Dyatel' => "YandexDirectDyatel",
	'YandexCatalog' => "YandexCatalog",
	'YandexNews' => "YandexNews",
	'YandexImageResizer' => "YandexImageResizer",*/
	'google' => "Google",//'googlebot' => "Google",
	//'google' => '<span style="color:blue;">G</span><span style="color:red;">o</span><span style="color:orange;">o</span><span style="color:blue;">g</span><span style="color:green;">l</span><span style="color:red;">e</span>',
	//'StackRambler' => "Rambler",
	'ask.com' => "Ask.com",
	'rambler' => "Rambler",
	'mail.ru' => "Mail.Ru",
	//'slurp' => "Slurp",//Inktomi Slurp
	'yahoo' => "Yahoo!",
	'msnbot' => "Bing",
	'aport' => "Aport",
	'scooter' => "Altavista",
	//'ia_archiver' => "Alexa (IA Archiver)",
	'alexa' => "Alexa",
	);
	foreach($robots as $key => $value)
	{
		if(strstr(strtolower($FC['useragent']), strtolower($key)))
			$robot = $value;
	}

	if($robot)
	{
		$name=$robot;
		$user_group=100;
	}
	}
	else
	{
		$name=$_SESSION['user_name'];
		$user_group=$_SESSION['user_group'];
	}

	// удаляем старые сессии
	//if(rand(0, 10)==0)
	query ("DELETE FROM `{P}_online` WHERE UNIX_TIMESTAMP() - time > 300") or $error[]= "Не получилось удалить старые сессии с онлайн";

	$onl_insert_query="INSERT INTO `{P}_online` (`ip`,`time`,`user_id`,`user_name`,`user_group`)
		VALUES (<ip>,UNIX_TIMESTAMP(),i<user_id>,<user_name>,i<user_group>)
		ON DUPLICATE KEY UPDATE `time`=UNIX_TIMESTAMP(), `user_name`=<user_name>, `user_group`=i<user_group>";
	$onl_insert_variables=array('ip'=>$online['md5ip'],
		'user_id'=>$_SESSION['user_id'],
		'user_name'=>$name,
		'user_group'=>$user_group);

	query($onl_insert_query, $onl_insert_variables);


	// считывание результатов
	$select = query ("SELECT * FROM `{P}_online` order by `user_group`,`user_name`");

	$robots_array = array();
	/*unset ($guests_quantity);
	unset ($authorized_quantity);
	unset ($users_quantity);
	unset ($site_command_quantity);
	unset ($robots_quantity);*/

	while($online_row = fetch_assoc($select))
	{
		//$online_quantity++;
		if(!$online_row['user_group'])//гость
		{
		$guests_quantity++;
		}
		elseif($online_row['user_group']==100)//робот
		{
		//раскрашиваем поисковики
		if(!$colored_robots_array)
		$colored_robots_array=array(
			"Google"=>'<span style="color:blue;">G</span><span style="color:red;">o</span><span style="color:orange;">o</span><span style="color:blue;">g</span><span style="color:green;">l</span><span style="color:red;">e</span>',
			"Yandex"=>'<span style="color:red;">Я</span><span style="color:black;">ндекс</span>',
			"Yahoo!"=>'<span style="color:purple;">Yahoo!</span>',
			"Bing"=>'<span style="color:#1E90FF;">bing</span>',
			);
		$robotname=strtr($online_row['user_name'], $colored_robots_array);

		if(!in_array($robotname, $robots_array))
		{
			$robots_quantity++;
			$robots_array[]=$robotname;
		}
		}
		elseif(!in_array($online_row['user_group'], array(4,5)))//команда сайта //4 - пользователь, 5 - гость
		{
		$authorized_quantity++;
		$site_command_quantity++;

		if($site_command_list)
			$site_command_list.=", ";

		$site_command_list .= "<a href='/".$LANG['user']."/".rawurlencode($online_row['user_name'])."/' class='nickcolor_".$online_row['user_group']."'>".$online_row['user_name']."</a>";
		}
		else//пользователь
		{
		$authorized_quantity++;
		$users_quantity++;

		if($userlist)
			$userlist.=", ";

		$userlist .= "<a href='/".$LANG['user']."/".rawurlencode($online_row['user_name'])."/' class='nickcolor_".$online_row['user_group']."'>".$online_row['user_name']."</a>";
		}
	}

	$parse['{guests}'] = (int) $guests_quantity;
	$parse['{authorized}'] = (int) $authorized_quantity;
	$parse['{users}'] = (int) $users_quantity;
	$parse['{site_command}'] = (int) $site_command_quantity;
	$parse['{robots}'] = (int) $robots_quantity;
	$parse['{all}'] = (int) $guests_quantity+$authorized_quantity+$robots_quantity; //$online_quantity;

	$parse['{site_command_list}'] = $site_command_list;
	$parse['{userlist}'] = $userlist;
	$parse['{robotslist}'] = implode(", ",$robots_array);

	$tpl=get_template('online');
	$online=parse_template($tpl, $parse);

	$parse_main['{plugin=online}'] =  $online;
}
?>
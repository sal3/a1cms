<?
if (!defined('a1cms'))
	die('Access denied to install.php!');

	if ($engine_config['is_installed']==1)
		die ('already installed');
	
// $template = get_template('install');
	
//install.php
	//добро пожаловать

	//проверить - есть ли подключение к базе
	//проверка прав на запись файла sys/config.php

	//проверять сложность пароля
	
	//выдаем "успех" и даем ссылку на страницу логина админки

 	
//  	$parse_main['{content}'] = parse_template($template, $parse_config);
 	$main = get_template('install', 1);

 	
 	
 	$file_directory = dirname("install.php");
 	$file="sys/config.php";
 	
 	if (is_writable($file_directory))
		echo 'root dir ok';
	elseif (!is_writable($file_directory))
		$error[]='root dir fial';
 	
 	
 	if (is_writable($file))
		echo 'sys/config.php ok';
	elseif (!is_writable($file))	
		$error[]='sys/config.php fial';
		
	

	
	
	$link = @mysqli_connect("host", "user", "pass", "dbname");
	
	if (@mysqli_ping($link))
		echo "Our connection is ok!";
	else
		$error[]="Ошибка подключения к БД: ".mysqli_connect_error();
	
	@mysqli_close($link);
 	
 
 
 $install_query1="CREATE TABLE IF NOT EXISTS `{P}_parameters` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) NOT NULL,
	`type` tinyint(1) NOT NULL,
	`technical` tinyint(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query1) or $error[] = "Ошибка инсталляции _parameters";
 

	//вливаем дампы таблиц
		//тестовые новость, тестовая категория
	//вносим в базу логин админа, хеш пароля, имейл
	//меняем опции в sys/config.php


//если были ошибки
	if($error)
	{
		$n=0;
		while($n<count($error))
		{
			//$errorsLine=ShowPopupInfo('Ошибка',$error[$n], "error").$errorsLine;
			if(isset($parse_main['{error}']))
				$parse_main['{error}'].=showinfo('',$error[$n],'error','');
			else
				$parse_main['{error}']=showinfo('',$error[$n],'error','');
			$n++;
		}
	}
	else
		$parse_main['{error}']='';

	if($message)
	{
		$n=0;
		while($n<count($message))
		{
			//$messagesLine=ShowPopupInfo('', $message[$n]).$messagesLine;
			$messagesLine.=showinfo('',$message[$n],'info');
			$n++;
		}
		$parse_main['{message}']=$messagesLine.$parse_main['{message}'];
	}
	else
		$parse_main['{message}']='';
	
	$main = parse_template ($main, $parse_main);
	//var_dump($parse_main);
	
	//$main = preg_replace("#{banner_.*?}#u", "", $main);//костыль против тегов неопубликованных баннеров
	echo $main;
	
?>
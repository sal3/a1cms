<?
if (!defined('a1cms'))
	die('Access denied to install.php!');

//index.php
//	проверка версии пхп, чтобы не ниже 5.3

//engine.php
	проверять - существует 
	if ($config['is_installed']==0)
		require_once 'install.php';
	elseif ($config['is_installed']==1)
		die ('already installed');

//install.php
	//добро пожаловать
	//инпуты: имя бд, пользователь бд, пароль к бд, префикс, хост
		//проверить - есть ли подключение к базе
	//проверка прав на запись файла sys/config.php
	//название сайта, имя админа, пароль дважды, имейл
		//проверять сложность пароля
	
	//вливаем дампы таблиц
		//тестовые новость, тестовая категория
	//вносим в базу логин админа, хеш пароля, имейл
	//меняем опции в sys/config.php
	//выдаем "успех" и даем ссылку на страницу логина админки

	
?>
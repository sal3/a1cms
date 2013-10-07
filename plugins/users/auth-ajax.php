<?php

define('root', substr(dirname( __FILE__ ), 0, -14));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';

include_once 'auth-function.php';
$result=array('title'=>0,'body'=>0,'result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

if($_POST['auth']=='login')
{
	if(fauthority($_POST['login'], $_POST['password']))
	{
		$result['result']=1;
		$result['resultmessage']='Авторизирован успешно';
	}
	else
	{
		$result['result']=0;
		$result['resultmessage']='Логин либо пароль неверны!';
	}
		
	
}
elseif($_POST['auth']=='exit')
{
	event('before_user_logout');
	session_unset();
	session_destroy();
	setcookie("sessid", "", time()-1, "/");
	setcookie("user_name", "", time()-1, "/");
	
	$result['result']=1;
	$result['resultmessage']='Разлогинен успешно';
}

echo json_encode($result);
?>
<?php

global $engine_config, $approve_code;

$users_plugin_options=array(
	'allow_add_users'=>array(1,2),
	'allow_edit_own_profile'=>array(1,2,3,4),
	'allow_edit_users'=>array(1,2),
	'allow_control_usergroups'=>array(1,2),
	'allow_configure_plugin'=>array(1,2),
	'allow_registration' => 0,
	'allow_recovery' => 1,
	'register_activate' => 'mail',
	'reserved_logins' => 
	array (
	0 => 'admin',
	1 => 'аdmin',
	2 => 'аdmіn',
	3 => 'admіn',
	4 => 'adмin',
	5 => 'administrator',
	6 => 'админ',
	7 => 'администратор',
	),
	'from'=>'webmaster@{http_host}',
	//'to'=>$_POST['email'],
	'register_subject'=>'Активация аккаунта на сайте {site_short_title}',
	'register_message'=>"Вы получили это письмо, т.к. указали этот email при регистрации на сайте {site_path} \r\n
		Для активации аккаунта перейдите по ссылке {site_path}/%D1%80%D0%B5%D0%B3%D0%B8%D1%81%D1%82%D1%80%D0%B0%D1%86%D0%B8%D1%8F?activationid={approve_code}&login={login} \r\n
		Если вы не регистрировали такой аккаунт - просто проигнорируйте данное письмо.",
	
	'recovery_subject'=>'Восстановление пароля на сайте {site_short_title}',
	'recovery_message'=>"Вы получили это письмо, было запрошено восстановление пароля нав сайте {site_path} \r\n
		Для восстановления пароля перейдите по ссылке {site_path}/%D0%B2%D0%BE%D1%81%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5-%D0%BF%D0%B0%D1%80%D0%BE%D0%BB%D1%8F?recoveryid={recoveryid} \r\n
		Если вы не запрашивали восстановление пароля - просто проигнорируйте данное письмо.",
	);
?>
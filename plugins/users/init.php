<?php
if (!defined('a1cms')) 
	die('Access denied to users init.php!');

if ($WHEREI['main']==true)
{
	event_register('plugin_init_by_uri','users_init');

	function users_init($_URI)
	{
		include_once 'auth-check.php';
		
		include_once 'options.php';
		include_once 'config.php';

		
		if($_URI['path_params'][1]=='регистрация')
		{
			include_once 'register.php';
				
			$parse_main['{meta-title}']="Регистрация";
			$parse_main['{meta-description}']="Регистрация нового пользователя";
			$parse_main['{meta-keywords}']="register, registration, регистрация";
		}
		elseif($_URI['path_params'][1]=='восстановление-пароля')
		{
			include_once 'pass_recovery.php';
				
			$parse_main['{meta-title}']="Восстановление пароля";
			$parse_main['{meta-description}']="Восстановление пароля";
			$parse_main['{meta-keywords}']="пароль, восстановление, recovery";
		}
	}
}
elseif ($WHEREI['admincenter']==true and $_GET['plugin']=='users' && ($_GET['undermod']=='own_profile' or $_GET['undermod']=='editusers'))
{
	include_once 'admin_users/editusers.php';
}
?>
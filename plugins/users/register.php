<?php
if (!defined('a1cms')) 
	die('Access denied!');

session_start();

global $parse_main, $error, $engine_config;

$template = get_template('registration');


if($users_plugin_options['allow_registration']==0)
{
	$error[] ="Регистрация отключена";
	$parse_main['{content}']=' ';
}
elseif($_SESSION['user_id'])
{
	$error[] ="Вы уже зарегистрированы на нашем сайте.";
	$parse_main['{content}']=' ';
}
elseif($_REQUEST['activationid'])
{

	if($_GET['activationid'] and $_GET['login'])
	{
		$login_query = "SELECT `approved`, `user_id`
				FROM `{P}_users`
				WHERE `user_name` = <user_name> and `approve_code`=<activationid>";

		$login_query_variables=array(
		"user_name"=>$_GET['login'],
		"activationid"=>$_GET['activationid']);
		
		$login_result = query($login_query, $login_query_variables);
		
		if(!$row = fetch_assoc($login_result))
		{
			$error[] = "Ошибка! Такой пользователь не найден.";
		}
		elseif($row['approved'])
		{
			$error[] = "Ошибка! Аккаунт уже активирован.";
		}
		else
		{
			$activate_query = "UPDATE `{P}_users`
					SET `approved`=1, `approve_code`=''
					WHERE `user_name` = <user_name> and `approve_code`=<activationid>";

			$activate_query_variables=array(
			"user_name"=>$_GET['login'],
			"activationid"=>$_GET['activationid']
			);
			
			$activate_result = query($activate_query, $activate_query_variables);
			
			if($activate_result)
			{
				$parse_main['{content}'] = showinfo("Активация прошла успешно.",  "Вы успешно зарегистрированы на нашем сайте. Можете войти под своим логином и паролем.");
				destroy_session_by_id($row['user_id']);
			}
			else
				$error[] = "Неизвестная ошибка активации пользователя.";
		}
	}
	else
	    $error[] = "Отсутствует код активации или логин.";
}
else
{
	if(count($_POST)>0)
	{

		$_POST['user_name'] = safe_text($_POST['user_name']);
		$_POST['realname'] = safe_text($_POST['realname']);
		$_POST['country'] = safe_text($_POST['country']);
		$_POST['city'] = safe_text($_POST['city']);
		$_POST['icq'] = safe_text($_POST['icq']);
		$_POST['info_about'] = safe_text($_POST['info_about']);
		$_POST['email'] = mb_strtolower(safe_text($_POST['email']), 'UTF-8');
		$_POST['key_code'] = safe_text($_POST['key_code']);

		//проверка заполнения формы
		if ($_POST['user_name'] == '')
			$error[]= "Ошибка! Поле \"Логин\" обязательно к заполнению!";
		else
		{
			$login_query = "SELECT `user_id`, `email`
					FROM `{P}_users`
					WHERE `user_name` = <user_name>";
			
			if($users_plugin_options['register_activate'])
				$login_query .= " and `approved`=1";
			
			$login_query_variables["user_name"]=$_POST['user_name'];
			$login_result = query($login_query, $login_query_variables);

			if(fetch_assoc($login_result))
				$error[]= "Ошибка! Пользователь с таким логином уже зарегистрирован на сайте! Выберите другой логин.";
		}
		
		if (in_array($_POST['user_name'],$users_plugin_options['reserved_logins']))
			$error[]="Запрещено региcтрировать такие логины!";

		if ($_POST['password1'] == '')
			$error[]="Поле \"Пароль\" обязательно к заполнению!";

		if ($_POST['password2'] == '')
			$error[]= "Поле \"Повторите пароль\" обязательно к заполнению!";

		//проверка совпадения паролей
		if ($_POST['password1'] != $_POST['password2'])
			$error[]= "Введенные пароли не совпадают!";

		//проверка email
		if ($_POST['email'] == '')
			$error[]= "Поле \"E-Mail\" обязательно к заполнению!";
		elseif ($_POST['email'] and !preg_match("/^[a-z0-9_.-]+@[a-z0-9_.-]+\.[a-z]{2,6}$/u", $_POST['email']))
			$error[]= "Недопустимый E-Mail!";
		else
		{
			//проверяем email в базе
			$mail_query = "SELECT `user_id`
					FROM `{P}_users`
					WHERE `email` = <email>";
			if($users_plugin_options['register_activate'])
				$mail_query .= " and `approved`=1";
					
			$mail_query_variables["email"]=$_POST['email'];
			$mail_result = query($mail_query, $mail_query_variables);
			
			if($mail_result and fetch_assoc($mail_result))
				$error[]= "Ошибка! Пользователь с таким email уже зарегистрирован на сайте!.";
		}

		//проверка кода безопасности
		if(!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $_POST['key_code'])
			$error[]="Правильный код безопасности был: ".$_SESSION['captcha_keystring']."
			А вы ввели: ".$_POST['key_code'];
		unset($_SESSION['captcha_keystring']);

		if (count($_POST)>0 and !$error)
		{
			$pass = md5(md5($_POST['password1']));
			
			if($users_plugin_options['register_activate']=="mail")
			{
				$approve_code=random_string(32, 'lower,upper,numbers');
				$approved=0;
			}
			elseif($users_plugin_options['register_activate']=="hands")
				$approved=0;
			else
				$approved=1;

			$insertuser_query="INSERT INTO `{P}_users`
			(`user_name`, `password`, `email`, `realname`, `country`, `city`, `icq`, `info_about`, `registration_date`, `last_visit_date`, `user_group`, `approved`, `approve_code`)
			VALUES
			(<user_name>,'$pass',<email>,<realname>,<country>,<city>,<icq>,<info_about>,now(),now(),4, $approved, '$approve_code')";

			$insertuser_variables=array(
			'user_name'=>$_POST['user_name'],
			'email'=>$_POST['email'],
			'realname'=>$_POST['realname'],
			'country'=>$_POST['country'],
			'city'=>$_POST['city'],
			'icq'=>$_POST['icq'],
			'info_about'=>$_POST['info_about']
			);

			if (query($insertuser_query,$insertuser_variables))
			{
				if($users_plugin_options['register_activate']=="mail")
				{
			
					$mail_parse['{site_path}']=$engine_config['site_path'];
					$mail_parse['{approve_code}']=$approve_code;
					$mail_parse['{login}']=rawurlencode($_POST['user_name']);
					$mail_parse['{site_short_title}']=$engine_config['site_short_title'];
					$mail_parse['{http_host}']=$_SERVER['HTTP_HOST'];
					
					$from=parse_template($users_plugin_options['from'], $mail_parse);
					$subject=parse_template($users_plugin_options['subject'], $mail_parse);
					$message=parse_template($users_plugin_options['message'], $mail_parse);
				
					if(mailer($from, $_POST['email'], $subject, $message))
						$parse_main['{content}'] = showinfo("Регистрация прошла успешно.",  "Вы успешно зарегистрированы на нашем сайте. На указанный email отправлено письмо, в котором указаны действия для активации вашего аккаунта.");
				}
				elseif($users_plugin_options['register_activate']=="hands")
					$parse_main['{content}'] = showinfo("Регистрация прошла успешно.", "Вы успешно зарегистрированы на нашем сайте. Ваш аккаунт будет проверен модератором и активирован в ближайшее время.");
				
				else
					$parse_main['{content}'] = showinfo("Регистрация прошла успешно.","Вы успешно зарегистрированы на нашем сайте. Можете войти под своим логином и паролем.");
			}
			else $parse_main['{content}'] = showinfo("Ошибка.","Внимание, при добавлении пользователя возникла ошибка. Сообщите об этом администратору.");
		}
		else
		{
			$parse['{user_name}'] = $_POST['user_name'];
			$parse['{email}'] = $_POST['email'];
			$parse['{realname}'] = $_POST['realname'];
			$parse['{country}'] = $_POST['country'];
			$parse['{city}'] = $_POST['city'];
			$parse['{icq}'] = $_POST['icq'];
			$parse['{info_about}'] = $_POST['info_about'];
			$parse['{reg_code}'] = "<img src='{$engine_config['site_path']}/plugins/users/captcha.php?".session_name()."=".session_id()."'>";
		}

	}
	else 
	{
		$parse['{user_name}'] = $_POST['user_name'];
		$parse['{email}'] = $_POST['email'];
		$parse['{realname}'] = $_POST['realname'];
		$parse['{country}'] = $_POST['country'];
		$parse['{city}'] = $_POST['city'];
		$parse['{icq}'] = $_POST['icq'];
		$parse['{info_about}'] = $_POST['info_about'];

		$parse['{reg_code}'] = "<img src='{$engine_config['site_path']}/plugins/users/captcha.php?".session_name()."=".session_id()."'>";
	}
	
	if(!$parse_main['{content}'])
// 	if (!$error)
		$parse_main['{content}']=parse_template($template,$parse);
}
?>
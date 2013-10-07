<?php
if (!defined('a1cms')) 
	die('Access denied!');

session_start();

global $parse_main, $error, $engine_config;

if($users_plugin_options['allow_recovery']==0)
{
	$error[] ="Восстановление паролей отключено";
	$parse_main['{content}']=' ';
}
elseif($_REQUEST['recoveryid'])
{
//проверяем recoveryid
	$recoveryid_query = "SELECT `user_id`
			FROM `{P}_users`
			WHERE `approve_code` = <recoveryid>";
	
	$recoveryid_query_variables["recoveryid"]=$_GET['recoveryid'];
	
//если совпадает - показываем шаблон восстановления
	if (num_rows(query($recoveryid_query, $recoveryid_query_variables))==1)
	{
		if ($_POST['passwd1'])
		{
			//принимаем пароли, сравниваем
			if ($_POST['passwd1']==$_POST['passwd2'])
			{
			//обновляем пароли в базе и очищаем код
				$pass = md5(md5($_POST['passwd1']));
				
				$update_passwd_query = "UPDATE `{P}_users`
					SET 
					`password`=<password>,
					`approve_code`=''
					WHERE `approve_code` = <recoveryid>";

				$update_passwd_query_variables=array
				(
				"recoveryid"=>$_GET['recoveryid'],
				"password"=>$pass
				);
				
				if (query($update_passwd_query, $update_passwd_query_variables))
					$parse_main['{content}']=showinfo("Восстановление пароля",  "Пароль успешно изменен");
				else
					$error[]="Ошибка обновления пароля";
				
			}
			else
			{
				$parse_main['{content}']=showinfo("Восстановление пароля",  "Введенные пароли не совпадают");
				$parse_main['{content}'].=parse_template($template,$recovery_parse);
			}
		}
		else
		{
			$template = get_template('recovery_passwd');
			
			$recovery_parse['{recoveryid}']=$_GET['recoveryid'];
			
			$parse_main['{content}']=parse_template($template,$recovery_parse);
		}
	}
	else
	{
		$error[]= "Недопустимый код";
		$parse_main['{content}']=' ';
	}
}
elseif($_POST['email'])
{

	//ищем имейл в базе
	if ($_POST['email'] and preg_match("/^[a-z0-9_.-]+@[a-z0-9_.-]+\.[a-z]{2,6}$/u", $_POST['email']))
	{
		//проверяем email в базе
		$mail_query = "SELECT `user_name`, `email`
				FROM `{P}_users`
				WHERE `email` = <email>";
		
		$mail_query_variables["email"]=$_POST['email'];
		$mail_result = query($mail_query, $mail_query_variables);
		$users_row=fetch_assoc($mail_result);
		//сетим recoveryid
		//if($mail_result and $users_row)
		if ($_POST['email']==$users_row['email'])
		{
			$recoveryid=random_string(32, 'lower,upper,numbers');
		
			$update_recoveryid_query = "UPDATE `{P}_users`
				SET `approve_code`=<recoveryid>
				WHERE `user_name` = <user_name>";

			$update_recoveryid_query_variables=array
			(
			"recoveryid"=>$recoveryid,
			"user_name"=>$users_row['user_name']
			);
			
			query($update_recoveryid_query, $update_recoveryid_query_variables);
		

		//отправляем письмо

			$mail_parse['{site_path}']=$engine_config['site_path'];
			$mail_parse['{recoveryid}']=$recoveryid;
			//$mail_parse['{login}']=$users_row['user_name'];
			$mail_parse['{site_short_title}']=$engine_config['site_short_title'];
			$mail_parse['{http_host}']=$_SERVER['HTTP_HOST'];

			$from=parse_template($users_plugin_options['from'], $mail_parse);
			$subject=parse_template($users_plugin_options['recovery_subject'], $mail_parse);
			$message=parse_template($users_plugin_options['recovery_message'], $mail_parse);

			//показываем "письмо отправено" ВСЕГДА
			if(mailer($from, $_POST['email'], $subject, $message))
				$parse_main['{content}'] = showinfo("Восстановление пароля",  "Письмо с кодом восстановления отправлено на указанный Вами e-mail");
		}
		else
		{
			//$error[] = "Неизвестная ошибка восстановления пароля.";
			$parse_main['{content}'] = showinfo("Восстановление пароля",  "1111 Письмо с кодом восстановления отправлено на указанный Вами e-mail");
		}
	}
	else
	{
		$error[]= "Недопустимый E-Mail!";
		$parse_main['{content}']=' ';
	}


}
else //отображение начальной страницы восстановления
{
	$template = get_template('recovery');
	
	
	if(!$parse_main['{content}'])
// 	if (!$error)
		$parse_main['{content}']=parse_template($template,$parse);

}





?>
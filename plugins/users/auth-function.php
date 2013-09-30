<?php
if (!defined('a1cms')) 
	die('Access denied to auth_function.php!');

function fauthority($login=false,$password=false, $sessid=false)
{
	global $FC;
	
	if($login and $password)
		$where = "`user_name`=<user_name> AND `password`=<password>";
	elseif($login and $sessid)
	{
		$pquery = "SELECT `{P}_users`.`password`
		FROM `{P}_users`
		WHERE `user_name`=<user_name>
		LIMIT 1";

		$pvars=array(
		'user_name'=>$login,
		);
		
		$prow = single_query($pquery,$pvars);
		
		$check_key=md5(md5($FC['ip'].$login.$prow['password']));
		
		if($check_key==$sessid)
		{
			$where = "`user_name`=<user_name>";
		}
		else
		{
			setcookie("sessid", "", time()-1, "/");
			setcookie("user_name", "", time()-1, "/");
		}
	}

	if($where)
	{
		// делаем запрос к БД и ищем юзера с таким логином и паролем
		$query = "SELECT `{P}_groups`.*,  `{P}_users`.`user_name`, `approved`, 
		`{P}_users`.`user_group`, `{P}_users`.`user_id`, `{P}_users`.`news_quantity`
		FROM `{P}_users`
		LEFT JOIN `{P}_groups` on (`{P}_users`.`user_group` = `{P}_groups`.`id`)
		WHERE $where
		LIMIT 1";

		$vars=array(
		'user_name'=>$login,
		'password'=>md5(md5($password)),
		'sessid'=>$sessid
		);
		
		$row = single_query($query,$vars);

		if(is_array($row))
		{
			foreach($row as $key=>$val)
			{
				$_SESSION[$key]=$val;
			}
			
			$key=md5(md5($FC['ip'].$_SESSION['user_name'].md5(md5($password))));
			
			//устанавливаем куки на месяц
			setcookie("sessid", $key, time()+2592000, "/", "", false, true);
			setcookie("user_name", $_SESSION['user_name'], time()+2592000, "/", "", false, true);
			
			return true;
		}
		else
			return false;
	}
	else
		return false;	
}
?>
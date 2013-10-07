<?

if (!defined('a1cms'))
	die('Access denied!');

if($_GET['username'] or $_GET['undermod']=='own_profile')
{
	if($_GET['undermod']=='own_profile')
		$login=$_SESSION['user_name'];
	else
		$login = safe_text(urldecode($_GET['username']));
		
		

	$_POST['email'] = safe_text($_POST['email']);
	$_POST['realname'] = safe_text($_POST['realname']);
	$_POST['country'] = safe_text($_POST['country']);
	$_POST['city'] = safe_text($_POST['city']);
	$_POST['icq'] = safe_text($_POST['icq']);
	$_POST['info'] = safe_text($_POST['info']);

	$_POST['newlogin'] = safe_text($_POST['newlogin']);
	$_POST['bandescr'] = safe_text($_POST['bandescr']);
	$_POST['ipbandescr'] = safe_text($_POST['ipbandescr']);
	$_POST['banpostdescr'] = safe_text($_POST['banpostdescr']);
	$_POST['bancommentsdescr'] = safe_text($_POST['bancommentsdescr']);

	$variables=array(
		'login'=>$login,
		'email'=>$_POST['email'],
		'realname'=>$_POST['realname'],
		'country'=>$_POST['country'],
		'city'=>$_POST['city'],
		'icq'=>$_POST['icq'],
		'signature'=>function_bbcode_to_html($_POST['signature']),
		'newlogin'=>$_POST['newlogin'],
		'bandescr'=>$_POST['bandescr'],
		'info_about'=>htmlspecialchars($_POST['info']),
		'session_name'=>$_SESSION['user_name'],
		'ipbandescr' => $_POST['ipbandescr'],
		'banpostdescr' => $_POST['banpostdescr'],
		'bancommentsdescr' => $_POST['bancommentsdescr'],
		'user_id'=>$_POST['user_id'],
		'approved'=>$_POST['approved'],
		'bandays'=>$_POST['bandays'],
		'ipbandays'=>$_POST['ipbandays'],
		'banpostdays'=>$_POST['banpostdays'],
		'bancommentsdays'=>$_POST['bancommentsdays'],
		'new_status'=>$_POST['status'],



	);

	if($_POST['delete_user'] and ($_SESSION['user_group']==1 or $_SESSION['user_group']==2))//FIXME!!! нормальные права
	{
		query("DELETE FROM `{P}_users` WHERE `user_name` = <login>", $variables);
		$parse_admin['{module}'] .= "Пользователь '$login' удален <br />";
// 		logger($_SESSION['user_name']." удалил пользователя $login" );
	}


	// Вносим изменения
        if($_POST['save'] and ($_SESSION['user_group']==1 or $_SESSION['user_group']==2))//FIXME!!! нормальные права
	{
		$user_id = intval($_POST['user_id']); //используется для destroy_session_by_id($user_id);

		// бан
		if($_POST['ban'] and !$_POST['oldban'])
		{
			if($_POST['bandescr'])
			{
				$ban_query="INSERT INTO `{P}_ban` (`users_id`, `description`, `date`, `days`, `type`, `author`)
					VALUES(i<user_id>, <bandescr>, unix_timestamp(), i<bandays>, 3, <session_name>)";

				query($ban_query, $variables);
// 				logger($_SESSION['user_name']." забанил пользователя $login" );
			}
			else  $error[]="Нельзя беспричинно банить людей. Введите причину.";

		}
		// снимаем бан
		elseif($_POST['oldban'] and !$_POST['ban'])
		{
			query("DELETE FROM `{P}_ban` WHERE `users_id`=i<user_id> AND `type`=3", $variables)
				or $error[]='Ошибка снятия бана';

// 				logger($_SESSION['user_name']." разбанил пользователя $login" );
		}

		// ipбан
		if($_POST['ipban'] and !$_POST['oldipban'])
		{
			if($_POST['ipbandescr'])
			{
					$ipban_query="INSERT INTO `{P}_ban` (`users_id`, `ip`, `description`, `date`, `days`, `type`, `author`)
					VALUES(i<user_id>, '1', <ipbandescr>, unix_timestamp(), i<ipbandays>, 4, <session_name>)";

				query($ipban_query, $variables);
// 				logger($_SESSION['user_name']." забанил по IP пользователя $login" );
			}
			else  $error[]="Нельзя беспричинно банить IP людей. Введите причину.";

			//очищаем кеш ipban-а
			if($engine_config['cache_enable']=='1')
				@unlink($engine_config['cache_dir'].'/ipban_array.tmp');
		}
		// снимаем бан
		elseif($_POST['oldipban'] and !$_POST['ipban'])
		{
			query("DELETE FROM `{P}_ban` WHERE `users_id`=i<user_id> AND `type`=4", $variables);

			//очищаем кеш ipban-а
			if($engine_config['cache_enable']=='1')
				@unlink($engine_config['cache_dir'].'/ipban_array.tmp');
// 			logger($_SESSION['user_name']." разбанил IP пользователя $login" );
		}

		//запрет постов
		if($_POST['banpost'] and !$_POST['oldbanbanpost'])
		{
			if($_POST['banpostdescr'])
			{
					$deny_post_query="INSERT INTO `{P}_ban` (`users_id`, `description`, `date`, `days`, `type`, `author`)
					VALUES(i<user_id>, <banpostdescr>, unix_timestamp(), i<banpostdays>, 2, <session_name>)";
				query($deny_post_query, $variables);
// 				logger($_SESSION['user_name']." запретил постить пользователю $login" );
			}
			else  $error[]="Нельзя беспричинно запрещать постить людям. Введите причину.";

		}
		// снимаем бан постов
		elseif($_POST['oldbanbanpost'] and !$_POST['banpost'])
		{
			query("DELETE FROM `{P}_ban` WHERE `users_id`=i<user_id> AND `type`=2", $variables);

// 			logger($_SESSION['user_name']." снял запрет постить пользователю $login" );
		}

		//запрет каментов
		if($_POST['bancomments'] and !$_POST['oldbancomments'])
		{
			if($_POST['bancommentsdescr'])
			{
				$ban_comment_query="INSERT INTO `{P}_ban` (`users_id`, `description`, `date`, `days`, `type`, `author`)
					VALUES(i<user_id>, <bancommentsdescr>, unix_timestamp(), i<bancommentsdays>, 1, <session_name>)";
				query($ban_comment_query, $variables) or $error[]='Ошибка установки бана';
// 				logger($_SESSION['user_name']." запретил каментить пользователю $login" );
			}
			else  $error[]="Нельзя беспричинно запрещать каментить людям. Введите причину.";
		}
		// снимаем бан каментов
		elseif($_POST['oldbancomments'] and !$_POST['bancomments'])
		{
			query("DELETE FROM `{P}_ban` WHERE `users_id`=i<user_id> AND `type`=1", $variables)
				or $error[]='Ошибка снятия запрета каментов';
// 				logger($_SESSION['user_name']." снял запрет каментить пользователю $login" );
		}

		// заливка аватара
		if($_FILES['image']['name']!='')
		{
			$new_avatar_extension=getExtension($_FILES['image']['name']);
			if(!in_array (strtolower($new_avatar_extension),  $engine_config['alloved_avatar_ext']))
				$error[]= 'Ошибка! Разрешена заливка аватаров только с расширениями: '.  implode(', ', $engine_config['alloved_avatar_ext']);
			else
			{
				$info = getimagesize ($_FILES['image']['tmp_name']);
				if($info[0]>$engine_config['alloved_avatar_maxwidth'])
					$error[]= 'Превышена максимальная ширина аватара: '.$engine_config['alloved_avatar_maxwidth'].'px';
				elseif($info[1]>$engine_config['alloved_avatar_maxheight'])
					$error[]= 'Превышена максимальная высота аватара: '.$engine_config['alloved_avatar_maxheight'].'px';
				elseif(filesize($_FILES['image']['tmp_name'])>$engine_config['alloved_avatar_maxsize']*1024)
					$error[]= 'Превышен максимальный размер аватара. Допустимый размер до: '.$engine_config['alloved_avatar_maxsize'].'КБ';
				else
				{
					//генерируем имя аве
					$uploadfile = $engine_config['avatar_dir'].random_string(15, 'lower,upper,numbers').".".$new_avatar_extension;
					while (file_exists($uploadfile))
						$uploadfile = $engine_config['avatar_dir'].random_string(15, 'lower,upper,numbers').".".$new_avatar_extension;

					//перемещаем аватар на место
					if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
					{
						$error[]= "Ошибка! Возникла неизвестная ошибка при загрузке изображения. Сообщите об этом администратору.";
					}
					else
					{
						$new_avatar_name = basename($uploadfile);
						$alt_change_string.=", avatar='$new_avatar_name' ";
					}
				}
			}
		}

		// удаляем аву
		if($_POST['del_avatar'] or $new_avatar_name)
		{
			$avatar_query = "SELECT `avatar`
				FROM `{P}_users`
				WHERE `user_name`=<login>
				LIMIT 1
				";
			$avatar_result=query($avatar_query, $variables);
			$avatar_row = fetch_assoc($avatar_result);

			if(!empty($avatar_row['avatar']))
			{
				$avatar = $engine_config['avatar_dir'].$avatar_row['avatar'];
				unlink($avatar);
				if(!$new_avatar_name)//если нет нового аватара - затираем старый адрес
				$alt_change_string.=", `avatar`='' ";
			}
		}
		//смена статуса
		if($_POST['status'] and !$error)
		{
			$alt_change_string.=", `user_group`=i<new_status> ";
// 			logger($_SESSION['user_name']." сменил статус пользователя $login" );
		}

		// смена пароля
		if($_POST['password1'] and !$error)
		{
			$new_password=md5(md5($_POST['password1']));
			$alt_change_string.=", `password`='{$new_password}' ";
// 			logger($_SESSION['user_name']." сменил пароль пользователю $login" );
		}

		// смена логина
		if($_POST['newlogin']  and !$error)
		{
			$alt_change_string.=", `user_name`=<newlogin> ";

			//проверяем занятость нового логина
			$search_query = "SELECT user_id quantity
			FROM `{P}_users`
			WHERE `user_name`=<newlogin>
			LIMIT 1";

			$sql = query($search_query, $variables) or $error[]= "Ошибка проверки занятости нового логина";

			// если такой пользователь нашелся
			if (num_rows($sql) == 0 )
			{
				// меняем автора постов
				$post_author_update_query="UPDATE `{P}_news` SET `user_name`=<newlogin> WHERE `user_name`=<login>";
				query($post_author_update_query, $variables) or $error[]= "Ошибка смены автора постов";

				//меняем автора каментов
				$comment_author_update_query="UPDATE `{P}_comments` SET `user_name`=<newlogin> WHERE `user_name`=<login>";
				query($comment_author_update_query, $variables) or $error[]= "Ошибка смены автора каментов";

// 				logger($_SESSION['user_name']." сменил ник пользователя $login на ".$_POST['newlogin']);
			}
			else
				$error[]="Такой логин уже занят";
		}

		if(!$error)
		{
			$update_query = "UPDATE `{P}_users`
			SET `realname`=<realname>, `country`=<country>, `city`=<city>, `icq`=<icq>,
				`info_about`=<info_about>, `signature`=<signature>, `email`=<email>, `approved`=i<approved>
				{$alt_change_string}
			WHERE `user_name`=<login>
			limit 1
			";
			$result=query($update_query, $variables);
			destroy_session_by_id($user_id);

			if(!$error and $result)
			{
				$parse['{errors}']="<center><font color='green'><b>Информация успешно изменена</b></font></center>";
// 				logger($_SESSION['user_name']." отредактировал профиль пользователя $login");
			}
		}
		else
		$parse['{errors}']="<center><font color='red'>".implode("</font><br /><font color='red'>",$error)."</font></center>";
	}


	$query = "SELECT `user_id`, `user_name`, `news_quantity`, `comments_quantity`, `last_visit_date`, `registration_date`, `signature`, `avatar`, `realname`, `country`, `city`, `icq`,
	group_name status, `info_about`, `email`, `user_group`, `approved`
	FROM `{P}_users`
	LEFT JOIN `{P}_groups` on (`{P}_users`.`user_group` = `{P}_groups`.`id`)
	WHERE `user_name`=<login>
	limit 1
	";
	$result=query($query, $variables);
	$row = fetch_assoc($result);

	if(isset($row['user_name']))
	{

		//проверяем на баны
// 		$restrict_query = "SELECT * FROM {P}_ban
// 			WHERE users_id={$row['user_id']}";
// 		$restrict_sql = query($restrict_query);
// 		while($restrict_row = fetch_assoc($restrict_sql))
// 		{
// 			$restricted[$restrict_row['type']]['descr']=$restrict_row['descr'];
// 			$restricted[$restrict_row['type']]['date']=$restrict_row['date'];
// 			$restricted[$restrict_row['type']]['days']=$restrict_row['days'];
// 			$restricted[$restrict_row['type']]['id']=$restrict_row['id'];
// 			$restricted[$restrict_row['type']]['author']=$restrict_row['author'];
// 		}
// 		if($restricted['1'])
// 		{
// 			$parse['{bancomments}'] = 'checked';
// 			$parse['{bancommentsdate}'] = "выдан: ".relative_date($restricted['1']['date']);
// 			$parse['{bancommentsdescr}'] = $restricted['1']['descr'];
// 			$parse['{bancommentsdays}'] = $restricted['1']['days'];
// 			$parse['{bancommentsauthor}'] = $restricted['1']['author'];
// 		}
// 		else
// 		{
// 			$parse['{bancomments}'] = '';
// 			$parse['{bancommentsdate}'] = '';
// 			$parse['{bancommentsdescr}'] = '';
// 			$parse['{bancommentsdays}'] = '';
// 			$parse['{bancommentsauthor}'] = '';
// 
// 		}
// 		if($restricted['2'])
// 		{
// 			$parse['{banpost}'] = 'checked';
// 			$parse['{banpostdate}'] = "выдан: ".relative_date($restricted['2']['date']);
// 			$parse['{banpostdescr}'] = $restricted['2']['descr'];
// 			$parse['{banpostdays}'] = $restricted['2']['days'];
// 			$parse['{banpostauthor}'] = $restricted['2']['author'];
// 		}
// 		else
// 		{
// 			$parse['{banpost}'] = '';
// 			$parse['{banpostdate}'] = '';
// 			$parse['{banpostdescr}'] = '';
// 			$parse['{banpostdays}'] = '';
// 			$parse['{banpostauthor}'] = '';
// 		}
// 		if($restricted['3'])
// 		{
// 			$parse['{ban}'] = 'checked';
// 			$parse['{bandate}'] = "выдан: ".relative_date($restricted['3']['date']);
// 			$parse['{bandescr}'] = $restricted['3']['descr'];
// 			$parse['{bandays}'] = $restricted['3']['days'];
// 			$parse['{banauthor}'] = $restricted['3']['author'];
// 
// 		}
// 		else
// 		{
// 			$parse['{ban}'] = '';
// 			$parse['{bandate}'] = '';
// 			$parse['{bandescr}'] = '';
// 			$parse['{bandays}'] = '';
// 			$parse['{banauthor}'] = '';
// 		}
// 		if($restricted['4'])
// 		{
// 			$parse['{ipban}'] = 'checked';
// 			$parse['{ipbandate}'] = "выдан: ".relative_date($restricted['4']['date']);
// 			$parse['{ipbandescr}'] = $restricted['4']['descr'];
// 			$parse['{ipbandays}'] = $restricted['4']['days'];
// 			$parse['{ipbanauthor}'] = $restricted['4']['author'];
// 
// 		}
// 		else
// 		{
// 			$parse['{ipban}'] = '';
// 			$parse['{ipbandate}'] = '';
// 			$parse['{ipbandescr}'] = '';
// 			$parse['{ipbandays}'] = '';
// 			$parse['{ipbanauthor}'] = '';
// 		}

		//проверяем статус
		$groups_query = "SELECT id, group_name from {P}_groups";
		$groups_sql = query($groups_query);
		while($groups_row = fetch_assoc($groups_sql))
		{
			unset($selected);
			if($row['user_group']==$groups_row['id'])
			$selected = "selected";
			$status_list.="<option value='{$groups_row['id']}' $selected>{$groups_row['group_name']}</option>";
		}
		$parse['{status_list}']=$status_list;

		$parse['{user_id}']=$row['user_id'];

		if(!empty($row['avatar']))
			$avatar = $engine_config['http_avatar_path'].$row['avatar'];
		else
			$avatar = $engine_config['default_avatar_path'];

		if(!$parse['{errors}'])
			$parse['{errors}']="";
		$parse['{usertitle}']=$login;
		$parse['{avatar}']=$avatar;
		$parse['{realname}']=$row['realname'];
		$parse['{status}']=$row['status'];
		$parse['{registration_date}']=relative_date($row['registration_date']);
		$parse['{last_visit_date}']=relative_date($row['last_visit_date']);
		$parse['{country}']=$row['country'];
		$parse['{city}']=$row['city'];
		$parse['{icq}']=$row['icq'];
		$parse['{news_quantity}']=$row['news_quantity'];
		$parse['{info_about}']=$row['info_about'];

		if($row['approved'])
		$parse['{approved}']="checked";
		else
		$parse['{approved}']='';

		if($row['news_quantity'])
		{
			// FIXME: в шаблон!!!!!!!!!!
			$parse['{releases}']="<div class='title_spoiler'>Динамика новостей</div>
			<div class='text_spoiler' id='dynamics'>
				<table class='noname' id='news_history'>
				<tr class='title'><td>месяц</td><td>общее количество</td></tr>
				".$releases."
				<tr class='title'><td>итого</td><td>$releases_sum</td></tr>
				</table>
			</div>";

			$parse['{news}']="<a href=".$engine_config['site_path']."/пользователь/$login/новости/>Посмотрeть новости пользователя</a>";
		}
		else
		{
			$parse['{releases}']="";
			$parse['{news}']="";
		}

		$parse['{comments_quantity}']=$row['comments_quantity'];

			$parse['{editsignature}']=$row['signature'];
			$parse['{editinfo}']=$row['info_about'];
// 			$parse['{xfields}']='';
// 			$parse['{hidemail}']='';
// 			if($row['comments_quantity'])
// 				$parse['{comments}']="<a href=".$engine_config['site_path']."/пользователь/$login/комментарии/>Посмотрeть комментарии пользователя</a>";
// 			else
// 				$parse['{comments}']="";


// 		$parse['{email}']="<a href=''>Отправить E-Mail</a>";
// 		$parse['{pm}']="<a href=''>Отправить сообщение</a>";
		$parse['{editmail}']=$row['email'];
// 		$parse['{action}']=$engine_config['site_path']."/admin/index.php?plugin=users&undermod=editusers&username=".urlencode($login);
		$parse['{toolbar}']=edToolbar();


// 		$template = get_template('userinfo',1);
// 		$parse_main['{content}'] = parse_template($template,$parse);
// 
// 		$headers['title'] = $login." &rsaquo; ".$engine_config['site_title'];
		$tpl= get_template('user',1);
		$parse_admin['{module}'] .= parse_template($tpl, $parse);
	}
	else
	{
		$parse_admin['{module}'] .= 'Пользователь <b>'.$login.'</b> не найден';
	}
}
else
{
	//FIXME: сделать нормальный поиск!!!!!!!!!
$parse_admin['{module}'] .= "<form action='/admin/index.php' method='get'>
	<input type='hidden' name='plugin' value='users' />
	<input type='hidden' name='undermod' value='editusers' />
	Найти: <input type='text' name='username'  />
	<input type='submit' value='Искать' />
	</form>";
}

?>
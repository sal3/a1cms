<?

define('root', substr(dirname( __FILE__ ), 0, -14));

include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once root.'/sys/init_plugins.php';
$result=array('result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

$options_path=root.'/plugins/users/options.php';

include_once $options_path;

$_POST['user_id'] = intval($_POST['user_id']);
$_POST['email'] = safe_text($_POST['email']);
$_POST['realname'] = safe_text($_POST['realname']);
$_POST['country'] = safe_text($_POST['country']);
$_POST['city'] = safe_text($_POST['city']);
$_POST['icq'] = safe_text($_POST['icq']);
$_POST['info_about'] = safe_text($_POST['info_about']);
$_POST['newlogin'] = safe_text($_POST['newlogin']);
$_POST['approved'] = intval($_POST['approved']);
$_POST['status'] = intval($_POST['status']);


$variables=array(
		'login'=>$login,
		'email'=>$_POST['email'],
		'realname'=>$_POST['realname'],
		'country'=>$_POST['country'],
		'city'=>$_POST['city'],
		'icq'=>$_POST['icq'],
		'signature'=>function_bbcode_to_html($_POST['signature']),
		'newlogin'=>$_POST['newlogin'],
// 		'bandescr'=>$_POST['bandescr'],
		'info_about'=>htmlspecialchars($_POST['info_about']),
		'session_name'=>$_SESSION['user_name'],
// 		'ipbandescr' => $_POST['ipbandescr'],
// 		'banpostdescr' => $_POST['banpostdescr'],
// 		'bancommentsdescr' => $_POST['bancommentsdescr'],
		'user_id'=>$_POST['user_id'],
		'approved'=>$_POST['approved'],
// 		'bandays'=>$_POST['bandays'],
// 		'ipbandays'=>$_POST['ipbandays'],
// 		'banpostdays'=>$_POST['banpostdays'],
// 		'bancommentsdays'=>$_POST['bancommentsdays'],
		'new_status'=>$_POST['status'],
	);

//смена статуса
if($_POST['status'] and !$error)
{
	$alt_change_string.=", `user_group`=i<new_status> ";
}

// смена пароля
if($_POST['new_password'] and !$error)
{
	$new_password=md5(md5($_POST['new_password']));
	$alt_change_string.=", `password`='{$new_password}' ";
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
	WHERE `user_id`=<user_id>
	limit 1";
 	$result=query($update_query, $variables) or $error[]="Не удалось сохранить изменения в базу";
// 	destroy_session_by_id($userid);
// 	$error[]=$update_query;
}


// 	$error[]=implode('<br />',$_POST);

if($error)
	$result=array('result'=>0,'resultmessage'=>implode('<br />',$error));
else
	$result=array('result'=>1,'resultmessage'=>'Профиль успешно сохранен');

echo json_encode($result);
?>
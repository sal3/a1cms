<?
define('root', substr(dirname( __FILE__ ), 0, -13));
include_once root.'/ajax/ajax_init.php';

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';//для destroy_session_by_id и для очистки кеша
// include_once root.'/sys/categories.php';//  для очистки кеша
include_once root.'/sys/init_plugins.php';
// include_once root.'/sys/related.php';
include_once 'options.php';



$id=intval($_GET['id']);
$action=($_GET['action']);

// if($_GET['redirto'])
// 	$redirto=intval($_GET['redirto']);

$result=array('title'=>0,'body'=>0,'result'=>0,'resultmessage'=>'Неизвестная ошибка');//. result: 0-error, 1-sucsess,

// if($_GET['dialog']==1)
// {
// 	$result['body']=related_posts('',$id,'deletedialog',15);
// 	$result['title']='Куда перенаправить посетителей?';
// 	$result['result']=1;
// }
// else //был elseif

if($action=='form' && isset($_GET['id']))
	$result = array('result' => "success", 'title'=>"Удаление новости", 'body'=>"Вы действительно хотите удалить эту новость?",'okbtn'=>"Удалить");
elseif($action=='del')
//if($id) // and isset($redirto)
{

event ('before_news_delete');

	$variables=array('del_newsid'=>$id,'redirto'=>$redirto);

	$allow_delete = false;

	//вытягиваем автора. Понадобится для проверки прав на удаление, если удаляющий не член администрации
	//и для уменьшения количества раздач в профиле автора, если удаляющий не автор
	//ну и для логгирования
	$user_query = "SELECT `user_name`, `title`, `date`, `id` FROM `{P}_news` WHERE `id` = i<del_newsid>";

	$user_row = fetch_assoc(query($user_query, $variables));
	
	
	//если разрешено все редактирование - разрешаем удаление
	if(in_array ($_SESSION['user_group'], $news_config['allow_edit_all_posts']))
		$allow_delete = true;
	//для журналистов и младше - проверяем имя автора, чтоб узнать, свою ли новость он хочет удалить
	elseif(in_array ($_SESSION['user_group'], $news_config['allow_edit_own_posts']) and $user_row['user_name']==$_SESSION['user_name'])
		$allow_delete = true;
	else
		$allow_delete = false;

	if($allow_delete==true)
	{
		//удаляем коментарии
		if ($plugin_list['comments']['state']==1)
		{
			$comments_query = "DELETE FROM `{P}_comments` WHERE `news_id` = i<del_newsid>";
			$result_comments = query($comments_query, $variables) or $error[] = "Ошибка удаления прикрепленных комментариев";
		}

		//удаляем кешированные просмотры
		if($news_config['cache_news_views'])
		query ("DELETE FROM `{P}_views` WHERE `news_id` = <del_newsid>", $variables);
		
		    //сброс кеша
			if($engine_config['cache_enable']=='1')
			{
				$c_query = "SELECT `id`, `url_name`, `category_id`, `approved`
				FROM  `{P}_news`
				WHERE `{P}_news`.`id`=i<del_newsid>";
				
				$c_result = query($c_query, $variables) or $error[]= "Ошибка выборки для очистки кеша";
				$c_row = fetch_assoc($c_result);

				if($c_row['id'])
					del_cache($c_row['id'],  $c_row['category_id']);
			}
			//конец сброса кеша

		//удаляем новость
		$news_query = "DELETE FROM `{P}_news` WHERE `id` = i<del_newsid>";
		if(query($news_query, $variables))
			$result['result']=1;
		else
		{
			$result['result']=0;
			$error[] = "Ошибка удаления поста";
		}


// 		//назначаем редирект
// 		if(intval($redirto)>0)//если не 404
// 		{
// 			$redir_query = "INSERT INTO `{P}_redir` (`from`,`to`) values (i<del_newsid>,i<redirto>)";
//                 	query($redir_query, $variables) or $error[] = "Ошибка добавления редиректа в базу";
// 
// 			$redir_query2 = "update `{P}_redir` set `to`=i<redirto> where `to`=i<del_newsid>";
//                         query($redir_query2, $variables) or $error[] = "Ошибка обновления редиректов в базе";
// 		}



		//записываем в лог, обязательно перед destroy_session_by_id !! ))
// 		logger($_SESSION['name']." удалил раздачу '".$user_row['title']."' №".$user_row['id']." созданную ".$user_row['user_name']." ". relative_date($user_row['date']) );


		//уменьшаем количество раздач
		$quantity_query="UPDATE `{P}_users` SET `news_quantity`=`news_quantity`-1 WHERE `user_name`=<user_name>";
		$quantity_variables=array('user_name'=>$user_row['user_name']);
		query($quantity_query, $quantity_variables);
		
		destroy_session_by_id(0,$user_row['user_name']);//для подержания в сессии пользователя актуального количества раздач
		
		event ('after_news_delete', array('newsid'=>$id));

	}
	else
	{
		$result['result']=0;
		$result['title']="Ошибка";
		$result['resultmessage']="Доступ запрещен";
	}


	if($error)
	{
		$result['result']=0;
		$result['title']="Ошибка";
		$result['resultmessage']=implode("<br />", $error);
	}
	else
	{
		$result['result']=1;
		$result['title']="Готово";
		$result['resultmessage']="Удалено успешно";
	}
}

echo json_encode($result);
?>
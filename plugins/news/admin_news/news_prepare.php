<?
if (!defined('a1cms')) 
	die('Access denied!');

if(!in_array($_SESSION['user_group'], $news_config['allow_add_posts']))
	die("Access denied in news_prepare!");

	//проверка прав---------------------------
	if(!in_array ($_SESSION['user_group'], $news_config['allow_post_wout_moderation']))//если нет прав на модерацию
	{
		if(!$author_row['approved']) //и если новость не была опубликована
			$_POST['approved']=false;
	}

	if(!in_array ($_SESSION['user_group'], $news_config['allow_edit_all_posts']))
	{
		$_POST['user_name'] = $_SESSION['user_name'];// если нет прав на редактирование всего - не даем менять автора
		$_POST['allow_comments']='checked';
		$_POST['show_on_main']='checked';
	}

	//конец проверка прав--------------------
	//подготовка
	$_POST['title'] = safe_text($_POST['title']);
	$old_url_name = safe_text($_POST['url_name']);
	$_POST['poster'] = safe_text($_POST['poster']);
	$_POST['short_description'] = trim($_POST['short_description']);
	$_POST['full_description'] = trim($_POST['full_description']);
	$_POST['date'] = safe_text($_POST['date']);
	$_POST['user_name'] = safe_text($_POST['user_name']);
	$_POST['edit_reason'] = safe_text($_POST['edit_reason']);
	$editor= safe_text($_SESSION['user_name']);

	if($_POST['approved'])
		$approver=safe_text($_SESSION['user_name']);
	elseif($_POST['approver'])
		$approver=safe_text($_POST['approver']);

	//дата
	if($_POST['dateradiobutton'] == 'now' or !$_POST['date'])
	{
		$_POST['date'] = date('Y-m-d H:i:s');
		echo $_POST['date'];
	}

	//категории
	if(!$_POST['cat'])
		$error[]= 'Ошибка! Нужно выбрать хотя бы одну категорию для новости!';
	else
		$cats_id = implode(",", $_POST['cat']);

	//заголовок
	if(!$_POST['title'])
			$error[]= 'Ошибка! Поле "Название" обязательно к заполнению!';
	elseif(mb_strlen($_POST['title']) > $news_config['max_title_length'])
			$error[]= 'Ошибка! Название не может быть длиннее '.$news_config['max_title_length'].' символов!';
	elseif(mb_strlen($_POST['title']) < $news_config['min_title_length'])
			$error[]= 'Ошибка! Название не может быть короче '.$news_config['min_title_length'].' символов!';
	else
	{
		//гненерируем альтнейм
		if(!$_POST['url_name'] or $news_config['always_regenerate_meta']==1)
			//в транслит, в нижний регистр, а потом - вырезаем все символы, кроме букв и дефисов
			$url_name = mb_substr(make_url_name(mb_strtolower($_POST['title'],'UTF-8')),0,200); //function_cut_characters назвать make_url_name
	}
	//постер
	if($news_config['require_poster'])
	{
		if(!$_POST['poster'])
			$error[]= 'Ошибка! Поле "Постер" обязательно к заполнению!';

		elseif(!preg_match("/".$engine_config['http_photohost_name_regexp']."(.*?)(png|gif|jpg|jpeg)$/u",$_POST['poster']) and !$_REQUEST['newsid'])
			$error[]= 'Ошибка! Поле "Постер" заполнено неправильно! В поле постер нужно вписывать ссылку в формате "'.$engine_config['photohost_name'].'.../ваше_изображение.jpg (jpeg/png/gif)"';
	}
	//короткое описание
	if($_POST['short_description'])
		$short_description = $_POST['short_description'];
	else
		$short_description = '';


     //генерируем мета-описание
	if(!$_POST['meta_description'])
	{
		if($_POST['short_description'])
			$source_descr= $_POST['short_description'];
		else
			$source_descr= $_POST['full_description'];
			$meta_description = str_replace("\r\n", " ", mb_substr(strip_bbcode(safe_text($source_descr)), 0, 300));
	}
	else
		$meta_description = safe_text($_POST['meta_description']);

	//полное описание
	if(!$_POST['full_description'] and $news_config['min_full_text'])
 			$error[]= 'Ошибка! Поле "Полное описание" обязательно к заполнению!';
	
	if(mb_strlen($_POST['full_description']) < $news_config['min_full_text'])
			$error[]= 'Ошибка! Полное описание не может быть короче '.$news_config['min_full_text'].' символов!';
	else
	{
		$full_description = $_POST['full_description'];

		//мета-keywords
		$meta_keywords = keyword($_POST['full_description']." ".$_POST['title']." ".$_POST['title']." ".$_POST['title']." ".$_POST['title']." ".$_POST['title']." ".$_POST['title']);//заголовок столько раз - чтоб релевантней всего был

	}
	

	//вывод ошибок
	if($error)
	{
		$error[] = "Пожалуйста, ознакомьтесь с <a href=".$news_config['new_news_instruction_link'].">инструкцией по оформлению новостей</a>";

		//возвращаемся к форме
		$_GET['action'] = 'news_form'; //var_dump ($error);
	}
	//все нормально
	else
	{
		//обработка перед добавлением в базу
		if($_POST['allow_comments'] == 'checked')
			$allow_comments = 1;
		if($_POST['show_on_main'] == 'checked')
			$show_on_main = 1;
		if($_POST['approved'] == 'checked')
			$approved = 1;
		if($_POST['pinned'] == 'checked')
			$pinned = 1;
		if($_POST['on_moderation'] == 'checked')
				$on_moderation =1;
		else
				$on_moderation =0;

	$variables=array(
		'newsid'=>$_REQUEST['newsid'],
		'title'=>$_POST['title'],
		'user_name'=>$_POST['user_name'],
		'poster'=>$_POST['poster'],
		'date'=>$_POST['date'],
		'meta_description'=>$meta_description,
		'meta_keywords'=>$meta_keywords,
		'url_name'=>$url_name,
		'cats_id'=> $cats_id,
		'editor'=>$editor,
		'edit_reason'=>$_POST['edit_reason'],
		'short_description'=>$short_description,
		'full_description'=>$full_description,
		'approver'=>$approver,

		'old_user_name'=>$old_user_name
		);
	}

?>
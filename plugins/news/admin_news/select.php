<?
if (!defined('a1cms')) 
	die('Access denied!');
if(!in_array($_SESSION['user_group'], $news_config['allow_add_posts']))
	die("Access denied news_select!");

	$news_query = "SELECT `{P}_news`.`id`, `title`, `date`, `poster`, `category_id`, `{P}_news`.`date`, `short_text`, `full_text`, `user_name`,
	`allow_comments`, `show_on_main`, `approved`, `pinned`, `url_name`, `description`, `keywords`,
	`on_moderation`, `approver`, `editor`, `edit_reason`
	FROM `{P}_news`
	WHERE `{P}_news`.`id` =i<newsid>
	LIMIT 1
	";

	$news_result = query($news_query, array('newsid'=>$_GET['newsid'])) or print ("Ошибка выборки новости для редактирования");

	$row = fetch_assoc($news_result);

	$_POST['newsid'] = $_GET['newsid'];
	$_POST['cat'] = explode(",", $row['category_id']);
	$cats_id = $row['category_id'];
	
	$_POST['user_name'] = /*stripslashes(*/$row['user_name']/*)*/;
	$_POST['date'] = $row['date'];
	$_POST['title'] = /*stripslashes(*/$row['title']/*)*/;
	$_POST['poster'] = /*stripslashes(*/$row['poster']/*)*/;


	$short_description = /*stripslashes(*/$row['short_text']/*)*/;
	$short_description = trim($short_description);
	$full_description = /*stripslashes(*/$row['full_text']/*)*/;
	$full_description = trim($full_description);

	$_POST['url_name'] = /*stripslashes(*/$row['url_name']/*)*/;
	$_POST['meta_description'] = /*stripslashes(*/$row['description']/*)*/;
	$_POST['meta_keywords'] = /*stripslashes(*/$row['keywords']/*)*/;

	if($row['show_on_main'])
		$_POST['show_on_main'] = 'checked';
	if($row['allow_comments'])
		$_POST['allow_comments'] = 'checked';
	if($row['approved'])
		$_POST['approved'] = 'checked';
	if($row['pinned'])
		$_POST['pinned'] = 'checked';
	if($row['on_moderation'])
		$_POST['on_moderation'] = 'checked';
	else
		$_POST['on_moderation'] = '';

	$approver = $row['approver'];
	$_POST['editor'] = $row['editor'];
	$_POST['edit_reason'] = $row['edit_reason'];

	$_GET['action']='news_form';
?>

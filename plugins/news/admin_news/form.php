<?
if (!defined('a1cms'))
	die('Access denied to news form.php!');

// if(!in_array($_SESSION['user_group'], $plugin_list[$pluginname]['allowed_groups']))//Проверяем права. $pluginname -из  menu.php
// 	die("Access denied!");

	$template = get_template('news', 1);

	preg_match("/\[cat\s*subcatdelim=('|\")(.*?)('|\")\s*checked_selected=('|\")(.*?)('|\")+\s*\](.*?)\[\/cat\]/isu", $template, $cat_out);
// 	var_dump($cat_out);
// 	preg_match("/\[subcat\](.*?)\[\/subcat\]/isu", $template, $subcat_out);
// 	$news_parse[$subcat_out['0']]='';
	preg_match("/\[extra\](.*?)\[\/extra\]/isu", $template, $extra_out);
	preg_match("/\[approved\](.*?)\[\/approved\]/isu", $template, $approved_out);
// 	var_dump($cat_out[2]);
	$news_parse[$cat_out['0']]=CategoriesSelect($_POST['cat'], 0, $cat_out[2], '', false, $cat_out[7], $cat_out[5]);
	//$selectedid = 0, $parentid = 0, $subCatDelim = '&nbsp;', $result = '', $root_only = false, $tpl= false, $checked_selected='selected'

// 	foreach ($cat_array as $cat)//перебор категорий
// 	{
// 		foreach ($cat_array as $subcat)//перебираем дочерние категории
// 		{
// 			if($subcat['parent_url_name'] == $cat['url_name'])
// 			{
// 				//проверяем, не был ли выбран этот пункт в предыдущем редактировании.. на случай вывода ошибок
// 				if($_POST['cat'] and in_array($subcat['id'], $_POST['cat']))
// 					$parse_subcat['{attr}'] = 'checked selected';
// 				else
// 					$parse_subcat['{attr}'] = '';
// 
// 				$parse_subcat['{catid}']=$subcat['id'];
// 				$parse_subcat['{catname}'] = $subcat['name'];
// 
// 				$cat_child_liststring.=parse_template($subcat_out['1'], $parse_subcat);
// 			}
// 		}
// 
// 		if(!$cat['parent_url_name'])//значит это корневая категория
// 		{
// 			//проверяем, не был ли выбран этот пункт в предыдущем редактировании.. на случай редактирования или вывода ошибок
// 			if($_POST['cat'] and in_array($cat['id'], $_POST['cat']))
// 				$parse_cat['{attr}'] = 'checked selected';
// 			else
// 				$parse_cat['{attr}'] = '';
// 
// 				$parse_cat['{catid}']=$cat['id'];
// 				$parse_cat['{catname}'] = $cat['name'];
// 
//                         if($cat_child_liststring)
// 				{
// 					//$parse_cat['{attr}'] .= " disabled";
// 					$news_parse[$cat_out['0']] .= parse_template($cat_out['1'].$cat_child_liststring, $parse_cat);
// 				}
//                         else
//                             $news_parse[$cat_out['0']] .= parse_template($cat_out['1'], $parse_cat);
// 		}
//                 unset($cat_child_liststring);
// 	}
	//Конец списка категорий

	if (in_array ($_SESSION['user_group'], $news_config['allow_edit_all_posts'])) //если есть права на редактирование всего
	{
		    //дефолтные значения для новой новости
		if(!$error && $_GET['mod']!='editnews')
		{
			$parse_extra['{allow_comments}'] = 'checked';
			$news_parse['{show_on_main}']= "checked";

			$parse_extra['{pinned}'] = '';
		}
		else
		{
			$parse_extra['{allow_comments}'] = $_POST['allow_comments'];
			$news_parse['{show_on_main}']= $_POST['show_on_main'];
			$parse_extra['{pinned}'] = $_POST['pinned'];
		    }


		$news_parse[$extra_out['0']] = parse_template($extra_out['1'], $parse_extra);
	}
	else
		$news_parse[$extra_out['0']] = '';

	if (in_array ($_SESSION['user_group'], $news_config['allow_post_wout_moderation']))
	{
		if(!$error && $_GET['mod']!='editnews')
			$parse_approved['{approved}'] = 'checked';
		else
			$parse_approved['{approved}'] = $_POST['approved'];

		$news_parse[$approved_out['0']] = parse_template($approved_out['1'], $parse_approved);
	}
	else
		$news_parse[$approved_out['0']] = '';



	if(!isset($_POST['on_moderation']))
	    $news_parse['{on_moderation}']= "checked";
	else
	    $news_parse['{on_moderation}']= $_POST['on_moderation'];


	if(!$_POST['user_name'])
		$_POST['user_name'] = $_SESSION['user_name'];

	$toolbar=str_replace('{THEME}', $engine_config['template_path_http'], edToolbar(true));

	$news_parse['{action}'] ="index.php?plugin=news&mod=addnews&action=insert";
	$news_parse['{id}'] = intval($_POST['newsid']);
	$news_parse['{title}'] = $_POST['title'];
	$news_parse['{poster}'] = $_POST['poster'];
	$news_parse['{user_name}'] =$_POST['user_name'];
	$news_parse['{approver}'] = $approver;
	$news_parse['{editor}'] = $_POST['editor'];
	$news_parse['{edit_reason}'] = $_POST['edit_reason'];
	$news_parse['{date}'] = $_POST['date'];
	$news_parse['{toolbar}'] = $toolbar;
	$news_parse['{short_description}'] = $short_description;
	$news_parse['{full_description}'] = $full_description;
	$news_parse['{tags}'] = $_POST['tags'];
	$news_parse['{advanced_options}'] = $advanced_options;
	$news_parse[$subcat_out['0']] ='';

	event('before_newsform_parse');

	$parse_admin['{module}'] = parse_template($template, $news_parse);

?>
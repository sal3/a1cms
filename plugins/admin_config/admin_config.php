<?
if (!defined('a1cms'))
	die('Access denied to admin_config!');

if ($_GET['action']=="save")
{
	$editarr['site_title']=safe_text($_POST['site_title']);
	$editarr['site_short_title']=safe_text($_POST['site_short_title']);
	$editarr['site_description']=safe_text($_POST['site_description']);
	$editarr['site_keywords']=safe_text($_POST['site_keywords']);

	if (empty($_POST['charset']))
		$error[]="Опция \"Кодировка\" не может быть пустой!";
	else
		$editarr['charset']=safe_text($_POST['charset']);

	$editarr['subfolder']=safe_text($_POST['subfolder']);

	if (empty($_POST['template_name']))
		$error[]="Опция \"Имя шаблона сайта\" не может быть пустой!";
	else
		$editarr['template_name']=safe_text($_POST['template_name']);

	if (empty($_POST['admin_template_name']))
		$error[]="Опция \"Имя шаблона админки\" не может быть пустой!";
	else
		$editarr['admin_template_name']=safe_text($_POST['admin_template_name']);

	if ($_POST['cache_enable'])
		$editarr['cache_enable']=true;
	else
		$editarr['cache_enable']=false;

// 	if ($_POST['ipban_enable'])
// 		$editarr['ipban_enable']=true;
// 	else
// 		$editarr['ipban_enable']=false;

	if (empty($_POST['avatar_dir_config']))
		$error[]="Опция \"Каталог аватаров\" не может быть пустой!";
	elseif (strstr($_POST['avatar_dir_config'], '../'))
		$error[]="В строке присутствуют запрещенные символы!";
	else
		$editarr['avatar_dir_config']=safe_text($_POST['avatar_dir_config']);


	if (empty($_POST['images_dir_config']))
		$error[]="Опция \"Каталог загуженных изображений\" не может быть пустой!";
	elseif (strstr($_POST['images_dir_config'], '../'))
		$error[]="В строке присутствуют запрещенные символы!";
	else
		$editarr['images_dir_config']=safe_text($_POST['images_dir_config']);


	if (empty($_POST['cache_dir_config']))
		$error[]="Опция \"Каталог кэша\" не может быть пустой!";
	elseif (strstr($_POST['cache_dir_config'], '../'))
		$error[]="В строке присутствуют запрещенные символы!";
	else
		$editarr['cache_dir_config']=safe_text($_POST['cache_dir_config']);

// 	if (empty($_POST['news_on_page']))
// 		$error[]="Опция \"Новостей на странице\" не может быть пустой!";
// 	else
// 		$editarr['news_on_page']=intval($_POST['news_on_page']);

// 	if (empty($_POST['news_on_page_alt']))
// 		$error[]="Опция \"Новостей на странице списка новостей\" не может быть пустой!";
// 	else
// 		$editarr['news_on_page_alt']=intval($_POST['news_on_page_alt']);

// 	if (empty($_POST['pagelinks']))
// 		$error[]="Опция \"Количество отображаемых страниц в меню навигации\" не может быть пустой!";
// 	else
// 		$editarr['pagelinks']=intval($_POST['pagelinks']);

// 	if (empty($_POST['news_in_admin_on_page']))
// 		$error[]="Опция \"Новостей на страницу в админке\" не может быть пустой!";
// 	else
// 		$editarr['news_in_admin_on_page']=intval($_POST['news_in_admin_on_page']);
/*
	if ($_POST['redirect_to_rigth_news_path'])
		$editarr['redirect_to_rigth_news_path']=true;
	else
		$editarr['redirect_to_rigth_news_path']=false;*/

// 	$editarr['register_activate']=safe_text($_POST['register_activate']);

// 	$editarr['reserved_logins']=explode(",", safe_text($_POST['reserved_logins']));

// 	if (empty($_POST['min_title_length']))
// 		$error[]="Опция \"Минимальная длина названия новости\" не может быть пустой!";
// 	else
// 		$editarr['min_title_length']=intval($_POST['min_title_length']);

// 	if (empty($_POST['max_title_length']))
// 		$error[]="Опция \"Максимальная длина названия новости\" не может быть пустой!";
// 	else
// 		$editarr['max_title_length']=intval($_POST['max_title_length']);

// 	if (empty($_POST['max_poster_size']))
// 		$error[]="Опция \"Максимальный размер постера\" не может быть пустой!";
// 	else
// 		$editarr['max_poster_size']=intval($_POST['max_poster_size']);

// 	if ($_POST['common_poster'])
// 		$editarr['common_poster']=true;
// 	else
// 		$editarr['common_poster']=false;

// 	$editarr['min_full_text']=safe_text($_POST['min_full_text']);

	$editarr['new_news_instruction_link']=safe_text($_POST['new_news_instruction_link']);

	$editarr['http_photohost_name_regexp']=safe_text($_POST['http_photohost_name_regexp']);

	$editarr['photohost_name']=safe_text($_POST['photohost_name']);

// 	if ($_POST['always_regenerate_meta'])
// 		$editarr['always_regenerate_meta']=true;
// 	else
// 		$editarr['always_regenerate_meta']=false;

// 	if ($_POST['cache_news_views'])
// 		$editarr['cache_news_views']=true;
// 	else
// 		$editarr['cache_news_views']=false;

// 	if (empty($_POST['news_views_taskperiod']))
// 		$error[]="Опция \"Период обновления количества просмотров\" не может быть пустой!";
// 	else
// 		$editarr['news_views_taskperiod']=intval($_POST['news_views_taskperiod']);
/*
	if ($_POST['rss_enable'])
		$editarr['rss_enable']=true;
	else
		$editarr['rss_enable']=false;*/

// 	if ($_POST['site_short_title_to_rsstitle'])
// 		$editarr['site_short_title_to_rsstitle']=true;
// 	else
// 		$editarr['site_short_title_to_rsstitle']=false;

	$editarr['smiles']=explode(",", preg_replace ('#\s+#sui', '', safe_text($_POST['smiles'])));


	if (empty($_POST['default_avatar_path_config']))
		$error[]="Опция \"Аватар по умолчанию\" не может быть пустой!";
	elseif (strstr($_POST['default_avatar_path_config'], '../'))
		$error[]="В строке присутствуют запрещенные символы!";
	else
		$editarr['default_avatar_path_config']=safe_text($_POST['default_avatar_path_config']);

	if (empty($_POST['alloved_avatar_ext']))
		$error[]="Опция \"Доспустимые расширения аватаров\" не может быть пустой!";
	else
		$editarr['alloved_avatar_ext']=explode(",", preg_replace ('#\s+#sui', '', safe_text($_POST['alloved_avatar_ext'])));


	if (empty($_POST['alloved_avatar_maxwidth']))
		$error[]="Опция \"Максимальная ширина аватара:\" не может быть пустой!";
	else
		$editarr['alloved_avatar_maxwidth']=intval($_POST['alloved_avatar_maxwidth']);

	if (empty($_POST['alloved_avatar_maxheight']))
		$error[]="Опция \"Максимальная высота аватара:\" не может быть пустой!";
	else
		$editarr['alloved_avatar_maxheight']=intval($_POST['alloved_avatar_maxheight']);

	if (empty($_POST['alloved_avatar_maxsize']))
		$error[]="Опция \"Максимальный размер аватара:\" не может быть пустой!";
	else
		$editarr['alloved_avatar_maxsize']=intval($_POST['alloved_avatar_maxsize']);

// 	if ($_POST['alternative_view'])
// 		$editarr['alternative_view']=true;
// 	else
// 		$editarr['alternative_view']=false;


	if (!$error)
	{
		$file=file_get_contents (root.'/sys/config.php');
		$file=preg_replace('/\$engine_config\s*=\s*array\s*\((.*?)\)\s*;/siu', '$engine_config='.var_export($editarr, TRUE).';',$file);
		file_put_contents (root.'/sys/config.php', $file);
		$engine_config=array_merge($engine_config,$editarr);
	}


}

$template = get_template('adminconfig', 1);

  	foreach ($engine_config as $name => $value)
  	{
		if (!is_array($value) and is_bool($value)===false)
			$parse_config['{'.$name.'}']=$value;
		elseif (!is_array($value) and is_bool($value)===true)
		{
			$parse_config['{'.$name.'}']=1;
			if ($value)
				$parse_config["{".$name."_checked}"]='checked';
			elseif (!$value)
				$parse_config["{".$name."_checked}"]='';
		}
		elseif (is_array($value))
			$parse_config['{'.$name.'}']=implode(",", $value);

	}

$parse_admin['{module}'] = parse_template($template, $parse_config);
//echo $parse_admin['{module}'];






?>
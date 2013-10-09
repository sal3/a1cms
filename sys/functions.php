<?php
if (!defined('a1cms'))
	die('Access denied to functions.php!');

function get_template ($tpl_name,$admintemplate=0)
{
	global $engine_config, $error, $current_plugins;
	if($admintemplate)
		$tpl_path=$engine_config['admincenter_tpl_path'];
	else
		$tpl_path=$engine_config['template_path'];
	$template = @file_get_contents($tpl_path.'/'.$tpl_name.'.tpl')
		or $local_error ='Шаблон '.$tpl_name.' не найден по заданному пути '.$tpl_path;
	if(isset($local_error) and $local_error)
	{
		$error[]=$local_error;
		return false;
	}
	else
		return $template;
}

function if_plugin_enabled ($pluginname)
{

	global $error, $plugin_list;

	if(file_exists(root."/plugins/$pluginname/config.php"))
	{
		include_once root."/plugins/$pluginname/config.php";
		
		if ($plugin_list[$pluginname]['state']==1)
			return true;
		else
			return false;
	}
	else
		$debug[]="if_plugin_enabled: плагин $pluginname не найден";
}

function parse_template ($template_source,$data_array)
{
	global $error,$engine_config,$TEMPLATES_PARSE_TIME_COUNTER;
	$parse_start_time = microtime();
	
	if ($template_source)
	{
		preg_match_all('#\[if-plugin-([\w\d]+)\]#siu', $template_source, $out);
		
		foreach ($out[1] as $pluginname)
		{
			if (if_plugin_enabled($pluginname))
			{
				$p_array=array("[if-plugin-$pluginname]"=>'',"[/if-plugin-$pluginname]"=>'');
				$data_array=array_merge($data_array, $p_array);
				//var_dump($data_array);
			}
			else
				$template_source=preg_replace("#\[if-plugin-$pluginname\].*?\[/if-plugin-$pluginname\]#siu",'',$template_source);
		}

		
		if(is_array($data_array))
		{
			//$data_array['{site_path}']=$engine_config['template_path_http'];
			$data_array['{THEME}']=$engine_config['template_path_http'];
			$data_array['{ADMIN_THEME}']=$engine_config['admin_template_path_http'];
			$data_array['{year_now}']=date('Y');
			$data_array['{site_path}']=$engine_config['site_path'];

			$parse_execute_time = microtime() - $parse_start_time;
			$TEMPLATES_PARSE_TIME_COUNTER += $parse_execute_time;

			return str_replace(array_keys($data_array), array_values($data_array), $template_source);
		}
		elseif($template_source)
			return $template_source;
		else
			$error[] = "parse_template: Нет данных для парсинга";
	}
	else
		$error[] = "parse_template: Нет шаблона для парсинга";

}

// возвращает категории новости в виде ссылок
function make_cat_links($category_ids, $parent_only=false, $text_only=false)
{
	global $_CAT, $engine_config;
	if(!$_CAT)
		$_CAT=CategoriesGet();
	
	$cats=get_parent_cats($category_ids);

	$first=true;
	foreach ($cats as $cat_chain_arr)
	{
		$first_line=true;
		foreach ($cat_chain_arr as $cat_id)
		{
			if($text_only)
			{
				$cat_arr[]=$_CAT[$cat_id]['name'];
			}
			else
			{
				if($first_line)
					$class='root_category';
				else
					$class='child_category';

				$first_line=false;
				
				if(!$_CAT[$cat_id])
					$_CAT[$cat_id]['url_name']=$_CAT[$cat_id]['name']='deleted_cat';
				
				$url[]=rawurlencode($_CAT[$cat_id]['url_name']);
				$cat_arr[]='<a href="'.$engine_config['site_path'].'/'.implode('/',$url).'" class="'.$class.'">'.$_CAT[$cat_id]['name'].'</a>';
			}
		}
		
		$cats_line_arr[]=implode(' &gt; ',$cat_arr);
		unset($cat_arr,$cat_chain_arr,$url);
	}
	return implode(', ',$cats_line_arr);;
}

function make_cat_link($search_cat_id)
{
	global $_CAT;
	//$link='/';
	
	$chain=get_parent_cat_chain($search_cat_id);
	if(is_array($chain))
	{
		foreach ($chain as $cat_id)
			$link.=rawurlencode($_CAT[$cat_id]['url_name']).'/';
	}
	if(isset($link))
		$link.=rawurlencode($_CAT[$search_cat_id]['url_name']);
	else
		$link=rawurlencode($_CAT[$search_cat_id]['url_name']);
	
	return $link;
}

function make_news_link ($id, $url_name, $category_id)
{
	global $_CAT, $engine_config;
	
	if(!$_CAT)
		$_CAT=CategoriesGet();
	
	$category_arr = get_parent_cats($category_id);
	$url_name=rawurlencode($url_name);
	
	if($category_arr[0])
	{
		foreach ($category_arr[0] as $cat_id)
			$link[]=rawurlencode($_CAT[$cat_id]['url_name']);

		return '/'.implode('/',$link).'/'.$id.'-'.$url_name;
	}
	else
		return '/---/'.$id.'-'.$url_name;
}

// возвращает вложенный массив цепочек ID родительских категорий
function get_parent_cats($search)
{
	global $_CAT;
	
	if(!$_CAT)
		$_CAT=CategoriesGet();
		
	// разбираем на массив в зависимости от типа
	if(strpos($search,","))
		$search_cat_array = explode (",", $search);
	elseif(is_numeric($search))
		$search_cat_array[]=$search;
	elseif(is_array($search))
		$search_cat_array=$search;
	else
		return false;
	
	// в int
	foreach ($search_cat_array as $index => $value)
		$search_cat_array[$index] = (int)$value; 
	
	foreach ($search_cat_array as $search_cat_id)
	{
		$chain=get_parent_cat_chain($search_cat_id);
		$chain[]=$search_cat_id;
		$chain_arr[]=$chain;
		unset($chain);
	}
	
	// удаляем дубликаты :)
	foreach ($chain_arr as $key=>$chain)
	{
		foreach ($chain_arr as $key2=>$chain2)
		{
			if($key!=$key2 and array_intersect($chain,$chain2))
			{
				if(count($chain)>count($chain2))
					unset($chain_arr[$key2]);
				else
					unset($chain_arr[$key]);
			}
		}
	}
	return array_values($chain_arr); //сбрасываем индексы и возвращаем
}

// возвращает массив-цепочку ID родительских категорий
function get_parent_cat_chain($search_cat_id)//FIXME переименовать в get_parent_cat_chain_ids
{
	global $_CAT;
	
	if(!$_CAT)
		$_CAT=CategoriesGet();
	
	// если у категории есть родитель
	if($_CAT[$search_cat_id]['parentid']>0)
	{
		// добавляем родителя
		$parent_arr[]=(int)$_CAT[$search_cat_id]['parentid'];
		
		// ищем по родителю
		$new_parent=get_parent_cat_chain((int)$_CAT[$search_cat_id]['parentid']);
		if($new_parent)
			$parent_arr=array_merge($new_parent,$parent_arr);
		return $parent_arr;
	}
}

// получает id всех дочерних категорий. Используется для отображения новостей по категории (и вложенных в нее)
function get_child_cats($id)
{
	global $_CAT;
	
	if(!$_CAT)
		$_CAT=CategoriesGet();
	
	foreach ($_CAT as $cat_id => $cat)
	{
		//echo $cat['parentid'].' '.$id;
		if($id and $cat['parentid']==$id)
		{
			
			$result[]=$cat['id'];
			$child=get_child_cats($cat['id']);
			if($child)
				$result=array_merge($result,$child);
		}
	}

	if(isset($result))
		return $result;
	else
		return false;
}

function get_cats_to_del ($cat_ids_string/*, $root_only*/){
	//формирует массив альтнеймов категорий по их id
	//$cat_ids_string - id категорий, списком через запятые без пробелов, например: 1,2,32
	//используется при редактировании новостей, чтоб сбросить кеш

// 	global $cat_array;
// 	$news_cat_array = explode (",", $cat_ids_string);
// 	$news_cat_array_quantity = count($news_cat_array);
// 	$parent_cats_array = array();
// 
// 	for($i=0;$i<$news_cat_array_quantity; $i++)
// 	{
// 		//раскаментить, если в корне кеша не будут появляться подкатегории, у которых есть родитель.. т.к. они должны быть в папке родителя
// 		if (isset($cat_array[$news_cat_array[$i]]["parent_url_name"]) and !empty($cat_array[$news_cat_array[$i]]["parent_url_name"]))
// 		{
// 			$parent_cat_url_name = $cat_array[$news_cat_array[$i]]["parent_url_name"];
// 			if(!in_array($parent_cat_url_name, $parent_cats_array))
// 				$parent_cats_array[] = $parent_cat_url_name;
// 		}
// 
// 		if (isset($cat_array[$news_cat_array[$i]]["name"]) and !empty($cat_array[$news_cat_array[$i]]["name"]))
// 		{
// 			$cat_url_name = $cat_array[$news_cat_array[$i]]["url_name"];
// 			if(!in_array($cat_url_name, $parent_cats_array))
// 				$parent_cats_array[] = $cat_url_name;
// 		}
// 	}
// 	
// 	global $_CAT;
// 	
// 	if(!$_CAT)
// 		$_CAT=CategoriesGet();
// 		
// 	
// 	
// 	if($parent_cats_array)
// 		return $parent_cats_array;
// 	else
 		return false;
}

function safe_text ($str)
{
	$str=html_entity_decode($str, ENT_QUOTES, 'UTF-8');
	$str = strip_tags($str);

	$str=htmlentities ($str, ENT_QUOTES, 'UTF-8');
	$str=trim($str);
	return  $str;
}

function make_url_name($str)
{
	//FIXME: переписать это говно!!!

	$str=trim($str);
	//пробелы - в дефисы
	$str = str_replace(' ','-',$str);
	//$str = mb_ereg_replace('/[^a-zA-Zа-яА-Я0-9\-]/','',$str);
	$str = preg_replace('~[^\.\w\pL-]~u','-',$str);
	//заменяем кучи дефисов на один
	$str = preg_replace('/-+/u','-', $str);
	$str = preg_replace('/-\./u','-', $str);
	$str = preg_replace('/\.-/u','-', $str);

	//убираем дефисы и точки в конце
	$str = preg_replace('/(-|\.)$/u','', $str);
	//убираем дефисы и точки в начале
	$str = preg_replace('/^(-|\.)/u','', $str);

	return  $str;
}

function check_denied_symbols ($text)
{
	$denied_symbols = array('/', '&','"', "'",'?',"<",">","%");

	$clean = str_replace($denied_symbols, '', $text);
		if($text != $clean)
			return true;
		else
			return false;
}

function  showinfo($title=false,$text=false,$type='info',$admin=false)
{
	global $engine_config;
	if($type=='error')
	{
		if(!$title)
			$title='Ошибка!';
		if(!$text)
			$text='Неизвестная ошибка!';
	}
	elseif($type=='info')
	{
		if(!$title)
			$title='Информация';
		if(!$text)
			$text='Нет информации';
	}

	$parse['{title}'] = $title;
	$parse['{text}']= $text;
	
	$template = get_template($type,$admin) or die ('missing error.tpl or info.tpl');
	return parse_template($template,$parse);// собственно парсим шаблон
}

function universal_link_bar($count, $page, $URL, $perpage, $show_link, $page_text='page/', $after_page_number='/')
{	
	$bar_content = array();

	// Для придания ссылкам стиля
	//$style = 'style="color: #808000; text-decoration: none;"';
	//$style = '';
	//$now_page_style = 'class="now_page"';
	// $show_link - количество отображаемых ссылок;
	// нагляднее будет, когда это число будет парное
	// Если страница всего одна, то вообще ничего не выводим
	$pages_count = ceil($count / $perpage); // Количество страниц
	if ($pages_count == 1) return false;
	//$sperator = ' '; // Разделитель ссылок; например, вставить "|" между ссылками

	$begin = $page - intval($show_link / 2);
	unset($show_dots); // На всякий случай :)


// Сам постраничный вывод

	//Добавляем ссылку < Предыдущая страница
	if ($page != 1 and $pages_count>1)
	if($page==2)
		$bar_content[]=array('url'=>$URL, 'name'=>'&lt;&lt;');// '<li><a '.$style.' href="'.$URL.'">&lt;&lt;</a></li>';
	else
		$bar_content[]=array('url'=>$URL.$page_text.($page - 1).$after_page_number, 'name'=>'&lt;&lt;');// '<li><a '.$style.' href="'.$URL.$page_text.($page - 1).$after_page_number.'">&lt;&lt;</a></li>';
	elseif ($pages_count>1)
		$bar_content[]=array('url'=>'#', 'name'=>'&lt;&lt;', 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">&lt;&lt;</a></li>';
	// Если количество отображ. ссылок больше кол. страниц
	if ($pages_count <= $show_link + 1) $show_dots = 'no';
		// Вывод ссылки на первую страницу
		if (($begin > 2) && !isset($show_dots) && ($pages_count - $show_link > 2))
		{
			$bar_content[]=array('url'=>$URL.$page_text.'1'.$after_page_number, 'name'=>'1'); // '<li><a '.$style.' href="'.$URL.$page_text.'1'.$after_page_number.'">1</a></li> ';
		}

	for ($j = 0; $j < $page; $j++)
	{
		// Если страница рядом с концом, то выводить ссылки перед идущих для того,
		// чтобы количество ссылок было постоянным
		if (($begin + $show_link - $j > $pages_count) && ($pages_count-$show_link + $j > 0))
		{
			$page_link = $pages_count - $show_link + $j; // Номер страницы
			// Если три точки не выводились, то вывести
			if (!isset($show_dots) && ($pages_count-$show_link > 1))
			{
				//точки ссылками
				//$bar_content .= ' <a '.$style.' href='.$URL.$page_text.($page_link - 1).'.$after_page_number.'><b>...</b></a> ';
				//точки без ссылок
				$bar_content[]=array('url'=>'#', 'name'=>'...', 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">...</a></li>';
				// Задаем любое значение для того, чтобы больше не выводить в начале "..." (три точки)
				$show_dots = "no";
			}
			// Вывод ссылки
			$bar_content[]=array('url'=>$URL.$page_text.$page_link.$after_page_number, 'name'=>$page_link); // ' <li><a '.$style.' href="'.$URL.$page_text.$page_link.$after_page_number.'">'.$page_link.'</a></li> '.$sperator;
		} else continue;
	}
	for ($j = 0; $j <= $show_link; $j++) // Основный цикл вывода ссылок
	{
		$i = $begin + $j; // Номер ссылки
		// Если страница рядом с началом, то увеличить цикл для того,
		// чтобы количество ссылок было постоянным
		if ($i < 1)
		{
			$show_link++;
			continue;
		}
		// Подобное находится в верхнем цикле
		if (!isset($show_dots) && $begin > 1)
		{
				//точки ссылками
			//$bar_content .= ' <a '.$style.' href='.$URL.$page_text.($i-1).$after_page_number.'><b>...</b></a> ';
				//точки без ссылок
			$bar_content[]=array('url'=>'#', 'name'=>'...', 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">...</a></li>';
			$show_dots = "no";
		}
		// Номер ссылки перевалил за возможное количество страниц
		if ($i > $pages_count) break;
		if ($i == $page)
		{
			$bar_content[]=array('url'=>'#', 'name'=>$i, 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">'.$i.'</a></li>';//$now_page_style
		}
		elseif($i==1)
		{
			$bar_content[]=array('url'=>$URL, 'name'=>$i); // ' <li><a '.$style.' href="'.$URL.'">'.$i.'</a></li> ';
		}
		else
		{
			$bar_content[]=array('url'=>$URL.$page_text.$i.$after_page_number, 'name'=>$i); // ' <li><a '.$style.' href="'.$URL.$page_text.$i.$after_page_number.'">'.$i.'</a></li> ';
		}
		// Если номер ссылки не равен кол. страниц и это не последняя ссылка
		//if (($i != $pages_count) && ($j != $show_link)) $bar_content .= $sperator;
		// Вывод "..." в конце
		if (($j == $show_link) && ($i < $pages_count))
		{
			//точки ссылками
			//$bar_content .= ' <a '.$style.' href='.$URL.$page_text.($i+1).$after_page_number.'><b>...</b></a> ';
			//точки без ссылок
			$bar_content[]=array('url'=>'#', 'name'=>'...', 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">...</a></li>';
		}
	}
	// Вывод ссылки на последнюю страницу
	if ($begin + $show_link + 1 < $pages_count)
	{
		$bar_content[]=array('url'=>$URL.$page_text.$pages_count.$after_page_number, 'name'=>$pages_count); // ' <li><a '.$style.' href="'.$URL.$page_text.$pages_count.$after_page_number.'"> '.$pages_count.' </a></li>';
	}
	//Добавляем ссылку Следующая страница >
	if ($page != $pages_count and $pages_count>1)
		$bar_content[]=array('url'=>$URL.$page_text.($page + 1).$after_page_number, 'name'=>'&gt;&gt;'); // '<li><a '.$style.' href="'.$URL.$page_text.($page + 1).$after_page_number.'">&gt;&gt;</a></li>';
	elseif ($pages_count>1)
		$bar_content[]=array('url'=>'#', 'name'=>'&gt;&gt;', 'disabled'=>'disabled'); // '<li class="disabled"><a href="#">&gt;&gt</a></li>';

		
	$template = get_template('pagination');
	preg_match("/\[page\](.*?)\[\/page\]/isu", $template, $page_out);
	$entrie_tpl=$page_out['1'];
	
	foreach($bar_content as $item)
	{
		$tmp_tpl=$entrie_tpl;
		if($item['disabled'])
			$parse_item['{disabled}']='disabled';
		else
			$parse_item['{disabled}']='';
			
		$parse_item['{url}']=$item['url'];
		$parse_item['{name}']=$item['name'];
		
		$parse_items.=parse_template($tmp_tpl,$parse_item);
	}
	
	$bar_content[$page_out[0]]=$parse_items;
	
	return parse_template($template,$bar_content);
}

function clean_url($url)
{
	$url=strip_tags($url);
	$url=strip_bbcode($url);
	$url = preg_replace('/(onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove|onmouseup|onmouseout|onmouseover|onreset|onselect|onsubmit|onunload|onload|onAbort|onerror|style)=?/siu', '[deleted]', $url);
	$url = preg_replace('/(jQuery\(|\$\(|script:|\<\s*\/?\s*script\s*\>|document\.|eval\(|expression\()/siu', '[deleted]', $url);//vbscript|javascript:|

	return $url;
}

function normalize_url ($url)
{
	$cleaned_url = clean_url($url);
	if($cleaned_url != $url)
		return "[dangerous_url]";

	//проверяем после urldecode
	$decoded_url = urldecode($url);
	$cleaned_decoded_url = clean_url($decoded_url);
	if($cleaned_decoded_url != $decoded_url)
		return "[dangerous_url]";

	//проверяем после html_entity_decode
	$entity_decoded_url=html_entity_decode($url, ENT_QUOTES, 'UTF-8');
	$cleaned_entity_decoded_url = clean_url($entity_decoded_url);
	if($cleaned_entity_decoded_url != $entity_decoded_url)
		return "[dangerous_url]";

	else
	{
		$url=str_replace(" ","%20",$url);
		// Добавляем в начало "http://" если нужно
		if (!preg_match("#^(http|ftp|https|news|magnet)\://#isu", $url))
		$url = "http://".$url;

		return $url;
	}
}

/*function validateURL ($url)
{
	// Check for empty url
	if (trim($url) == '')
		return false;

	// Make replacement of dangerous symbols
	if (preg_match('#^(http|https|ftp)://(.+)$#', $url, $mresult))
		return $mresult[1].'://'.str_replace(array(':', "'", '"'), array('%3A', '%27', '%22'), $mresult[2]);

	// Process special `magnet` links
	if (preg_match('#^(magnet\:\?)(.+)$#', $url, $mresult))
		return $mresult[1].str_replace(array(' ', "'", '"'), array('%20', '%27', '%22'), $mresult[2]);

	return str_replace(array(':', "'", '"'), array('%3A', '%27', '%22'), $url);
}*/

// function htmlspecialchars_intellect($string)
// {
// 	$string = preg_replace('/(\&amp;)(#\d+)/siu', '&$2',  htmlspecialchars($string, ENT_QUOTES, 'utf-8'));
// 
// 	return $string;
// }

function function_bbcode_to_html ($str, $news_title="изображение")
{
	global $engine_config, $SMILES;

	event('before_bbcode_parse');

	// ютуб
	//$str= preg_replace('$\<object.+?youtube\.com/v/([a-zA-Z0-9-_+]+).+?\</object\>$u', '[youtube=$1]', $str);
	//$str=preg_replace('$\<iframe.+?youtube\.com/embed/([a-zA-Z0-9-_+]+).+?\</iframe\>$isu', '[youtube=$1]', $str);//new

// 	$str=html_entity_decode($str, ENT_QUOTES, 'UTF-8');
// 	$str=htmlentities ($str, ENT_QUOTES, 'UTF-8');
// 
// 	$news_title=html_entity_decode($news_title, ENT_QUOTES, 'UTF-8');
// 	$news_title=htmlentities ($news_title, ENT_QUOTES, 'UTF-8');

	//переносы строк
	$str = str_replace("\r\n", "<br />", $str);
	$str = str_replace("\n", "<br />", $str);
	//$str= nl2br($str);

	// code
	while (preg_match("/\[code\](.*?)\[\/code\]/isu", $str, $code_out))//если  найден блок кода
	{
		$code_out_new = str_replace("[", "&#91", $code_out['1']);
		$code_out_new = str_replace("]", "&#93", $code_out_new);
		$code_out_new = "<div class='scriptcode'>".$code_out_new;
		$code_out_new .= "</div>";
		$str = str_replace($code_out['0'], $code_out_new, $str);
	}

	$replace_array=array(
	'/\[br\]/isu'=>"<br />\n",
	'/\[b\](.*?)\[\/b\]/isu'=>'<b>$1</b>',
	'/\[i\](.*?)\[\/i\]/isu'=>'<em>$1</em>',
	'/\[u\](.*?)\[\/u\]/isu'=>'<u>$1</u>',
	'/\[s\](.*?)\[\/s\]/isu'=>'<s>$1</s>',
	'/\[(left|center|right)\](.*?)\[\/(left|center|right)\]/isu'=>'<div style="text-align: $1;">$2</div>',
	'/\[font\=([A-z\s]*)\]/isu'=>'<span style="font-family: $1;">',
	'/\[\/font\]/isu'=>'</span>',
	'/\[size\=(\d*)\]/isu'=>'<span style="font-size: $1pt;">',
	'/\[\/size\]/isu'=>'</span>',
	'/\[color\=\s*([A-z]*|#?[A-f0-9]{6})\s*\]/isu'=>'<span style="color: $1;">',
	'/\[\/color\]/isu'=>'</span>',
	'/\[quote\=(.*?)\]/isu'=>'<div class="main_quote"><div class="title_quote">$1</div><div class="quote">',
	'/\[quote\]/isu'=>'<div class="main_quote"><div class="quote">',
	'/\[\/quote\](\<br \/\>)?/isu'=>'</div></div>',
	'/\[attachment=\d*\]/isu'=>'',
	'/\[youtube=\s*([a-zA-Z0-9-_+]+)\s*\]/isu'=>'<iframe width="600" height="450" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');
	
	$str = preg_replace (array_keys($replace_array), array_values($replace_array), $str);

	// смайлы
	if($SMILES) // FIXME!!! выпилить! смайлы - это плагин!!
	while (preg_match('/:('.implode('|', array_keys($SMILES)).'):/isu', $str, $out_smile))
	{
		$str = str_replace($out_smile['0'], '<img src="'.$SMILES[$out_smile['1']].'" \>', $str);
	}

	// спойлер
	while (preg_match('/\[spoiler=?\](\<br \/\>)*(.*?)\[\/spoiler\]/isu', $str, $out_without_name))
	{
		$spoilername = random_string(12, 'lower,upper');
		$str = str_replace($out_without_name[0], '<div class="title_spoiler">Показать / Скрыть содержимое спойлера</div>
		<div class="text_spoiler" style="display:none">'.$out_without_name['2'].'</div>', $str);
	}
	while (preg_match('/\[spoiler=(.*?)\](\<br \/\>)*(.*?)\[\/spoiler\]/isu', $str, $out_with_name))
	{
		$spoilername = random_string(12, 'lower,upper');
		$str = str_replace($out_with_name[0], '<div class="title_spoiler"">'.$out_with_name[1].'</div><div class="text_spoiler" style="display:none">'.$out_with_name['3'].'</div>', $str);
	}

	// имаги
	while (preg_match('/\[img\]('.$engine_config['http_photohost_name_regexp'].'.*?)\[\/img\]/isu', $str, $img))
	{
		$img['1'] = normalize_url($img['1']);
		$str = str_replace($img['0'], '<img src="'.$img['1'].'" alt=\''.$news_title.'\' title=\''.$news_title.'\' />', $str);
	}
	//имаги с левых фотохостов
	while (preg_match('/\[img\](.*?)\[\/img\]/isu', $str, $img2))
	{
		$img2['1'] = normalize_url($img2['1']);
		$str = str_replace($img2['0'], /*$img2['1'].*/'[Изображения разрешено заливать только на '.$engine_config['photohost_name'].']', $str);
	}

	// ссылки
	//url_on_bad_image
	while (preg_match('/\[url\=(.*?)\]\[Изображения разрешено заливать только на '.$engine_config['photohost_name'].'\]\[\/url\]/isu', $str, $url_on_bad_image))
	{
		$str = str_replace($url_on_bad_image['0'], '[Изображения разрешено заливать только на '.$engine_config['photohost_name'].']', $str);
	}
	//url_without_name
	while (preg_match('/\[url=?\](.*?)\[\/url\]/isu', $str, $url_without_name))
	{
		$url_without_name['1'] = normalize_url($url_without_name['1']);
		if(!mb_strpos($url_without_name['1'], $_SERVER['HTTP_HOST']) /*and !mb_strpos($url_with_name['1'], $engine_config['photohost_link'])*/)
			$nofollow = ' rel="nofollow" ';
		else
			$nofollow = '';
		$str = str_replace($url_without_name['0'], '<a href="'.$url_without_name['1'].'"'.$nofollow.'>'.$url_without_name['1'].'</a>', $str);
		unset($nofollow);
	}
	//url_with_name
	while (preg_match('/\[url\=(.*?)\](.*?)\[\/url\]/isu', $str, $url_with_name))
	{
		$url_with_name['1'] = normalize_url($url_with_name['1']);
		if(!mb_strpos($url_with_name['1'], $_SERVER['HTTP_HOST']) /*and !mb_strpos($url_with_name['1'], $engine_config['photohost_link'])*/)
			$nofollow = ' rel="nofollow" ';
		else
			$nofollow = '';
		$str = str_replace($url_with_name['0'], '<a href="'.$url_with_name['1'].'"'.$nofollow.'>'.$url_with_name['2'].'</a>', $str);
		unset($nofollow);
	}

	return $str;
}

function function_bbcode_to_html_short ($str, $news_title)
{
	$news_title=html_entity_decode($news_title, ENT_QUOTES, 'UTF-8');
	$news_title=htmlentities ($news_title, ENT_QUOTES, 'UTF-8');

	//переносы строк
	$str = str_replace("\r\n", "<br />", $str);
	$str = str_replace("\n", "<br />", $str);

	// рейтинг
	while (preg_match('/\[rating=(\d*)\]/isu', $str, $out_rating))
		$str = str_replace($out_rating['0'], get_kp_rating($out_rating['1']), $str);

	return strip_bbcode($str);
}

/*
function function_html_to_bbcode ($str)
{
	$replace_array = array(
	'/\<br\s*\/*\>/isu'=>"\r\n",
	'/\<hr\s*\/*\>/isu'=>'[hr]',
	'$<!--rating:(\d*)-->(.+?)<!--/rating-->$isu'=>"[rating=$1]",
	'/\<!--spoiler\s(.*?)-->.*?\<!--spoiler_text--\>/isu'=>"[spoiler=$1]\r\n",
	'/\<!--spoiler-->.*?\<!--spoiler_text--\>/isu'=>"[spoiler]\r\n",
	'/\<!--spoiler_text_end--\>.*?\<!--\/spoiler--\>/isu'=>'[/spoiler]',
	'/\<b\>(.*?)\<\/b\>/isu'=>'[b]$1[/b]',
	'/\<(i|em)\s*?\>(.*?)\<\/(i|em)\s*?\>/isu'=>'[i]$2[/i]',
	'/\<u\>(.*?)\<\/u\>/isu'=>'[u]$1[/u]',
	'/\<s\>(.*?)\<\/s\>/isu'=>'[s]$1[/s]',
	'/\<a\s*href=\"(.*?)\".*?\>(.*?)\<\/a\>/isu'=>'[url=$1]$2[/url]',
	'/\<div align="(left|center|right)"\>(.*?)\<\/div\>/isu'=>'[$1]$2[/$1]',
	'/\<img src=\"(.*?)\".*?\>/isu'=>'[img]$1[/img]',
	'$\<!--colorstart:(.*?)--\>.*?\<!--/colorstart--\>$isu'=>'[color=$1]',
	'$\<!--colorend--\>\</span\>\<!--/colorend--\>$isu'=>'[/color]',
	'$\<!--sizestart:.*?--\>\<span style=\"font-size:\s*(\d+)pt;.*?\"\><!--/sizestart--\>$isu'=>'[size=$1]',
	'$\<!--sizeend--\>\</span\>\<!--/sizeend--\>$isu'=>'[/size]',
	'$\<!--fontstart:(.*?)--\>.*?\<!--/fontstart--\>$isu'=>'[font=$1]',
	'$\<!--fontend--\>\</span\>\<!--/fontend--\>$isu'=>'[/font]',
	'$\<!--QuoteBegin\s+(.*?)\s+--\>.*?\<!--QuoteEBegin--\>$isu'=>'[quote=$1]',//открывающий тег цитата с названием
	'$\<!--QuoteBegin--\>.+?\<!--QuoteEBegin--\>$isu'=>'[quote]',//открывающий тег цитата без названия
	'$\<!--QuoteEnd--\>\<\/div\>\<!--QuoteEEnd--\>$isu'=>"[/quote]\r\n",//закрывающий тег цитаты
	'$\<!--smile:(.*?)--\>.*?\<!--\/smile--\>$isu'=>':$1:',
	//'$\<img.*?alt=\"(\w+)\" align=\"absmiddle\".*?\>$isu'=>':$1:',//временно для конвертирования каментовПоказать / Скрыть содержимое спойлера
	//'$\<div class=\"title_spoiler\".*?\>.*?Показать \/ Скрыть содержимое спойлера.*?\<\/div\>\<div.*?\>(.*?)\<\/div\>$isu'=>'[spoiler]$1[/spoiler]',//временно для конвертирования каментов
	//'$\<div class=\"title_spoiler\".*?\>(.*?)\<\/div\>\<div.*?\>(.*?)\<\/div\>$isu'=>'[spoiler=$1]$2[/spoiler]',//временно для конвертирования каментов

	'$\<!--code1--\>.+?\<!--ecode1--\>(.*?)\<!--code2--\>\<\/div\>\<!--ecode2--\>$isu'=>'[code]$1[/code]',
	'$\<object.+?youtube\.com/v/([a-zA-Z0-9-_+]+).+?\</object\>$isu'=>'[youtube=$1]',//old
	'$\<iframe.+?youtube\.com/v/([a-zA-Z0-9-_+]+).+?\</iframe\>$isu'=>'[youtube=$1]',//new
	);

	$str = preg_replace (array_keys($replace_array), array_values($replace_array), $str);

	return $str;
}*/

function keyword($text,$delimiter=', ',$lenkey=4,$kolkey=40, $returntextonly=1)
{
	//$text- текст
	//$lenkey - минимальная длинна ключевого слова
	//$kolkey - количество ключевиков
	//$returntextonly=1 - возвращает текст без цифр
	$text = strip_bbcode($text);
	//$text = mb_ereg_replace('/(http:\/\/.*?)\]/is','',$text);//вырезаем изображения... strip_tags не режет адреса ихображений
	$text=mb_strtolower(strip_tags($text),'UTF-8');//удаляем таги и все в нижний регистр
	if($returntextonly)
		preg_match_all("/[а-яa-zёіїє-]{".$lenkey.",}+/isu",$text,$word);//вытягиваем слова //альтернативная регулярка, которая не режет точки в словах : [^а-яА-Яa-zA-Z0-9\s\*\.-]
	else
		preg_match_all("/[а-яa-z0-9ёіїє-]{".$lenkey.",}+/isu",$text,$word);
	$return = array_count_values ($word['0']);//считаем колличество слов
	arsort($return);//сортируем по встречаемости слова

	foreach($return as $key => $value)//перебираем массив, чтоб получить в значения то, что в ключах... уверен, для этого существует функция
		$final_keywords_array[]=$key;

	if(is_array($final_keywords_array))
	{
		$return = array_slice ($final_keywords_array, 0, $kolkey);//отрезаем верхушку массива
		$return = implode($delimiter,$return);//формируем с массива текст
	}
	return $return;
}

function remote_file_size($path)
{
	$fp = @fopen($path,"r");
	$inf = @stream_get_meta_data($fp);
	@fclose($fp);
	if($inf)
	{
		foreach($inf["wrapper_data"] as $v)
		{
			if (stristr($v,"content-length"))
			{
				$v = explode(":",$v);
				return trim($v['1']);
			}
		}
	}
	else
		return false;
}

// узнаем расширение файла
function getExtension($filename)
{
	if($pieces = explode(".", $filename))
		return end($pieces);
	else
		return false;
}

function random_string($length, $chartypes)
{
	$chartypes_array=explode(",", $chartypes);
	// задаем строки символов
	$lower = 'abcdefghijklmnopqrstuvwxyz'; // lowercase
	$upper = 'abcdefghijklmnopqrstuvwxyz'; // uppercase
	$numbers = '1234567890'; // numbers
	$special = '^@*+-+%()!?'; //special characters

	// определяем символы, из которых будет сгенерирована наша строка
	if(in_array('all', $chartypes_array))
		$chars = $lower.$upper.$numbers.$special;
	else
	{
		if(in_array('lower', $chartypes_array))
			$chars = $lower;
		if(in_array('upper', $chartypes_array))
			$chars .= $upper;
		if(in_array('numbers', $chartypes_array))
			$chars .= $numbers;
		if(in_array('special', $chartypes_array))
			$chars .= $special;
	}

	// длина строки с символами
	$chars_length = (strlen($chars) - 1);
	// создаем нашу строку
	$string = $chars{rand(0, $chars_length)};
	// генерируем нашу строку
	for ($i = 1; $i < $length; $i = strlen($string))
	{
		// выбираем случайный элемент из строки с допустимыми символами
		$random = $chars{rand(0, $chars_length)};
		// убеждаемся в том, что два символа не будут идти подряд
		if ($random != $string{$i - 1})
			$string .= $random;
	}
	// возвращаем результат
	return $string;
}


function formatfilesize( $data ) //преобразование размера с байтов
{
	if( $data < 1024 ) return $data . " Bytes";
	else if( $data < 1048576 ) return round( ( $data / 1024 ), 1 ) . " Kb";
	elseif ( $data < 1073741824 ) return round( ( $data / 1048576 ), 2 ) . " Mb";
	elseif ( $data < 1099511627776) return round( ( $data / 1073741824 ), 2 ) . " Gb";
	else return round( ( $data / 1099511627776 ), 2 ) . " Tb";
}

function strip_bbcode($text)
{
	$text = preg_replace('|\[img\].*?\[/img\]|isu', '', $text);
	return preg_replace('#\[.*?\]#isu', '', $text);
}

function relative_date($date) {
	if (mb_strlen($date)==strlen(intval($date)))//если получен таймстамп
		$time = $date;
	else
		$time = strtotime($date);//иначе - получена дата

	$today = strtotime(date('M j, Y'));

	$reldays = ($time - $today)/86400;

	if ($reldays >= 0 && $reldays < 1)
		return 'Сегодня, '.date('H:i:s',$time);
	else if ($reldays >= -1 && $reldays < 0)
		return 'Вчера, '.date('H:i:s',$time);
	else if ($reldays >= -2 && $reldays < -1)
		return '2 дня назад, '.date('H:i:s',$time);
	else if ($reldays >= -3 && $reldays < -2)
		return '3 дня назад, '.date('H:i:s',$time);
	else return date('d.m.Y H:i:s',$time);
}

function rmdir_recursive($dir)
{
	if (is_dir($dir))
	{
		$objects = scandir($dir);
		foreach ($objects as $object)
		{
			if ($object != "." && $object != "..")
			{
				if (filetype($dir."/".$object) == "dir")
					rmdir_recursive($dir."/".$object);
				else
					unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function trimarray($Input)
{
	if (!is_array($Input))
		return trim($Input);
	return array_map('trimarray', $Input);
}

function edToolbar($inadmin=false)
{
	global $SMILES;

	event('before_toolbar_create');

	$tpl=get_template('toolbar',$inadmin);
	$parse['{toolbarid}']=$toolbarid;



	preg_match("/\[item\](.*?)\[\/item\]/isu", $tpl, $entrie_out);
	$item_smiledata=$entrie_out[1];
	$item_general_tpl=$entrie_out[0];

	//echo $item_smiledata;

// 	if (is_array($SMILES));
// 	{
// 		foreach ($SMILES as $name=>$path)
// 		{
// 
// 		//echo $path;
// 
// 		//echo $item_smiledata;
// 			$parse_item=array
// 				(
// 				'{smile_name}'=>$name,
// 				'{smile_path}'=>$path,
// 				);
// 
// 			$parse[$item_general_tpl].=parse_template($item_smiledata,$parse_item);
// 
// 		}
// 
// 		//return parse_template($tpl,array($item_general_tpl=>$parse_items));
// 	}

	return parse_template($tpl, $parse);
}

function destroy_session_by_id ($id=false,$name=false)
{
	if($id)
		$where = " `user_id`=i<id>";
	elseif($name)
		$where = " `user_name`=<user_name>";

	$squery = "SELECT sessionid
		FROM {P}_users
		WHERE $where
		LIMIT 1
		";
		$sresult = query($squery,array('id'=>$id,'user_name'=>$name)) or $err=1;
		if ($err != 1)
		$srow = fetch_assoc($sresult);

	if($srow['sessionid'])
	{
		$kicksessionid = $srow['sessionid'];

		// Сохраняем id текущей сессии
		$realsessionid=session_id();

		if($kicksessionid)
		{
			// Заканчиваем нашу сессию и переключаемся на ту, которую нужно убить
			session_commit();
			session_id($kicksessionid);
			session_start();

			// Убиваем сессию
			session_unset();
			session_destroy();

			// Возвращаемся к своей сессии
			session_id($realsessionid);
			session_start();



			//убить куку sessid
		}
	}
}

function logger ($text,$logfile="/sitelogs/sitelog.txt") //FIXME: вынести в плагин Logger
{
	$fp = @fopen(root.$logfile, "a"); // Открываем файл в режиме записи
	$text = date("H:i:s d.m.Y")." ".$text."\r\n"; // Исходная строка
	$write = @fwrite($fp, $text); // Запись в файл
	@fclose($fp); //Закрытие файла
}

// функция от крона
function check_task($taskfile, $taskperiod )
{
	if (file_exists($taskfile) and (time()-filemtime($taskfile)>$taskperiod))
		return 1;
	else
		return 0;
}

// определение пути к кешу страниц
function get_short_text_cache_name ($path, $page)
{
	global $engine_config;

	if(!$page)// глагне
		$name = 1;
	else
		$name = $page;

	$dir_path = $engine_config['cache_dir']."/short/$path";

	if(!file_exists($dir_path))
		mkdir($dir_path, 0777, 1);

	return $dir_path."/$name.htm";
}

// определение пути к кешу полной новости
function get_full_text_cache_name ($newsid)
{
	global $engine_config;

	$newsid=intval($newsid);

	$dir_path = $engine_config['cache_dir']."/full";

	if(!file_exists($dir_path))
		mkdir($dir_path, 0777, 1);//рекурсивно создаем

	return $dir_path."/".$newsid;
}


// вытягивание кеша
function get_cache ($file_cache_name,$cache_time)
{
	global $engine_config, $debug;

	$modif=time()-@filemtime ($file_cache_name);

	if ($modif<$cache_time)
	{
		$debug[]= "Файл '".basename($file_cache_name)."' взят с кеша";
		return file_get_contents($file_cache_name);
	}
	else
	{
		$debug[]= "Не удалось получить файл '".basename($file_cache_name)."' с кеша";
		return false;
	}
}


// сохранение кеша
function set_cache ($file_cache_name, $content)
{
	global $engine_config, $debug, $error;
	if(is_writable($engine_config['cache_dir']))
	{
		if(file_put_contents($file_cache_name, $content))
		{
			chmod($file_cache_name, 0777);
			$debug[]="Файл '".basename($file_cache_name)."' записан в кеш.";
			return true;
		}
		else
		{
			$debug[]="Не удалось записать файл '".basename($file_cache_name)."' в кеш.";
			return false;
		}
	}
	else
		$error[]="Директория кеша недоступна для записи. Кеш не записан.";
}

// удаление кеша
function del_cache ($newsid=false,$cats_id=false)
{
	global $engine_config;
	//if($engine_config['cache_enable']=='1')
	//{
		if($cats_id)
			$cats_to_del_array = get_cats_to_del ($cats_id);
		foreach ($cats_to_del_array as $cat_to_del)
		{
			@rmdir_recursive($engine_config['cache_dir']."/short/$cat_to_del");
		}
			@rmdir_recursive($engine_config['cache_dir']."/short/index");//FIXME: получать параметр "есть ли новость на главной"
			@rmdir_recursive($engine_config['cache_dir']."/short/".$cat_to_del."/altview");
	//}

	if($newsid)
	{
		$file_cache_name = get_full_text_cache_name ($newsid);
		@unlink($file_cache_name);
	}
}

//очистка кеша
function clean_cache ()
{
	global $engine_config, $error;
	if($engine_config['cache_dir']!=root and is_dir($engine_config['cache_dir']))
		@rmdir_recursive($engine_config['cache_dir']);
		//echo $engine_config['cache_dir'];
	else
		$error[]='Кеш не очищен. Путь к кешу неверен!';
}

// #*** Получение списка категорий ***#
function CategoriesGet()
{
	global $_CAT;
	
	$cachefile=root.'/cache/cats/categorys.tmp';
	$_CAT = unserialize( @file_get_contents( $cachefile ) );
	if(!is_array($_CAT))
	{
		$_CAT = array();
		$sql_cat = query("SELECT * FROM `{P}_categories` ORDER BY `position` ASC");

		while( $row = fetch_assoc($sql_cat) )
		{
			$_CAT[$row['id']] = array ();
			foreach( $row as $key => $value ) {
				$_CAT[$row['id']][$key] = stripslashes( $value );
			}
		}
		
		if(count($_CAT)>0)
			set_cache($cachefile,serialize($_CAT));
	}
	return $_CAT;
}

#*** Получение альтнеймов списка категорий ***#
function CategoriesGetAltnames()
{
	$categoryAltnames=array();
	$cachefile=root.'/cache/cats/categories_altnames.tmp';
	if(is_file($cachefile))
		$categoryAltnames = unserialize( @file_get_contents( $cachefile ) );
	else
	{
		global $_CAT;
		if(!$_CAT)
			$_CAT=CategoriesGet();
		
		if(count($_CAT)>0)
		{
			foreach ($_CAT as $val)
				$categoryAltnames[$val['url_name']]=$val['id'];
				
			if(count($categoryAltnames)>0)
				set_cache($cachefile,serialize($categoryAltnames));
		}
	}
	
	return $categoryAltnames;
}

// #*** Построение списка категорий для выбора ***#
function CategoriesSelect($selectedid = 0, $parentid = 0, $subCatDelim = '&nbsp;', $result = '', $root_only = false, $tpl= false, $checked_selected='selected')
{
	global $_CAT;
	if(!$_CAT)
		$_CAT=CategoriesGet();
			
	$root_category = array ();

	if(count($_CAT))
	{
		foreach($_CAT as $cats)
		{
			if($cats['parentid'] == $parentid)
				$root_category[] = $cats['id'];
		}
		
		if(count($root_category))
		{
			foreach($root_category as $id)
			{
				$selected='';
				if(is_array($selectedid))
				{
					foreach ($selectedid as $element)
					{
						if($element == $id)
							$selected = $checked_selected;
					}
				}
				elseif($selectedid == $id)
					$selected = $checked_selected;

				$parse_cat['{attr}'] = $selected;
				$parse_cat['{catid}']= $id;
				if($parentid > 0)
					$parse_cat['{catname}'] = $subCatDelim.$_CAT[$id]['name'];
				else
					$parse_cat['{catname}'] = $_CAT[$id]['name'];
				
				$result .= parse_template($tpl, $parse_cat);

				if(!$root_only)
				{
					if($parentid > 0)
						$subCatDelim .= $subCatDelim;
					
					$result = CategoriesSelect($selectedid, $id, $subCatDelim, $result, false,  $tpl, $checked_selected);
				}
			}
		}
	}
	return $result;
}

// function CategoriesSelect___TO_DELETE($cid = 0, $pid = 0, $subCat = '', $result = '', $root_only = false)
// {
// 	global $category;
// 	$root_category = array ();
// 	if( $pid > 0 ) {
// 		$subCat .= '&nbsp;';
// 	}
// 	if( count( $category ) ) {
// 		foreach( $category as $cats ) {
// 			if( $cats['parentid'] == $pid ) $root_category[] = $cats['id'];
// 		}
// 		if( count($root_category) ) {
// 			foreach( $root_category as $id ) {
// 				$result .= "<option value=\"{$id}\"";
// 				if( is_array( $cid ) ) {
// 					foreach ( $cid as $element ) {
// 						if( $element == $id ) $result .= 'selected';
// 					}
// 				} elseif( $cid == $id ) $result .= 'selected';
// 				$result .= ">{$subCat}{$category[$id]['name']}</option>";
// 				if(!$root_only) $result = CategoriesSelect( $cid, $id, $subCat, $result );
// 			}
// 		}
// 	}
// 	return $result;
// }

#*** Подготовка для json ***# FIXME: выпилить!!!
function sjson_encode($s)
{
	return str_replace(array('\\', '/', '"', "\r", "\n", "\b", "\f", "\t"), array('\\\\', '\/', '\"', '\r', '\n', '\b', '\f', '\t'), $s);
}

if (!function_exists('json_encode')) 
{
	function json_encode($data) 
	{
		switch ($type = gettype($data)) 
		{
		case 'NULL':
			return 'null';
		case 'boolean':
			return ($data ? 'true' : 'false');
		case 'integer':
		case 'double':
		case 'float':
			return $data;
		case 'string':
			return '"' . addslashes($data) . '"';
		case 'object':
			$data = get_object_vars($data);
		case 'array':
			$output_index_count = 0;
			$output_indexed = array();
			$output_associative = array();
			foreach ($data as $key => $value) {
			$output_indexed[] = json_encode($value);
			$output_associative[] = json_encode($key) . ':' . json_encode($value);
			if ($output_index_count !== NULL && $output_index_count++ !== $key) {
				$output_index_count = NULL;
			}
			}
			if ($output_index_count !== NULL) {
			return '[' . implode(',', $output_indexed) . ']';
			} else {
			return '{' . implode(',', $output_associative) . '}';
			}
		default:
			return ''; // Not supported
		}
	}
}

function event_register($event_name,$function) 
{
// 	echo '  '.$event_name.'_'.$function;
	global $_HOOKS, $_current_pluginname;
	$_HOOKS[$event_name][]=array(
		'pluginname' => $_current_pluginname,
		'function' => $function,
	);
}

function event($event_name, $arguments = false)
{
	global $_HOOKS, $debug;
	if (isset($_HOOKS[$event_name])) 
	{
		$hook = $_HOOKS[$event_name];
		$n = count($hook);
		for ($i = 0; $i < $n; $i++) 
		{
		$current_hook_time = microtime(true);
		$_current_action = $event_name;
// 		echo $event_name.'_'.$hook[$i]['function'];
		if ($hook[$i]['function'] && is_callable($hook[$i]['function']))
		{
			call_user_func($hook[$i]['function'], $arguments);
// 			echo $event_name.'_'.$hook[$i]['function'];
		}
		$debug[] = 'Хук события ' . $event_name . ' плагином ' . $hook[$i]['pluginname'] . ' выполнен за ' . number_format(microtime(true) - $current_hook_time, 5) . ' сек';
		unset($_current_action);
		unset($current_hook_time);
		}
	} else
		return false;
}

function filter_register($filter_name,$function) 
{
	global $_FILTERS, $_current_pluginname;
	$_FILTERS[$filter_name][]=array(
		'pluginname' => $_current_pluginname,
		'function' => $function,
	);
}

function filter($filter_name, $arguments)
{
	global $_FILTERS, $debug;
	if (isset($_FILTERS[$filter_name])) 
	{
		$filter = $_FILTERS[$filter_name];
		$n = count($filter);
		for ($i = 0; $i < $n; $i++) 
		{
		$current_filter_time = microtime(true);
		$_current_action = $filter_name;
		
		if ($filter[$i]['function'] && is_callable($filter[$i]['function'])){
			$arguments=call_user_func($filter[$i]['function'], $arguments);
		}
		$debug[] = 'Фильтр данных ' . $filter_name . ' плагином ' . $filter[$i]['pluginname'] . ' выполнен за ' . number_format(microtime(true) - $current_filter_time, 5) . ' сек';
		unset($_current_action);
		unset($current_filter_time);
		}
	} 
	//else
	return $arguments;
}

// function getDefinedVars($varList, $excludeList=false)
// {
// 	if(!$excludeList)
// 		$excludeList = array('GLOBALS', '_FILES', '_COOKIE', '_POST', '_GET', 'excludeList');
// 	$temp1 = array_values(array_diff(array_keys($varlist), $excludelist));
// 	$temp2 = array();
// 	while (list($key, $value) = each($temp1)) {
// 		global $$value;
// 		$temp2[$value] = $$value;
// 	}
// 	return $temp2;
// }

function make_query ($query_array)
{
	//$news_query_array['join']['outer join'][]='outer on (outer.а = outer.б)';
	
	global $error;
	// подготовка запроса
	if(isset($query_array['select']) and $query_array['select'])
		$query='SELECT ' . implode(',',$query_array['select']);
	else
		$error[]="Нет параметров select";
		
	if(isset($query_array['from']) and $query_array['from'])
		$query .= ' FROM ' . $query_array['from'];
	else
		$error[]="Нет параметра from";
		
	if(isset($query_array['join']) and $query_array['join'])
	{
		foreach($query_array['join'] as $type=>$value)
// 			$query_join.=" $type join ".implode(" $type join ",$query_array['join'][$type]).' ';
			if(isset($query_join) and $query_join)
				$query_join.=" $type join ".implode(" $type join ",$query_array['join'][$type]).' ';
			else
				$query_join=" $type join ".implode(" $type join ",$query_array['join'][$type]).' ';
		$query .= $query_join;
	}
		
	if(isset($query_array['where']) and $query_array['where'])
		$query .= ' WHERE ' . implode(' and ',$query_array['where']).' ';
		
	if(isset($query_array['order_by']) and $query_array['order_by'])
		$query .= ' ORDER BY ' . implode(',',$query_array['order_by']).' ';
		
	if(isset($query_array['limit']) and $query_array['limit'])
		$query .= " LIMIT {$query_array['limit']} ";
	
	return $query;
}

function mailer($from, $to, $subject, $message)
{
	$headers=
	'MIME-Version: 1.0' . "\r\n".
	'Content-type: text/plain; charset="UTF-8"' . "\r\n" .
	'Date: ' . date('r', $_SERVER['REQUEST_TIME'])."\r\n".
	'From: '.$from."\r\n" .
	'Reply-To: '.$from."\r\n" .
	'X-Mailer: PHP/' . phpversion();

	return mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $headers);
}
?>
<?php
if (!defined('a1cms'))
	die('Access denied to amanager!');

include_once 'options.php';

	if($engine_config['cache_enable'] and $ad_options['use_cache'])
	{
		$ad_cache_dir=root.'/cache/ads/';
		$ad_array_cache_file = $ad_cache_dir.'ad_array.tmp';

		if(file_exists($ad_array_cache_file))
		{
			$ad_array = unserialize(file_get_contents($ad_array_cache_file));
			$debug[]= "Массив рекламы взят с кеша.";
		}
	}
	
	if(!isset($ad_array))
	{
		//запрос
		$ad_query = "SELECT `id`, `name`, `code`, `enabled`, `block`, `show_for`, `show_on`
		FROM `{P}_adv`
		WHERE `enabled` = 1";

		$ad_result = query($ad_query) or $error[] = "Ошибка выборки рекламных баннеров" ;

		while ($ad_row = fetch_assoc($ad_result))
		{
			/*$ad_array[$ad_row['name']]["b".$ad_row['id']]["id"] = $ad_row['id'];
			$ad_array[$ad_row['name']]["b".$ad_row['id']]["name"] = $ad_row['name'];
			$ad_array[$ad_row['name']]["b".$ad_row['id']]["code"] = $ad_row['code'];
			$ad_array[$ad_row['name']]["b".$ad_row['id']]["enabled"] = $ad_row['enabled'];
			$ad_array[$ad_row['name']]["b".$ad_row['id']]["block"] = $ad_row['block'];*/

			$ad_array[$ad_row['name']]["b".$ad_row['id']] = $ad_row;
		}

		if($engine_config['cache_enable'] and $ad_options['use_cache'])
		{
			if (!file_exists($ad_cache_dir))
			mkdir($ad_cache_dir, 0777, 1);
			file_put_contents($ad_array_cache_file, serialize($ad_array));

			$debug[]= "Массив рекламы cформирован с базы и сохранен в кеш.";
		}
	}

	//вытягиваем шаб в переменную
	$ad_tpl=get_template('ad');

	if($ad_array)
	{

		foreach ($ad_array as $banners)
		{
			$banners = array_values($banners);

			if(count($banners)>1)
				$banners[0]=$banners[rand(0,count($banners)-1)];//выбираем рандомные баннер

			if($banners[0]["show_for"]!='all')
				$groups = explode(",", $banners[0]["show_for"]);
				
			if(!$banners[0]["show_on"] or ($banners[0]["show_on"]==1 and ($_URI['request_uri']=='' or $_URI['request_uri']=='/' or $_URI['request_uri']=='/index.php')))
			{
				$banner_on=1;
			}
			else
			{
				$banner_on=0;
			}

			if ($banner_on and ($banners[0]["show_for"]=='all' or in_array($_SESSION['user_group'], $groups) or !$_SESSION['user_group']))
			{
				
// 				$banners[0]['code'] = strtr($banners[0]['code'],$parse);
				$banners[0]['code'] = stripslashes($banners[0]['code']);

				if($banners[0]['block']==1)
					$parse_adw["{banner_".$banners[0]['name']."}"] =  parse_template($ad_tpl,array('{ad}'=> $banners[0]['code'],'{ad_id}'=> $banners[0]['id']));
				else
					$parse_adw["{banner_".$banners[0]['name']."}"] = $banners[0]['code'];
			
			}
			else
				$parse_adw["{banner_".$banners[0]['name']."}"] =  '';
		}

		$parse_main = array_merge($parse_adw, $parse_main);
	}
?>
<?php
if (!defined('a1cms'))
	die('Access denied to menu!');

$plugincats = $remove_cats = array('content', 'users', 'administration', 'configuration', 'other');

// уже делается в plugins_init
// 	$admin_menu=array();
// 	$handle=opendir(root.'/plugins');
// 	while (false !== ($file = readdir($handle))) {
// 		if($file!='.' and $file!='..' and is_dir(root.'plugins/'.$file))
// 		{
// 			include_once root.'plugins/'.$file."/config.php";
// 		}
// 	}
// 	closedir($handle);

// 	var_dump ($admin_menu);

	$dir=scandir(root.'/plugins');
	foreach ($dir as $file)
	{
		if($file!='.' and $file!='..' and file_exists(root."/plugins/".$file."/options.php")) 
		{
			include_once root."/plugins/".$file."/options.php";
		}
		
		if($file!='.' and $file!='..' and file_exists(root."/plugins/".$file."/adminmenu.php")) 
		{
			include_once root."/plugins/".$file."/adminmenu.php";
		}
	}

	foreach ($admin_menu as $pluginname => $plugin)
	{
		$position[$pluginname] = $plugin['position'];
	}
	array_multisort($position, SORT_ASC, $admin_menu); //сортируем по позиции

	$menu_item=get_template('menu_item',1);

	foreach ($admin_menu as $manu_item) {
		$pluginname=$manu_item['pluginname'];

		if($plugin_list[$pluginname]['state']==1
		and in_array($manu_item['cat'],$plugincats)
// 		and ( in_array($_SESSION['user_name'], $plugin_list[$pluginname]['allowed_users']) or in_array($_SESSION['user_group'], $plugin_list[$pluginname]['allowed_groups']) )
		)
		//if($plugin_list[$pluginname]['state']==1 and in_array($_SESSION['user_group'], $plugin_list[$pluginname]['allowed_groups']) and in_array($manu_item['cat'],$plugincats))
		{
			$parse['{link}']=$engine_config['site_path']."/admin/index.php?plugin=".$pluginname.$manu_item['get_params'];
			$parse['{icon}']=$engine_config['site_path'].'/plugins/'.$pluginname.'/'.$manu_item['icon'];
			$parse['{title}']=$manu_item['title'];

			$parsecat["[".$manu_item['cat']."]"]=$parsecat["[/".$manu_item['cat']."]"]='';
			$parsecat["{".$manu_item['cat']."}"].=parse_template($menu_item,$parse);

			if(($key = array_search($manu_item['cat'], $remove_cats)) !== false) {
				unset($remove_cats[$key]);
			}
		}
	}

	$menu = get_template('menu',1);

	foreach ($remove_cats as $rmcat) {
		//echo $rmcat;
		preg_match("/\[".$rmcat."\](.*?)\[\/".$rmcat."\]/isu", $menu, $post);
		$parsecat[$post[0]]='';
	}

	if($parsecat)
	{
		$parse_admin['{menu}']=parse_template($menu,$parsecat);
	}
?>
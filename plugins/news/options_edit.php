<?php
	include_once 'options.php';
	
	$plugin_options_name='news_config';
	$plugin_options_array=$$plugin_options_name;
	
	if(!in_array ($_SESSION['user_group'], $plugin_options_array['allow_configure_news']))
		$error[]='Нет прав для настройки данного плагина';
	else
	{
		$template = get_template('news_options', 1);
		
		$groups_query = "SELECT id, group_name from {P}_groups ORDER by `Order`";
		$groups_sql = query($groups_query);
		while($groups_row = fetch_assoc($groups_sql))
			$groups_arr[$groups_row['id']]=$groups_row['group_name'];
		
		foreach ($plugin_options_array as $name => $value)
		{
			if (!is_array($value) and is_bool($value)===false)
				$parse_news_options['{'.$name.'}']=$value;
			elseif (!is_array($value) and is_bool($value)===true)
			{
				$parse_news_options['{'.$name.'}']=1;
// 				$bool_options_arr[]=$name;
				
				if ($value)
					$parse_news_options["{".$name."_checked}"]='checked';
				elseif (!$value)
					$parse_news_options["{".$name."_checked}"]='';
			}
			elseif (is_array($value) and strstr($name,'allow'))
			{
				
				$parse_news_options['{'.$name.'}']="<option value='0'>Ни одной из групп</option>";
				
				foreach ($groups_arr as $gr_id => $gr_name)
				{
					if(in_array($gr_id,$value))
						$selected='selected';
					else
						$selected='';
					$parse_news_options['{'.$name.'}'].="<option value=\"{$gr_id}\" $selected>{$gr_name}</option>";
				}
				
				
			}
			elseif (is_array($value))
				$parse_news_options['{'.$name.'}']=implode(",", $value);
			
		}
// 		if(is_array($bool_options_arr))
// 			$parse_news_options['{bool_options}']=implode(',', $bool_options_arr);
		$parse_admin['{module}'] = parse_template($template, $parse_news_options);
	}
?>
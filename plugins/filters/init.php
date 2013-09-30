<?php

if (!defined('a1cms'))
	die('Access denied to filters!');

if($WHEREI['main']==true)
{
 	event_register('before_parse_main','filters');
 	event_register('plugin_init_by_uri','filter_init');

	function filter_init($_URI)
	{
		if($_GET['fparam'] || $_GET['fcat'] || $_GET['fsliderparam'])
		{
			filter_register('short_news_query', 'filters_modif_query');
			filter_register('short_news_count_query', 'filters_modif_query');
			$view_short_type='getparams';
			include_once root.'/plugins/news/front_news/view_short.php';
		}
	}
	
	// фильтруем
	function filters_modif_query ($query_array)
	{
		if($_GET['ftext'])
		{
			$query_array['variables']['ftext']=$_GET['ftext'];
			
			if(is_numeric($_GET['ftext']))
				$query_array['where'][]=" ( MATCH (`short_text`, `full_text`, `title`)  AGAINST (<ftext>) or `{P}_news`.`id` = i<ftext> ) ";
			else
				$query_array['where'][]=" MATCH (`short_text`, `full_text`, `title`)  AGAINST (<ftext>) ";
		}
		if($_GET['fparam'])
		{
			global $storage_ids_arr; // чтоб не вытягивать каждый раз
			if(!$storage_ids_arr)
			{
				// FIXME: выпилить "`technical`=1" technical - технический параметр, не складской. техпараметров может быть много, не только склад. 
				$storage_ids_result=query('SELECT `{P}_parameter_values`.`id`
				FROM `{P}_parameter_values`
				LEFT JOIN `{P}_parameters` ON `{P}_parameter_values`.`parameter_id` = `{P}_parameters`.`id`
				WHERE `technical` =1');
				
				while ($storage_ids_row = fetch_assoc($storage_ids_result))
					$storage_ids_arr[]=$storage_ids_row['id'];
			}
			foreach ($_GET['fparam'] as $param_val_id)
			{
				if(is_numeric($param_val_id))
					//$OR_arr[]=' `parameter_value_id`='.$paramid.' ';
					if(in_array($param_val_id,$storage_ids_arr)) //значит параметр складовой, ищем на складе
						$subqeries_arr[]='(SELECT `productid` FROM `{P}_storage` where `quantity`>0 and `parameter_value_id`='.$param_val_id.')';
					else
						$subqeries_arr[]='(SELECT `news_id` FROM `{P}_parameters_relation` where `parameter_value_id`='.$param_val_id.')';
			}
		}
		
		if($_GET['fcat'])
		{
			foreach ($_GET['fcat'] as $fcat_id)
			{
				if(is_numeric($fcat_id))
					//$OR_arr[]=' `parameter_value_id`='.$paramid.' ';
					$query_array['where'][]=" `category_id` REGEXP '[[:<:]](".$fcat_id.")[[:>:]]' ";
// 					echo " `category` REGEXP '[[:<:]](".$fcat_id.")[[:>:]]' ";
			}
		}
		
		if($_GET['fsliderparam'])
		{
			foreach ($_GET['fsliderparam'] as $paramid=>$param_val)
			{
				$param=explode('-',$param_val);
				if(is_numeric($paramid) and is_numeric($param[0]) and is_numeric($param[1]))
				{
					$subqeries_arr[]='(SELECT `news_id` FROM `{P}_parameters_relation` where `parameter_id`='.$paramid.' and `value` between '.$param[0].' and '.$param[1].')';
				}
			}
		}
		
		if($subqeries_arr)
		{
			$filter_result=query('SELECT distinct `news_id`
			FROM `{P}_parameters_relation`
			where `news_id` in 
			'. implode(' and `news_id` in ', $subqeries_arr) .' ');

			while ($filter_row = fetch_assoc($filter_result))
				$ids_arr[]=$filter_row['news_id'];
			
			if($ids_arr)
				$query_array['where'][]=' `fb_news`.`id` in ('.implode(',',$ids_arr).') ';
			else
				$query_array['where'][]=' 1=0 ';
		}
		return $query_array;
	}
	
	
	
 	// отображение фильтров
	function filters($main)
	{
		// доп параметры
		global $custom_fields_names_arr, $parse_main; // чтоб не вытягивать каждый раз
		if (!is_array($custom_fields_names_arr))
		{
			$all_params_result=query('SELECT `name` FROM `{P}_parameters`');
			while ($all_params_row = fetch_assoc($all_params_result))
				$custom_fields_names_arr[]=$all_params_row['name'];
		}
		
		foreach($custom_fields_names_arr as $n_val)
		if(preg_match("/\[filter_item_{$n_val}\](.*?)\[\/filter_item_{$n_val}\]/isu", $main, $post))
		{
			$short_query="SELECT `{P}_parameter_values`.`id` parameter_value_id, `value`
			FROM `{P}_parameter_values`
			LEFT JOIN `{P}_parameters` ON ( `{P}_parameters`.`id` = `{P}_parameter_values`.`parameter_id` )
			WHERE `name`=<productname>";
			
			$params_result=query($short_query, array('productname'=>$n_val));
			
			//$quantity=0;
			while ($params_row = fetch_assoc($params_result))
			{
				$parse_main[$post['0']].=parse_template($post['1'],array('{value}'=>$params_row['value'],'{parameter_value_id}'=>$params_row['parameter_value_id']));
			}
		}
	
		
		// категории
		$category = CategoriesGet();
		if(preg_match("/\[filter_category\](.*?)\[\/filter_category\]/isu", $main, $tpl_piece))
		{
			foreach ($category as $k => $cat)
			{
				//var_dump($cat);
				$parse_main[$tpl_piece['0']].=parse_template($tpl_piece['1'],array('{catid}'=>$cat['id'],'{caturl}'=>rawurlencode($cat['url_name']),'{catname}'=>$cat['name']));
			}
		}
	}

}
?>
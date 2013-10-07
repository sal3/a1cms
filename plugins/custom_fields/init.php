<?php

if (!defined('a1cms'))
	die('Access denied to custom_fields!');

if($WHEREI['admincenter']==true /*and $_GET['plugin']=='custom_fields'*/)
{
	//event_register('before_newsform_parse','custom_fields_in_newsform');
	event_register('after_news_insert','insert_custom_fields');
	event_register('after_news_update','update_custom_fields');
	
	if($_GET['plugin']=='custom_fields')
		include_once 'custom_fields.php';
}
elseif($WHEREI['main']==true)
{
	filter_register('filter_before_shortnews_parse','select_custom_fields');
	filter_register('filter_before_fullnews_parse','select_custom_fields');
	filter_register('filter_before_related_parse','select_custom_fields');
}
elseif($WHEREI['ajax']==true)
{
	event_register('after_news_delete','delete_custom_fields');
}

function update_custom_fields($post) 
{
// 	var_dump($post);
	delete_custom_fields($post);
	insert_custom_fields($post);
}

function delete_custom_fields($post)
{
	query("DELETE FROM {P}_parameters_relation where `news_id`=i<news_id>", array('news_id'=>$post['newsid']));
}

function insert_custom_fields($post)
{
	if(is_array($post['custom']))
	{
		$q='insert into {P}_parameters_relation (`news_id`, `parameter_id`, `parameter_value_id`, `value`)
		VALUES ';
		foreach($post['custom'] as $type=>$values_arr)
		{
			foreach($values_arr as $key => $value)
			{
				if($qv)
					$qv .= ',';

				if($type=='select')
					$qv .= '('.intval($post['newsid']).','.intval($key).','.intval($value).',"")';
				else
				{
					$qv .= '('.intval($post['newsid']).','.intval($key).',0,<'.'val'.$key.'>)';
					$values['val'.$key]=$value;
				}
			}
		}
		$q .= $qv;
	}
	query($q, $values);
}

function select_custom_fields ($data) 
{
	if($data['related_row']['newsid'])
		$newsid=$data['related_row']['newsid'];
	else
		$newsid=$data['news_row']['newsid'];
	
	$params_result=query("SELECT `{P}_parameters_relation`.`parameter_id` , `{P}_parameters`.`name`, `{P}_parameters_relation`.`parameter_value_id`,
	case when `{P}_parameter_values`.`value` is not null then `{P}_parameter_values`.`value` else `{P}_parameters_relation`.`value` end as val 
	FROM `{P}_parameters_relation`
	left join `{P}_parameters` on `{P}_parameters`.`id`=`{P}_parameters_relation`.`parameter_id`
	left join `{P}_parameter_values` on (`{P}_parameter_values`.`id`=`{P}_parameters_relation`.`parameter_value_id` and `{P}_parameters_relation`.`parameter_id`=`{P}_parameter_values`.`parameter_id`)
	where `news_id`=i<news_id>", array('news_id'=>$newsid));
	
	//$tpl=get_template('view_short_custom_field');
	while ($params_row = fetch_assoc($params_result))
	{
		//$tmp_tpl=$tpl;
		//var_dump($params_row);
		
		if(!$params_row['parameter_value_id'])
			$params_row['val']=function_bbcode_to_html ($params_row['val']);
			
		$data['parse']['{'.$params_row['name'].'}']=$params_row['val'];
		
		while(preg_match("/\[if_{$params_row['name']}\](.*?)\[\/if_{$params_row['name']}\]/isu", $data['tpl'], $post))
		{
			if($params_row['val'])
				$data['tpl'] = str_replace($post['0'], $post['1'], $data['tpl']);
			else
				$data['tpl'] = str_replace($post['0'], '', $data['tpl']);
		}
	}
	
	
	// костыль для вырезания неустановленных параметров
	global $custom_fields_names_arr; // чтоб не вытягивать каждый раз
	if (!is_array($custom_fields_names_arr))
	{
		$all_params_result=query('SELECT `name` FROM `{P}_parameters`');
		while ($all_params_row = fetch_assoc($all_params_result))
			$custom_fields_names_arr[]=$all_params_row['name'];
	}
	
	foreach($custom_fields_names_arr as $n_val)
		while(preg_match("/\[if_{$n_val}\](.*?)\[\/if_{$n_val}\]/isu", $data['tpl'], $post))
		{
				$data['tpl'] = str_replace($post['0'], '', $data['tpl']);
		}
	
	return $data;
}

?>
<?php
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))
	session_start();

define('root', substr(dirname( __FILE__ ), 0, -22));

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array($_SESSION['user_group'], $custom_fields_config['allow_cf_access']))
	die("Access denied to custom_fields!");

// $tpl=get_template('custom_fields_parameter_set_table',1);
// preg_match("/\[item\](.*?)\[\/item\]/isu", $tpl, $entrie_out);
// $item_tpl=$entrie_out[1];
// $item_parse=$entrie_out[0];
if($_REQUEST['cats'])
{
	foreach (array_values($_REQUEST['cats']) as $var) {
		$cat_arr[] = (int)$var;
	}
	$cats=implode(',',$cat_arr);
	$vars=array('news_id'=>$_REQUEST['newsid']);
	
	//if(!$_REQUEST['news_id'])
		$parameters_query = "SELECT DISTINCT `parameter_id` , `name` , `{P}_parameters`.`type` , `{P}_parameter_types`.`html_type`
		FROM `{P}_parameter_set_values`
		LEFT JOIN `{P}_parameters` ON `{P}_parameter_set_values`.`parameter_id` = `{P}_parameters`.`id`
		LEFT JOIN `{P}_parameter_types` ON `{P}_parameter_types`.`id` = `{P}_parameters`.`type`
		WHERE `{P}_parameter_set_values`.`category_id`	IN ( $cats )
		AND technical <> 1
		ORDER BY `name`";
		
	//echo 111;
	if($_REQUEST['newsid'])
	{
	//echo 111;
		$data_q=query("SELECT `{P}_parameters_relation`.`parameter_value_id` , `{P}_parameters_relation`.`value`, `parameter_id`
		FROM `{P}_parameters_relation`
		WHERE `news_id`=i<news_id>", $vars);
		while($data_row = fetch_assoc($data_q))
		{
			if($data_row['parameter_value_id'])
				$data[$data_row['parameter_id']]=$data_row['parameter_value_id'];
			else
				$data[$data_row['parameter_id']]=$data_row['value'];
		}
	}
	//var_dump($_REQUEST['newsid']);
		
		
// 	$parameters_query = "SELECT *
// 	FROM `{P}_parameter_set_values`
// 	LEFT JOIN `{P}_parameters` ON ( `{P}_parameter_set_values`.`parameter_id` = `{P}_parameters`.`id` )
// 	LEFT JOIN `{P}_parameters_relation` ON ( `{P}_parameter_set_values`.`parameter_id` = `{P}_parameters_relation`.`parameter_id` = `{P}_parameters_relation`.`parameter_id` )
// 	WHERE {P}_parameter_set_values.category_id
// 	IN ( $cats )";
	
	//echo $cats;
	$parameters_sql = query($parameters_query,$vars);

	while($parameters_row = fetch_assoc($parameters_sql))
	{
		if(!$tpl[$parameters_row['html_type']])
			$tpl[$parameters_row['html_type']]=get_template("custom_fields_".$parameters_row['html_type'],1);
		
		if($parameters_row['html_type']=='select' or $parameters_row['html_type']=='multiple_select')
		{
			unset($parameter_valuesList);
			$parameter_values_query = "SELECT `id`, `value` from `{P}_parameter_values` where `parameter_id`=".$parameters_row['parameter_id']." ORDER by `value`";
			$parameter_values_sql = query($parameter_values_query);
		// 	$parameter_valuesList="<option value='0'>Ни одной из групп</option>";
			while($parameter_values_row = fetch_assoc($parameter_values_sql))
			{
				if($data[$parameters_row['parameter_id']]==$parameter_values_row['id'])
					$s='selected';
				else
					$s='';
					
				$parameter_valuesList.="<option value=\"{$parameter_values_row['id']}\" $s>{$parameter_values_row['value']}</option>";
			}
			$parse['{value}']=$parameter_valuesList;
		}
		else
			$parse['{value}']=$data[$parameters_row['parameter_id']];

		$parse['{name}']=$parameters_row['name'];
		$parse['{parameter_id}']=$parameters_row['parameter_id'];
		
		
		echo parse_template($tpl[$parameters_row['html_type']],$parse);
		//var_dump($data);


		//$item_tpl_current=$item_tpl;

		// 	$parse_item=array(
		// 	'{id}'=>$parameters_row['id'],
		// 	'{name}'=>$parameters_row['name'],
		// 	);
		// 
		// 	$item.=parse_template($item_tpl_current,$parse_item);
	}
	echo $item;//parse_template($tpl, array($item_parse=>$item));
}
else
	echo "Выберите категорию для отображения доп. полей";
//var_dump($_REQUEST['cats']);


?>
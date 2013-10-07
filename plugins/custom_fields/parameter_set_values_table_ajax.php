<?php
define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');
if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))//если куки нет совсем или идентификатор нормальный
    session_start();

define('root', substr(dirname( __FILE__ ), 0, -22));

include_once root.'/sys/engine.php';
include_once root.'/sys/mysql.php';
include_once root.'/sys/functions.php';
include_once 'options.php';

if(!in_array($_SESSION['user_group'], $custom_fields_config['allow_cf_control']))
	die("Access denied to custom_fields!");

$tpl=get_template('custom_fields_parameter_set_values_table',1);
preg_match("/\[item\](.*?)\[\/item\]/isu", $tpl, $entrie_out);
$item_tpl=$entrie_out[1];
$item_parse=$entrie_out[0];

$parameter_set_query = "SELECT {P}_parameter_set_values.id parameter_set_value_id, {P}_parameter_set_values.category_id, parameter_id, {P}_categories.name category_name, {P}_parameters.name parameter_name
FROM {P}_parameter_set_values
LEFT JOIN {P}_categories ON ( {P}_parameter_set_values.category_id = {P}_categories.id )
LEFT JOIN {P}_parameters ON ( {P}_parameter_set_values.parameter_id = {P}_parameters.id )
WHERE {P}_parameter_set_values.category_id =i<category_id>
ORDER BY {P}_parameters.name";

$parameter_set_sql = query($parameter_set_query,array('category_id'=>$_REQUEST['category_id']));
while($parameter_set_row = fetch_assoc($parameter_set_sql))
{
	$item_tpl_current=$item_tpl;

	$parse_item=array(
	'{id}'=>$parameter_set_row['parameter_set_value_id'],
	'{category_name}'=>$parameter_set_row['category_name'],
	'{parameter_name}'=>$parameter_set_row['parameter_name'],
	);

	$item.=parse_template($item_tpl_current,$parse_item);
}
echo parse_template($tpl, array($item_parse=>$item));
?>
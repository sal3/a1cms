<?php
error_reporting(7);
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

$tpl=get_template('custom_fields_parameter_values_table',1);
preg_match("/\[item\](.*?)\[\/item\]/isu", $tpl, $entrie_out);
$item_tpl=$entrie_out[1];
$item_parse=$entrie_out[0];

$parameters_query = "SELECT {P}_parameter_values.id parameter_value_id, parameter_id, name, value
from {P}_parameter_values
left join {P}_parameters on ({P}_parameter_values.parameter_id={P}_parameters.id)
where parameter_id=i<parameterID>
order by `value`";
$parameters_sql = query($parameters_query,array('parameterID'=>$_REQUEST['parameterID']));
while($parameters_row = fetch_assoc($parameters_sql))
{
	$item_tpl_current=$item_tpl;

	$parse_item=array(
	'{id}'=>$parameters_row['parameter_value_id'],
	'{value}'=>$parameters_row['value'],
	'{parameter_name}'=>$parameters_row['name'],
	);

	$item.=parse_template($item_tpl_current,$parse_item);
}
echo parse_template($tpl, array($item_parse=>$item));
?>

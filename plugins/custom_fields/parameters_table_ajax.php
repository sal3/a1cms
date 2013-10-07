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

$tpl=get_template('custom_fields_parameters_table',1);
preg_match("/\[item\](.*?)\[\/item\]/isu", $tpl, $entrie_out);
$item_tpl=$entrie_out[1];
$item_parse=$entrie_out[0];

$parameters_query = "SELECT {P}_parameters.name, {P}_parameters.type, {P}_parameters.id parameter_id, {P}_parameter_types.typename from {P}_parameters 
left join {P}_parameter_types on ({P}_parameters.type={P}_parameter_types.id)
ORDER by `name`";
$parameters_sql = query($parameters_query);
while($parameters_row = fetch_assoc($parameters_sql))
{
	$item_tpl_current=$item_tpl;

	if($parameters_row['type']==2 || $parameters_row['type']==4)
		$item_tpl_current=preg_replace("/\[\/?if-list\]/isu", '', $item_tpl_current);
	else
		$item_tpl_current=preg_replace("/\[if-list\](.*?)\[\/if-list\]/isu", '', $item_tpl_current);
		

	$parse_item=array(
	'{id}'=>$parameters_row['parameter_id'],
	'{name}'=>$parameters_row['name'],
	'{type}'=>$parameters_row['typename'],
	);

	$item.=parse_template($item_tpl_current,$parse_item);
}
echo parse_template($tpl, array($item_parse=>$item));
?>

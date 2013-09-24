<?php
if (!defined('a1cms'))
	die('Access denied to admin_config!');

if ($WHEREI['admincenter']==true and $_GET['plugin']=='admin_config')
{
	$parse_admin['{meta-title}']='Общие настройки сайта';
	include_once 'admin_config.php';
}
?>
<?
if (!defined('a1cms')) 
	die('Access denied!');

$query = "SELECT `name` FROM `{P}_users` WHERE `approved`=0";
$result=query($query);
if($engine_config['register_activate']=='mail')
	$echo.="Включена активация через email. Вручную активировать только в крайних случаях.<br /><br />";

				
while($row=fetch_assoc($result))
	$echo.="<a href='/admin/index.php?plugin=users&undermod=editusers&username=".$row['name']."'>{$row['name']}</a><br />";
	
?>

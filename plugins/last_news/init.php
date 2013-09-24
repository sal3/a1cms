<?
if (!defined('a1cms')) 
	die('Access denied to last_news!');

if ($WHEREI['main']==true)
{
	event_register('plugin_init_by_uri','last_news');

	include_once 'last_news.php';
}
elseif ($WHEREI['admincenter']==true and $_GET['plugin']=='last_news')
{
	if($_GET['mod']=='options_edit')
	{
		$parse_admin['{meta-title}']='Настройки последних новостей';
		include_once 'options_edit.php';
	}
}

?>
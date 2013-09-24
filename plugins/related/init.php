<?
if (!defined('a1cms')) 
	die('Access denied to related!');

if ($WHEREI['main']==true)
{
	event_register('plugin_init_before_fullnews_parse','related_news');

	include_once 'related.php';
}
elseif ($WHEREI['admincenter']==true and $_GET['plugin']=='related')
{
	if($_GET['mod']=='options_edit')
	{
		$parse_admin['{meta-title}']='Настройки похожих новостей';
		include_once 'options_edit.php';
	}
}

?>
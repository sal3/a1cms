<?
if (!defined('a1cms'))
	die('Access denied to admin_optimize!');

include_once 'options.php';

if ($WHEREI['admincenter']==true and $_GET['plugin']=='sitemap')
{          
	if(!in_array($_SESSION['user_group'], $sitemap_config['allow_control']))
		die("Access denied to sitemap!");

	if ($_GET['action']=='rebuild')
		include_once 'sitemap.php';
	elseif($_GET['action']=='options_edit')
	{
		$parse_admin['{meta-title}']='Настройки Sitemap';
		include_once 'options_edit.php';
	}
}
?>
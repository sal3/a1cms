<?
if (!defined('a1cms'))
	die('Access denied to admin_optimize!');

include_once 'options.php';

if ($WHEREI['admincenter']==true and $_GET['plugin']=='admin_optimize')
{          
	if(!in_array($_SESSION['user_group'], $optimize_config['allow_control']))
		die("Access denied to admin_optimize!");

	if (isset($_GET['undermod']) and $_GET['undermod']=='clear_cache')
	{
		clean_cache ();
		$parse_admin['{module}'] = "Кеш  очищен";
	}
	elseif (isset($_GET['undermod']) and $_GET['undermod']=='sitemap')
		include_once 'sitemap.php';

	elseif (isset($_GET['undermod']) and $_GET['undermod']=='stat_recount')
		include_once 'stat_recount.php';
}
?>
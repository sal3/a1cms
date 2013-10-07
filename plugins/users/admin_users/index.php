<?

if (!defined('a1cms'))
	die('Access denied!');

if (isset($_GET['undermod']) and $_GET['undermod']=='activate')
{
    include_once 'activate.php';
}
elseif(isset($_GET['undermod']) and $_GET['undermod']=='editusers')
{
    include_once 'editusers.php';
}
else
{

    if($engine_config['register_activate']=='hands' or $engine_config['register_activate']=='mail')
	$echo .= "<a href='/admin/index.php?plugin=users&undermod=activate'>Активировать пользователей</a><br/>";

    $echo .= "<a href='/admin/index.php?plugin=users&undermod=editusers'>Редактировать пользователей</a><br/>";
    //<a href='/admin/index.php?plugin=users&undermod=mults&action=view_mults'>Поиск мультов</a><br/>";
}


	$parse_module['{module}']=$echo;
	$tpl_file_path = get_template('module',1);
	$parse_admin['{module}'] = parse_template($tpl_file_path,$parse_module);
?>

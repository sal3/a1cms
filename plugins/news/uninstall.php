<?

if (!defined('a1cms'))
	die('Access denied!');

	$install_query1 = "DROP TABLE IF EXISTS `{P}_news`;";
	query($install_query1) or $error[] = "Ошибка деинсталляции _news";

	$install_query2 = "DROP TABLE IF EXISTS `{P}_views`;";
	query($install_query2) or $error[] = "Ошибка деинсталляции _views";
?>

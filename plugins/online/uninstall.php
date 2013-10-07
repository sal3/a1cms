<?

if (!defined('a1cms'))
	die('Access denied to online!');

	$install_query = "DROP TABLE IF EXISTS `{P}_online`;";
	query($install_query) or $error[] = "Ошибка деинсталляции _online";

?>

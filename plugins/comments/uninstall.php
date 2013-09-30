<?

if (!defined('a1cms'))
	die('Access denied to comments!');

	$install_query = "DROP TABLE IF EXISTS `{P}_comments`;";
	query($install_query);

?>

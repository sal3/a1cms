<?

if (!defined('a1cms')) 
	die('Access denied to smiles!');

event_register('before_toolbar_create','hook_before_toolbar_create');
event_register('before_bbcode_parse','hook_before_toolbar_create');

function hook_before_toolbar_create()
{
	global $SMILES,$engine_config;

	$SMILES=array(
	'angry' => $engine_config['site_path'].'/plugins/smiles/data/angry.gif',
	'biggrin' => $engine_config['site_path'].'/plugins/smiles/data/biggrin.gif',
	'blush' => $engine_config['site_path'].'/plugins/smiles/data/blush.gif',
	'confused' => $engine_config['site_path'].'/plugins/smiles/data/confused.gif',
	'cool' => $engine_config['site_path'].'/plugins/smiles/data/cool.gif',
	'crazy' => $engine_config['site_path'].'/plugins/smiles/data/crazy.gif',
	'cry' => $engine_config['site_path'].'/plugins/smiles/data/cry.gif',
	'down' => $engine_config['site_path'].'/plugins/smiles/data/down.gif',
	'kiss' => $engine_config['site_path'].'/plugins/smiles/data/kiss.gif',
	'sad' => $engine_config['site_path'].'/plugins/smiles/data/sad.gif',
	'shhh' => $engine_config['site_path'].'/plugins/smiles/data/shhh.gif',
	'smile' => $engine_config['site_path'].'/plugins/smiles/data/smile.gif',
	'surprise' => $engine_config['site_path'].'/plugins/smiles/data/surprise.gif',
	'thinking' => $engine_config['site_path'].'/plugins/smiles/data/thinking.gif',
	'tired' => $engine_config['site_path'].'/plugins/smiles/data/tired.gif',
	'tongue' => $engine_config['site_path'].'/plugins/smiles/data/tongue.gif',
	'undecide' => $engine_config['site_path'].'/plugins/smiles/data/undecide.gif',
	'up' => $engine_config['site_path'].'/plugins/smiles/data/up.gif',
	'upset' => $engine_config['site_path'].'/plugins/smiles/data/upset.gif',
	'wink' => $engine_config['site_path'].'/plugins/smiles/data/wink.gif',
	);
}


?>
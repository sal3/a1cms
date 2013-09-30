<?

global $_POST, $engine_config;

if ($_GET['action']=='del')
{
	preg_match_all ('#(https?://[\w-]+[\.\w-]+/((?!https?://)[\w- ./?%&=])+)#', $_POST['full_description_hidden'], $out_old);

	

}


if ($_POST)
{
preg_match_all ('#(https?://[\w-]+[\.\w-]+/((?!https?://)[\w- ./?%&=])+)#', $_POST['full_description_hidden'], $out_old);
	$old_img_arr=$out_old['0'];
preg_match_all ('#(https?://[\w-]+[\.\w-]+/((?!https?://)[\w- ./?%&=])+)#', $_POST['full_description'], $out_new);
	$new_img_arr=$out_new['0'];
}

if ($old_img_arr!=$new_img_arr)
{
	foreach ($old_img_arr as $img)
	{
		if (!in_array($img, $new_img_arr))
		{
			$img=str_replace($engine_config['images_path_http'], $engine_config['images_dir'], $img);
			//echo "<br/><br/>".$img;
			@unlink($img);
		}
	}

}


?> 

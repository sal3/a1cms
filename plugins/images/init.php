<?php

if (isset($WHEREI['admincenter']) and $WHEREI['admincenter']==true and $_GET['plugin']=='images' and $_GET['mod']=='options_edit')
{
	$parse_admin['{meta-title}']='Настройки изображений';
	include_once 'options_edit.php';
}

?>
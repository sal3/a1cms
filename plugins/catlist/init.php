<?php

if (!defined('a1cms')) 
	die('Access denied to catlist!');
	
	
if($WHEREI['main']==true)
{
	$parse_main['{plugin=catlist}']=get_template('catlist');
}

<?php
if (!defined('a1cms'))
	die('Access denied to admin_category-init!');
// global $WHEREI;
	
if ($WHEREI['admincenter']==true and $_GET['plugin']=='admin_category')
{
	$parse_admin['{meta-title}']='Категории';

	include_once "function.php";

	$category = CategoriesGet();

	$template = get_template('catlist', 1);

	$parse['{category_sort}']="<ol class=\"sortable\" id=\"cat_sortable\">".CategoriesSort()."</ol>";
	
	preg_match("/\[cat\s*subcatdelim=('|\")(.*?)('|\")\s*checked_selected=('|\")(.*?)('|\")+\s*\](.*?)\[\/cat\]/isu", $template, $cat_out);
	$news_parse[$cat_out['0']]=CategoriesSelect(0, 0, $cat_out[2], '', false, $cat_out[7], $cat_out[5]);
	$template=parse_template($template, $news_parse);
	
// 	$parse['{CategoriesSelect}']=CategoriesSelect();
	$parse_admin['{module}'] = parse_template($template, $parse);
}
?>
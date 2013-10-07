<?php
if (!defined('a1cms'))
	die('Access denied to admin_category!');

#*** Построение списка категорий для сортировки ***#
function CategoriesSort($pid=0, $subCat=false) 
{
	global $category;
	$cat_item = "";
	if(count($category)) 
	{
		foreach($category as $cats) 
		{
			if($cats['parentid'] == $pid) $root_category[] = $cats['id'];
		}
		if(count($root_category)) 
		{
			foreach($root_category as $id) 
			{
				$category_name = $cat[$id];
				$cat_item .= "<li id=\"list_{$category[$id]['id']}\"><div><b>".stripslashes($category[$id]['name'])."</b> <span class=\"catFunc\"><span class=\"catFunc_i\" id=\"catFunc_{$id}\"><a href=\"#\" onclick=\"categoryEdit('{$category[$id]['id']}'); return !1;\" class=\"btn\" ><i class=\"fam-pencil\"></i></a> <a href=\"#\" onclick=\"categoryDel('{$category[$id]['id']}'); return !1;\" class=\"btn\"><i class=\"fam-cross\"></i></a> <a href=\"#\" onclick=\"categoryDelConfirm('{$category[$id]['id']}'); return !1;\" class=\"btn btn-danger\">ДА</a> <a href=\"#\" onclick=\"categoryDelCancel('{$category[$id]['id']}'); return !1;\" class=\"btn btn-success\" >НЕТ</a></span></span></div>";
				$cat_item .= CategoriesSort($id, true);
			}
			if($subCat) return "<ol>".$cat_item."</ol>"; else return $cat_item;
		}
	}
}

?>
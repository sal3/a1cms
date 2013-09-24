<link rel="stylesheet" href="/plugins/admin_category/styles.css" type="text/css" media="screen, projection">

<script type="text/javascript" src="/plugins/admin_category/jquery.nestedSortable.js"></script>
<script type="text/javascript" src="/plugins/admin_category/function.js"></script>


<div class="general_block"><div class="container_">

<div class="row-fluid show-grid">
	<a href="#" onclick="categoryEdit(0); return !1;" class="btn btn-success span6"><i class="fam-add"></i> <b>Добавить категорию</b></a>
	<a href="#" onclick="categorySort(); return !1;" class="btn btn-info span6"><i class="fam-disk"></i> <b>Сохранить сортировку</b></a>
</div>

{category_sort}

<div class="row-fluid show-grid">
	<a href="#" onclick="categoryEdit(0); return !1;" class="btn btn-success span6"><i class="fam-add"></i> <b>Добавить категорию</b></a>
	<a href="#" onclick="categorySort(); return !1;" class="btn btn-info span6"><i class="fam-disk"></i> <b>Сохранить сортировку</b></a>
</div>

<div id="category_sort_info1" class="alert alert-block" style="display:none; text-align:center; margin:5px; padding:5px; font-weight:bold; position:absolute; right:0px; top:50px;"></div>

<div id="CategoryModal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header" style="padding: 3px 15px;">
		<h3 id="CategoryModalLabel"></h3>
	</div>
	<div class="modal-body">
		<div class="input-prepend">
			<span class="add-on" style="width:120px;">Название:</span>
			<input class="span2" style="width:380px;" id="cat_name" type="text" placeholder="Название категории">
		</div>
		<div class="input-prepend">
			<span class="add-on" style="width:120px;">Альтнейм:</span>
			<input class="span2" style="width:380px;" id="cat_url_name" type="text" placeholder="Альтеративное название">
		</div>
		<div class="input-prepend">
			<span class="add-on" style="width:120px;">Родитель:</span>
			<select style="width:394px;" id="cat_parentid">
				<option value="0"></option>
				[cat subcatdelim='&nbsp;' checked_selected='selected']<option value='{catid}' {attr}/><b>{catname}</b></option>[/cat]
			</select>
		</div>
		<div class="input-prepend">
			<span class="add-on" style="width:120px;">Описание:</span>
			<input class="span2" style="width:380px;" id="cat_description" type="text" placeholder="Описние категории, не более 200 символов">
		</div>
		<div class="input-prepend">
			<span class="add-on" style="width:120px;">Ключевые слова:</span>
			<textarea rows="3" style="width:380px;" id="cat_keywords" placeholder="Ключевые слова категории"></textarea>
		</div>
	</div>
	<div class="modal-footer" style="padding: 3px 15px;">
		<a href="#" class="btn" data-dismiss="modal"><i class="fam-cross"></i> Закрыть</a>
		<a href="#" class="btn btn-primary" onclick="categorySave(); return !1;"><i class="fam-disk"></i> Сохранить</a>
	</div>
</div>

</div></div>
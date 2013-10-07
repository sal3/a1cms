<script type="text/javascript" src="{site_path}/plugins/storage/options_edit.js"></script>

<h4>Настройки плагина "Склад"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<ul class="nav nav-tabs">
<!-- 		<li><a href="#content" data-toggle="tab"><i class="fam-map"></i> Изображения</a></li> -->
		<li class="active"><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<!--<div class="tab-pane " id="content">
		</div>-->

		<div class="tab-pane active" id="control">
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено управлять товарами:</span>
				<select name="allow_add_edit_goods[]" multiple>
					{allow_add_edit_goods}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено настраивать плагин:</span>
				<select name="allow_control[]" multiple>
					{allow_control}
				</select>
			</div>
		</div>
	</div>
<input type='submit' class='btn btn-success ' value='Сохранить'>
</form>
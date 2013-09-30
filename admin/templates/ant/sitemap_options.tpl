<script type="text/javascript" src="{site_path}/plugins/sitemap/sitemap.js"></script>

<h4>Настройки плагина "Sitemap"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<input type='hidden' name='bool_options' value='{bool_options}'>

	<ul class="nav nav-tabs">
<!-- 		<li ><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Контент</a></li> -->
		<li class="active"><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<!--<div class="tab-pane " id="content">
			
		</div>-->

		<div class="tab-pane active" id="control">
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено пересоздавать sitemap:</span>
				<select name="allow_rebuild_sitemap[]" multiple>
					{allow_rebuild_sitemap}
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
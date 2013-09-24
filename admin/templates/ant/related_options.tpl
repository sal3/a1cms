<script type="text/javascript" src="{site_path}/plugins/related/options_edit.js"></script>

<h4>Настройки плагина "Похожие"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Контент</a></li>
		<li><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="content">
			<div class="input-prepend">
				<span class="add-on adm_sp">Отображать похожих новостей:</span>
				<input class="adc_input_txt" name='limit' type="text" value='{limit}'>
			</div>
		</div>

		<div class="tab-pane " id="control">
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
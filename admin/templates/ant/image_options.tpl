<script type="text/javascript" src="{site_path}/plugins/images/options_edit.js"></script>
<!-- <link rel="stylesheet" href="/plugins/news/editconfig.css" type="text/css" media="screen, projection"> -->
<h4>Настройки плагина "Изображения"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#content" data-toggle="tab"><i class="fam-map"></i> Изображения</a></li>
		<li><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="content">
			<div class="input-prepend">
				<span class="add-on adm_sp">Заливка включена:</span>
				<input type="checkbox" name="site_work" id="site_work" value="{site_work}" {site_work_checked} hidden>
				<label for="site_work" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Шаблон:</span>
				<input class="adc_input_txt" name='template_name' type="text" value='{template_name}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Максимальный размер изображения, МБ:</span>
				<input class="adc_input_txt" name='max_size_mb' type="text" value='{max_size_mb}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Максимальная высота изображения, px:</span>
				<input class="adc_input_txt" name='max_height' type="text" value='{max_height}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Максимальная ширина изображения, px:</span>
				<input class="adc_input_txt" name='max_width' type="text" value='{max_width}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Ширина изображения на странице просмотра, px:</span>
				<input class="adc_input_txt" name='view_one_width' type="text" value='{view_one_width}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Ширина изображения после мультизагрузки, px:</span>
				<input class="adc_input_txt" name='view_multi_width' type="text" value='{view_multi_width}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Уменьшать качество изображения до, %:</span>
				<input class="adc_input_txt" name='quality' type="text" value='{quality}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">MIME-types, разрешенные к заливке:</span>
				<input class="adc_input_txt ant_tooltip" name='mimes' type="text" value='{mimes}' title='Разделитель - запятая, без пробелов'>
			</div>
			
			<div class="input-prepend">
				<span class="add-on adm_sp">CURL-таймаут удаленного соединения, сек:</span>
				<input class="adc_input_txt" name='curl_timeout' type="text" value='{curl_timeout}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">CURL юзер-агент:</span>
				<input class="adc_input_txt" name='curl_user_agent' type="text" value='{curl_user_agent}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Длина автогенерируемого имени изображений, символов:</span>
				<input class="adc_input_txt ant_tooltip" name='random_str_quantity' type="text" value='{random_str_quantity}' title='Не менее 5ти. При значении менее 5 - возможны проблемы'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Время кеширования количества загруженных изображений, сек:</span>
				<input class="adc_input_txt" name='cache_time' type="text" value='{cache_time}'>
			</div>
			
			
		</div>

		<div class="tab-pane" id="control">
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
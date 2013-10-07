<script type="text/javascript" src="{site_path}/plugins/comments/options_edit.js"></script>

<h4>Настройки плагина "Комментарии"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Комментарии</a></li>
		<li><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="content">
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешить добавление новых:</span>
				<input type="checkbox" name="enable_add_new_comments" id="enable_add_new_comments" value="{enable_add_new_comments}" {enable_add_new_comments_checked} hidden>
				<label for="enable_add_new_comments" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Отображать подпиcь под комментариями <b>*</b>:</span>
				<input type="checkbox" name="signature_enable" id="signature_enable" value="{signature_enable}" {signature_enable_checked} hidden>
				<label for="signature_enable" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Модерация комментариев <b>*</b>:</span>
				<input type="checkbox" name="moderation_enable" id="moderation_enable" value="{moderation_enable}" {moderation_enable_checked} hidden>
				<label for="moderation_enable" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Комментариев на странице:</span>
				<input class="adc_input_txt" name='comments_on_page' type="text" value='{comments_on_page}'>
			</div>
		</div>

		<div class="tab-pane" id="control">
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено добавлять комментарии:</span>
				<select name="allow_add_comments[]" multiple>
					{allow_add_comments}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено редактировать собственные:</span>
				<select name="allow_edit_own_comments[]" multiple>
					{allow_edit_own_comments}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено редактировать все:</span>
				<select name="allow_edit_all_comments[]" multiple>
					{allow_edit_all_comments}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено добавлять без модерации <b>*</b>:</span>
				<select name="allow_add_wout_moderation[]" multiple>
					{allow_add_wout_moderation}
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
	<p class="alert ui-state-info">* - еще не реализовано в плагине</p>
<input type='submit' class='btn btn-success ' value='Сохранить'>
</form>
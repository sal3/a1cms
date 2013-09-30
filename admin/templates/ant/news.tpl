<script type="text/javascript" src="{site_path}/plugins/news/news.js"></script>
<div class="addnews">
	<div id='post-id-{id}'>
		<form name='dataform' action='{action}' method='post' enctype='multipart/form-data'>
		<input name='newsid' id='newsid' type='hidden' value='{id}'>
		<div class=''>
			<div class=''>
					<b>Категории:</b><br />
					<div class='scrolled_categorys'>
						<select id='cat' name='cat[]' data-placeholder="Выберите категорию..." multiple class="chzn-select" style="width:100%;">
							[cat subcatdelim='&nbsp;' checked_selected='selected']<option value='{catid}' {attr}/><b>{catname}</b></option>[/cat]
						</select>
					</div>
			</div>
			<div class='news'>
				<table>
					<tr>
						<td><b>Название новости:</b></td>
						<td><b>Автор:</b></td>
					</tr>
					<tr>
						<td><input name='title' id='title' type='text' style='width:365px;' value='{title}'></td>
						<td><input name='user_name' type='text' style='width:130px;' value='{user_name}'>
							<input name='old_user_name' type='hidden' value='{user_name}'></td>
					</tr>
					<tr style="vertical-align: top;">
						<td><b>Ссылка на постер (картинку):</b><br />
							<input name='poster' type='text' id='poster' style='width:365px;' value='{poster}'></td>
						<td colspan='4'><b>Дата:</b><br />
							<div class="datepicker input-append date">
								<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="date" value="{date}"></input>
								<span class="add-on">
									<i data-time-icon="icon-time" data-date-icon="fam-date"></i>
								</span>
							</div>
							<label class='label'><input type='radio' name='dateradiobutton' value='now'>Текущая дата и время</label>
							<label class='label'><input type='radio' name='dateradiobutton' value='entered' checked>Указать дату</label>
						</td>
					</tr>
				</table>
				<b>Короткое описание (только текст):</b><br />
				{toolbar}
				<textarea name='short_description' id='short_description' class='editarea' style='width:97.5%; height:150px;'>{short_description}</textarea><br />

				<b>Полное описание:</b><br />
				<textarea name='full_description' id='full_description' class='editarea' style='width:97.5%; height:300px;'>{full_description}</textarea><br />
				[if-plugin-custom_fields]
					<b>Дополнительные поля:</b><br />
					<link media="screen, projection" type="text/css" href="{site_path}/plugins/custom_fields/custom_fields.css" rel="stylesheet"></link>
					<script src="{site_path}/plugins/custom_fields/custom_fields_parameter_newsform.js" type="text/javascript"></script>
					<table id="custom_parameters" class="table"></table>
				[/if-plugin-custom_fields]
				[if-plugin-storage]
					<b>Наличие на складе:</b><br />
					<script src="{site_path}/plugins/storage/storage.js" type="text/javascript"></script>
					<table id="storage" class="table"></table>
				[/if-plugin-storage]
			
				<table>
					<tr>
						<td class='span4'>[approved]<label><input type='checkbox' name='approved' value='checked' {approved}> Опубликовать</label>[/approved]</td>
						<td><b>Причина редактирования: </b><input name='edit_reason' type='text' style='width:250px;' value='{edit_reason}'></td>
					</tr>
					<tr>
						<td><label><input type='checkbox' name='show_on_main' value='checked' {show_on_main}> Публиковать на главной</label></td>
						<td><b>Опубликовал: </b><input name='approver' type='hidden' value='{approver}'>{approver}</td>
					</tr>
					<tr>
						<td><label><input type='checkbox' name='allow_comments' value='checked' {allow_comments}> Разрешить коментарии</label></td>
						<td><b>Редактировал: </b><input name='editor' type='hidden' value='{editor}'>{editor}</td>
					</tr>
					[extra]
						<tr>
							<td><label><input type='checkbox' name='pinned' value='checked' {pinned}> Зафиксировать</label></td>
							<td></td>
						</tr>
						<tr>
							
							<td></td>
						</tr>
					[/extra]
					<tr><td><label><input type='checkbox' name='on_moderation' value='checked' {on_moderation}> Оформление окончено</label></td></tr>

					{advanced_options}
				</table>

			</div><!--news-->

			<center>
				<button type='button' class='btn' onclick="document.dataform.action = 'index.php?plugin=news&mod=addnews&action=preview'; document.dataform.target='_blank'; document.dataform.submit();">Предпросмотр</button>
				<button type='button' class='btn' onclick="document.dataform.submit();">Отправить</button>
				<button type='button' class='btn' onclick="javascript:NewsDel({id});">Удалить</button>
				<br />
			</center>
			<br class='clearboth'>
		</div> <!--container-->
		</form>
	</div> <!--post-id-->
</div>

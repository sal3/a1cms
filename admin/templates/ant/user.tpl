<script type="text/javascript" src="{site_path}/plugins/users/user_edit.js"></script>

<div><h3>Пользователь: <span class="author_img"></span>{usertitle}</h3></div>
<div id="options">
<form id='userform' method='post' enctype='multipart/form-data'>
<input type="hidden" name="user_id" value="{user_id}" />
<table><tr>
	<td style="vertical-align: top;"><img src="{avatar}" /></td>
	<td>
		<table cellspacing="5" cellpadding="5">
		<tr>
			<td>Новый логин:</td>
			<td><input type="text" name="newlogin" value="" /></td>
		</tr>
		<tr>
			<td>Старый пароль:</td>
			<td><input type="password" name="old_password" /></td>
		</tr>
		<tr>
			<td>Новый пароль:</td>
			<td><input type="password" name="new_password" /></td>
		</tr>
		<tr>
			<td>Статус:</td>
			<td><select name="status">
			{status_list}
			</select>
			</td>
		</tr>
		<tr>
			<td>E-Mail:</td>
			<td><input type="text" name="email" value="{editmail}" /></td>
		</tr>
		<tr>
			<td>Имя:</td>
			<td><input type="text" name="realname" value="{realname}" /></td>
		</tr>
		<tr>
			<td>Страна:</td>
			<td><input type="text" name="country" value="{country}" /></td>
		</tr>
		<tr>
			<td>Страна:</td>
			<td><input type="text" name="city" value="{city}" /></td>
		</tr>
		<tr>
			<td>Номер ICQ:</td>
			<td><input type="text" name="icq" value="{icq}" /></td>
		</tr>
		<!--<tr>
			<td>IP:</td>
			<td>{ip}<input type="hidden" name="ip" value="{ip}"/></td>
		</tr>-->
		<tr>
			<td>Активирован:</td>
			<td><input type="checkbox" name="approved" value="1" {approved} /></td>
		</tr>
		<tr>
			<td>Фото:</td>
			<td><button class='btn' id='avatar_edit'>Изменить</button></td>
		</tr>
		<!--<tr>
			<td>Забанен:</td>
			<td><input type="checkbox" name="ban" value="1" {ban} />
			<input type="hidden" name="oldban" value="{ban}" />
			на <input type="text" name="bandays" value="{bandays}" size='2' />дней {bandate}
			Причина: <input type="text" name="bandescr" value="{bandescr}" /><br />
			Автор: {banauthor}</td>
		</tr>
		<tr>
			<td>Забанен по IP:</td>
			<td><input type="checkbox" name="ipban" value="1" {ipban} />
			<input type="hidden" name="oldipban" value="{ipban}" />
			на <input type="text" name="ipbandays" value="{ipbandays}" size='2' />дней {ipbandate}
			Причина: <input type="text" name="ipbandescr" value="{ipbandescr}" /><br />
			Автор: {ipbanauthor}</td>
		</tr>
		<tr>
			<td>Запрет на комментарии:</td>
			<td><input type="checkbox" name="bancomments" value="1" {bancomments} />
			<input type="hidden" name="oldbancomments" value="{bancomments}" />
			на <input type="text" name="bancommentsdays" value="{bancommentsdays}" size='2' />дней {bancommentsdate}
			Причина: <input type="text" name="bancommentsdescr" value="{bancommentsdescr}" /><br />
			Автор: {bancommentsauthor}</td>
		</tr>
		<tr>
			<td>Запрет на публикацию:</td>
			<td><input type="checkbox" name="banpost" value="1" {banpost} />
			<input type="hidden" name="oldbanbanpost" value="{banpost}" />
			на <input type="text" name="banpostdays" value="{banpostdays}" size='2' />дней {banpostdate}
			Причина: <input type="text" name="banpostdescr" value="{banpostdescr}" /><br />
			Автор: {banpostauthor}</td>
		</tr>-->
		<tr>
			<td>Новостей:</td>
			<td>{news_quantity}</td>
		</tr>
		<tr>
			<td>Комментариев:</td>
			<td>{comments_quantity}</td>
		</tr>
		<tr>
			<td>Дата регистрации:</td>
			<td>{registration_date}</td>
		</tr>
		<tr>
			<td>Последний визит:</td>
			<td>{last_visit_date}</td>
		</tr>
		<tr>
			<td>О себе:</td>
			<td><textarea name="info_about" style="width:460px; height:70px" class="f_textarea" />{editinfo}</textarea></td>
		</tr>
		<tr>
			<td>Подпись:</td>
			<td>{toolbar}
			<textarea name="signature" id="signaturearea" class='editarea' style='width:459px; height:150px;'/>{editsignature}</textarea></td>
		</tr>
		<tr>
			<td><input type="submit" class="btn btn-success" name="save" value="Сохранить"  /></td><td><input type="submit" class="btn btn-danger" name="delete_user" value="Удалить" /></td>
		</tr>

		</table>
	</td>
	</tr>
</table>
</form>
</div>
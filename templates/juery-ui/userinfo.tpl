<div class="ui-widget ui-widget-content ui-corner-all mymodule">
	<h3 class="ui-widget-header ui-corner-all"><span class="ui-icon text-icon ui-icon-person" title="пользователь"></span>{usertitle}</h3>
	<div class="widget-content">
	{errors}
		<table>
			<tr>
				<td valign="top" width="100">
					<img src="{avatar}" />
				</td>
				<td valign="top" style="padding: 15px;">
					Имя: {realname}<br />
					Группа: {status}<br />
					Дата регистрации: {registration}<br />
					Последнее посещение: {last_visit_date}<br />
				</td>
			</tr>
		</table>
		
		<div class="border2"></div>
				{pm}<br />
                                {email}<br />
                                <b>Страна:</b> {country}<br />
                                <b>Город:</b> {city}<br />
		<b>Номер ICQ:</b> {icq}<br />
		<b>Количество публикаций:</b> {news_quantity}<br />
		<b>Количество комментариев:</b> {comments_quantity}<br />
                                <b>О себе:</b> {info_about}<br />
		[signature]<div class='title_spoiler'>Подпись</div>
                                <div class='text_spoiler'>
                                    {signature}
                                </div>[/signature]

                [releases]<div class='title_spoiler'>Динамика новостей</div>
                <div class='text_spoiler'>
                    <table class='news_history'>
                        <tr class='title'><td>месяц</td><td>общее количество</td></tr>
                        [releasesentrie]<tr><td>{releases-date}</td><td>{releases-quantity}</td></tr>[/releasesentrie]
                        <tr class='title'><td>итого</td><td>{releases_sum}</td></tr>
                    </table>
                </div>[/releases]
		<br />
                    {news}<br />
                    {comments}<br />
                    {postcomments}
                [edit]                
		<div class="title_spoiler">{edituser}</div>
		
		<div class="text_spoiler">
			<b>Редактирование профиля</b><br /><br />
			
                        <form action='{action}' method='post' enctype='multipart/form-data'>
				<table cellspacing="5" cellpadding="5">
				<tr>
					<td>Ваш E-Mail:</td>
					<td>
					<input type="text" name="email" value="{editmail}" class="f_input" /> {hidemail}
					</td>
				</tr>
				<tr>
					<td>Ваше Имя:</td>
					<td><input type="text" name="realname" value="{realname}" class="f_input" /></td>
				</tr>
				<tr>
					<td>Страна:</td>
					<td><input type="text" name="country" value="{country}" class="f_input" /></td>
				</tr>
				<tr>
					<td>Город:</td>
					<td><input type="text" name="city" value="{city}" class="f_input" /></td>
				</tr>
				<tr>
					<td>Номер ICQ:</td>
					<td><input type="text" name="icq" value="{icq}" class="f_input" /></td>
				</tr>
				<tr>
					<td>Старый пароль:</td>
					<td><input type="password" name="altpass" class="f_input" /></td>
				</tr>
				<tr>
					<td>Новый пароль:</td>
					<td><input type="password" name="password1" class="f_input" id="newpass1" /></td>
				</tr>
				<tr>
					<td>Повторите:</td>
					<td><input type="password" name="password2" class="f_input" id="newpass2" /></td>
				</tr>
				<!--<tr>
					<td>Блокировка по IP:</td>
					<td><input type="text" name="allowed_ip" value="{allowed-ip}" class="f_input" /><br />Ваш текущий IP: {ip}</td>
				</tr>-->
				<tr>
					<td>Фото:</td>
					<td><input type="file" class="bbcodes" name="image" style="width:304px;">
					<br /><input type="checkbox" name="del_avatar" value="yes" />Удалить фотографию</td>
				</tr>
				<tr>
					<td>О себе:</td>
					<td><textarea name="info_about" style="width:460px; height:70px" class="f_textarea" />{editinfo}</textarea></td>
				</tr>
				<tr>
					<td>Подпись:</td>
					<td>{toolbar}
					<textarea name="signature" id="signaturearea" onclick="javascript:setlast('signaturearea');" style="width:460px; height:100px" class="f_textarea" />{editsignature}</textarea></td>
				</tr>
				<tr>
					<td><input type="submit" class="bbcodes" value="Отправить" name="submit" />
					<input name="submit" type="hidden" id="submit" value="submit" /></td>
				</tr>

				</table>
			</form>
		</div>
		[/edit]
</div>
</div>

<div class="ui-widget ui-widget-content ui-corner-all mymodule">
	<h3 class="ui-widget-header ui-corner-all">{title}</h3>
	<div class="widget-content"> 
	      Здравствуйте, уважаемый посетитель нашего сайта!<br />
             Регистрация на нашем ресурсе позволит Вам стать его полноценным участником. <br />
            Вы сможете добавлять новости на сайт, оставлять свои комментарии и многое другое.<br /><br />

<form name="formregister" action="index.php?do=register" method="post">

	<table cellpadding="4">
	<tr>
		<td>Логин *:</td>
		<td><input type="text" name="user_name" id='user_name' value='{user_name}'></td>
		</tr>
		<tr>
		<td>Пароль *:</td>
		<td><input type="password" name="password1"></td>
	</tr><tr>
		<td>Повторите пароль *:</td>
		<td><input type="password" name="password2"></td>
	</tr><tr>
		<td>Ваш E-Mail *:</td>
		<td><input type="text" name="email" value='{email}'></td>
	</tr>
	<tr>
		<td>Код безопасности:</td>
		<td>{reg_code}</td>
	</tr>
	<tr>
		<td>Введите код *:</td>
		<td><input type="text" name="key_code"></td>
	</tr>
	</table>

    * - обязательные к заполнению поля.

        <div class='title_spoiler' onclick="javascript:ShowOrHide('extend_info')">Необязательные поля</div>
        <div class='text_spoiler' id='extend_info'>
            <table cellpadding="4">
            <tr>
                    <td>Ваше Имя:</td>
                    <td><input type="text" name="realname" class="f_input"  value='{realname}'></td>
            </tr>
            <tr>
                    <td>Страна:</td>
                    <td><input type="text" name="country" value='{country}'></td>
            </tr>
            <tr>
                    <td>Город:</td>
                    <td><input type="text" name="city" value='{city}'></td>
            </tr>
            <tr>
                    <td>Номер ICQ:</td>
                    <td><input type="text" name="icq" value='{icq}'></td>
            </tr>
            <!--
            <tr>
                    <td>Фото:</td>
                    <td><input type="file" name="image"></td>
            </tr>
            -->
            <tr>
                    <td>О себе:</td>
                    <td><textarea name="info_about" style="width:320px; height:70px">{info_about}</textarea></td>
            </tr>
        </table>
        </div>
        <br />
        <input style="margin-left:155px;" type="submit" class="bbcodes" name="submit" alt="Отправить" value="Регистрация">
</form>
</div>
</div>

<form class="login" method="post" onsubmit="" action="{site_path}/index.php?auth=login">
	<table class="login noname">
		<tr>
			<td colspan="2"><input type="text" name="login_name" class="ui-input focus ui-corner-all" value="" /></td>
		</tr>
		<tr>
			<td><input type="password" name="login_password" class="ui-input focus ui-corner-all" value="" /></td>
			<td>
				<button id="button" class="ui-button ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text">Войти</span>
				</button>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="links"><a class="link" href="{link_regist}">Регистрация</a> / <a class="link" href="{link_lost}">Забыли пароль?</a></td>
		</tr>
	</table>
</form>
<div class="ui-widget ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all">Корзина</h3>
	
		<div class="order">

			<form name='dataform' action='/%D0%BE%D1%84%D0%BE%D1%80%D0%BC%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5-%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0' method='post' enctype='multipart/form-data'>
			
				<table class='related' id='related'>
					<tr class='title'>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr class=''>
						<td>*ФИО:</td>
						<td><input type="text" name="fio"></td>
					</tr>
					<tr class=''>
						<td>*Телефон:</td>
						<td><input type="text" name="phone"></td>
					</tr>
					<tr class=''>
						<td>*Email:</td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr class=''>
						<td>*Город:</td>
						<td><input type="text" name="city"></td>
					</tr>
					<tr class=''>
						<td>Способ доставки:</td>
						<td><select name="deliverytype">{deliverytype}</select></td>
					</tr>
					<tr class=''>
						<td>Комментарий:</td>
						<td><textarea name="comment"></textarea></td>
					</tr>
				</table>
				
				<br/>Поля отмеченные звёздочкой (*) обязательны для заполнения.
				<br/>
				<br/>
				
				<button id="button_clear" class="ui-button ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" onclick="document.dataform.submit();">
					<span class="ui-button-text">Оформить</span>
				</button>

			</form>
		</div>
	
	<div id='cart_inner' class="widget-content"></div>
</div>



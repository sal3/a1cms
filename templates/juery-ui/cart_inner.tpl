<table class='related' id='related'>
	<tr class='title'>
		<td>Артикул</td>
		<td>Картинка</td>
		<td>Название продукта</td>
		<td>Цена</td>
		<td>Количество</td>
		<td>Сумма</td>
		<td>Удалить</td>
	</tr>
	[entrie]<tr class=''>
		<td>{id}</td>
		<td><img src="{product_poster}" style="max-width:50px;"></td>
		<td>{view_link}</td>
		<td>{product_price}</td>
		<td><input type="text" id="quantity-{id}" pid="{id}" price="{product_price}" class="product_quantity" size="3" value="{product_quantity}"></td>
		<td id="sumprice-{id}" class="price_in"></td>
		<td><a href='#'><i class="fam-delete" title="Удалить" onClick="javascript:remove_from_cart({id}, '{product_name}');"></i></a></td>
	</tr>[/entrie]
</table>

<br/>

<button id="button_clear" class="ui-button ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" onclick="javascript:clear_cart();">
	<span class="ui-button-text">Очистить корзину</span>
</button>

<button id="button_order" class="ui-button ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" onclick="window.location.href='/%D0%BE%D1%84%D0%BE%D1%80%D0%BC%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5-%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0'">
	<span class="ui-button-text">Перейти к заказу</span>
</button>
<br/><br/>
Сумма товаров в корзине: <span id="cartsum">{total_cost}</span>
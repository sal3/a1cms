<script type="text/javascript" src="{site_path}/plugins/cart/options_edit.js"></script>

<h4>Настройки плагина "Корзина"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Основное</a></li>
		<li><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="content">
			<div class="input-prepend">
				<span class="add-on adm_sp">ID ценового поля в CustomField:</span>
				<input class="adc_input_txt" name='custom_field_price_id' type="text" value='{custom_field_price_id}'>
			</div>
			
			<h5>Письмо клиенту</h5>
			<div class="input-prepend">
				<span class="add-on adm_sp">Отсылать от имени:</span>
				<input class="adc_input_txt" name='user_from' type="text" value='{user_from}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Тема письма:</span>
				<input class="adc_input_txt" name='user_subject' type="text" value='{user_subject}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Текст письма:</span>
				<textarea class="adc_input_txt" name='user_message' style='height: 250px;'>{user_message}</textarea>
			</div>
			
			<h5>Письмо админу</h5>
			<div class="input-prepend">
				<span class="add-on adm_sp">Email админа:</span>
				<input class="adc_input_txt" name='admin_to' type="text" value='{admin_to}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Отсылать от имени:</span>
				<input class="adc_input_txt" name='admin_from' type="text" value='{admin_from}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Тема письма:</span>
				<input class="adc_input_txt" name='admin_subject' type="text" value='{admin_subject}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Текст письма:</span>
				<textarea class="adc_input_txt" name='admin_message' style='height: 250px;'>{admin_message}</textarea>
			</div>
			
			<h5>Доступные теги</h5>
			<p>{order_num} - id заказа</p>
			<p>{items_in_letter} - заказанные товары</p>
			<p>{cart_cost} - заказанные товары</p>
			<p>{fio} - ФИО заказчика</p>
			<p>{phone} - телефон заказчика</p>
			<p>{city} - город заказчика</p>
			<p>{email} - email заказчика</p>
			<p>{delivery_type} - выбранный способ доставки</p>
			<p>{comment} - комментарий к заказу</p>
			<p>{site_path_cart} - адрес сайта</p>
			<p>{site_title_cart} - название сайта (с настроек)</p>
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
	<!--<p class="alert ui-state-info">* - еще не реализовано в плагине</p>-->
<input type='submit' class='btn btn-success ' value='Сохранить'>
</form>
<div class="view">
	<div align="center">
		{width}x{height}, {size}<br/>
		<div class="prev">{img}</div>
	</div><br/>
	Прямая ссылка на картинку <button onclick="insertimage('{url_img}')">Вставить в текст</button> <button onclick="insertposter('{url_img}','#poster')">Постер!</button><br />
	<input value="{url_img}" size="100" class="code_fields" /><br />
	BB-код картинки <button onclick="insertimage('{bb_img}')">Вставить</button><br />
	<input value="{bb_img}" size="100" class="code_fields"/><br />

	<br />

	[one_img_prev]
	URL превью<br />
	<input value="{url_prev}" size="100" class="code_fields" /><br />
	BB-код превью+картинка <button onclick="insertimage('{bb_prev_and_img}')">Вставить</button><br />
	<input value="{bb_prev_and_img}" size="100" class="code_fields" /><br />
	<br />[/one_img_prev]
</div>

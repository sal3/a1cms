<link rel="stylesheet" href="/plugins/admin_config/styles.css" type="text/css" media="screen, projection">

<form name='configform' method='post' action = 'index.php?plugin=admin_config&action=save' enctype='multipart/form-data'>

<ul class="nav nav-tabs">
	<li class="active"><a href="#system" data-toggle="tab"><i class="fam-cog-add"></i> Система</a></li>
	<!--
	<li><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Контент</a></li>
	<li><a href="#users" data-toggle="tab"><i class="fam-user"></i> Пользователи</a></li>
	-->
	<li><a href="#img" data-toggle="tab"><i class="fam-map"></i> Изображения</a></li>
	<li><a href="#static" data-toggle="tab"><i class="fam-star"></i> Статические пути</a></li>
</ul>

<div class="tab-content">


	<div class="tab-pane active" id="system">
		<div class="input-prepend">
			<span class="add-on adm_sp">Название движка:</span>
			<input class="adc_input_txt" name='engine_name' type="text"  value='{engine_name}' disabled>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Версия движка:</span>
			<input class="adc_input_txt" name='engine_version' type="text"  value='{engine_version}' disabled>
		</div>
		<div class="input-prepend ant_tooltip" title="Тэг &lt;title&gt; главной страницы">
			<span class="add-on adm_sp">Полное название сайта:</span>
			<input class="adc_input_txt" name='site_title' type="text"  value='{site_title}'>
		</div>
		<div class="input-prepend ant_tooltip" title="Тэг &lt;title&gt; подстраниц">
			<span class="add-on adm_sp">Короткое название сайта:</span>
			<input class="adc_input_txt" name='site_short_title' type="text"  value='{site_short_title}'>
		</div>
		<div class="input-prepend ant_tooltip" title="Тэг meta description">
			<span class="add-on adm_sp">Описание сайта:</span>
			<textarea class="adc_input_txt" name='site_description'>{site_description}</textarea>
		</div>
		<div class="input-prepend ant_tooltip" title="Тэг meta keywords">
			<span class="add-on adm_sp">Ключевые слова сайта:</span>
			<textarea class="adc_input_txt" name='site_keywords'>{site_keywords}</textarea>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Кодировка:</span>
			<input class="adc_input_txt" name='charset' type="text"  value='{charset}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Если установлен в подкаталог'>
			<span class="add-on adm_sp">Подкаталог:</span>
			<input class="adc_input_txt" name='subfolder' type="text"  value='{subfolder}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Имя шаблона сайта:</span>
			<input class="adc_input_txt" name='template_name' type="text"  value='{template_name}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Имя шаблона админки:</span>
			<input class="adc_input_txt" name='admin_template_name' type="text"  value='{admin_template_name}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Включить кэш:</span>
			<input type="checkbox" name="cache_enable" id="cache_enable" value="{cache_enable}" {cache_enable_checked} hidden>
			<label for="cache_enable" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Каталог кэша:</span>
			<input class="adc_input_txt" name='cache_dir_config' type="text" value='{cache_dir_config}'>
		</div>
	</div>

<!--
	<div class="tab-pane" id="content">
		<div class="input-prepend">
			<span class="add-on adm_sp">Новостей на странице:</span>
			<input class="adc_input_txt" name='news_on_page' type="text" value='{news_on_page}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Новостей на странице списка новостей:</span>
			<input class="adc_input_txt" name='news_on_page_alt' type="text" value='{news_on_page_alt}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Количество отображаемых ссылок-страниц в меню навигации (в конце страницы, под короткими новостями)'>
			<span class="add-on adm_sp">Cтраниц в меню навигации:</span>
			<input class="adc_input_txt" name='pagelinks' type="text" value='{pagelinks}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Новостей на страницу в админке:</span>
			<input class="adc_input_txt" name='news_in_admin_on_page' type="text" value='{news_in_admin_on_page}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Если сменился альтнейм, вычисляет правильную новость по ID новости и перенаправляет на правильный путь новости'>
			<span class="add-on adm_sp">Правильные пути новостей:</span>
			<input type="checkbox" id="redirect_to_rigth_news_path" name="redirect_to_rigth_news_path" value="{redirect_to_rigth_news_path}" {redirect_to_rigth_news_path_checked} hidden>
			<label for="redirect_to_rigth_news_path" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Минимальная длина названия новости:</span>
			<input class="adc_input_txt" name='min_title_length' type="text" value='{min_title_length}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Максимальная длина названия новости:</span>
			<input class="adc_input_txt" name='max_title_length' type="text" value='{max_title_length}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Максимальный размер постера, байт:</span>
			<input class="adc_input_txt" name='max_poster_size' type="text" value='{max_poster_size}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Общий или индивидуальный постер на короткую и полную новости'>
			<span class="add-on adm_sp">Общий постер:</span>
			<input type="checkbox" id="common_poster" name="common_poster" value="{common_poster}" {common_poster_checked} hidden>
			<label for="common_poster" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Минимально символов в полной новости:</span>
			<input class="adc_input_txt" name='min_full_text' type="text" value='{min_full_text}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Всегда генерировать мета-описание и ключевые слова при создании новой новсти'>
			<span class="add-on adm_sp">Мета-описание и ключевые слова:</span>
			<input type="checkbox" id="always_regenerate_meta" name="always_regenerate_meta" value="{always_regenerate_meta}" {always_regenerate_meta_checked} hidden>
			<label for="always_regenerate_meta" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend ant_tooltip">
			<span class="add-on adm_sp">Кешировать количество просмотров:</span>
			<input type="checkbox" id="cache_news_views" name="cache_news_views" value="{cache_news_views}" {cache_news_views_checked} hidden>
			<label for="cache_news_views" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend ant_tooltip" title='В секундах'>
			<span class="add-on adm_sp">Период обновления просмотров:</span>
			<input class="adc_input_txt" name='news_views_taskperiod' type="text" value='{news_views_taskperiod}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Активировать RSS:</span>
			<input type="checkbox" id="rss_enable" name="rss_enable" value="{rss_enable}" {rss_enable_checked} hidden>
			<label for="rss_enable" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Короткое название сайта в RSS:</span>
			<input type="checkbox" id="site_short_title_to_rsstitle" name="site_short_title_to_rsstitle" value="{site_short_title_to_rsstitle}" {site_short_title_to_rsstitle_checked} hidden>
			<label for="site_short_title_to_rsstitle" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
	</div>

	<div class="tab-pane" id="users">
		<div class="input-prepend ant_tooltip" title='mail - письмо на почту указанную при регистрации, hands - руками, пусто - без активации'>
			<span class="add-on adm_sp">Активировать с помощью:</span>
			<input class="adc_input_txt" name='register_activate' type="text" value='{register_activate}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Недоступные для регистрации логины'>
			<span class="add-on adm_sp">Зарезервированные логины:</span>
			<input class="adc_input_txt" name='reserved_logins' type="text" value='{reserved_logins}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Активировать ipban:</span>
			<input type="checkbox" id="ipban_enable" name="ipban_enable" value="{ipban_enable}" {ipban_enable_checked} hidden>
			<label for="ipban_enable" class="btn checkbox"><i class="fam-tick"></i></label>
		</div>
	</div>
-->

	<div class="tab-pane" id="img">
		<div class="input-prepend ant_tooltip">
			<span class="add-on adm_sp">Каталог аватаров:</span>
			<input class="adc_input_txt" name='avatar_dir_config' type="text" value='{avatar_dir_config}'>
		</div>
		<div class="input-prepend ant_tooltip">
			<span class="add-on adm_sp">Каталог загуженных изображений:</span>
			<input class="adc_input_txt" name='images_dir_config' type="text" value='{images_dir_config}'>
		</div>
		<div class="input-prepend ant_tooltip" title='Адрес доверенного(ых) фотохоста(ов) в формате regexp для заливки пользователями изображений'>
			<span class="add-on adm_sp">Адрес фотохоста в regexp формате:</span>
			<input class="adc_input_txt" name='http_photohost_name_regexp' type="text" value='{http_photohost_name_regexp}'>
		</div>
		<div class="input-prepend ant_tooltip" title="в директории шаблона">
			<span class="add-on adm_sp">Аватар по умолчанию:</span>
			<input class="adc_input_txt" name='default_avatar_path_config' type="text" value='{default_avatar_path_config}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Доспустимые расширения аватаров:</span>
			<input class="adc_input_txt" name='alloved_avatar_ext' type="text" value='{alloved_avatar_ext}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Максимальная ширина аватара, px:</span>
			<input class="adc_input_txt" name='alloved_avatar_maxwidth' type="text" value='{alloved_avatar_maxwidth}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Максимальная высота аватара, px:</span>
			<input class="adc_input_txt" name='alloved_avatar_maxheight' type="text" value='{alloved_avatar_maxheight}'>
		</div>
		<div class="input-prepend ant_tooltip">
			<span class="add-on adm_sp">Максимальный размер аватара, КБ:</span>
			<input class="adc_input_txt" name='alloved_avatar_maxsize' type="text" value='{alloved_avatar_maxsize}'>
		</div>
		<div class="input-prepend">
			<span class="add-on adm_sp">Смайлы:</span>
			<input class="adc_input_txt" name='smiles' type="text" value='{smiles}'>
		</div>
	</div>

	<div class="tab-pane" id="static">
		<p>Адрес сайта:
		<br/>{site_path}</p>
		<p>HTTP путь аватаров:
		<br/>{http_avatar_path}</p>
		<p>Каталог шаблона:
		<br/>{template_path}</p>
		<p>HTTP адрес шаблона:
		<br/>{template_path_http}</p>
		<p>Каталог шаблона админки:
		<br/>{admincenter_tpl_path}</p>
		<p>Каталог аватаров:
		<br/>{avatar_dir}</p>
		<p>Каталог изображений:
		<br/>{images_dir}</p>
		<p>Каталог кэша:
		<br/>{cache_dir}</p>
		<p>Каталог кешированых категорий:
		<br/>{cat_cache_dir}</p>
		<p>Кэш категорий:
		<p>{cat_array_cache_file}</p>
		<p>{cat_url_names_cache_file}</p>
		<p>{cat_parent_altnames_array}</p>
	</div>

</div>
<input type='submit' class='btn btn-success' value='Сохранить'>
</form>
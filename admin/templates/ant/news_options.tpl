<script type="text/javascript" src="{site_path}/plugins/news/news.js"></script>

<h4>Настройки плагина "Новости"</h4>
<form id="configform" name='configform' method='post' action = '#' enctype='multipart/form-data'>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#content" data-toggle="tab"><i class="fam-page-white-star"></i> Контент</a></li>
		<li><a href="#control" data-toggle="tab"><i class="fam-user"></i> Доступ</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="content">
			<div class="input-prepend">
				<span class="add-on adm_sp">Использовать кэш:</span>
				<input type="checkbox" name="use_cache" id="use_cache" value="{use_cache}" {use_cache_checked} hidden>
				<label for="use_cache" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp ant_tooltip" title='Отображать новости на главной'>Новости на главной:</span>
				<input type="checkbox" name="news_on_main" id="news_on_main" value="{news_on_main}" {news_on_main_checked} hidden>
				<label for="news_on_main" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp ant_tooltip" title='Запретить публиковать посты без постера'>Требовать постер:</span>
				<input type="checkbox" name="require_poster" id="require_poster" value="{require_poster}" {require_poster_checked} hidden>
				<label for="require_poster" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend ant_tooltip" title='Если сменился альтнейм, вычисляет правильную новость по ID новости и перенаправляет на правильный путь новости'>
				<span class="add-on adm_sp">Правильные пути новостей:</span>
				<input type="checkbox" id="redirect_to_rigth_news_path" name="redirect_to_rigth_news_path" value="{redirect_to_rigth_news_path}" {redirect_to_rigth_news_path_checked} hidden>
				<label for="redirect_to_rigth_news_path" class="btn checkbox"><i class="fam-tick"></i></label>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Новостей на странице:</span>
				<input class="adc_input_txt" name='news_on_page' type="text" value='{news_on_page}'>
			</div>
			<div class="input-prepend ant_tooltip" title='Количество отображаемых ссылок-страниц в меню навигации (в конце страницы, под короткими новостями)'>
				<span class="add-on adm_sp">Cтраниц в меню навигации:</span>
				<input class="adc_input_txt" name='pagelinks' type="text" value='{pagelinks}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Новостей на страницу в админке:</span>
				<input class="adc_input_txt" name='news_in_admin_on_page' type="text" value='{news_in_admin_on_page}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Время жизни кеша короткой новости, сек</span>
				<input class="adc_input_txt" name='short_cache_time' type="text" value='{short_cache_time}'>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Время жизни кеша полной новости, сек</span>
				<input class="adc_input_txt" name='full_cache_time' type="text" value='{full_cache_time}'>
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
			<div class="input-prepend">
				<span class="add-on adm_sp">Минимально символов в полной новости:</span>
				<input class="adc_input_txt" name='min_full_text' type="text" value='{min_full_text}'>
			</div>
			<div class="input-prepend ant_tooltip" title='Всегда генерировать мета-описание и ключевые слова при создании новой новсти'>
				<span class="add-on adm_sp">Автогенерация описания и ключевых слов:</span>
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
			<div class="input-prepend">
				<span class="add-on adm_sp">Количество новостей в RSS:</span>
				<input class="adc_input_txt" name='rss_limit' type="text" value='{rss_limit}'>
			</div>
		</div>

		<div class="tab-pane" id="control">
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено добавлять новости:</span>
				<select name="allow_add_posts[]" multiple>
					{allow_add_posts}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено редактировать собственные:</span>
				<select name="allow_edit_own_posts[]" multiple>
					{allow_edit_own_posts}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено редактировать все новости:</span>
				<select name="allow_edit_all_posts[]" multiple>
					{allow_edit_all_posts}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено публиковать на главной:</span>
				<select name="allow_post_main[]" multiple>
					{allow_post_main}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено добавлять без модерации:</span>
				<select name="allow_post_wout_moderation[]" multiple>
					{allow_post_wout_moderation}
				</select>
			</div>
			<div class="input-prepend">
				<span class="add-on adm_sp">Разрешено настраивать плагин:</span>
				<select name="allow_configure_news[]" multiple>
					{allow_configure_news}
				</select>
			</div>
		</div>
	</div>
<!-- 	<p class="alert ui-state-info">* - еще не реализовано в плагине</p> -->
<input type='submit' class='btn btn-success ' value='Сохранить'>
</form>
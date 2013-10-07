<div class="ui-widget ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all"><a href="{full-link}">{title}</a></h3>
	<div class="widget-content">
		<span class="ui-icon text-icon ui-icon-folder-collapsed" title="категория"></span>{link-category}
		<a href="{full-link}"><img src="{poster}" alt="{safe_title}" class="poster ui-corner-all" onerror="imgError(this);"/></a>
			<div class="widget-content">
				{short-story}
				<div style="clear:both;"></div>
			</div>
			<span class="ui-icon text-icon ui-icon-person" title="автор"></span>[if-plugin-users]<a href="{author_link}">[/if-plugin-users]{author_name}[if-plugin-users]</a>[/if-plugin-users]
			<span class="ui-icon text-icon ui-icon-calendar" title="добавлено"></span>{date}
			[edit|{author_name}]<span class="ui-icon text-icon ui-icon-pencil" title="правка"></span><a href="#" data-dropdown="#dropdown-{newsid}">Правка</a>
				<div id="dropdown-{newsid}" class="dropdown-menu has-tip">
					<ul>
						<li><a href="javascript:PostEdit('{newsid}', 'short')">Быстрое редактирование</a></li>
						<li><a href="{site_path}/admin/index.php?plugin=admin_news&mod=editnews&amp;action=editnews&amp;newsid={newsid}">Полное редактирование</a></li>
						<li class="divider"></li>
						<li><a href="#" onClick="javascript:PostDel('{newsid}'); return false;"> Удалить</a></li>
					</ul>
				</div>
			[/edit]
			<span class="ui-icon text-icon ui-icon-star" title="просмотров"></span>{views}
			[if-plugin-comments]<span class="ui-icon text-icon ui-icon-comment" title="комментариев"></span><a href="{full-link}#comments">{comments-num}</a>[/if-plugin-comments]
			<a href="{full-link}"><span class="ui-icon text-icon ui-icon-circle-arrow-e" title="подробнее о {safe_title}"></span><b>Подробнее</b></a>		
	</div>
</div>
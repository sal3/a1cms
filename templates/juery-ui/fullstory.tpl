<div class="ui-widget ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all"><a href="{full-link}">{title}</a></h3>
	<div class="widget-content">
				<span class="ui-icon text-icon ui-icon-folder-collapsed" title="категория"></span>{link-category}<br />
				<span class="ui-icon text-icon ui-icon-person" title="автор"></span>[if-plugin-users]<a href="{author_link}">[/if-plugin-users]{author_name}[if-plugin-users]</a>[/if-plugin-users]
				| <span class="ui-icon text-icon ui-icon-calendar" title="добавлено"></span>{date}
				| [edit|{author_name}]<span class="ui-icon text-icon ui-icon-pencil" title="правка"></span><a href="#" data-dropdown="#dropdown-{newsid}">Правка</a>
					<div id="dropdown-{newsid}" class="dropdown-menu has-tip">
						<ul>
							<li><a href="javascript:PostEdit('{newsid}', 'full')">Быстрое редактирование</a></li>
							<li><a href="/admin/index.php?plugin=admin_news&mod=editnews&amp;action=editnews&amp;newsid={newsid}">Полное редактирование</a></li>
							<li class="divider"></li>
							<li><a href="#" onClick="javascript:PostDel('{newsid}'); return false;"> Удалить</a></a></li>
						</ul>
					</div>
				[/edit]



		<div align="center"><img src="{poster}" alt="{safe_title}" class="ui-corner-all" onerror="imgError(this);"/>

		</div><br /><br />
		{full-story}<br />

			<div class="comments">
				Просмотрели: {views}
			</div>
	</div>
</div>
[if-plugin-related]{plugin=related}[/if-plugin-related]
[if-plugin-comments]{plugin=comments}[/if-plugin-comments]
<div class="comment">
	<div class="ui-widget ui-widget-content ui-corner-all ">

			<span class="ui-icon text-icon ui-icon-person" title="автор"></span><a href="{author-url}" class="nickcolor_{group_id}">{author}</a> ({group_name}) {news_title} &gt;&gt; {date}
			[com-edit]<span class="ui-icon text-icon ui-icon-pencil" title="правка"></span><a href="#" data-dropdown="#dropdown-{commentid}">Правка</a>
					<div id="dropdown-{commentid}" class="dropdown-menu has-tip">
						<ul>
							<li><a href="#" onClick="{comment_edit}">Редактировать</a></li>
							<li><a href="#" onClick="{comment_delete}"> Удалить</a></li>
						</ul>
					</div>[/com-edit]
		<div class="widget-content">
			<img src="{avatar}" alt="{author_encoded}" title="{author_encoded}" class="avatar" />
			{comment}
			<div class="clr"></div>
		</div>
	</div>
</div>
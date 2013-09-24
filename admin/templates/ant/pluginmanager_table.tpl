<table class="table">
	<tr><th></th><th>Название</th><th></th><th>Статус</th><th>Инсталляция</th><th></th></tr>
	[item]
	<tr class="plugin_{name}">
	<td><img src="{site_path}/plugins/{name}/{icon}"></td>
	<td><!--<a href='{site_path}/admin/index.php?plugin={name}&mod=exec' title='настройки плагина'>--> {title}<!--</a>--> <br /><small class='muted'>{name} {version}</small></td>
	<td><a href="javascript:pluginInfo('{name}');" class='btn ant_tooltip' title='Информация о плагине'><i class="fam-information"></i></a></td>
		<td><span class='label {state-style}'>{state}</span></td>
		<td><span class='label {install-state-style}'>{install-state}</span></td>
		<td>
			
			<span class="actions">
				<span class="actions_url itemDel_{name}">
					<a href="javascript:pluginEdit('{name}');" class='btn'><i class="fam-pencil"></i></a>
					<a href="javascript:[not-disable]itemDel('{name}')[/not-disable];" class='btn {delete-button-style}' title='удалить плагин'><i class="fam-cross"></i></a>
					<a href="javascript:pluginDelConfirm('{name}');" class="btn btn-danger">Да</a>
					<a href="javascript:itemDelCancel('{name}');" class="btn btn-success">Нет</a>
				</span>
			</span>
		</td>
	</tr>
	[/item]
</table>

<div class="row-fluid show-grid">
	<a href="javascript:parameterAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить параметр</b></a>
</div>
<table class="table">
	<tr>
	<th>Название</th><th>Тип</th><th></th></tr>
	[item]<tr class="parameter_{id}"><td>[if-list]<a href="{site_path}/admin/index.php?plugin=custom_fields&action=parameter_values&id={id}">[/if-list]{name}[if-list]</a>[/if-list]</td><td>{type}</td>
	<td>
		<span class="actions">
			<span class="actions_url itemDel_{id}">
				<a href="javascript:parameterEdit('{id}');" class='btn'><i class="fam-pencil"></i></a>
				<a href="javascript:itemDel('{id}');" class='btn ant_tooltip {delete-button-style}'><i class="fam-cross" title="удалить"></i></a>
				<a href="javascript:parameterDelConfirm('{id}');" class="btn btn-danger">ДА</a>
				<a href="javascript:itemDelCancel('{id}');" class="btn btn-success">НЕТ</a>
			</span>
		</span>
	</td>
	</tr>[/item]
</table>
<div class="row-fluid show-grid">
	<a href="javascript:parameterAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить параметр</b></a>
</div>

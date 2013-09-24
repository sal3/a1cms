<div class="row-fluid show-grid">
	<a href="javascript:parameter_setValueAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить значение набора</b></a>
</div>
<table class="table">
	<tr>
	<th>Параметр</th><th>Категория</th><th></th></tr>
	[item]<tr class="parameter_setValue_{id}"><td>{parameter_name}</td><td>{category_name}</td>
	<td>
		<span class="actions">
			<span class="actions_url itemDel_{id}">
				<a href="javascript:parameter_setValueEdit('{id}');" class='btn' style="visibility:hidden;"><i class="fam-pencil"></i></a>
				<a href="javascript:itemDel('{id}');" class='btn ant_tooltip {delete-button-style}'><i class="fam-cross" title="удалить"></i></a>
				<a href="javascript:parameter_setValueDelConfirm('{id}');" class="btn btn-danger">ДА</a>
				<a href="javascript:itemDelCancel('{id}');" class="btn btn-success">НЕТ</a>
			</span>
		</span>
	</td>
	</tr>[/item]
</table>
<div class="row-fluid show-grid">
	<a href="javascript:parameter_setValueAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить значение набора</b></a>
</div>
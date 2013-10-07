<div class="row-fluid show-grid">
	<a href="javascript:parameterValueAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить значение параметра</b></a>
</div>
<table class="table">
	<tr>
	<th>Значение</th><th>Параметр</th><th></th></tr>
	[item]<tr class="parameterValue_{id}"><td>{value}</td><td>{parameter_name}</td>
	<td>
		<span class="actions">
			<span class="actions_url itemDel_{id}">
				<a href="javascript:parameterValueEdit('{id}');" class='btn'><i class="fam-pencil"></i></a>
				<a href="javascript:itemDel('{id}');" class='btn ant_tooltip {delete-button-style}'><i class="fam-cross" title="удалить"></i></a>
				<a href="javascript:parameterValueDelConfirm('{id}');" class="btn btn-danger">ДА</a>
				<a href="javascript:itemDelCancel('{id}');" class="btn btn-success">НЕТ</a>
			</span>
		</span>
	</td>
	</tr>[/item]
</table>
<div class="row-fluid show-grid">
	<a href="javascript:parameterValueAdd();" class="btn btn-success span12"><i class="fam-add"></i> <b>Добавить значение параметра</b></a>
</div>
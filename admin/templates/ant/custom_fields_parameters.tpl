<link media="screen, projection" type="text/css" href="{site_path}/plugins/custom_fields/custom_fields.css" rel="stylesheet"></link>
<script src="{site_path}/plugins/custom_fields/parameters.js" type="text/javascript"></script>
<script type="text/javascript">editLabel='{editLabel}';addLabel='{addLabel}';okSaveName='{okSaveName}';okAddName='{okAddName}';</script>
<div id="custom_fields_parameters"></div>

<!-- Modal -->
<div id="parameterModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="parameterLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="parameterLabel"></h3>
	</div>
	<div class="modal-body">
		<div class="modal-body-items">
			<div id="modal-body-general">
				<div class="input-prepend">
					<span class="add-on modalAdd-on">Название:</span>
					<input id="parameterName" type="text" class="modalInput-prepend">
				</div>
				<div class="input-prepend" id="parameterType">
					<span class="add-on modalAdd-on">Тип:</span>
					<select id="parameterTypeSelect" class="modalSelect">
						{parameter_typesList}
					</select>
				</div>
			</div>
			<div id="modal-body-wait"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
		<button class="btn btn-primary" id="okButton">Сохранить</button>
	</div>
</div>
<link media="screen, projection" type="text/css" href="{site_path}/plugins/custom_fields/custom_fields.css" rel="stylesheet"></link>
<script src="{site_path}/plugins/custom_fields/parameter_set_values.js" type="text/javascript"></script>
<script type="text/javascript">editLabel='{editLabel}';addLabel='{addLabel}';okSaveName='{okSaveName}';okAddName='{okAddName}';category_id='{category_id}';</script>
<div id="custom_fields_parameter_setValues"></div>

<!-- Modal -->
<div id="parameter_setValueModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="parameter_setValueLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="parameter_setValueLabel"></h3>
	</div>
	<div class="modal-body">
		<div class="modal-body-items">
			<div id="modal-body-general">
				<div class="input-prepend modalInput-prepend">
					<span class="add-on modalAdd-on">Параметр:</span>
					<select id="parametersList" class="modalSelect">
						{parametersList}
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
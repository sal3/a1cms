<link media="screen, projection" type="text/css" href="{site_path}/plugins/custom_fields/custom_fields.css" rel="stylesheet"></link>
<script src="{site_path}/plugins/custom_fields/parameter_values.js" type="text/javascript"></script>
<script type="text/javascript">editLabel='{editLabel}';addLabel='{addLabel}';okSaveName='{okSaveName}';okAddName='{okAddName}';parameterID='{parameterID}';</script>
<div id="custom_fields_parameterValues"></div>

<!-- Modal -->
<div id="parameterValueModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="parameterValueLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="parameterValueLabel"></h3>
	</div>
	<div class="modal-body">
		<div class="modal-body-items">
			<div id="modal-body-general">
				<div class="input-prepend">
					<span class="add-on modalAdd-on">Значение:</span>
					<input id="parameterValueName" type="text" class="modalInput-prepend">
				</div>
				<!--<div class="input-prepend" id="parameterValueType">
					<span class="add-on">Параметр:</span>
					<select id="parameter">
						{parametersList}
					</select>
				</div>-->
			</div>
			<div id="modal-body-wait"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
		<button class="btn btn-primary" id="okButton">Сохранить</button>
	</div>
</div>
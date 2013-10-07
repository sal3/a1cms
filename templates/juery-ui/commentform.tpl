<div class="ui-widget ui-widget-content ui-corner-all" id="commentform">
	<h3 class="ui-widget-header ui-corner-all">Добавить комментарий:</h3>
	<div class="widget-content">
		<form onkeypress="ctrlEnter(event, this);">
			{toolbar}
			<textarea name='comment' class='editarea' id='comment'></textarea>
			<center>
				<button id="comm_submit_btn" onClick="{button_action}" aria-disabled="false" role="button" class="ui-button ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">Отправить (Ctrl-Enter)</span>
				</button>
			</center>
		</form>
		<div class="clr"></div>
	</div>
</div>

<link media="screen, projection" type="text/css" href="{site_path}/plugins/admin_pluginmanager/pluginmanager.css" rel="stylesheet"></link>
<script src="{site_path}/plugins/admin_pluginmanager/pluginmanager.js" type="text/javascript"></script>
<ul class="nav nav-tabs">
	<li class="active" id="active"><a href="javascript:getPluginsTable('active');"><i class="fam-accept"></i> Активные</a></li>
	<li id="inactive"><a href="javascript:getPluginsTable('inactive');"><i class="fam-stop"></i> Отключенные</a></li>
	<li id="installed"><a href="javascript:getPluginsTable('installed');"><i class="fam-plugin-add"></i> Инсталированные</a></li>
	<li id="uninstalled"><a href="javascript:getPluginsTable('uninstalled');"><i class="fam-plugin-disabled"></i> Не инсталированные</a></li>
	<li id="all"><a href="javascript:getPluginsTable('all');"><i class="fam-plugin"></i> Все</a></li>
</ul>

<div id="pluginsTable"></div>


<!-- Modal -->
<div id="pluginConfigModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="pluginConfigLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="pluginConfigLabel"></h3>
	</div>
	<div class="modal-body">
		<div class="modal-body-items">
			<div id="modal-body-general">
				<div class="btn-group" data-toggle="buttons-radio">
					<button type="button" class="btn btn-success inst_on_btn" id="plugin_on">Включен</button>
					<button type="button" class="btn inst_on_btn" id="plugin_off">Выключен</button>
				</div>
				<div class="btn-group" data-toggle="buttons-radio">
					<button type="button" class="btn btn-success inst_on_btn" id="plugin_installed" data-loading-text="Инсталяция...">Инсталирован</button>
					<button type="button" class="btn inst_on_btn" id="plugin_uninstalled" data-loading-text="Деинсталяция...">Деинсталирован</button>
				</div>
				<br />
				<br />
				<div class="input-prepend">
					<span class="add-on">Версия:</span>
					<input id="pluginVersion" type="text" disabled>
				</div>
				<div class="input-prepend">
					<span class="add-on">Сайт:</span>
					<input id="pluginSite" type="text" disabled>
				</div>
				<div class="input-prepend">
					<span class="add-on">Тип плагина:</span>
					<input id="pluginType" type="text" disabled>
				</div>
				<div class="input-prepend">
					<span class="add-on">Приоритет:</span>
					<input id="pluginPriority" type="text">
				</div>
				<div class="input-prepend">
					<span class="add-on">Иконка:</span>
					<input id="pluginIcon" type="text" disabled>
				</div>
<!--				<div class="input-prepend">
					<span class="add-on">Доступен для групп:</span>
					<select id="pluginGroups" multiple>
						{groups_list}
					</select>
				</div>
				<div class="input-prepend ant_tooltip" title="Ники пользователей через запятую">
					<span class="add-on">Доступен пользователям:</span>
					<input id="pluginAllowedUsers" type="text">
				</div>-->

			</div>
			<div id="modal-body-wait"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
		<button class="btn btn-primary" onclick="pluginSave();">Сохранить</button>
	</div>
</div>
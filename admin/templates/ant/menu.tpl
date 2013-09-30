<div class="accordion" id="MenuAccordion">
		[content]
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#MenuAccordion" href="#collapseContent">
					<i class="fam-page-white"></i> <b>Контент</b>
				</a>
			</div>
			<div id="collapseContent" class="accordion-body collapse in">
				<div class="accordion-inner">
					{content}
				</div>
			</div>
		</div>[/content]
		[users]
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#MenuAccordion" href="#collapseUsers">
					<i class="fam-group"></i> <b>Пользователи</b>
				</a>
			</div>
			<div id="collapseUsers" class="accordion-body collapse">
				<div class="accordion-inner">
					{users}
				</div>
			</div>
		</div>[/users]
		[administration]
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#MenuAccordion" href="#collapseAdmin">
					<i class="fam-award-star-gold-1"></i> <b>Администрирование</b>
				</a>
			</div>
			<div id="collapseAdmin" class="accordion-body collapse">
				<div class="accordion-inner">
					{administration}
				</div>
			</div>
		</div>[/administration]
		[configuration]
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#MenuAccordion" href="#collapseConfiguration">
					<i class="fam-wrench"></i> <b>Настройки</b>
				</a>
			</div>
			<div id="collapseConfiguration" class="accordion-body collapse">
				<div class="accordion-inner">
					{configuration}
				</div>
			</div>
		</div>[/configuration]
		[other]
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#MenuAccordion" href="#collapseOther">
					<b>Прочее</b>
				</a>
			</div>
			<div id="collapseOther" class="accordion-body collapse">
				<div class="accordion-inner">
					{other}
				</div>
			</div>
		</div>[/other]
</div>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>{meta-title}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- styles -->
		

		<link href="{ADMIN_THEME}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="{ADMIN_THEME}/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="{ADMIN_THEME}/bootstrap/css/fam-icons.css" rel="stylesheet">
		<link href="{ADMIN_THEME}/chosen/chosen.css" rel="stylesheet">
		<link href="{ADMIN_THEME}/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		<link href="{ADMIN_THEME}/ant.css" rel="stylesheet">

		<link href="{site_path}/engine.css" rel="stylesheet">

		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
		<script src="{ADMIN_THEME}/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
		<script src="{ADMIN_THEME}/bootstrap/js/bootstrap.min.js"></script>
		<script src="{ADMIN_THEME}/chosen/chosen.jquery.min.js"></script>
		<script src="{ADMIN_THEME}/datepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="{ADMIN_THEME}/datepicker/js/bootstrap-datetimepicker.ru.js"></script>
		<script src="{ADMIN_THEME}/jquery.cookie.js"></script>
		<script src="{site_path}/engine.js"></script>
		<script src="{ADMIN_THEME}/ant.js"></script>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{site_path}/admin/favicon.png">
	</head>

	<body>
		{AJAX}
		<div class="navbar navbar-fixed-top"> <!--navbar-inverse -->
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</a>
				<a class="brand" href="{site_path}/admin/index.php">Админпанель</a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						{enter_info}
					</p>
					<ul class="nav">
						<li><a href="{site_path}/">На сайт</a></li><!--class="active"-->
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		</div>

		<div class="container content">
		<div class="row">
<!-- 			<div class="span3 sidebar-background"></div> -->
			<div class="span3 navpannel">
				{menu}
			</div><!--/span-->
			<div class="span9">
				<div class="general">
					<div class="hero unit">
						{module}
					</div>
				</div><!--/general-->
			</div><!--/span-->
		</div><!--/row-->

		<hr>

		<footer>
			<p>&copy; Company 2012-2013</p>
		</footer>

		</div><!--/.fluid-container-->
		{debug}
	</body>
</html>
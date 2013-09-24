<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<title>{meta-title}</title>
	<meta name="description" content="{meta-description}">
	<meta name="keywords" content="{meta-keywords}">
	
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	
	<link href="{site_path}/engine.css" rel="stylesheet">
	<link rel="stylesheet" href="{THEME}/cupertino/jquery-ui-1.10.0.custom.min.css" type="text/css" />
	<link rel="stylesheet" href="{THEME}/css/fam-icons.css" />
	<link rel="stylesheet" href="{THEME}/css/style.css" type="text/css" />

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
	<script src="{THEME}/js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
	<script src="{site_path}/engine.js"></script>
<!-- 	<script src="{site_path}/js/jquery.cookie.js" type="text/javascript"></script> -->

	<!-- jquery.dropdown -->
	<link type="text/css" rel="stylesheet" href="{THEME}/css/jquery.dropdown.css" />
	<script type="text/javascript" src="{THEME}/js/jquery.dropdown.js"></script>
</head>

<body>
{AJAX}

<div id="wrapper">

	<div class="ui-widget ui-widget-content ui-corner-all" id="header">
		<div class="widget-content">
			<a href="{site_path}/">Название сайта</a>
		</div>
	</div><!-- #header-->

	<div id="middle">

		<div id="container">
			<div id="content">
				{content}
			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar" id="sideLeft">
			<div class="ui-widget ui-widget-content ui-corner-all" id="block-cats">
				<h3 class="ui-widget-header ui-corner-all">Категории</h3>
				<div class="widget-content">{plugin=catlist}</div>
			</div>

		[if-plugin-online]
			<div class="ui-widget ui-widget-content ui-corner-all" id="block-online">
				<h3 class="ui-widget-header ui-corner-all">Онлайн</h3>
				<div class="widget-content">{plugin=online}</div>
			</div>
		[/if-plugin-online]
		
		</div><!-- .sidebar#sideLeft -->

		<div class="sidebar" id="sideRight">
	
		
		[if-plugin-cart]
			<script src="{site_path}/plugins/cart/cart.js"></script>
			
			<div class="ui-widget ui-widget-content ui-corner-all" id="block-cats">
				<h3 class="ui-widget-header ui-corner-all">Корзина</h3>
				<div class="widget-content" id="cart_main"></div>
			</div>
		[/if-plugin-cart]
		
			<!-- Поиск -->
			<div class="ui-widget ui-widget-content ui-corner-all" id="block-cats">
				<h3 class="ui-widget-header ui-corner-all">Поиск</h3>
				<div class="widget-content">{searchform}</div>
			</div>

			<!-- Вход -->
			<div class="ui-widget ui-widget-content ui-corner-all" id="block-login">
				<h3 class="ui-widget-header ui-corner-all">Авторизация</h3>
				<div class="widget-content">{login}</div>
			</div>

			<div class="ui-widget ui-widget-content ui-corner-all" id="block-nav">
				<h3 class="ui-widget-header ui-corner-all">Навигация</h3>
				<div class="widget-content">
					<ul class="nav">
						<li><a href="{site_path}/">Главная</a></li>
						<li><a href="{site_path}/%D1%81%D1%82%D0%B0%D1%82%D0%B8%D1%81%D1%82%D0%B8%D0%BA%D0%B0">Статистика</a></li>
						<li><a href="{site_path}/%D0%BF%D0%BE%D1%81%D0%BB%D0%B5%D0%B4%D0%BD%D0%B8%D0%B5-%D0%BA%D0%BE%D0%BC%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%80%D0%B8%D0%B8/">Последние комментарии</a></li>
					</ul>
				</div>
			</div>
		</div><!-- .sidebar#sideRight -->

	</div><!-- #middle-->
	<br clear="all">
	<div class="ui-widget ui-widget-content ui-corner-all" id="footer">
		<div class="widget-content">&copy;2008-{year_now}</div>
	</div><!-- #footer -->
	{debug}
</div><!-- #wrapper -->

</body>
</html>
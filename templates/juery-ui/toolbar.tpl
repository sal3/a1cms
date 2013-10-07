<div class="edToolbar">
<i class="fam-text-bold" title="Полужирный" onClick="doAddTags('[b]','[/b]');"></i>
<i class="fam-text-italic" title="Курсив" onClick="doAddTags('[i]','[/i]');"></i>
<i class="fam-text-underline" title="Подчеркнутый" onClick="doAddTags('[u]','[/u]');"></i>
<i class="fam-text-strikethrough" title="Зачеркнутый" onClick="doAddTags('[s]','[/s]');"></i>
<i class="fam-text-align-left" title="По левому краю" onClick="doAddTags('[left]','[/left]');"></i>
<i class="fam-text-align-center" title="По центру" onClick="doAddTags('[center]','[/center]');"></i>
<i class="fam-text-align-right" title="По правому краю" onClick="doAddTags('[right]','[/right]');"></i>



<i class="fam-text-lowercase" title="Размер шрифта" data-dropdown="#dropdown-fontsize"></i>
<div id="dropdown-fontsize" class="dropdown-menu">
	<ul>
		<li><a style="font-size:10px;" href="javascript:doAddTags('[size=10]','[/size]');">10</a></li>
		<li><a style="font-size:11px;" href="javascript:doAddTags('[size=11]','[/size]');">11</a></li>
		<li><a style="font-size:12px;" href="javascript:doAddTags('[size=12]','[/size]');">12</a></li>
		<li><a style="font-size:14px;" href="javascript:doAddTags('[size=14]','[/size]');">14</a></li>
		<li><a style="font-size:16px;" href="javascript: doAddTags('[size=16]','[/size]');">16</a></li>
		<li><a style="font-size:18px;" href="javascript:doAddTags('[size=18]','[/size]');">18</a></li>
		<li><a style="font-size:20px;" href="javascript:doAddTags('[size=20]','[/size]');">20</a></li>
		<li><a style="font-size:22px;" href="javascript:doAddTags('[size=22]','[/size]');">22</a></li>
	</ul>
</div>

<i class="fam-style" title="Шрифт" data-dropdown="#dropdown-font"></i>
<div id="dropdown-font" class="dropdown-menu">
	<ul>
		<li><a style="font-family: arial;" href="javascript:doAddTags('[font=arial]','[/font]');">Arial</a></li>
		<li><a style="font-family: georgia;" href="javascript:doAddTags('[font=georgia]','[/font]');">Georgia</a></li>
		<li><a style="font-family: system;" href="javascript:doAddTags('[font=system]','[/font]');">System</a></li>
		<li><a style="font-family: times new roman;" href="javascript:doAddTags('[font=times new roman]','[/font]');">Times New Roman</a></li>
		<li><a style="font-family: verdana;" href="javascript:doAddTags('[font=verdana]','[/font]');">Verdana</a></li>
	</ul>
</div>




<i class="fam-link-add" title="Вставить сылку" onClick="doURL();"></i>
<i class="fam-picture" title="Вставить скриншот" onClick="doImage();"></i>
<i class="fam-text-linespacing" title="Спойлер (скрытый текст)" onClick="doSpoiler();"></i>



<i class="fam-comments" title="Цитата" onClick="doAddTags('[quote]','[/quote]');"></i>
<i class="fam-page-white-code" title="Вставка кода" onClick="doAddTags('[code]','[/code]');"></i>


<i class="fam-color-swatch" title="Цвет" data-dropdown="#dropdown-color"></i>
<div id="dropdown-color" class="dropdown-menu">
<table class='colortable'>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFFFF]','[/color]');" bgcolor="#FFFFFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCCCC]','[/color]');" bgcolor="#FFCCCC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCC99]','[/color]');" bgcolor="#FFCC99"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFF99]','[/color]');" bgcolor="#FFFF99"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFFCC]','[/color]');" bgcolor="#FFFFCC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#99FF99]','[/color]');" bgcolor="#99FF99"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#99FFFF]','[/color]');" bgcolor="#99FFFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CCFFFF]','[/color]');" bgcolor="#CCFFFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CCCCFF]','[/color]');" bgcolor="#CCCCFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCCFF]','[/color]');" bgcolor="#FFCCFF"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#CCCCCC]','[/color]');" bgcolor="#CCCCCC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF6666]','[/color]');" bgcolor="#FF6666"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF9966]','[/color]');" bgcolor="#FF9966"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFF66]','[/color]');" bgcolor="#FFFF66"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFF33]','[/color]');" bgcolor="#FFFF33"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#66FF99]','[/color]');" bgcolor="#66FF99"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#33FFFF]','[/color]');" bgcolor="#33FFFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#66FFFF]','[/color]');" bgcolor="#66FFFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#9999FF]','[/color]');" bgcolor="#9999FF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF99FF]','[/color]');" bgcolor="#FF99FF"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#C0C0C0]','[/color]');" bgcolor="#C0C0C0"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF0000]','[/color]');" bgcolor="#FF0000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF9900]','[/color]');" bgcolor="#FF9900"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCC66]','[/color]');" bgcolor="#FFCC66"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFFF00]','[/color]');" bgcolor="#FFFF00"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#33FF33]','[/color]');" bgcolor="#33FF33"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#66CCCC]','[/color]');" bgcolor="#66CCCC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#33CCFF]','[/color]');" bgcolor="#33CCFF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#6666CC]','[/color]');" bgcolor="#6666CC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CC66CC]','[/color]');" bgcolor="#CC66CC"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#999999]','[/color]');" bgcolor="#999999"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CC0000]','[/color]');" bgcolor="#CC0000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FF6600]','[/color]');" bgcolor="#FF6600"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCC33]','[/color]');" bgcolor="#FFCC33"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#FFCC00]','[/color]');" bgcolor="#FFCC00"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#33CC00]','[/color]');" bgcolor="#33CC00"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#00CCCC]','[/color]');" bgcolor="#00CCCC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#3366FF]','[/color]');" bgcolor="#3366FF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#6633FF]','[/color]');" bgcolor="#6633FF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CC33CC]','[/color]');" bgcolor="#CC33CC"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#666666]','[/color]');" bgcolor="#666666"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#990000]','[/color]');" bgcolor="#990000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CC6600]','[/color]');" bgcolor="#CC6600"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#CC9933]','[/color]');" bgcolor="#CC9933"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#999900]','[/color]');" bgcolor="#999900"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#009900]','[/color]');" bgcolor="#009900"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#339999]','[/color]');" bgcolor="#339999"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#3333FF]','[/color]');" bgcolor="#3333FF"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#6600CC]','[/color]');" bgcolor="#6600CC"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#993399]','[/color]');" bgcolor="#993399"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#333333]','[/color]');" bgcolor="#333333"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#660000]','[/color]');" bgcolor="#660000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#993300]','[/color]');" bgcolor="#993300"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#996633]','[/color]');" bgcolor="#996633"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#666600]','[/color]');" bgcolor="#666600"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#006600]','[/color]');" bgcolor="#006600"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#336666]','[/color]');" bgcolor="#336666"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#000099]','[/color]');" bgcolor="#000099"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#333399]','[/color]');" bgcolor="#333399"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#663366]','[/color]');" bgcolor="#663366"></td>
	</tr>
	<tr>
		<td onclick="hideDropdowns();doAddTags('[color=#000000]','[/color]');" bgcolor="#000000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#330000]','[/color]');" bgcolor="#330000"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#663300]','[/color]');" bgcolor="#663300"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#663333]','[/color]');" bgcolor="#663333"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#333300]','[/color]');" bgcolor="#333300"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#003300]','[/color]');" bgcolor="#003300"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#003333]','[/color]');" bgcolor="#003333"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#000066]','[/color]');" bgcolor="#000066"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#330099]','[/color]');" bgcolor="#330099"></td>
		<td onclick="hideDropdowns();doAddTags('[color=#330033]','[/color]');" bgcolor="#330033"></td>
	</tr>
</table>
</div>


<i class="fam-emoticon-grin" title="Вставить смайл" data-dropdown="#dropdown-smile"></i>
<div id="dropdown-smile" class="dropdown-menu">
	[item]<img onclick="hideDropdowns(); doAddTags(':{smile_name}:','')" src="{smile_path}" style='border:0; padding-top:2px;' alt='smile' />[/item]
</div>


<i class="fam-film" title="Ролик на Youtube" onClick="doAddTags('[youtube=',']');"></i>
</div>
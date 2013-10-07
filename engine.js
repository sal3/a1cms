// всплывающие уведомления
var showAlertTimer = [];
function showAlert(data, style) {
	var time = new Date().valueOf();
	if( $('div').is('.blockInform') == false ) {
		$('body').append("<div class=\"blockInform\"></div>");
	}
	$('.blockInform').prepend("<div class='alert "+style+"' id='timer_"+time+"'><button type='button' tmr='"+time+"' class='close' data-dismiss='alert'>&times;</button>"+data+"</div>");
	$('.blockInform button.close').click(function() {
		var id =$(this).attr('tmr');
		clearTimeout(showAlertTimer[id]);
		$('#timer_'+id).remove();
	});

	showAlertTimer[""+time+""] = setTimeout(function(){
		$('#timer_'+time).remove();
	}, 7000);
}

$(document).ready(function(){
	//устанавливаем id редактируемой textarea
	$("textarea").click(function(){
		window.lasttextarea=this.id;
	});

	//быстрый ajax поиск //FIXME!!
	//.keyup().click().change(function(){

	//});
	$("input#navSearch").bind('keyup focus', function() {
		console.log(event.type);
		var q = $("input#navSearch").val();
		if(q.length > 2)
		{
			$.get(site_path+"/ajax/search.php", {q: q},function(data){
			if(data!="")
			{
				//отпрываем меню
				//$("ul#searchResults").html(data).dropdown('toggle');
				$("ul#searchResults").html(data);

				$("ul#searchResults a").bind('click', function() {
					//подставляем выбранное значение в поиск
					$("input#navSearch").val($(this).text());
					//return false;
					//скрываем меню
					//$("ul#searchResults").parent().removeClass('open');
					//$(this).parent().parent().parent().removeClass('open');
				//	console.log($("ul#searchResults").parent().attr('class'));
				});
			}
			else
				$("ul#searchResults").html('<li class="disabled"><a href="#" onclick="return false">нет совпадений</a></li>');
				//скрываем меню
				//$("ul#searchResults").parent().removeClass('open');
			});
		}
	});

	/*$("input#navSearch").keydown(function(e){
		var result=$("ul#searchResults").html();
		if (e.keyCode == 40 && result != "") {
			$("ul#searchResults a:first").focus();
		}
	});*/

// 	$('.mytooltip').tooltip({'trigger':'hover'});

	$('.title_spoiler').click(function(){
		if ($(this).next().css("display") == 'none')
			$(this).addClass("title_spoiler_opened");
		else
			$(this).removeClass("title_spoiler_opened");

		$(this).next().slideToggle("fast");
	});
});

//плагин обертывания текста тегами в textarea
(function($) {
  $.fn.wrapSelected = function(open, arg2, arg3, arg4, close) {
    return this.each(function() {
      var textarea = $(this);
      var value = textarea.val();
      var start = textarea[0].selectionStart;
      var end = textarea[0].selectionEnd;
      textarea.val(
        value.substr(0, start)+open+arg2+arg3+arg4+value.substring(start, end)+close+value.substring(end, value.length)
      );
    });
  };
})(jQuery);

//создаем модальное окно
function modalCreate()
{
	if(IN_ADMIN==1)
		theme=ADMIN_THEME;
	else
		theme=THEME;

	$.get(theme+"/modaldialog.jsontpl",function(data){
			$('body').append(data);

		//удалять по закрытии
		$("#myModal").on('hidden', function () {
			$("#myModal").remove();
		})
	});
}

//обрамляем тегами
function doAddTags (start, end)
{
	$('textarea#'+window.lasttextarea).wrapSelected(start, '', '', '', end);
}

function doURL ()
{
	var url = prompt('Введите адрес ссылки:','http://');
	if (url != '' && url != null && url != 'http://')
		$('textarea#'+window.lasttextarea).wrapSelected('[url', '=', url, ']', '[/url]');
}

function doImage ()
{
	var url = prompt('Введите адрес изображения:','http://');

	if (url != '' && url != null && url != 'http://')
		$('textarea#'+window.lasttextarea).wrapSelected('[img]', '', url, '', '[/img]');
}
function doSpoiler ()
{
	var name = prompt('Введите название спойлера:','');
	if (name != '' && name != null)
		$('textarea#'+window.lasttextarea).wrapSelected('[spoiler', '=', name, ']', '[/spoiler]');
	else if (name=='')
		$('textarea#'+window.lasttextarea).wrapSelected('[spoiler', '', '', ']', '[/spoiler]');
}

//получение категорий с адресной строки
function getUrlDirs ()
{
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('//') + 2).split('/');
	return hashes;
}

//заменяем картинки с ошибкой на свою
// function imgError (image){
//     image.onerror = "";
//     image.src = site_path+"/data/noimage.jpg";
//     return true;
// }

//ctrl-enter
function ctrlEnter (event, formElem)
{
    if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD)))
        $('#comm_submit_btn').click();
}
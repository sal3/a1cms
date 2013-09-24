function img_go() 
{
	var new_win = window.open('/plugins/images/index.php', 'pop', 'height=600, resizable=yes, scrollbars=yes, width=800');       
	new_win.oldDocument = document;
	//alert(window.last);
}


$(document).ready(function()
{
	$('body').click(function(){
		var t=$("*:focus");
		if((t.is("input") || t.is("textarea")) && t.attr("id") != undefined)
			window.last=t.attr('id');
		//alert(window.last);
	});
})
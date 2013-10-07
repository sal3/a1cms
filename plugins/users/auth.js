$(document).ready(function(){
	$('.auth-form').submit(function()
	{
		var login=$('.auth-login').val();
		var password=$('.auth-password').val();
		
		authenticate(login, password);
		return false;
	});
	
	$('.unauth-button').click(function()
	{
		unauthenticate();
	});
})

function authenticate(login, password) 
{
    $.ajax
    ({
        type: "POST",
        //the url where you want to sent the login and password to
        url: site_path+'/plugins/users/auth-ajax.php',
        dataType: 'json',
        async: false,
        //json object to sent to the authentication url
        data: {"auth": "login", "login": login, "password": password},
        success: function (data) 
	{
		if(data.result==1)
			location.reload();
		else
			showAlert(data.resultmessage, "ui-state-error");
        }
    })
}

function unauthenticate()
{
    $.ajax
    ({
        type: "POST",
        //the url where you want to sent the login and password to
        url: site_path+'/plugins/users/auth-ajax.php',
        dataType: 'json',
        async: false,
        //json object to sent to the authentication url
        data: {"auth": "exit"},
        success: function (data) 
	{
		if(data.result==1)
			location.reload();
		else
			showAlert(data.resultmessage, "ui-state-error");
        }
    })
}
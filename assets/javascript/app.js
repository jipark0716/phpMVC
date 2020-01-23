const baseUrl = '/api';
var isApp = navigator.userAgent.includes('_QBANK_APP_');

window.onpopstate = function(event) {
	loadContent(location.pathname);
};
document.onkeydown = function(){
	if( (event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) || (event.keyCode == 116) ) {
		event.keyCode = 0;
		event.cancelBubble = true;
		event.returnValue = false;
		loadContent(location.pathname);
	}
}
$(document).ready(function(){
	loadContent(location.pathname);
	$('#shadow').click(closePopup);
});
function loadContent(url){
	if(url == '/') url = '/home';
	if(location.pathname != url)
		history.pushState(null,null,url);
	var urlpath = url.split('/');
	var data = {};
	if(urlpath.length > 2){
		url = '/'+urlpath[1];
		urlpath.splice(0,2)
		data.params = urlpath
	}
	content.html('');
	if(urlpath[1] == 'home'){
		appDownudo();
	}
	$.ajax({
		url : baseUrl + url + '.php',
		type : 'GET',
		dataType : 'json',
		data : data,
		error : function(jqXHR, textStatus, error){
			if(jqXHR.hasOwnProperty('responseJSON') && jqXHR.responseJSON.hasOwnProperty('message')){
				setErrorPage(jqXHR.status,jqXHR.responseJSON.message);
			}else{
				setErrorPage(jqXHR.status);
			}
		},
		success : function(data, jqXHR, textStatus){
			if(data.message) getMessage(data.message);
			if(data.content) content.html(data.content);
			else if(data.redir) loadContent(data.redir);
			if(data.script) eval(data.script);
		}
	});
}
function setDeviceToken(input){
	alert('1');
	$.ajax({
		url : baseUrl + '/home.php',
		type : 'POST',
		data : {'device_token':input}
	});
}
function login(){

}
function appDownudo(){
	var filter = "win16|win32|win64|mac";
	if(filter.indexOf(navigator.platform.toLowerCase()) > 0 ){
		return;
	}

	if(isApp) return;
	var popupA = $.merge($('#shadow'),$('#popup'));
	$('#popup').css({
		height: '430',
		width: $(window).width()
	})
	$('#popup').html(`
		<h1 style="text-align:center">앱도 있다 이놈들아</h1>
		<a download href="" onclick="closePopup();">
			<button
			 class="btn col-md-8 col-xs-10 col-md-offset-2 col-xs-offset-1"
			 style="height:50px;
					margin-top:50px;
					margin-bottom:50px;
					border:1px solid black;"
			>안드로이드</button>
		</a>
		<a href="/ios" onclick="closePopup();">
			<button
			 class="btn col-md-8 col-xs-10 col-md-offset-2 col-xs-offset-1"
			 onclick=""
			 style="height:50px;
					margin-bottom:50px;
					border:1px solid black;"
			>IOS</button>
		</a>
		<button
		 onclick="closePopup();"
		 class="btn col-md-8 col-xs-10 col-md-offset-2 col-xs-offset-1"
		 style="height:50px;
				border:1px solid black;"
		>웹애서 계속 하기</button>
		`)
	popupA.fadeIn(500);
}
function sendForm(form){
	var request = new FormData(form);
	var obj = $(form);
	$.ajax({
		url : baseUrl + obj.attr('action-real') + '.php',
		type : obj.attr('method'),
		dataType : 'json',
		data : formDatatoJson(request),
		error : function(jqXHR, textStatus, error){
			if(jqXHR.hasOwnProperty('responseJSON') && jqXHR.responseJSON.hasOwnProperty('message')){
				setErrorPage(jqXHR.status,jqXHR.responseJSON.message);
			}else{
				setErrorPage(jqXHR.status);
			}
		},
		success : function(data, jqXHR, textStatus){
			if(data.success){
				if(data.script) eval(data.script);
				loadContent(data.redir);
			}else{
				sendFormError(data.error);
				if(data.message) getMessage(data.message);
				if(data.redir) loadContent(data.redir);
				if(data.script) eval(data.script);
			}
		}
	});
}
function removeMsg(){
	$('#message').fadeOut(1000,function(){
		$('#message').remove();
	});
}
function getMessage(message){
	$('body').append(`
<div id="message">
	${message}
</div>
		`)
	$('#message').click(removeMsg)
	setTimeout(removeMsg,5000)
}
function login(input){
	user = input
	$('.navbar-right').html(`
<li><a href="javascript:loadContent('/logout')">Logout</a></li>
<li><a href="javascript:loadContent('/my')">MemberInfo</a></li>
		`)
}
function logout(){
	user = null;
	$('.navbar-right').html(`
<li><a href="javascript:loadContent('/login')">Login</a></li>
<li><a href="javascript:loadContent('/register')">Register</a></li>
		`)
}
function closePopup(){
	var popupA = $.merge($('#shadow'),$('#popup'));
	popupA.fadeOut(500);
}

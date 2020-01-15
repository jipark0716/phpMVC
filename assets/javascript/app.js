const baseUrl = '/api';

window.onpopstate = function(event) {
    loadContent(location.pathname);
};
document.onkeydown = function(){
    // if( (event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) || (event.keyCode == 116) ) {
    //     event.keyCode = 0;
    //     event.cancelBubble = true;
    //     event.returnValue = false;
    //     loadContent(location.pathname);
    // }
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
function login(){

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

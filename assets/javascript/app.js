const baseUrl = '/api';

loadContent(location.pathname);
function loadContent(url){
    if(url == '/') url = '/home';
    history.pushState(null,null,url);
    $.ajax({
		url : baseUrl + url + '.php',
        type : 'GET',
		dataType : 'json',
        error : function(jqXHR, textStatus, error){
            if(jqXHR.hasOwnProperty('responseJSON') && jqXHR.responseJSON.hasOwnProperty('message')){
                setErrorPage(jqXHR.status,jqXHR.responseJSON.message);
            }else{
                setErrorPage(jqXHR.status);
            }
        },
        success : function(data, jqXHR, textStatus){
            content.html(data.content);
            if(data.script) eval(data.script);
        }
    });
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
                location.href = data.redir;
            }else{
                sendFormError(data.error);
            }
        }
    });
}

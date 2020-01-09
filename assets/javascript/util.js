var content;
$(document).ready(function(){
    content = $('#content');
})
var errorpage = {
    notFound : `not found`,
    badrequest : `bad request`,
    unauthorized: `권한이 읎다`
}
function setErrorPage(code,message){
    var error;
    switch (code) {
        case 400:
            error = errorpage.badrequest;
            break;
        case 401:
            error = errorpage.unauthorized;
            break;
        case 404:
            error = errorpage.notFound;
            break;
    }
    content.html(error);
    $('#http-error-message').html(message);
}
function sendFormError(errors){
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').html('')
    var first = true;
    for(var key in errors){
        var value = errors[key]
        var obj = $(`[name=${key}]`);
        if(first){
            obj.focus()
            first = false;
        }
        obj.addClass('is-invalid')
        if(obj.parent().find('.invalid-feedback').length == 0){
            obj.parent().append(`<span role="alert" class="invalid-feedback"></span>`)
        }
        obj.parent().find('.invalid-feedback').html(`<strong>${value.message}</strong>`)
    }
}
function formDatatoJson(formData){
    var object = {};
    formData.forEach(function(value, key){
        object[key] = value;
    });
    return object;
}

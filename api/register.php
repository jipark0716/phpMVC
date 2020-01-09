<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data['content'] = viewCompile('register');
        apiEnd($data);
    case 'POST':
        $user = new App\Validation\Validation($_POST);
        $user->requiredCol(['login_pw','login_id','nick_name','login_pw_confirmation']);
        $user->ifErrorEndApi();
        apiEnd($_POST);
}

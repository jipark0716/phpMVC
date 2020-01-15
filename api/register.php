<?
include getenv('autoload');
if(array_key_exists('user_id',$_SESSION)){
    $data['message'] = '이미 로그인 되어있습니다.';
    $data['redir'] = '/home';
    apiEnd($data);
}
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data['title'] = 'register';
        $data['content'] = viewCompile('register');
        apiEnd($data);
    case 'POST':
        $user = new App\Validation\Validation($_POST,['login_pw','login_id','nick_name','login_pw_confirmation']);
        $user->requiredCol(['login_pw','login_id','nick_name','login_pw_confirmation']);
        $user->length(6,16,['login_pw','login_id']);
        $user->length(2,8,'nick_name');
        $user->confirmation('login_pw');
        $user->disallowedChar(['\'','(',')']);
        $user->uniqueKey('users',['nick_name','login_id']);
        $user->ifErrorEndApi();
        $user->hashing('login_pw');
        $user->append('reg_time',time());
        $_SESSION['user_id'] = App\Model\Builder::insertGetId($user->data,'users');
        apiEnd([
            'script' => 'login('.json_encode(getUser(['level','nick_name'])).')',
            'success' => true,
            'redir'=> '/home'
        ]);
}

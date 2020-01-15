<?
include getenv('autoload');
if(array_key_exists('user_id',$_SESSION)){
    $data['message'] = '이미 로그인 되어있습니다.';
    $data['redir'] = '/home';
    apiEnd($data);
}
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data['content'] = viewCompile('login');
        apiEnd($data);
    case 'POST':
        $user = new App\Validation\Validation($_POST,['login_pw','login_id']);
        $user->requiredCol(['login_pw','login_id']);
        $user->length(6,16,['login_pw','login_id']);
        $user->disallowedChar(['\'','(',')']);
        $user->ifErrorEndApi();
        $sql = 'select id,login_pw from users where login_id = \''.$user->data['login_id'].'\'';
        $userData = App\Model\Builder::first($sql);
        if($userData == null){
            $user->error('login_id','존재하지 않는 아이디 입니다.');
            if(!password_verify($_POST['login_pw'],$user['login_pw']))
                $user->error('login_pw','비밀번호가 일치하지 않습니다.');
        }
        $user->ifErrorEndApi();
        $_SESSION['user_id'] = $userData['id'];
        apiEnd([
            'script' => 'login('.json_encode(getUser(['level','nick_name'])).')',
            'success' => true,
            'redir'=> '/home'
        ]);
}

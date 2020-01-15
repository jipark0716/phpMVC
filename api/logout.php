<?
include getenv('autoload');
if(!array_key_exists('user_id',$_SESSION)){
    $data['message'] = '로그인이 필요한 서비스 입니다.';
    $data['redir'] = '/home';
    apiEnd($data);
}
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        unset($_SESSION['user_id']);
        $data['script'] = 'history.back();logout();';
        apiEnd($data);
    case 'POST':
}

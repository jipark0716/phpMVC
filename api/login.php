<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data['content'] = viewCompile('login');
        apiEnd($data);
    case 'POST':

        apiEnd($data);
}

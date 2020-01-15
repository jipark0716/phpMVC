<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        apiEnd([
            'content' => viewCompile('memInfo')
        ]);
    case 'POST':
}

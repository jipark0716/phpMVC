<?
function viewCompile($path,$data = null){
    $_VIEWPATH = '/home/site/wwwroot/view/';
    if($data != null && getType($data) == 'array'){
        foreach ($data as $key => $value) {
            eval('$'.$key.' = $value;');
        }
    }
    ob_start();
    include $_VIEWPATH.$path.'.php';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
function apiEnd($data){
    echo json_encode($data);exit();
}
$user = null;
function getUser($colums = '*'){
    global $user;
    if($user) return $user;
    if(isset($_SESSION['user_id'])){
        if(getType($colums) == 'array')
            $colums = join(',',$colums);
        $sql = 'select ' . $colums . ' from users where id = ' . $_SESSION['user_id'];
        $user = App\Model\Builder::first($sql);
        return $user;
    }else{
        return null;
    }
}
function userLevel($input,$sys = true){
    if($input <= 0 && $sys) return true;
    return getUser(['level'])['level'] > $input;
}
function strposa($haystack, $needles=array(), $offset=0) {
    foreach($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) return true;
    }
    return false;
}
function abort($status,$message = ''){
    header('HTTP/1.1 '.$status);
    if(getType($message) == 'string'){
        $message = ['message'=>$message];
    }
    exit(json_encode($message));
}
function shuffleAnswer($input1,$input2){
    $array = array_values($input2);
    $array[] = $input1;
    shuffle($array);
    return $array;
}

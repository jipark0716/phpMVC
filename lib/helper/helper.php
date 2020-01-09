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

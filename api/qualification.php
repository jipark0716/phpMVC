<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(count($_GET['params']) != 1) abort(400);
        $sql = 'select name,id,view_level,edit_level from qualifications where id = ' . $_GET['params'][0];
        $data['quali'] = \App\Model\Builder::first($sql);
        if($data['quali'] == null)
            abort(404);
        if(!userLevel($data['quali']['view_level']))
            abort(400);
        $sql = 'select name,id from subjects where qualification_id = ' . $_GET['params'][0] . ' order by id desc';
            $data['subjects'] = \App\Model\Builder::query($sql);

        $res['content'] = viewCompile('qualification',$data);
        apiEnd($res);
    case 'POST':
        switch ($_POST['mode']) {
            case 'add':
                if(!userLevel(20)) abort(400,'권한이 없습니다.');
                $input = new App\Validation\Validation($_POST,['name']);
                $input->requiredCol('name');
                $input->length(2,20,['name']);
                $input->disallowedChar(['\'','(',')']);
                $input->uniqueKey('qualifications',['name']);
                $input->ifErrorEndApi();
                $input->append('host_id',$_SESSION['user_id']);
                apiEnd([
                   'success' => true,
                   'id' => \App\Model\Builder::insertGetId($input->data,'qualifications')
                ]);
        }
}

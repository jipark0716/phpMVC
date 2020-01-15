<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        break;
    case 'POST':
        switch ($_POST['mode']) {
            case 'add':
                $input = new App\Validation\Validation($_POST,['qualification_id']);
                $input->requiredCol();
                $input->isNumber();
                $input->ifErrorEndApi();
                $sql = 'select edit_level from qualifications where id = ' . $_POST['qualification_id'];
                $data['quali'] = \App\Model\Builder::first($sql);
                if($data['quali'] == null)
                    abort(404);
                if(!userLevel($data['quali']['edit_level']))
                    abort(400);
                $input = new App\Validation\Validation($_POST,['name']);
                $input->requiredCol('name');
                $input->length(2,20,['name']);
                $input->disallowedChar(['\'','(',')']);
                $input->uniqueKey('qualifications',['name']);
                $input->ifErrorEndApi();
                $input->append('qualification_id',$_POST['qualification_id']);
                $sql = 'select count(*) from subjects where qualification_id = '.$_POST['qualification_id'];
                $id = \App\Model\Builder::value($sql) + 1;
                $input->append('id',$id);
                App\Model\Builder::insert($input->data,'subjects');
                apiEnd([
                   'success' => true,
                   'id' => $id
                ]);
        }
}

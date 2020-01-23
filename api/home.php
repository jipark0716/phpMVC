<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		$level = getUser('level') == null ? 0 : getUser('level')['level'];
		$sql = 'select name,id from qualifications where view_level <= '.$level.' order by id desc';
		$data['qualis'] = \App\Model\Builder::query($sql);
		$res['content'] = viewCompile('home',$data);
		apiEnd($res);
	case 'POST':
		if(!isset($_POST['device_token']) || $_POST['device_token'] == null || $_POST['device_token'] == '') abort(400);
		\App\Model\Builder::insert([
			'token' => $_POST['device_token'],
			'reg_date' => time()
		],'device_tokens');
}

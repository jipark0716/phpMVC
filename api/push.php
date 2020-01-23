<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		if(!userLevel(80)) abort(404);
		$res['content'] = viewCompile('sendpush');
		apiEnd($res);
	case 'POST':
		if(!userLevel(80)) abort(404);
        $request = new App\Validation\Validation($_POST,['title','content']);
		$request->requiredCol(['title','content']);
        $request->ifErrorEndApi();
		$sql = 'select token from device_tokens';
		$data = App\Model\Builder::query($sql);
		$token = [];
		foreach ($data as $key => $value) {
			$token[] = $value;
		}
		apiEnd(sendGCM($request->data,$token));
}

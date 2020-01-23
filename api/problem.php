<?
include getenv('autoload');
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		switch ($_GET['params'][0]) {
			case 'new':
				if(count($_GET['params']) != 3)
					abort(404);
				if(!array_key_exists('user_id',$_SESSION))
					apiEnd([
						'message' => '로그인이 필요한 서비스 입니다',
						'redir' => '/login'
					]);
				$sql = ',(select name from qualifications where id = '. $_GET['params'][1] .') as qualiName';
				$sql = 'select name as subjectName '.$sql.' from subjects where qualification_id = '. $_GET['params'][1] .' and id = '.$_GET['params'][2];
				$data = \App\Model\Builder::first($sql);
				$data['params'] = $_GET['params'];
				apiEnd([
					'content' => viewCompile('newProblem',$data)
				]);
			case 'solve':
				if($_GET['params'][1] == 'wrong'){
					if(!isset($_SESSION['user_id']))
						apiEnd([
							'message' => '로그인이 필요한 서비스 입니다',
							'redir' => '/login'
						]);
					$col = 'a.qualification_id,a.subject_id,a.problem_id';
					$join = ' join problems as b on a.qualification_id = b.qualification_id and a.subject_id = b.subject_id and a.problem_id = b.id ';
					$sql = 'select '.$col.',b.problem,b.answer,b.wrong,count(if(currect = \'N\',1,null))-count(if(currect = \'Y\',1,null)) as cnt from solve_log a '.$join.' where user_id = '.$_SESSION['user_id'].' group by '.$col.' having cnt > 1 order by cnt desc limit 20';
					$data['problems'] = \App\Model\Builder::query($sql);
					$data['mode'] = 'myWrong';
					apiEnd([
						'content' => viewCompile('solveProblem',$data)
					]);
				}
				if(count($_GET['params']) != 3)
					abort(404,'');
				if($_GET['params'][2] == 'all'){
					$sql = "select name as qualiName,view_level from qualifications where id = ".$_GET['params'][1];
				}
				else{
					$sql = ',(select name from qualifications where id = '. $_GET['params'][1] .') as qualiName';
					$sql.= ',(select view_level from qualifications where id = '. $_GET['params'][1] .') as view_level';
					$sql = 'select name as subjectName '.$sql.' from subjects where qualification_id = '. $_GET['params'][1] .' and id = '.$_GET['params'][2];
				}
				$data = \App\Model\Builder::first($sql);
				if($data == null)
					abort(404);
				if(!userLevel($data['view_level']))
					abort(400);
				if($_GET['params'][2] == 'all') $where = 'qualification_id = '.$_GET['params'][1];
				else $where = 'qualification_id = '.$_GET['params'][1].' and subject_id = '.$_GET['params'][2];
				$sql = 'select distinct id as problem_id,subject_id,qualification_id,problem,answer,wrong from problems where '.$where.' order by rand()';
				$data['problems'] = \App\Model\Builder::paging($sql,20);
				$data['params'] = $_GET['params'];
				if($data['params'][2] == 'all')
					$data['subjectName'] = '전체';
				unset($data['view_level']);
				apiEnd([
					'content' => viewCompile('solveProblem',$data)
				]);
		}
	case 'POST':
		switch ($_POST['mode']) {
			case 'new':
				$sql = '(select edit_level from qualifications where id = '.$_POST['qualification_id'].') as edit_level';
				$sql = 'select '.$sql.' from subjects where id = '.$_POST['subject_id'].' and qualification_id = '.$_POST['qualification_id'];
				$data = \App\Model\Builder::first($sql);
				if($data == null)
					abort(404);
				if(!userLevel($data['edit_level']))
					abort(400);
				if(!array_key_exists('user_id',$_SESSION))
					apiEnd([
						'message' => '로그인이 필요한 서비스 입니다',
						'redir' => '/login'
					]);
				$input = new App\Validation\Validation($_POST,['problem','answer']);
				$input->requiredCol();
				$input->length(0,100);
				$input->escape();
				$input->ifErrorEndApi();

				$wrong = [];
				foreach ($_POST['wrong'] as $key => $value) {
					$wrong['wrong'.$key] = $value;
				}

				$wrong = new App\Validation\Validation($wrong);
				$wrong->length(0,100);
				$wrong->ifErrorEndApi();

				$input->append('wrong',json_encode(array_values($wrong->data),JSON_UNESCAPED_UNICODE));
				$input->append('qualification_id',$_POST['qualification_id']);
				$input->append('subject_id',$_POST['subject_id']);
				$sql = 'select count(*) from problems where qualification_id = '.$_POST['qualification_id'].' and subject_id = '.$_POST['subject_id'];
				$id = \App\Model\Builder::value($sql) + 1;
				$input->append('id',$id);
				$input->append('writer',$_SESSION['user_id']);
				\App\Model\Builder::insert($input->data,'problems');
				apiEnd([
					'success' => true,
					'redir' => '/qualification/1'
				]);
			case 'solve':
				$input = new App\Validation\Validation($_POST,['qualification_id','subject_id','problem_id','answer']);
				$input->requiredCol();
				$input->ifErrorEndApi();
				$where = "qualification_id = '{$_POST['qualification_id']}' and subject_id = '{$_POST['subject_id']}' and id = '{$_POST['problem_id']}'";
				$sql = 'select answer,w_cnt,c_cnt from problems where '.$where;
				$data = \App\Model\Builder::first($sql);
				$answer = $data['answer'];
				$correct = $answer == $_POST['answer'];
				\App\Model\Builder::update([
					$correct ? 'c_cnt' : 'w_cnt' => '+1'
				],'problems',$where);
				if(isset($_SESSION['user_id'])){
					\App\Model\Builder::insert([
						'user_id' => $_SESSION['user_id'],
						'currect' => $correct ? 'Y' : 'N',
						'qualification_id' => $_POST['qualification_id'],
						'subject_id' => $_POST['subject_id'],
						'problem_id' => $_POST['problem_id'],
						'reg_time' => time()
					],'solve_log');
				}
				if($correct) $data['c_cnt']++;
				else $data['w_cnt']++;
				$res = [
					'correct' => $correct,
					'c' => round($data['w_cnt'] + $data['c_cnt'] == 0 ? '100' : ($data['c_cnt'] / ($data['w_cnt'] + $data['c_cnt'])) * 100,1)
				];
				if(!$correct)
					$res['answer'] = $answer;
				apiEnd($res);
		}
}

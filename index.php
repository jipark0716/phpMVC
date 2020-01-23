<?include getenv('autoload');?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?include './partials/cdn.php';?>
		<title><?=getenv('site_name')?></title>
		<script>
			var user = <?=array_key_exists('user_id',$_SESSION)
			? json_encode(getUser(['nick_name','level']))
			: 'null'?>;
		</script>
	</head>
	<body>
		<div id="wrap">
			<nav class="navbar navbar-default navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" data-toggle="collapse" data-target="#app-navbar-collapse" class="navbar-toggle collapsed">
							<span class="sr-only">Toggle Navigation</span>
						</button>
						<a href="javascript:loadContent('/home')" class="navbar-brand">
							<?=getenv('site_name')?>
						</a>
					</div>
					<div id="app-navbar-collapse" class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
						</ul>
						<ul class="nav navbar-nav navbar-right">
						  <?if(array_key_exists('user_id',$_SESSION)){?>
							<li><a href="javascript:loadContent('/logout')">Logout</a></li>
							<li><a href="javascript:loadContent('/my')">MemberInfo</a></li>
						  <?}else{?>
							<li><a href="javascript:loadContent('/login')">Login</a></li>
							<li><a href="javascript:loadContent('/register')">Register</a></li>
						  <?}?>
						</ul>
					</div>
				</div>
			</nav>
			<div class="container-fluid" id=content-container>
				<div class="col-md-10 col-md-offset-1 col-xs-12" id="content"></div>
			</div>
			<div id="footer">
				머충 푸터
				<a href="https://github.com/jipark0716/phpMVC" target="_blank">(view source)</a>
			</div>
		</div>
		<div id="shadow"></div>
		<div id="popup"></div>
	</body>
</html>

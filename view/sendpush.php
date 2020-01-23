<div class="panel panel-default">
	<div class="panel-heading">
		<span style="font-size:2.3rem">
			푸쉬내용
		</span>
	</div>
	<div class="panel-body" id="qualifications">
		<form
		 onsubmit="sendForm(this);"
		 method="POST"
		 action-real="/push"
		 action="javascript:void(0)"
		 class="form-horizontal">
			<div class="form-group">
				<label for="title" class="col-md-4 control-label">제목</label>
				<div class="col-md-6">
					<input
					 id="title"
					 type="text"
					 name="title"
					 autofocus="autofocus"
					 class="form-control">
				 </div>
			</div>
			<div class="form-group">
				<label for="content" class="col-md-4 control-label">내용</label>
				<div class="col-md-6">
					<input
					 id="content"
					 type="text"
					 name="login_pw"
					 class="form-control">
				 </div>
			</div>
			<div class="form-group">
				<div class="col-md-8 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						전송
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

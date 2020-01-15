<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <form
             onsubmit="sendForm(this);"
             method="POST"
             action-real="/login"
             action="javascript:void(0)"
             class="form-horizontal">
                <div class="form-group">
                    <label for="login_id" class="col-md-4 control-label">ID</label>
                    <div class="col-md-6">
                        <input
                         id="login_id"
                         type="text"
                         name="login_id"
                         autofocus="autofocus"
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <label for="login_pw" class="col-md-4 control-label">PW</label>
                    <div class="col-md-6">
                        <input
                         id="login_pw"
                         type="password"
                         name="login_pw"
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                        <a href="javascript:loadContent('/password')" class="btn btn-link">
                            비밀번호 찾기
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

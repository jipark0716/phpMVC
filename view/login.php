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
                    <label for="email" class="col-md-4 control-label">ID</label>
                    <div class="col-md-6">
                        <input
                         id="email"
                         type="text"
                         name="email"
                         required
                         autofocus="autofocus"
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">PW</label>
                    <div class="col-md-6">
                        <input
                         id="password"
                         type="password"
                         name="password"
                         required
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                        <a href="javascript:void('/password')" class="btn btn-link">
                            비밀번호 찾기
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

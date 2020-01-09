<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
            <form
             role="form"
             method="POST"
             onsubmit="sendForm(this)"
             action-real="/register"
             action="javascript:void(0)"
             class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">닉네임</label>
                    <div class="col-md-6">
                        <input
                         id="name"
                         type="text"
                         name="nick_name"
                         required
                         autofocus="autofocus"
                         class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">ID</label>
                    <div class="col-md-6">
                        <input id="email"
                         type="text"
                         name="login_id"
                         required
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">PW</label>
                    <div class="col-md-6">
                        <input
                         id="password"
                         type="password"
                         name="login_pw"
                         
                         class="form-control">
                     </div>
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">CONFIRM PW</label>
                    <div class="col-md-6">
                        <input
                        id="password-confirm"
                        type="password"
                        name="login_pw_confirmation"
                        required
                        class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

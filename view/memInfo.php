<div class="panel panel-default">
    <div class="panel-heading">
        <span style="font-size:2.3rem">
            내정보
        </span>
        <button class="btn pull-right" onclick="loadContent('/problem/solve/wrong')">오답노트</button>
    </div>
    <div class="panel-body">
        <form action="javascript:void(0)" class="was-validated">
          <div class="form-group">
            <label for="user_id">ID</label>
            <input type="text" class="form-control" name="user_id" id="user_id" value="id">
          </div>
          <div class="form-group">
            <label for="user_name">NAME</label>
            <input type="text" class="form-control" name="user_name" id="user_name" value="user_name" required>
          </div>
          <div class="form-group">
            <label for="user_pass">PASSWORD</label>
            <input type="password" class="form-control" name="user_pass" id="user_pass" required>
          </div>
          <button class="btn btn-primary" type="submit">수정</button>
      </form>
    </div>
</div>

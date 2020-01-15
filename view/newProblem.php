<div class="panel panel-default">
    <div class="panel-heading">문제 출제 <hr><?=$qualiName?> - <?=$subjectName?></div>
    <div class="panel-body">
        <form
         onsubmit="sendForm(this);"
         method="POST"
         action-real="/problem"
         action="javascript:void(0)"
         class="form-horizontal"
         id="newProblem">
            <input type="hidden" name="mode" value="new">
            <input type="hidden" name="qualification_id" value="<?=$params[1]?>">
            <input type="hidden" name="subject_id" value="<?=$params[2]?>">
            <div class="form-group">
                <label for="problem" class="col-md-4 control-label">문제</label>
                <div class="col-md-6">
                    <input
                     id="problem"
                     type="text"
                     name="problem"
                     class="form-control">
                 </div>
            </div>
            <div class="form-group">
                <label for="answer" class="col-md-4 control-label">정답</label>
                <div class="col-md-6">
                    <input
                     id="answer"
                     type="text"
                     name="answer"
                     class="form-control">
                 </div>
            </div>
            <div class="form-group">
                <label for="wrong1" class="col-md-4 control-label">
                    오답1
                </label>
                <div class="col-md-6">
                    <input
                     id="wrong1"
                     type="text"
                     name="wrong[0]"
                     class="form-control">
                 </div>
            </div>
            <div class="form-group menu">
                <div class="col-md-8 col-md-offset-4">
                    <button
                     class="btn"
                     type="button"
                     onclick="appendWrong()"
                    >오답추가</button>
                    <button type="submit" class="btn btn-primary">
                        출제하기
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
var wrongCnt = 1;
function appendWrong(){
    $('#newProblem>.menu').before(`
    <div class="form-group">
        <label for="wrong${++wrongCnt}" class="col-md-4 control-label">
            오답${wrongCnt}
        </label>
        <div class="col-md-6">
            <input
             id="wrong${wrongCnt}"
             type="text"
             name="wrong[${wrongCnt-1}]"
             class="form-control">
         </div>
    </div>
        `)
}
</script>

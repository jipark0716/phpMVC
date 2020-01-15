<div class="panel panel-default">
    <div class="panel-heading">
        <span style="font-size:2.3rem">
          <?if($mode != 'myWrong'){?>
            <a href="javascript:loadContent('/qualification/<?=$params[1]?>')">
                <?=$qualiName?>
            </a>
            > <?=$subjectName?>
          <?}else{?>
            오답노트
          <?}?>
        </span>
    </div>
    <div class="panel-body">
        <ul class="solveUl">
            <?foreach ($problems as $key => $row) {
                $id = $mode == 'myWrong' ? 'subject_id="'.$row['subject_id'].'" qualification_id="'.$row['qualification_id'].'" idx="'.$row['problem_id'].'"' : 'idx="'.$row['id'].'"';
                $answers = shuffleAnswer($row['answer'],json_decode($row['wrong'],true));
                echo '<li>'.($key+1).'. '.$row['problem'].'</li><li '.$id.'><ul>';
                foreach ($answers as $key => $ans) {
                    echo '<li>'.($key+1).'. <span>'.$ans.'</span></li>';
                }
                echo '</ul></li>';
            }?>
        </ul>
    </div>
</div>
<script>
var solvedList = [];
$('.solveUl>li li').click(function(){
    var request = {};
    if(solvedList.includes($(this).parents('li').attr('idx'))) return;
    solvedList.push($(this).parents('li').attr('idx'));
    request.problem_id = $(this).parents('li').attr('idx');
  <?if($mode == 'myWrong'){?>
    request.subject_id = $(this).parents('li').attr('subject_id');
    request.qualification_id = $(this).parents('li').attr('qualification_id');
  <?}else{?>
    request.subject_id = <?=$params[2]?>;
    request.qualification_id = <?=$params[1]?>;
  <?}?>
    request.answer = $(this).find('span').text();
    request.mode = 'solve';
    $.ajax({
		url : baseUrl + '/problem.php',
        type : 'POST',
		dataType : 'json',
        data : request,
        error : function(jqXHR, textStatus, error){
            alert(jqXHR.responseJSON.message);
        },
        success : function(data, jqXHR, textStatus){
            console.log(data);
        }
    });
})
</script>

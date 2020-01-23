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
		<div class="pointBox" style="text-align:right;">
			점수 :
			<span class="point">0</span>
		</div>
		<div class="solveUl">
			<?foreach ($problems as $key => $row) {
				$id = 'subject_id="'.$row['subject_id'].'" qualification_id="'.$row['qualification_id'].'" idx="'.$row['problem_id'].'"';
				$answers = shuffleAnswer($row['answer'],json_decode($row['wrong'],true));
				?>
			<ul class="col-md-6 problem" style="padding:0">
				<li><?=$key+1?>.&nbsp;<?=$row['problem']?></li>
				<li <?=$id?>>
					<ul>
					  <?foreach ($answers as $key1 => $ans) {?>
						  <li><span><?=$ans?></span></li>
					  <?}?>
					</ul>
				</li>
			</ul>
				<?
			}?>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-animateNumber/0.0.14/jquery.animateNumber.min.js"></script>
<script>
var solvedList = [];
var point = $('.point');
var c_cnt = 0;
var w_cnt = 0;

$('.solveUl li li').click(function(){
	var obj = $(this);
	var request = {};

	if(solvedList.includes($(this).parents('li').attr('idx'))) return;
	solvedList.push($(this).parents('li').attr('idx'));
	request.problem_id = $(this).parents('li').attr('idx');
	request.subject_id = $(this).parents('li').attr('subject_id');
	request.qualification_id = $(this).parents('li').attr('qualification_id');
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
			if(data.correct){
				c_cnt++;
				obj.parents('.problem').addClass('currect');
				obj.addClass('currect');
			}else{
				w_cnt++;
				obj.parents('.problem').addClass('wrong');
				obj.addClass('wrong');
				for (var i = 0; i < obj.parents('ul').find('li').length; i++) {
					if(obj.parent().find('li').eq(i).find('span').text() == data.answer){
						obj.parent().find('li').eq(i).addClass('currect')
						break;
					}
				}
			}
			obj.parents('.problem').find('li').eq(0).append(`<span style="float:right;margin-right:15px;">정답률 : ${data.c}</span>`)
			$('.pointBox>.point').html( Math.round((c_cnt / $('.problem').length) * 100) )
			return;
		}
	});
})

</script>

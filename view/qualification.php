<div class="panel panel-default">
	<div class="panel-heading">
		<span style="font-size:2.3rem"><?=$quali['name']?> </span>
	  <?if(userLevel(20)){?>
		<button class="btn pull-right" id="add-subject">추가</button>
		<div class="col-md-3 col-xs-5 pull-right">
			<input class="form-control" type="text" name="subject">
		</div>
	  <?}?>
	</div>
	<div class="panel-body" id="subjects">
	  <?if($subjects->num_rows > 1){?>
		<a href="javascript:loadContent('/problem/solve/<?=$quali['id']?>/all')">
			<div class="col-md-4 col-xs-12 ">
				<div class="card card bg-light mb-3">
					<div class="card-body">
						<h5 class="card-title">전체</h5>
					</div>
				</div>
			</div>
		</a>
	  <?}?>
	  <?foreach ($subjects as $row) {?>
		<a href="javascript:clickSubject(<?=$row['id']?>)">
			<div class="col-md-4 col-xs-12 ">
				<div class="card card bg-light mb-3">
					<div class="card-body">
						<h5 class="card-title"><?=$row['name']?></h5>
					</div>
				</div>
			</div>
		</a>
	  <?}?>
	</div>
</div>
<script>
<?if(userLevel(20)){?>
$('#add-subject').click(function(){
	var subjectName = $('input[name=subject]').val();
	$('input[name=subject]').val('');
	$.ajax({
		url : baseUrl + '/subject.php',
		type : 'POST',
		dataType : 'json',
		data : {
			name:subjectName,
			qualification_id:<?=$quali['id']?>,
			mode:'add',
		},
		error : function(jqXHR, textStatus, error){
			alert(jqXHR.responseJSON.message);
		},
		success : function(data, jqXHR, textStatus){
			if(!data.success) {
				alert(data.error.name.message);
			}else{
				loadContent(location.pathname)
			}
		}
	});
})
var newQuestion,solve;
<?}?>
function clickSubject(id){
  <?if(userLevel($quali['edit_level'],false)){?>
	newQuestion = function(){

	}
	var popupA = $.merge($('#shadow'),$('#popup'));
	$('#popup').css({
		height: '250',
		width: '500'
	})
	$('#popup').html(`
		<button
		 class="btn col-md-8 col-xs-10 col-md-offset-2 col-xs-offset-1"
		 onclick="loadContent('/problem/solve/<?=$quali['id']?>/${id}');closePopup();"
		 style="height:50px;
				margin-top:50px;
				margin-bottom:50px;
				border:1px solid black;"
		>문제풀기</button>
		<button
		 onclick="loadContent('/problem/new/<?=$quali['id']?>/${id}');closePopup();"
		 class="btn col-md-8 col-xs-10 col-md-offset-2 col-xs-offset-1"
		 style="height:50px;
				border:1px solid black;"
		>문제내기</button>
		`)
	popupA.fadeIn(500);
  <?}else{?>
	loadContent('/problem/solve/<?=$quali['id']?>/'+id)
  <?}?>
}
</script>

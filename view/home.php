<div class="panel panel-default">
    <div class="panel-heading">
        <span style="font-size:2.3rem">종목 선택</span>
      <?if(userLevel(20)){?>
        <button class="btn pull-right" id="add-quali">추가</button>
        <div class="col-md-3 pull-right">
            <input class="form-control" type="text" name="quali">
        </div>
      <?}?>
    </div>
    <div class="panel-body" id="qualifications">
      <?foreach ($qualis as $row) {?>
          <a href="javascript:(loadContent('/qualification/<?=$row['id']?>'))">
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
$('#add-quali').click(function(){
    var qualiName = $('input[name=quali]').val();
    $('input[name=quali]').val('');
    $.ajax({
		url : baseUrl + '/qualification.php',
        type : 'POST',
		dataType : 'json',
        data : {
            name:qualiName,
            mode:'add',
        },
        error : function(jqXHR, textStatus, error){
            alert(jqXHR.responseJSON.message);
        },
        success : function(data, jqXHR, textStatus){
            if(!data.success) {
                alert(data.error.name.message);
            }else{
                $('#qualifications').html(`
                    <div class="col-md-3">
                        <button
                         onclick="loadContent('/qualification/${data.id}')"
                         class="btn col-md-8 col-md-offset-2"
                         style="margin-bottom:20px;"
                        >${qualiName}</button>
                    </div>`+$('#qualifications').html());
            }
        }
    });
})
<?}?>
</script>

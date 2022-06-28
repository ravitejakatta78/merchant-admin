
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
$actionId = Yii::$app->controller->action->id;

?>
<script src="<?= Yii::$app->request->baseUrl.'/js/jquery.table2excel.js'?>"></script>
<style>
ul.resp-tabs-list, p {
  margin: 0;
  padding: 0;
}
.resp-tabs-list li {
  font-weight: 600;
  font-size: 14px;
  display: inline-block;
  padding: 15px 15px;
  margin: 0 4px 0 0;
      margin-bottom: 0px;
  list-style: none;
  cursor: pointer;
  float: left;
background:#ffcf95;
border-radius:4px 4px 0 0;
color:#333;
}
.resp-tab-active {
  padding: 12px 14px 14px !important;
  border-top: 4px solid #fe2503 !important;
  border-bottom: 0 #fff solid !important;
background:#FD8B02 !important;
color:#fff !important;

}

	</style>
<header class="page-header">
<?php 
foreach (Yii::$app->session->getAllFlashes() as $message) {
    echo SweetAlert::widget([
        'options' => [
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text' => (!empty($message['text'])) ? Html::encode($message['text']) : 'Text Not Set!',
            'type' => (!empty($message['type'])) ? $message['type'] : SweetAlert::TYPE_INFO,
            'timer' => (!empty($message['timer'])) ? $message['timer'] : 4000,
            'showConfirmButton' =>  (!empty($message['showConfirmButton'])) ? $message['showConfirmButton'] : true
        ]
    ]);
}
?>
          </header>
          <section>
		  <?= \Yii::$app->view->renderFile('@app/views/admin/_articles.php',['actionId'=>$actionId]); ?>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Food Shorts</h3>
				<div class="col-md-6 text-right pr-0">
					<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus mr-1"></i> Add Food Short</button>
				</div>
              </div>


              <div class="card-body">
			  <form class="form-horizontal" method="POST" id="article" action="food-shorts">
                <div class="row">
			  <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">Start Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker1" name="sdate" placeholder="Start Date" value="<?= $sdate ; ?>">
                </div>
                  </div>
				  </div>
				  </div>
				  
				 <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">End Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker2" name="edate" placeholder="End Date" value="<?= $edate ; ?>">
                </div>
				</div>
                  </div>
				  </div>
				  
				  
				  
				  <div class="col-md-3 ">
                  <div class="form-group pt-3">
                    <input type="submit" value="Search" class="btn btn-add btn-sm btn-search"/>
                  </div>
				  </div>
                  </div>
  
                </form>
   

                  <table  id="example" class="table table-striped table-bordered ">
                    <thead>
                      	<tr>
							<th>S.No</th>
							<th>Title</th>
							<th>Date & Time</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
                    </thead>
		    		<tbody>
						<?php $x=1; 
						foreach($foodShorts as $foodShort){
						?>
                            <tr>
								<td><?= $x; ?></td>
								<td><?= $foodShort['title']; ?></td>
								<td><?= date('d-M-Y h:i A',strtotime($foodShort['reg_date'])); ?></td>
								<td>
									<label class="switch">
										  <input type="checkbox" <?php if($foodShort['status']=='1'){ echo 'checked';}?> onChange="changestatus('foodShorts',<?php echo $foodShort['ID'];?>);">
										  <span class="slider round"></span>
									</label>
								</td>
								<td class="icons">
									<a title="Article - Delete" onClick="deleteFoodShort('<?= $foodShort['ID']; ?>')"   ><span class="fa fa-trash"></span></a>
								    <a title="Article - Edit" onClick="editFoodShort('<?= $foodShort['ID']; ?>')"   ><span class="fa fa-edit"></span></a>
								</td>
							</tr>
							
							<?php $x++; } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>


	<div class="modal" id="myModal">
    	<div class="modal-dialog modal-lg">
      		<div class="modal-content">
      
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Add Food Short</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
        
				<!-- Modal body -->
				<div class="modal-body">
			
					<?php
						$form = ActiveForm::begin([
    						'id' => 'add-article-form',
							'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12','enctype'=> 'multipart/form-data'],
								'layout' => 'horizontal',
								'fieldConfig' => [
									'horizontalCssClasses' => [
										'offset' => 'col-sm-offset-0',
										'wrapper' => 'col-sm-12 pl-0 pr-0',
									],
								]
						]) ?>
		
					<div class="row">	
						<div class="col-md-6">	
							<div class="form-group row">
	   							<label class="control-label col-md-4">Title</label>
								<div class="col-md-8">
											<?= $form->field($model, 'title')->textinput(['class' => 'form-control'])->label(false); ?>
								</div>
	   						</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group row">
	   							<label class="control-label col-md-4">Content</label>
								<div class="col-md-8">
											<?= $form->field($model, 'content')->textarea(['class' => 'form-control content', "maxlength"=> "355", "placeholder" => "Please Enter Not More Than 355 Characters"])->label(false); ?>
								</div>
	   						</div>
						</div>
					</div>
					<table id="tblAddRow" class="table table-bordered table-striped">
    					<thead>
							<tr>
								<th>Image</th>
								<th>Action</th>
							</tr>
    					</thead>
    					<tbody>
							<tr>

								
								<td>
									<input type="file" name="image[]" class="form-control">
								</td>
								
							</tr>
						
						</tbody>
					</table>
	   			</div>
	   			<div class="modal-footer">
				   <button id="btnAddRow" class="btn btn-add btn-xs" type="button">
    					Add Row
					</button>
					<?= Html::submitButton('Add Food Short', ['class'=> 'btn btn-add btn-hide']); ?>
		        </div> 		
				<?php ActiveForm::end() ?>
			</div>
		</div>
	</div>	


<div id="editfoodshort" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" >
    	<div class="modal-content">
      
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Edit Food Short</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div id="editfoodshortbody">
			
			</div>	
		</div>
	</div>
</div>

        </section>
		<?php
$script = <<< JS
    $('#example').DataTable();
JS;
$this->registerJs($script);
?>
<script>
function deleteFoodShort(id){
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "delete-food-short",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
                    	
							location.reload();
						});
					}
				});

}

function editFoodShort(id)
{

$.ajax({
  url: "edit-food-short-popup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editfoodshortbody').html(msg);
	$('#editfoodshort').modal('show');
});		

}

$('#tblAddRow tbody tr')
    .find('td')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>');

// Add row the table
$('#btnAddRow').on('click', function() {
    var lastRow = $('#tblAddRow tbody tr:last').html();
    //alert(lastRow);
	var lenRow = $('#tblAddRow tbody tr').length;
	if(lenRow >= 9) {
		swal(
			'Warning!',
			'You Cannot Add More Than 9 Images',
			'warning'
		);
		return false;
	} else {
		$('#tblAddRow tbody').append('<tr>' + lastRow + '</tr>');
    	$('#tblAddRow tbody tr:last input').val('');
	}
    
});


// Delete row on click in the table
$('#tblAddRow').on('click', 'tr a', function(e) {
    var lenRow = $('#tblAddRow tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});

$(".content").keyup(function(){
	if($(".content").val().length == 355) {
		swal(
			'Warning!',
			'355 Characters are added to the content',
			'warning'
		);
	}
});

function contentUpdateCheck(){
	if($(".content-update").val().length == 355) {
		swal(
			'Warning!',
			'355 Characters are added to the content',
			'warning'
		);
	}
}
</script>
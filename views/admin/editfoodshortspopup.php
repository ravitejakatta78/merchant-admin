<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

				<?php	$form = ActiveForm::begin([
    		'id' => 'edit-article-form',
			'action'=>'edit-food-short',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12','enctype'=> 'multipart/form-data'],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>
		<div class="modal-body">
			<div class="row">	
					<div class="col-md-6">	
						<div class="form-group row">
							<label class="control-label col-md-4">Title</label>
							<div class="col-md-8">
												<?= $form->field($model, 'title')->textinput(['class' => 'form-control'])->label(false); ?>
												<?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control'])->label(false); ?>

							</div>
						</div>
					</div>

					<div class="col-md-6">	
						<div class="form-group row">
							<label class="control-label col-md-4">Content</label>
							<div class="col-md-8">
												<?= $form->field($model, 'content')->textarea(['class' => 'form-control content-update', "maxlength"=> "355", "placeholder" => "Please Enter Not More Than 355 Characters",'onkeyup' => 'contentUpdateCheck()'])->label(false); ?>
							</div>
						</div>
					</div>
			</div>
			<div class="row">
				<?php for($i=0; $i < count($imagesModel); $i++ ) { ?> 
				<div class="col-md-4 images_display" id="image_<?= $imagesModel[$i]['ID']; ?>" >
				<div>
				<a href="<?= Yii::$app->request->baseUrl.'/../../merchant_images/food_shorts/'.$imagesModel[$i]['image']; ?>" target="_blank">
					<img src="<?= Yii::$app->request->baseUrl.'/../../merchant_images/food_shorts/'.$imagesModel[$i]['image']; ?>" style="width=50px;height:100px" />
				</a>
				</div>
				<div>
				<a class="btn btn-add" onclick="deleteFoodShortImage('<?= $imagesModel[$i]['ID']; ?>','<?= $imagesModel[$i]['image']; ?>')">Delete</a>
				</div>	
			</div>
				<?php } ?>
			</div>

			<table id="tblAddRows" class="mt-3 table table-bordered table-striped">
    					<thead>
							<tr>
								<th>Image</th>
								<th>Action</th>
							</tr>
    					</thead>
    					<tbody>
							<tr>

								
								<td>
									<input type="file" name="updateImage[]" class="form-control">
								</td>
								
							</tr>
						
						</tbody>
					</table>
		</div>
		
   		<div class="modal-footer">
		   <?php if(count($imagesModel) < 9) { ?>
			<a onclick="addrow()" class="btn btn-add">Add Row</a>
		   <?php } ?>	
		<?= Html::submitButton('Edit Food Short', ['class'=> 'btn btn-add']); ?>
      	</div> 
	<?php ActiveForm::end() ?>
        
        
	<script>
function deleteFoodShortImage(imageId,image) {
	swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "delete-food-short-image",
						  type: "POST",
						  data: {id : imageId,image:image},
						}).done(function(msg) {
							$("#image_"+msg).remove();
						});
					}
				});

}

$(document).ready(function(){
// Add button Delete in row
$('#tblAddRows tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow" ><i class="fa fa-trash border-red text-red deleterow" name="deleterow" ></i></a></td>');
	

	
});

function addrow() {
	var numPrevImages = $('.images_display').length;
	var lenRow = $('#tblAddRows tbody tr').length;
	var prsntRows = (numPrevImages + lenRow);
	if(prsntRows >= 9) {
		swal(
			'Warning!',
			'You Cannot Add More Than 9 Images',
			'warning'
		);
		return false;
	} else {
	    var lastRow = $('#tblAddRows tbody tr:last').html();
    	$('#tblAddRows tbody').append('<tr>' + lastRow + '</tr>');
    	$('#tblAddRows tbody tr:last input').val('');
	}
}
		</script>
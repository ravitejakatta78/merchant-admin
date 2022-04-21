<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

   				<?php	$form = ActiveForm::begin([
    		'id' => 'app-notification-form',
			'action'=>'updateappnotification',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
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
	      <?= $form->field($model, 'title')->textinput(['class' => 'form-control labeltag','placeholder'=>'Title'])->label(false); ?>
		 <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control labeltag'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Image</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'image')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>

	   	   	   	
</div>
<div class="col-md-6">

	   <div class="form-group row">
	   <label class="control-label col-md-4">Content</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'message')->textarea(['class' => 'form-control','placeholder'=>'Content'])->label(false); ?>
	   </div></div>

	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Edit APP Notification', ['class'=> 'btn btn-add']); ?>

      </div> 


<?php ActiveForm::end() ?>

<?php
$script = <<< JS
    $('#tblAddRow1').DataTable();
	$('select').select2();
JS;
$this->registerJs($script);
?>
   
<script>

$(document).on('keydown', '.titleedit,.labeltagedit', function(){


            source: function (query, result) {
                $.ajax({
                    url: "productautocomplete",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
});

</script>    
        
        
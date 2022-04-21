<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

   		<?php	$form = ActiveForm::begin([
    		'id' => 'update-reward-form',
			'action'=>'updatereward',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?><div class="row">	
<div class="col-md-6">	

	   <div class="form-group row">
	   <label class="control-label col-md-4">Reward Type</label>
	   <div class="col-md-8">

				  			      <?= $form->field($model, 'rewardtype')
				  ->dropdownlist(['Single'=>'Single','Multiple'=>'Multiple'],['prompt'=>'Select Reward Type'])->label(false); ?>
				  
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Coins to redeem</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'coins')->textinput(['class' => 'form-control labeltag','placeholder'=>'Coins to redeem'])->label(false); ?>
				  			      <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control labeltag'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity from</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'validityfrom')->textinput(['class' => 'form-control datepicker1'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity to</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'validityto')->textinput(['class' => 'form-control datepicker2'])->label(false); ?>
	   </div></div>
	   	   	   	<div class="form-group row">
	   <label class="control-label col-md-4">Cover Image</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'cover')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Title</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'title')->textinput(['class' => 'form-control','placeholder'=>'Title'])->label(false); ?>
	   </div></div>


	   <div class="form-group row">
	   <label class="control-label col-md-4">Tag line</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'excerpt')->textinput(['class' => 'form-control','placeholder'=>'Tag line'])->label(false); ?>
	   </div></div>
	   
	   	<div class="form-group row">
	   <label class="control-label col-md-4">Description</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'description')->textarea(['class' => 'form-control','placeholder'=>'Description'])->label(false); ?>
	   </div></div>
	   

	   
	   	   	<div class="form-group row">
	   <label class="control-label col-md-4">Logo </label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'logo')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Edit Reward', ['class'=> 'btn btn-add']); ?>

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
        
        
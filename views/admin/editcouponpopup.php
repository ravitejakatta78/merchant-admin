<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

   		<?php	$form = ActiveForm::begin([
    		'id' => 'update-coupon-form',
			'action'=>'updatecoupon',
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
	   <label class="control-label col-md-4">Coupon Type</label>
	   <div class="col-md-8">
				  			      <?= $form->field($model, 'purpose')
				  ->dropdownlist(['Single'=>'Single Use','Multiple'=>'Multiple Use'],['prompt'=>'Select Coupon Type'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Discount Type</label>
	   <div class="col-md-8">
				  			      <?= $form->field($model, 'type')
				  ->dropdownlist(['amount'=>'Amount','percent'=>'Percentage'],['prompt'=>'Select Discount Type'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity from</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'fromdate')->textinput(['class' => 'form-control datepicker1','value'=>date('Y-m-d')])->label(false); ?>
	   </div></div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity to</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'todate')->textinput(['class' => 'form-control datepicker2','value'=>date('Y-m-d')])->label(false); ?>
	   <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control'])->label(false); ?>
	   </div></div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Description</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'description')->textarea(['class' => 'form-control','placeholder'=>'Coupon Description'])->label(false); ?>
	   </div></div>

	   	   	   	
</div>
<div class="col-md-6">

	   <div class="form-group row">
	   <label class="control-label col-md-4">Coupon Code</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'code')->textinput(['class' => 'form-control','placeholder'=>'Coupon Code'])->label(false); ?>
	   </div></div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Amount Of Discount</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'price')->textinput(['class' => 'form-control','placeholder'=>'Flat Amount or Percentage Eg 100 or 25'])->label(false); ?>
	   </div></div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Max Amount Of Discount</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'maxamt')->textinput(['class' => 'form-control','placeholder'=>'Max Amount Of Discount'])->label(false); ?>
	   </div></div>

	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Edit Coupon', ['class'=> 'btn btn-add']); ?>

      </div> 


<?php ActiveForm::end() ?>
<?php
$script = <<< JS
    $('#tblAddRow1').DataTable();
	$('select').select2();
JS;
$this->registerJs($script);
?>
        
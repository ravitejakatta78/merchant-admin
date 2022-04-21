<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
 
   		<?php	$form = ActiveForm::begin([
    		'id' => 'update-storetype-form',
			'action'=>'editstoretype',
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
	   <label class="control-label col-md-4">Merchant Type Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'storetypename')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Store Type Name'])->label(false); ?>
				   <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control','autocomplete'=>'off'])->label(false); ?>
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Status</label>
	   <div class="col-md-8 select-all-none">
	  	 <?= $form->field($model, 'type_status')
				  ->dropdownlist(['0'=>'Inactive','1'=>'Active']
				   ,['prompt'=>'Select'])->label(false); ?>
				 
				 
	   </div>
	   </div>

	   	   
	   </div>
	          
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Update Merchant Type', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 



<?php ActiveForm::end() ?>
<?php
$script = <<< JS
    
JS;
$this->registerJs($script);
?>
 
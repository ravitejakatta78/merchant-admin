<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

				<?php	$form = ActiveForm::begin([
    		'id' => 'edit-client-form',
			'action'=>'edit-client',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
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
	   <label class="control-label col-md-4">Merchant Name</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'merchant_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Merchant::find()->distinct()
				  ->all(), 'ID', 'storename')
  ,['prompt'=>'Select'])->label(false); ?>
	   </div>
	   </div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Subscription Amount</label>
 <div class="col-md-8">	   
 <?= $form->field($model, 'subscription_amount')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Subscription Amount'])->label(false); ?>
				   <?= $form->field($model, 'ID')->hiddenInput(['class' => 'form-control','autocomplete'=>'off'
				  ])->label(false); ?>
	   </div>
	   </div>

	   <div class="form-group row">
	   <label class="control-label col-md-4">Payment Status</label>
 <div class="col-md-8">	   
 <?= $form->field($model, 'payment_status')
				  ->dropdownlist(['1'=>'Paid','2'=>'Pending']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div>
	   </div>
	   	   
	   </div>
	           
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Subscription Start Date</label>
	   <div class="col-md-8">
	   	   	   <?= $form->field($model, 'subscription_start_date')->textinput(['class' => 'form-control datepicker1','value'=>date('Y-m-d')])->label(false); ?>

			   </div></div>

			   <div class="form-group row">
	   <label class="control-label col-md-4">Executive Name & ID</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'executive_details')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Executive Name & ID'])->label(false); ?>
	   </div></div>
	   
	   


	   </div>
	   </div>
		</div>
		
   		<div class="modal-footer">
			<?= Html::submitButton('Edit Client', ['class'=> 'btn btn-add']); ?>
      	</div> 
	<?php ActiveForm::end() ?>
        
        
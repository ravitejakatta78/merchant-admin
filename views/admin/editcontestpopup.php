<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
 <style type="text/css">
  .select-all-none .select2 ,#multiple-checkboxes1  { display : none}
.multiselect-container { height:200px;overflow-y:scroll;width:230px; }
.multiselect-container > li{
	height:34px;
}
.multiselect{width:230px;background:#fff;}
.multiselect-container > li > a > label.checkbox{padding-left:10px;}
</style> 
   		<?php	$form = ActiveForm::begin([
    		'id' => 'update-contest-form',
			'action'=>'updatecontest',
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
	   <label class="control-label col-md-4">Contest Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'contest_name')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Contest Name'])->label(false); ?>
				   <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Contest Name'])->label(false); ?>
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest Participants</label>
	   <div class="col-md-8 select-all-none">
	  	 <?= $form->field($model, 'contest_participants')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Merchant::find()
				  ->all(), 'ID', 'storename')
				  ,[
      'multiple'=>'multiple',
      'id'=>'multiple-checkboxes1',              
     ]  ,['prompt'=>'Select'])->label(false); ?>
				 
				 
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest Area</label>
 <div class="col-md-8">	   
	   <?= $form->field($model, 'contest_area')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Merchant::find()->distinct()
				  ->all(), 'location', 'location')
  ,['prompt'=>'Select'])->label(false); ?>
	   </div>
	   </div>
	   	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest Image</label>
 <div class="col-md-8">	   
	   <?= $form->field($model, 'contest_image')->fileinput(['class' => 'form-control'])->label(false) ; ?>
				  
	   </div>
	   </div>
	   </div>
	           
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest Start Date</label>
	   <div class="col-md-8">
	   	   	   <?= $form->field($model, 'contest_start_date')->textinput(['class' => 'form-control datepicker3'])->label(false); ?>

			   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest End Date</label>
	   <div class="col-md-8">
				   	   	   <?= $form->field($model, 'contest_end_date')->textinput(['class' => 'form-control datepicker4'])->label(false); ?>

	   </div></div>
	  	<div class="form-group row">
	   <label class="control-label col-md-4">Contest Persons</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'contest_persons')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Contest Persons'])->label(false); ?>
	   </div></div>
	   
	   


	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Contest', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 



<?php ActiveForm::end() ?>
<?php
$script = <<< JS
    
JS;
$this->registerJs($script);
?>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
	<script>
	    $(document).ready(function() {
        $('#multiple-checkboxes1').multiselect({
          includeSelectAllOption: true,
        });
				$('.datepicker3 ').datepicker({
            uiLibrary: 'bootstrap',
			format: 'yyyy-mm-dd',
			
        });
			$('.datepicker4 ').datepicker({
            uiLibrary: 'bootstrap',
			format: 'yyyy-mm-dd',
			
        });
    });
	</script> 
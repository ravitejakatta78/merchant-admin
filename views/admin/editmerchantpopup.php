<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$hrRange = ['0'=>'12 AM','1'=>'1 AM','2'=>'2 AM','3'=>'3 AM','4'=>'4 AM','5'=>'5 AM','6'=>'6 AM','7'=>'7 AM','8'=>'8 AM','9'=>'9 AM','10'=>'10 AM','11'=>'11 AM',
'12'=>'12 PM','13'=>'1 PM','14'=>'2 PM','15'=>'3 PM','16'=>'4 PM','17'=>'5 PM','18'=>'6 PM','19'=>'7 PM','20'=>'8 PM','21'=>'9 PM','22'=>'10 PM','23'=>'11 PM'
];
?>


   		<?php	$form = ActiveForm::begin([
    		'id' => 'merchant-update-form',
		'action' => 'updatemerchant',
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
	   <label class="control-label col-md-4">Owner Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'name')->textinput(['class' => 'form-control title','autocomplete'=>'off'
,'placeholder'=>'Merchant Name'])->label(false); ?>
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Email Id</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'email',['enableAjaxValidation' => true])->textinput(['class' => 'form-control labeltag','autocomplete'=>'off'
,'placeholder'=>'Email Id'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Store Type</label>
	   <div class="col-md-8">
				      <?= $form->field($model, 'storetype')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Storetypes::find()
				  ->where(['type_status'=>'1'])
				  ->all(), 'ID', 'storetypename')
		,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Address</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'address')->textarea(['class' => 'form-control','placeholder'=>'Enter Address'])->label(false); ?>
	   <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control'])->label(false); ?>	   
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">City</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'city')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter City'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Latitude</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'latitude')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Latitude'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Serving Type</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'servingtype')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Serving Type'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Description</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'description')->textarea(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Description'])->label(false); ?>
	   </div></div>
	    <div class="form-group row">
	   <label class="control-label col-md-4">QR Scan Range (In Meters)</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'scan_range')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter QR Scan Range (In Meters)'])->label(false); ?>
	   </div></div>
	    <div class="form-group row">
	   <label class="control-label col-md-4">Owner Type</label>
	   <div class="col-md-8">
	        <?= $form->field($model, 'owner_type')
				  ->dropdownlist(['1'=>'Owner','2'=>'Co Owner']
				  ,['prompt'=>'Select'])->label(false); ?>

	   </div></div>
	   	    <div class="form-group row">
	   <label class="control-label col-md-4">Table Reservation</label>
	   <div class="col-md-8">
	        <?= $form->field($model, 'table_res_avail')
				  ->dropdownlist(['1'=>'Enable','2'=>'Disable']
				  ,['prompt'=>'Select'])->label(false); ?>

	   </div></div>
	   	   	    
	   <div class="form-group row">
	        <label class="control-label col-md-4">Subscription</label>
	        <div class="col-md-8">
	            <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                    <?= $form->field($model, 'subscription_date')->textinput(['class' => 'form-control datepicker3','onclick'=>'datepickerfrom()','autocomplete'=>'off'])->label(false); ?>
	        </div>
	   </div>
	  
	   <div class="form-group row">
	        <label class="control-label col-md-4">Allocated Messages</label>
	        <div class="col-md-8">
                <?= $form->field($model, 'allocated_msgs')->textinput(['class' => 'form-control','autocomplete'=>'off'])->label(false); ?>
	        </div>
	   </div>
	   <div class="form-group row">
	        <label class="control-label col-md-4">Used Messages</label>
	        <div class="col-md-8">
                <?= $form->field($model, 'used_msgs')->textinput(['class' => 'form-control','autocomplete'=>'off', 'readonly'=>'true'])->label(false); ?>
	        </div>
	   </div>
	   
	 <div class="form-group row">
	   <label class="control-label col-md-4">Cancel Decision</label>
	    <div class="col-md-8">
			       <?= $form->field($model, 'cancel_decision')
				  ->dropdownlist(['1'=>'POS User','2'=>'Pilot','3'=>'Both']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div>
	 </div>
	  
	 <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Bill Copy</label>
	    <div class="col-md-8">
			       <?= $form->field($model, 'merchant_bill_copy')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div>
	</div> 
	
		    <div class="form-group row">
	   <label class="control-label col-md-4">Cancel With OTP</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'cancel_with_otp')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   
	   
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Mobile Number</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'mobile',['enableAjaxValidation' => true])->textinput(['class' => 'form-control','autocomplete'=>'off','maxlength'=>10,'placeholder'=>'Mobile Number'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Password</label>
	   <div class="col-md-8">
				      <?= $form->field($model, 'password')->passwordinput(['class' => 'form-control','autocomplete'=>'new-password'
,'placeholder'=>'Enter Password', 'value' => null ])->label(false); ?>
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Store Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'storename')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Store Name'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">State</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'state')->textinput(['class' => 'form-control','autocomplete'=>'off'
,'placeholder'=>'Enter State'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Location</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'location')->textinput(['class' => 'form-control','autocomplete'=>'off'
,'placeholder'=>'Enter Location'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Longitude</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'longitude')->textinput(['class' => 'form-control','autocomplete'=>'off'
,'placeholder'=>'Enter Longitude'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Verify</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'verify')->checkbox(['class' => 'form-control'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">logo</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'logo')->fileinput(['class' => 'form-control'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">QR code </label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'qrlogo')->fileinput(['class' => 'form-control'])->label(false);
				 ?> 
	   </div></div>
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Cover Pic</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'coverpic')->fileinput(['class' => 'form-control'])->label(false);
				 ?> 
	   </div></div>
	   
	   <div class="form-group row">
	   <label class="control-label col-md-4">Open Time</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'open_time')->dropdownlist($hrRange,['prompt'=>'Select'])->label(false); ?> 
	   </div></div>

<div class="form-group row">
	   <label class="control-label col-md-4">Close Time</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'close_time')
				  ->dropdownlist($hrRange,['prompt'=>'Select'])->label(false); ?>  
	   </div></div>
	   	   	    <div class="form-group row">
	   <label class="control-label col-md-4">Tip</label>
	   <div class="col-md-8">
  <?= $form->field($model, 'tip')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Tip'])->label(false); ?>

	   </div></div>
	   
        <div class="form-group row">
	   <label class="control-label col-md-4">Food Service Type</label>
	   <div class="col-md-8">
    <?= $form->field($model, 'food_serve_type')
				  ->dropdownlist(['1'=>'Dining','2'=>'Take Away','3'=>'Both']
				  ,['prompt'=>'Select'])->label(false); ?>


	   </div></div>
	   
	   <div class="form-group row">
	   <label class="control-label col-md-4">Table Occupancy</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'table_occupy_status')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  )->label(false); ?>
	   </div></div>
	   
	<div class="form-group row">
	   <label class="control-label col-md-4">Popularity</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'popularity')
				  ->dropdownlist(['1'=>'New','2'=>'Most Popular','3'=>'Both']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div> 
	   
	<div class="form-group row">
	   <label class="control-label col-md-4">Approx Cost</label>
	 <div class="col-md-8">
        <?= $form->field($model, 'approx_cost')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Approx Cost'])->label(false); ?>
   </div></div> 	   
	   
	<div class="form-group row">
	   <label class="control-label col-md-4">GST Number</label>
	 <div class="col-md-8">
        <?= $form->field($model, 'gst_number')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'GST Number'])->label(false); ?>
   </div></div>
	   
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
	       	       		<button class="btn btn-danger btn-xs" style="border-radius:25px;" data-dismiss="modal">Cancel</button>
		<?= Html::submitButton('Edit Merchant', ['class'=> 'btn btn-add placeorder']); ?>

      </div> 


<?php ActiveForm::end() ?>
<?php
$script = <<< JS
    $('#tblAddRow1').DataTable();
	$('select').select2();
JS;
$this->registerJs($script);
?>
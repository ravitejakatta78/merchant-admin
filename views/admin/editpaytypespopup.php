<style >
.selection{
	display:none;
}
	</style>
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$paytypearray = array('1'=>'Cash On Dine','2'=>'Online Payment'
,'3'=>'UPI Scanner','4'=>'Card Swipe');
?>
<?php 
		$merchants = (\app\models\Merchant::find()->where(['ID'=>$model['merchant_id']])->asArray()
				  ->one());
	  
		?>
  			<?php /*	$form = ActiveForm::begin([
    		'id' => 'payment-method-form',
			'action' =>'updatepaymentmethod',
		'options' => ['class' => 'form-horizontal','onsubmit' => 'return validateformupddate()','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) */?>
		<form id="payment-method-form" class="form-horizontal" action="updatepaymentmethod" method="post"  onsubmit="return validateformupddate()" wrapper="col-xs-12">
<div class="row">	
<div class="col-md-6">	

	   <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Name</label>
	   <div class="col-md-8">
	   <input type="hidden" value="<?= $merchants['ID']; ?>" name="MerchantPaytypes[merchantId]">
           <?= $merchants['storename'] ?>
	
			    
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Payment Type</label>
	   <div class="col-md-8">
	   <input type="hidden" value="<?= $model['ID']; ?>" name="MerchantPaytypes[paymenttype]" id="merchantpaytypes-update-paymenttype">
           <?= $paytypearray[$model['paymenttype']] ?>


	   	<div id="err_update_paymenttype" style="color:red;display:none">Payment Type is required</div>
	   
	   </div></div>
  
</div>
<div class="col-md-6">
		<div class="form-group row">
	   <label class="control-label col-md-4">Service Type</label>
	   <div class="col-md-8">
	   

	   <select class="test" name="updategroup[]" multiple="multiple" id="merchantpaytypes-update-servicetype">
	  		<?php foreach(\app\helpers\MyConst::_SERVICE_TYPES as $key => $value) { ?>
				<option value="<?= $key; ?>" <?php if(in_array($key , $serviceTypeDetailsArray)) { echo 'selected'; } ?>><?= $value; ?></option>
	
			<?php } ?>			
	  
		</select>
	   	<div id="err_update_servicetype" style="color:red;display:none">Service Type is required</div>
	   
	   </div></div>
	</div>


</div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Edit Payment Method', ['class'=> 'btn btn-add']); ?>

      </div> 


<?php //ActiveForm::end() ?>
        </form>

<?php
$script = <<< JS
	$('select').select2();	
JS;
$this->registerJs($script);
?>
   
<script>



function validateformupddate(){
	
	var err = 0;
	var servicetype = $("#merchantpaytypes-update-servicetype").val();
	
	if(servicetype == ''){
				$("#err_update_servicetype").show();
					err = err+1;
	}
	else{
				$("#err_update_servicetype").hide();		
	}
		

	if(err > 0){
		return false;
	}
	else{
		return true;
	}
	
}


(function($) {
    $(function() {
        window.fs_test = $('.test').fSelect();
    }); 
})(jQuery);
</script>    
        
        
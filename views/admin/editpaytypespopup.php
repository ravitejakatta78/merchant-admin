<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
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
	   <select name="MerchantPaytypes[merchant_id]" id="merchantpaytypes-merchant_id" class="form-control select2-hidden-accessible" disabled>
	   				  <option value="<?= $merchants['ID'] ?>"> <?= $merchants['storename'] ?></option>
	   </select>
	
			    
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Payment Type</label>
	   <div class="col-md-8">
	   

	   	   <select name="MerchantPaytypes[paymenttype]" id="merchantpaytypes-update-paymenttype" class="form-control select2-hidden-accessible">
		   <option value="">Select Payment Type</option>
		   <option value="1" <?php if($model['paymenttype'] == '1') { echo 'selected';} ?>>Default</option>
		   <option value="2" <?php if($model['paymenttype'] == '2') { echo 'selected';} ?>>Custom</option>
		   

	   </select>
	   	<div id="err_update_paymenttype" style="color:red;display:none">Payment Type is required</div>
	   
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4"> Payment Method</label>
	   <div class="col-md-8">
	   	   	   <select name="MerchantPaytypes[paymentgateway]" id="merchantpaytypes-update-paymentgateway" class="form-control select2-hidden-accessible">
		   <option value="">Select Payment Method</option>
		   <option value="0" <?php if($model['paymentgateway'] == '0') { echo 'selected';} ?>>Cash On Delivery</option>
		   <option value="1" <?php if($model['paymentgateway'] == '1') { echo 'selected';} ?>>Paytm</option>
		   <option value="2" <?php if($model['paymentgateway'] == '2') { echo 'selected';} ?>>PhonePay</option>
		   <option value="3" <?php if($model['paymentgateway'] == '3') { echo 'selected';} ?>>online</option>		   
		   

	   </select>
	   
	<div id="err_update_paymentgateway" style="color:red;display:none">Payment Method is required</div>	


	   </div></div>	   
</div>
<div class="col-md-6">
	    <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Id</label>
	   <div class="col-md-8">
	   <input type="text" name="MerchantPaytypes[merchantid]" id="merchantpaytypes-update-merchantid" value="<?= $model['merchantid'];?>" class="form-control" >
<div id="err_update_paymentid" style="color:red;display:none">Merchant Id is required</div>

	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Key </label>
	   <div class="col-md-8">
	   	   <input type="text" name="MerchantPaytypes[merchantkey]" value="<?= $model['merchantkey'];?>" id="merchantpaytypes-update-merchantkey" class="form-control" >
		    	   <input type="hidden" name="MerchantPaytypes[ID]" value="<?= $model['ID'];?>" id="merchantpaytypes-update-ID" class="form-control" >
	  
<div id="err_update_paymentkey" style="color:red;display:none">Merchant Key is required</div>
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
	var paymentgateway = $("#merchantpaytypes-update-paymentgateway").val();
	
	if(paymentgateway == ''){
				$("#err_update_paymentgateway").show();
					err = err+1;
	}
	else{
				$("#err_update_paymentgateway").hide();		
	}
		var paymenttype = $("#merchantpaytypes-update-paymenttype").val();
	
	if(paymenttype == ''){
				$("#err_update_paymenttype").show();
					err = err+1;
	}
	else{
				$("#err_update_paymenttype").hide();		
	}	


	if(paymentgateway != '0'){
		if($("#merchantpaytypes-update-merchantkey").val() == ''){
		$("#err_update_paymentkey").show();
			err = err+1;
		}
		else{
					$("#err_update_paymentkey").hide();
		}

		if($("#merchantpaytypes-update-merchantid").val() == ''){
		$("#err_update_paymentid").show();
			err = err+1;
		}
		else{
					$("#err_update_paymentid").hide();
		}

		

		
	}
	else{
		$("#err_update_paymentid").hide();
		$("#err_update_paymentkey").hide();
		
	}
	
	if(err > 0){
		return false;
	}
	else{
		return true;
	}
	
}

</script>    
        
        
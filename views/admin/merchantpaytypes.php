
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<header class="page-header">
                    <?php 
foreach (Yii::$app->session->getAllFlashes() as $message) {
    echo SweetAlert::widget([
        'options' => [
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text' => (!empty($message['text'])) ? Html::encode($message['text']) : 'Text Not Set!',
            'type' => (!empty($message['type'])) ? $message['type'] : SweetAlert::TYPE_INFO,
            'timer' => (!empty($message['timer'])) ? $message['timer'] : 4000,
            'showConfirmButton' =>  (!empty($message['showConfirmButton'])) ? $message['showConfirmButton'] : true
        ]
    ]);
}
?>
          </header>
     <div class="loading" style="display:none">
  		<img src="<?php echo Url::base(); ?>/img/load.gif" >
  	</div>
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant Payment Details</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Payment Method</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                         <th>S No</th>
						<th>Merchant Name</th>
						<th>Payment Type</th>
						<th>Merchant Id</th>
						<th>Merchant Key</th>
						<th>Status</th>
						<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
								$paytypearray = array('1'=>'Cash','2'=>'Online','3'=>'UPI','4'=>'Card');
								
									foreach($merchantPay as $merchantPay){
								?>
                                  <tr>
                                 <td>
                                                        <?php echo $x; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $merchantPay['storename']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $paytypearray[$merchantPay['paymenttype']]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $merchantPay['merchantid']; ?>
                                                    </td>													
                                                    <td>
                                                        <?php echo $merchantPay['merchantkey']; ?>
                                                    </td>
                                                    <td><label class="switch">
            										  <input type="checkbox" <?php if($merchantPay['status']=='1'){ echo 'checked';}?> onChange="changestatus('merchant_paytypes',<?php echo $merchantPay['ID'];?>);">
            										  <span class="slider round"></span>
            										</label>
									            </td>
                                                    <td class="icons">
                                                        <a onclick="deletepaytypes('<?= $merchantPay['ID'];?>')"><span class="fa fa-trash"></span>
													</a></td>
										</tr>			
                                                	<?php $x++; }?>
                       </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Payment Method</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php 
		$merchants = (\app\models\Merchant::find()->where(['ID'=>$merchantId])->asArray()
				  ->one());
	  
		?>
        <!-- Modal body -->
        <div class="modal-body">
			<?php	$form = ActiveForm::begin([
    		'id' => 'payment-method-form',
			
		'options' => ['class' => 'form-horizontal','onsubmit' => 'return validateform()','wrapper' => 'col-xs-12',],
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
	   <label class="control-label col-md-4">Merchant Name</label>
	   <div class="col-md-8">
	   <select name="MerchantPaytypes[merchant_id]" id="merchantpaytypes-merchant_id" class="form-control select2-hidden-accessible">
	   				  <option value="<?= $merchants['ID'] ?>"> <?= $merchants['storename'] ?></option>
	   </select>
	
			    
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Payment Type</label>
	   <div class="col-md-8">
	   

	   	   <select name="MerchantPaytypes[paymenttype]" id="merchantpaytypes-paymenttype" class="form-control select2-hidden-accessible">
		   <option value="">Select Payment Type</option>
		   <option value="1">Cash On Dine</option>
		   <option value="2">Online Payment</option>
		   <option value="3">UPI Scanner</option>
		   <option value="4">Card Swipe</option>
		   

	   </select>
	   	<div id="err_paymenttype" style="color:red;display:none">Payment Type is required</div>
	   
	   </div></div>
	   
	   	   <div class="form-group row">
	   <label class="control-label col-md-4">Status</label>
	   <div class="col-md-8">
	   

	   	   <select name="MerchantPaytypes[status]" id="merchantpaytypes-status" class="form-control select2-hidden-accessible">
		   <option value="1">Yes</option>
		   <option value="2">No</option>
		   <option value="3">UPI</option>
		   <option value="4">Card</option>
		   

	   </select>
	   	<div id="err_paymenttype" style="color:red;display:none">Payment Type is required</div>
	   
	   </div></div>

	   
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Id</label>
	   <div class="col-md-8">
	   <input type="text" name="MerchantPaytypes[merchantid]" id="merchantpaytypes-merchantid" class="form-control" >
<div id="err_paymentid" style="color:red;display:none">Merchant Id is required</div>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Key </label>
	   <div class="col-md-8">
	   	   <input type="text" name="MerchantPaytypes[merchantkey]" id="merchantpaytypes-merchantkey" class="form-control" >
	  
<div id="err_paymentkey" style="color:red;display:none">Merchant Key is required</div>
	   </div></div>
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Payment Method', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
    

        
      </div>
    </div>
  </div>
  
    <div id="updatepaytypes" class="modal fade" role="dialog">
<div class="modal-dialog modal-xl" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Pilot</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="paytypesbody">
		
		</div>	
		
		  
		
	</div>
	</div>
</div>
        </section>
		<?php
$script = <<< JS
    $('#example').DataTable();
JS;
$this->registerJs($script);
?>
<script>
$(document).ready(function(){
	
	$('#example').DataTable();
});
function validateform(){
	var err = 0;

	
		var paymenttype = $("#merchantpaytypes-paymenttype").val();
	if(paymenttype == ''){
				$("#err_paymenttype").show();
					err = err+1;
	}
	else{
				$("#err_paymenttype").hide();		
	}	
	
	
	
	if(err > 0){
		return false;
	}
	else{
		return true;
	}
	
}
function deletepaytypes(id) {
	
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				confirmButtonText: "Yes",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
		var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','deletepaytype');
        

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "id");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    

					} else if (result.dismiss === 'cancel') {
					    
					}
				})
		}
</script>

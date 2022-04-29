<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
$hrRange = ['0'=>'12 AM','1'=>'1 AM','2'=>'2 AM','3'=>'3 AM','4'=>'4 AM','5'=>'5 AM','6'=>'6 AM','7'=>'7 AM','8'=>'8 AM','9'=>'9 AM','10'=>'10 AM','11'=>'11 AM',
'12'=>'12 PM','13'=>'1 PM','14'=>'2 PM','15'=>'3 PM','16'=>'4 PM','17'=>'5 PM','18'=>'6 PM','19'=>'7 PM','20'=>'8 PM','21'=>'9 PM','22'=>'10 PM','23'=>'11 PM'
];
?>
<style>
.placeorder{background:#FD8B02;border:1px solid #FD8B02;color:#fff;border-radius:24px;}
.placeorder:hover{bacground:#28a745;border:1px solid #28a745;}
</style>
<script src="<?= Yii::$app->request->baseUrl.'/js/typeahead.js'?>"></script>
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant List</h3>
				<div class="col-md-6 text-right pr-0">
	<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Merchant</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S No</th>
                                    <th>Unique id</th>
                                    <th>Logo</th>
                                    <th>Merchant details</th>
                                    <th>Restaraunt / Theatre Details</th>
                                    <th>Location details</th>
                                    <th>Table Reservation</th>
                                    <th>Status</th>

                                    <th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($merchantslist as $merchant){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
                                 	<td><?php echo $merchant['unique_id'];?></td> 
                                 	<td><img style="width:100px;height:100px" src="<?= Yii::$app->request->baseUrl.'/../../merchantimages/'. $merchant['logo'];?>"/></td> 
                                 	<td><strong><?php echo $merchant['name'];?></strong><br/><?php echo $merchant['email'];?>
									<br/><?php echo $merchant['mobile'];?></td> 
										<td><strong><?php echo $merchant['storename'];?></strong></td> 
										<td><?php echo $merchant['address'];?><br/>
										<?php echo $merchant['state'];?>,<?php echo $merchant['city'];?><br/>
										<?php echo $merchant['location'];?></td>
											<td><?php if($merchant['table_res_avail'] == '1'){
											    echo "Enabled";
											}else{
											    echo "Disabled";
											}?></td>
									  <td><label class="switch">
										  <input type="checkbox" <?php if($merchant['status']=='1'){ echo 'checked';}?> onChange="changestatus('merchant',<?php echo $merchant['ID'];?>);">
										  <span class="slider round"></span>
										</label>
									</td>

									<td class="icons">
									<a title="Merchant - Delete" onClick="deletemerchant('<?=$merchant['ID'] ?>')"   ><span class="fa fa-trash"></span></a>
								   <a title="Merchant - Edit" onClick="editmerchant('<?=$merchant['ID'] ?>')"   ><span class="fa fa-edit"></span></a>
								   <!--<a title="Merchant - Rating" onClick="merchantrating('<?=$merchant['ID'] ?>')" ><span class="fa fa-star"></span></a>-->
								   <a href="transactionmerchant.php?merchant=<?php echo $merchant['ID'];?>"><span class="fa fa-eye"></span></a>
								   <a title="Merchant - Paymethods" onClick="merchantpaydetail('<?=$merchant['ID'] ?>')" ><span class="fa fa-inr"></span></a>
							       <a title="Merchant - Info" onClick="addMerchantInfo('<?=$merchant['ID'] ?>')" ><span class="fa fa-info-circle"></span></a>
								   <a title="Merchant - Amenities" onClick="merchantamenities('<?=$merchant['ID'] ?>')" ><span class="fa fa-building"></span></a>
								   <!--<a title="Edit SMS" onClick="merchantSms('<?=$merchant['ID'] ?>')" ><span class="fa fa-envelope"></span></a>-->
								   </td>	
										
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
          <h4 class="modal-title">Add Merchant</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'merchant-form',
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
	   <?= $form->field($model, 'scan_range')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter QR Scan Range(In Meters)'])->label(false); ?>
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
                    <?= $form->field($model, 'subscription_date')->textinput(['class' => 'form-control datepicker1','autocomplete'=>'off','value'=>date('Y-m-d')])->label(false); ?>
	            </div>
	        </div>
	        <div class="form-group row">
	   <label class="control-label col-md-4">Table Occupancy</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'table_occupy_status')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  )->label(false); ?>
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
	        

   <div class="form-group row">
	   <label class="control-label col-md-4">Reverse Buzz</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'reverse_buzz')
				  ->dropdownlist(['1'=>'Enable','2'=>'Disable']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>

    </div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Mobile Number</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'mobile',['enableAjaxValidation' => true])->textinput(['class' => 'form-control','maxlength'=>10,'autocomplete'=>'off','placeholder'=>'Mobile Number'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Password</label>
	   <div class="col-md-8">
				      <?= $form->field($model, 'password')->passwordinput(['class' => 'form-control','autocomplete'=>'new-password'
,'placeholder'=>'Enter Password'])->label(false); ?>
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
	   <label class="control-label col-md-4">Cover Pic</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'coverpic')->fileinput(['class' => 'form-control'])->label(false);
				 ?> 
	   </div></div>

<div class="form-group row">
	   <label class="control-label col-md-4">Open Time</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'open_time')
				  ->dropdownlist($hrRange,['prompt'=>'Select'])->label(false); ?> 
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
	   <label class="control-label col-md-4">Popularity</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'popularity')
				  ->dropdownlist(['1'=>'New','2'=>'Most Popular','3'=>'Both']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   
	   <div class="form-group row">
	   <label class="control-label col-md-4">Cancel Decision</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'cancel_decision')
				  ->dropdownlist(['1'=>'POS User','2'=>'Pilot','3'=>'Both']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   
	   	   <div class="form-group row">
	   <label class="control-label col-md-4">Merchant Bill Copy</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'merchant_bill_copy')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   
	    <div class="form-group row">
	   <label class="control-label col-md-4">Cancel With OTP</label>
	 <div class="col-md-8">
			       <?= $form->field($model, 'cancel_with_otp')
				  ->dropdownlist(['1'=>'Yes','2'=>'No']
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   
	   
	   
	   
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
	       		<button class="btn btn-danger btn-xs" style="border-radius:25px;" data-dismiss="modal">Cancel</button>
		<?= Html::submitButton('Add Merchant', ['class'=> 'btn btn-add btn-hide placeorder']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
        
        
        
      </div>
    </div>
  </div>
  
<div id="editmerchant" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Merchant</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editmerchantbody">
		
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


          function datepickerfrom(){
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
 $('.datepicker3 ').datepicker({
            uiLibrary: 'bootstrap',
			format: 'yyyy-mm-dd',
			startDate: nowDate 
        });
		}


function deletemerchant(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deletemerchant",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}

function merchantrating(id){


        var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','rating');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    


}
function merchantdashboard(id){


        var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','dashboard');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    


}


function merchantpaydetail(id)
{
	    var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','paydetails');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    

}
function addMerchantInfo(id)
{
	    var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','merchant-info');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    

}

function merchantamenities(id)
{
	    var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','merchant-amenities');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();        
}
function merchantSms(id)
{
	var form=document.createElement('form');
    form.setAttribute('method','post');
    form.setAttribute('action','merchantsms');
    form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "merchantId");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    

}

</script>

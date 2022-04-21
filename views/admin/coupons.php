<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Coupons List</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Coupons</button>
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
					<th>S.No.</th>
					<th>Coupon Type</th> 
					<th>Code</th>
					<th>Price</th>
					<th>Max amount</th>
					<th>From date</th>
					<th>To date</th>       
					<th>Status</th>
					<th>Status Acion</th>
					<th>Date & Time</th>
					<th>Actions</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($coupondet as $coupon){
								?>
                                  <tr>
                                 	<td><?=$x;?></td>
											<td><?=$coupon['purpose'];?></td>
											<td><?=$coupon['code'];?></td>
											<td><?php if($coupon['type']=='amount'){ echo '<i class="fa fa-inr"></i>';}?><?=$coupon['price'];?><?php if($coupon['type']=='percent'){ echo '%';}?></td>
											<td><?=$coupon['maxamt'];?></td>
											<td><?=$coupon['fromdate'];?></td>
											<td><?=$coupon['todate'];?></td>	
											<td><?=$coupon['status'];?> </td>
											<td><label class="switch">										  
											<input type="checkbox" <?php if($coupon['status']=='Active'){ echo 'checked';}?> onChange="changestatus('coupon',<?php echo $coupon['ID'];?>);">										  
											<span class="slider round"></span>										
										</label>
											</td>
											<td><?=date('d/m/Y H:i',strtotime($coupon['reg_date']));?></td>
											<td class="icons"><a onClick="editcoupon('<?=$coupon['ID'] ?>')"   >
										<span class="fa fa-edit"></span></a>
										<a onClick="deletecoupon('<?=$coupon['ID'] ?>')"   >
										<span class="fa fa-trash"></span></a>
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
          <h4 class="modal-title">Add Coupon</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'coupon-form',
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
		<?= Html::submitButton('Add Coupon', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
      </div>
    </div>
  </div>
  <div id="editcoupon" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Coupon</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editcouponbody">
		
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
function deletecoupon(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deletecoupon",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}
</script>
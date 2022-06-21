<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
   <style type="text/css">
  .select-all-none .select2   { display : none}
.multiselect-container { height:200px;overflow-y:scroll;width:230px; }
.multiselect-container > li{
	height:34px;
}
.multiselect{width:230px;background:#fff;}
.multiselect-container > li > a > label.checkbox{padding-left:10px;}
</style> 
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
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Client List</h3>
				<div class="col-md-6 text-right pr-0">
					<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Client</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                    
                  <table id="example" class="table table-striped table-bordered ">
				  	<thead>   
				  		<tr>
							<th>S No</th>
							<th>Merchant Name</th>
							<th>Subscription Amount/Year</th>
							<th>Subscription Start Date</th>
							<th>Executive Name & ID</th>
							<th>Payment Status</th>
							<th>Action</th>
	                    </tr>
                    </thead>
		    <tbody>
			<?php $x=1; 
					foreach($clients as $client){
								?>
                                  <tr>
                                 	<td><?=$x;?></td>
											<td><?=$client['storename'];?></td>
											<td><?=$client['subscription_amount'];?></td>
											<td><?=date('d-m-Y',strtotime($client['subscription_start_date']));?></td>
											<td><?=$client['executive_details'];?></td>
											<td><?= $client['payment_status'] == 1 ? 'Paid' : 'Pending';?></td>
											<td class="icons">
												<a title="Article - Delete" onClick="deleteClient('<?= $client['ID']; ?>')"   ><span class="fa fa-trash"></span></a>
								    			<a title="Article - Edit" onClick="editClient('<?= $client['ID']; ?>')"   ><span class="fa fa-edit"></span></a>
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
          <h4 class="modal-title">Add Client</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<?php	$form = ActiveForm::begin([
    		'id' => 'client-form',
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
	   <div class="modal-footer">
		<?= Html::submitButton('Add Client', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
    

        
      </div>
    </div>
  </div>
</div>
<div id="editcontest" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Client</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editcontestbody">
			
		</div>	
		
		  
		
	</div>
	</div>
</div>


<div id="editclient" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" >
    	<div class="modal-content">
      
			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Edit Client</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div id="editclientbody">
			
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
function deleteClient(id){
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "delete-client",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
                    	
							location.reload();
						});
					}
				});

}

function editClient(id)
{

$.ajax({
  url: "edit-client-popup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editclientbody').html(msg);
	$('#editclient').modal('show');
});		

}
		</script>
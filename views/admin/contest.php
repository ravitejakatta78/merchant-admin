<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Contest List</h3>
				<div class="col-md-6 text-right pr-0">
					<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Contest</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                    <thead>
                  <table id="example" class="table table-striped table-bordered ">
                      <tr>
                         <th>S No</th>
						<th>Contest Id</th>
						<th>Contest Name</th>
						<th>Contest Merchants</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Action</th>
	
				   
                      </tr>
                    </thead>
		    <tbody>
			<?php $x=1; 
									foreach($contest as $contest){
								?>
                                  <tr>
                                 	<td><?=$x;?></td>
											<td><?=$contest['contest_id'];?></td>
											<td><?=$contest['contest_name'];?></td>
											<td class="icons">		<a title="Edit" onClick="editcontestparticpants('<?=$contest['ID'] ?>')"   ><span class="fa fa-eye"></span></a></td>
											
											<td><?=date('d/m/Y',strtotime($contest['contest_start_date']));?></td>
											<td><?=date('d/m/Y',strtotime($contest['contest_end_date']));?></td>
											<td><?php if($contest['contest_end_date'] < date('Y-m-d')){
												echo "Expired";
											}else{
												echo "Active";
											}?></td>	
											<td class="icons"><?php if($contest['contest_end_date'] < date('Y-m-d')){
												
											}else { ?>
												<a title="Edit" onClick="editcontestpopup('<?=$contest['ID'] ?>')"   ><span class="fa fa-edit"></span></a>
	
											<?php } ?></td>
								
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
          <h4 class="modal-title">Add Contest</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<?php	$form = ActiveForm::begin([
    		'id' => 'employee-form',
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
      'id'=>'multiple-checkboxes',              
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
	   <label class="control-label col-md-4">Contest Area</label>
 <div class="col-md-8">	   
	   <?= $form->field($model, 'contest_image')->fileinput(['class' => 'form-control'])->label(false) ; ?>
				  
	   </div>
	   </div>
	   </div>
	           
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest Start Date</label>
	   <div class="col-md-8">
	   	   	   <?= $form->field($model, 'contest_start_date')->textinput(['class' => 'form-control datepicker1','value'=>date('Y-m-d')])->label(false); ?>

			   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Contest End Date</label>
	   <div class="col-md-8">
				   	   	   <?= $form->field($model, 'contest_end_date')->textinput(['class' => 'form-control datepicker2','value'=>date('Y-m-d')])->label(false); ?>

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
        
    

        
      </div>
    </div>
  </div>
</div>
<div id="editcontest" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Contest</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editcontestbody">
			
		</div>	
		
		  
		
	</div>
	</div>
</div>

<div id="contestmerchants" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Contest Participant Merchants</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="contestmerchantsbody">
		
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
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
	<script>
	    $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
	</script>



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
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Pilot List</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Pilot</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                         <th>S No</th>
						<th>Pilot Id</th>
						<th>Pilot Name</th>
						<th>Mobile Number</th>
						<th>Email</th>
						<th>Logged In</th>
						<th>Status</th>
						<th>Action</th>
				   
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($pilotModel as $pilotModel){
								?>
                                  <tr>
                                 <td>
                                                        <?php echo $x; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['unique_id']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['mobile']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['email']; ?>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php if($pilotModel[ 'loginaccess']=='1' ){ echo 'checked';}?> 
															onChange="changeloginaccess('serviceboy',
                                                            <?php echo $pilotModel['ID'];?>);"> <span class="slider round"></span> </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php   if($pilotModel[ 'status']=='1' ){ echo 'checked';}?> 
															onChange="changestatus('serviceboy',
                                                            <?php echo $pilotModel['ID'];?>);"> <span class="slider round"></span> </label>
                                                    </td>
                                                    <td class="icons"><a onclick="updatepilot('<?= $pilotModel['ID'];?>')"><span class="fa fa-pencil"></span>
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
          <h4 class="modal-title">Add Pilot</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<?php	$form = ActiveForm::begin([
    		'id' => 'pilot-form',
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
	   <label class="control-label col-md-4">Pilot Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'name')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Pilot Name'])->label(false); ?>
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Mobile Number</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'mobile')->textinput(['class' => 'form-control','placeholder'=>'Mobile Number'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Email</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'email')->textinput(['class' => 'form-control','placeholder'=>'Email'])->label(false); ?>
	   </div></div>
	   
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Password</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'password')->passwordinput(['class' => 'form-control','placeholder'=>'Password'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Joined On</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'joiningdate')->textinput(['class' => 'form-control datepicker1'])->label(false); ?>
	   </div></div>
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Pilot', ['class'=> 'btn btn-add']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
    

        
      </div>
    </div>
  </div>
  
    <div id="updatepilot" class="modal fade" role="dialog">
<div class="modal-dialog modal-xl" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Pilot</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="pilotbody">
		
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
</script>

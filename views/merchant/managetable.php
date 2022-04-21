<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Manage Table</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Table</button>
				</div>
              </div>
              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
						<th>S No</th>
						<th>Table Name</th> 
						<th>Capacity</th> 
						<th>Download QR Code</th> 
						<th>Status</th>             
						<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($tableDet as $productlist){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>                     
									<td><?php echo $productlist['name'];?></td>  
									<td><?php echo $productlist['capacity'];?></td>  
									<td class="icons"><a class="label label-xs label-warning " <?php if(!empty($merchantdetails['qrlogo'])){?>  
									href="../../../test.php?table=<?= $productlist['ID'];?>&tablename=<?= $productlist['name'];?>&userid=<?= $merchantdetails['ID']; ?>&qrlogo=<?= $merchantdetails['qrlogo']; ?>"	<?php }?> target="_blank" ><span class="fa fa-download"></span></a></td>		
									<td><label class="switch">	
									  <input type="checkbox" <?php if($productlist['status']=='1'){ echo 'checked';}?> onChange="changestatus('tablename',<?php echo $productlist['ID'];?>);">	
									  <span class="slider round"></span>
										</label>					
									</td>
                                    <td  class="icons"><a onclick="edittablepopup('<?php echo $productlist['ID']; ?>')"  ><span class="fa fa-pencil"></span></a></td>
                                                                  </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>
		  
                </div>
              </div>
            </div>
          </div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Table</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
				<?php	$form = ActiveForm::begin([
    		'id' => 'add-table-form',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>
		<div class="form-group row">
		<label class="control-label col-md-4">Table Name</label>
		<div class="col-md-8">
		 <?= $form->field($model, 'name')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Table Name'])->label(false); ?>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="control-label col-md-4">Capacity</label>
		<div class="col-md-8">
		 <?= $form->field($model, 'capacity')->textinput(['class' => 'form-control','autocomplete'=>'off','placeholder'=>'Capacity'])->label(false); ?>
		</div>
		</div>
		
   <div class="modal-footer">
		<?= Html::submitButton('Add Table', ['class'=> 'btn btn-add']); ?>
      </div> 
		<?php ActiveForm::end() ?>
		
	    </div>
        
        
        
      </div>
    </div>
  </div>
  
    <div id="edittable" class="modal fade" role="dialog">
<div class="modal-dialog " >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Table</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="edittablebody">
		
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

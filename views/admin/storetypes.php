<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant Types List</h3>
				<div class="col-md-6 text-right pr-0">
					<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Merchant Type</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                    <thead>
                  <table id="example" class="table table-striped table-bordered ">
                      <tr>
                         <th>S No</th>
						<th>Store Type</th>
						<th>Status</th>
						<th>Action</th>
	
				   
                      </tr>
                    </thead>
		    <tbody>
			<?php $x=1; 
									foreach($storetype as $storetype){
								?>
                                  <tr>
                                 	<td><?=$x;?></td>
									<td><?= $storetype['storetypename']; ?>
									<td><?php if($storetype['type_status'] == '0'){ ?> Inactive <?php }else { ?> Active  <?php } ?>
<td class="icons" ><a  onclick="storetypechange('<?= $storetype['ID'] ?>')" title="Store Type Edit"><span class="fa fa-edit"></span></a>									
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
          <h4 class="modal-title">Add Merchant Types</h4>
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
	   <label class="control-label col-md-4">Merchant Type Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'storetypename')->textinput(['class' => 'form-control','autocomplete'=>'off'
				  ,'placeholder'=>'Merchant Type Name'])->label(false); ?>
	   </div>
	   </div>
	   
	   </div>
	         
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Merchant Type', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
    

        
      </div>
    </div>
  </div>
</div>
<div id="editstore" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Merchant Types</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editstorebody">
			
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


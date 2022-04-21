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
                <h3 class="h4 col-md-6 pl-0 tab-title">Rewards List</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Rewards</button>
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
									<th>S No</th> 
                                    <th>Reward type</th>  
                                    <th>Title</th>  
                                    <th>Tag line</th>  
                                    <th>Description</th>  
                                    <th>Coins</th>  
                                    <th>Coupons List</th>  
                                    <th>Validity from</th>  
                                    <th>Validity to</th>  
                                    <th>Sold out</th>      
                                    <th>Cover image</th>  
                                    <th>Logo image</th>        
                                    <th>Status</th>            
									<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($rewardsdet as $rewards){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>   
                                 	<td><?php echo $rewards['rewardtype'];?></td>   
                                 	<td><?php echo $rewards['title'];?></td>   
                                 	<td><?php echo $rewards['excerpt'];?></td>   
                                 	<td><?php echo $rewards['description'];?></td>   
                                 	<td><?php echo $rewards['coins'];?></td>   
                                 	<td><a>Coupon codes</a></td>   
                                 	<td><?php echo $rewards['validityfrom'];?></td>   
                                 	<td><?php echo $rewards['validityto'];?></td>   
                                 	<td><?php echo $rewards['soldout']=='0' ? 'Available' : 'Sold';?></td>   
									<td><img  width="100" height="100"  src="<?= Yii::$app->request->baseUrl.'/uploads/rewardsimage/'. $rewards['cover'];?>" /></td>
									<td><img  width="100" height="100"  src="<?= Yii::$app->request->baseUrl.'/uploads/rewardsimage/'. $rewards['logo'];?>" /></td>
									<td><label class="switch">										  
											<input type="checkbox" <?php if($rewards['status']=='1'){ echo 'checked';}?> onChange="changestatus('rewards',<?php echo $rewards['ID'];?>);">										  
											<span class="slider round"></span>										
										</label>		
									</td>
                             <td class="icons"><a onclick="editrewardpopup('<?= $rewards['ID'];?>')"><span class="fa fa-pencil"></span></a>
                              <a onclick="deletereward('<?= $rewards['ID'];?>')"><span class="fa fa-trash"></span></a>
                             </td>
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
          <h4 class="modal-title">Add Reward</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'food-categery-form',
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
	   <label class="control-label col-md-4">Reward Type</label>
	   <div class="col-md-8">

				  			      <?= $form->field($model, 'rewardtype')
				  ->dropdownlist(['Single'=>'Single','Multiple'=>'Multiple'],['prompt'=>'Select Reward Type'])->label(false); ?>
				  
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Coins to redeem</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'coins')->textinput(['class' => 'form-control labeltag','placeholder'=>'Coins to redeem'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity from</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'validityfrom')->textinput(['class' => 'form-control datepicker1','value'=>date('Y-m-d')])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity to</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'validityto')->textinput(['class' => 'form-control datepicker2','value'=>date('Y-m-d')])->label(false); ?>
	   </div></div>
	   	   	   	<div class="form-group row">
	   <label class="control-label col-md-4">Cover Image</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'cover')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Title</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'title')->textinput(['class' => 'form-control','placeholder'=>'Title'])->label(false); ?>
	   </div></div>


	   <div class="form-group row">
	   <label class="control-label col-md-4">Tag line</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'excerpt')->textinput(['class' => 'form-control','placeholder'=>'Tag line'])->label(false); ?>
	   </div></div>
	   
	   	<div class="form-group row">
	   <label class="control-label col-md-4">Description</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'description')->textarea(['class' => 'form-control','placeholder'=>'Description'])->label(false); ?>
	   </div></div>
	   

	   
	   	   	<div class="form-group row">
	   <label class="control-label col-md-4">Logo </label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'logo')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Reward', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
      </div>
    </div>
  </div>

<div id="editreward" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Reward</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editrewardbody">
		
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
function deletereward(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deletereward",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}
</script>
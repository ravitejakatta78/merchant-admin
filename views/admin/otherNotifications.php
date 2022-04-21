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
                <h3 class="h4 col-md-6 pl-0 tab-title">Notifications</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Notification</button>
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No.</th>
						<th>Notification Type</th>
						<th>Title</th>
						<th>Message</th>
						<th>Image</th>
						<th>Date & Time</th>
				<!--		<th>Actions</th> -->
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($appNotificationModel as $notificationlist){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
						            <td><?= \app\helpers\Utility::notificationType($notificationlist['notification_type']) ;?></td>
                                 	<td><?=$notificationlist['title'];?></td>
									<td><?=$notificationlist['message'];?></td>
									<td><?php if($notificationlist['image']){ ?><img width="100px" height="100px" src="<?= SITE_URL.'/othernotificationimage/'.$notificationlist['image'];?>" alt="" ><?php }?></td>
									<td><?=date('d/m/Y H:i',strtotime($notificationlist['reg_date']));?></td>
									
								<!--	   <td class="icons">
<a onClick="editappnotification('<?=$notificationlist['ID'] ?>')"   >
										<span class="fa fa-edit"></span></a>
										<a onClick="deleteappnotification('<?=$notificationlist['ID'] ?>')"   >
										<span class="fa fa-trash"></span></a>
</td> -->
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
          <h4 class="modal-title">Add Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'app-notification-form',
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
	   <label class="control-label col-md-4">Title</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'title')->textinput(['class' => 'form-control labeltag','placeholder'=>'Title'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Image</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'image')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>

	   	   	   	
</div>
<div class="col-md-6">

	   <div class="form-group row">
	   <label class="control-label col-md-4">Content</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'message')->textarea(['class' => 'form-control','placeholder'=>'Content'])->label(false); ?>
	   </div></div>
	   
	   	   <div class="form-group row">
	   <label class="control-label col-md-4">Nofication Type</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'notification_type')->dropdownlist(\app\helpers\Utility::notificationType()
                    ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>

	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Notifcation', ['class'=> 'btn btn-add btn-hide']); ?>

      </div> 


<?php ActiveForm::end() ?>
      </div>
    </div>
  </div>
    <div id="editappnotification" class="modal fade" role="dialog">
<div class="modal-dialog modal-xl" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editeditappnotificationbody">
		
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
function deleteappnotification(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deleteappnotification",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}
</script>

<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
$actionId =  Yii::$app->controller->action->id;
?>
 <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl.'/css/css/custom1.css'?>"> 
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
            <div class="card" >
              <div class="card-header d-flex align-items-center pt-0 pb-0" >
                <h3 class="h4 col-md-6 pl-0 tab-title" ><?= $storetype['storetypename']; ?> Permissions</h3>
				<input type="hidden" id="storeid" value="<?= $storetype['ID'] ;?>">
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
                <div class="row">   
					<?php for($i=0;$i<count($permissions);$i++) { ?>
					    <div id="assignpermissionid<?= $permissions[$i]['ID']; ?>" onclick="assignpermissions('<?= $permissions[$i]['ID']; ?>')" class="col-md-3 
					    <?php if(in_array($permissions[$i]['ID'],$rolePermissionArray)) {  ?> permission <?php } ?>">
					<div class="tile">
					<div class="tile-icon text-center">
					<i class="fa fa-building-o"></i>
					</div>
					<div class="tile-text">
					<?= $permissions[$i]['process_name'];?>
					</div>
					</div>
					</div>
					<?php } ?>
					
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
function assignpermissions(display_id)
{
	var clsCheck = $("#assignpermissionid"+display_id).hasClass("permission");
	if(clsCheck == true){
		  $("#assignpermissionid"+display_id).removeClass('permission');
	}
	else{
		  $("#assignpermissionid"+display_id).addClass('permission');
	}
	
	var storeid = $("#storeid").val();
	
var request = $.ajax({
  url: "saverolepermissions",
  type: "POST",
  data: {main_pernission_id : display_id, storeid:storeid},
}).done(function(msg) {

});
}
</script>
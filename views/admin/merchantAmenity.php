<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use app\models\MerchantAmenities;

$amenities = MerchantAmenities::AMENITIES;

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
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant Amenities</h3>
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S No</th>
                        <th>Amenity</th>
                        <th>Action</th>
                        <th>Visibility</th>
                      </tr>
                    </thead>
		            <tbody>
                        <?php $x = 0; foreach($amenities as $key => $value) { ?>
                            <tr>
                                <td><?= $x+1; ?></td>
                                <td><?= $value; ?></td>
                                 <td><label class="switch">
										  <input type="checkbox" <?php if(@$resMerchantAmenity[$key]=='1'){ echo 'checked';}?> onChange="changeAmenityStatus(<?php echo $key;?>,'<?= $merchantId; ?>');">
										  <span class="slider round"></span>
										</label>
								</td>
								<td><label class="switch">
										  <input type="checkbox" <?php if(@$resMerchantVisibilityAmenity[$key]=='1'){ echo 'checked';}?> onChange="changeAmenityVisibilityStatus(<?php echo $key;?>,'<?= $merchantId; ?>');">
										  <span class="slider round"></span>
										</label>
								</td>
                            </tr>    
                        <?php $x++; } ?>
                    </tbody>
                  </table>

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


function changeAmenityStatus(id,merchantId){
    var request = $.ajax({
						  url: "change-amenity-status",
						  type: "POST",
						  data: {id : id,merchantId : merchantId},
						}).done(function(msg) {
							location.reload();
						});
}

function changeAmenityVisibilityStatus(id,merchantId){
    var request = $.ajax({
						  url: "change-amenity-visibility-status",
						  type: "POST",
						  data: {id : id,merchantId : merchantId},
						}).done(function(msg) {
						    var res = JSON.parse(msg);
						    if(res['status'] == '2'){
						        alert(res['msg']);
						    }
							location.reload();
						});
}
</script>

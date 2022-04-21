<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<style type="text/css">
  .selection{display: none;}
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant Grouping</h3>
				<div class="col-md-6 text-right pr-0">
			<!--	<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal">
			<i class="fa fa-plus mr-1"></i> Add Coupons</button> -->
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
					<th>S.No.</th>
					<th>Merchant Name</th> 
					<th>Store Name</th>
					<th>Actions</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($res as $res){
								?>
                                  <tr>
                                 	<td><?=$x;?></td>
											<td><?=$res['name'];?></td>
											<td><?=$res['storename'];?></td>
											
						<td class="icons"><a onClick="editgrouping('<?=$res['ID'] ?>')"   >
							<span class="fa fa-edit"></span></a>
						</td>
                                </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
<div id="updatefoodcategery" class="modal fade" role="dialog">
<div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Merchant Grouping</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form method="post" action="updategroup">
        <div class="modal-body" id="foodcategerybody">
		</div>	
	</form> 	  
		
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


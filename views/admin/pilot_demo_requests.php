
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
$actionId = Yii::$app->controller->action->id;

?>
<script src="<?= Yii::$app->request->baseUrl.'/js/jquery.table2excel.js'?>"></script>
<style>
ul.resp-tabs-list, p {
  margin: 0;
  padding: 0;
}
.resp-tabs-list li {
  font-weight: 600;
  font-size: 14px;
  display: inline-block;
  padding: 15px 15px;
  margin: 0 4px 0 0;
      margin-bottom: 0px;
  list-style: none;
  cursor: pointer;
  float: left;
background:#ffcf95;
border-radius:4px 4px 0 0;
color:#333;
}
.resp-tab-active {
  padding: 12px 14px 14px !important;
  border-top: 4px solid #fe2503 !important;
  border-bottom: 0 #fff solid !important;
background:#FD8B02 !important;
color:#fff !important;

}

	</style>
<header class="page-header">
          </header>
          <section>
		  <?= \Yii::$app->view->renderFile('@app/views/admin/_demo_requests.php',['actionId'=>$actionId]); ?>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Pilot Demo Requests</h3>
				<div class="col-md-6 text-right pr-0">
				</div>
              </div>


              <div class="card-body">
			  

                  <table  id="example" class="table table-striped table-bordered ">
                    <thead>
                      	<tr>
							<th>S.No</th>
							<th>Business Name</th>
							<th>Owner Name</th>
							<th>Location</th>
							<th>City</th>
							<th>State</th>
							<th>Pin Code</th>
							<th>Mobile Number</th>
							<th>Alternative Mobile Number</th>
							<th>Date & Time</th>
						</tr>
                    </thead>
		    		<tbody>
						<?php $x=1; 
						foreach($res as $res){
						?>
                            <tr>
								<td><?= $x; ?></td>
								<td><?= $res['business_name']; ?></td>
								<td><?= $res['owner_name']; ?></td>
								<td><?= $res['location']; ?></td>
								<td><?= $res['city']; ?></td>
								<td><?= $res['state']; ?></td>
								<td><?= $res['pincode']; ?></td>
								<td><?= $res['mobile_number']; ?></td>
								<td><?= $res['alt_mobile_number']; ?></td>
								<td><?= date('d-M-Y h:i A',strtotime($res['reg_date'])); ?></td>
								
							</tr>
							
							<?php $x++; } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>


	
        </section>
		<?php
$script = <<< JS
    $('#example').DataTable({
		"scrollX": true
	});
JS;
$this->registerJs($script);
?>

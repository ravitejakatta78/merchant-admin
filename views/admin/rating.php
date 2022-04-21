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
 <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Feedback Rating</h3>
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
			  <form class="form-horizontal" method="POST" action="rating">
			  <div class="row">
			  <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">Start Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker1" name="sdate" placeholder="Start Date" value="<?= $sdate ; ?>">
                </div>
                  </div>
				  </div>
				  </div>
				  
				 <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">End Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker2" name="edate" placeholder="End Date" value="<?= $edate ; ?>">
                </div>
				</div>
                  </div>
				  </div>
				  
				  
				  <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-1">Restaurant:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <select id="merchantId" name="merchantId">
				  <option value="">Select</option>
				  <?php for($i=0;$i<count($merchants);$i++){ ?>
				  <option value="<?= $merchants[$i]['ID']?>" <?php if($merchantId == $merchants[$i]['ID'] ){ echo 'selected'; }; ?>><?= $merchants[$i]['storename'] ;?> </option>
				  <?php } ?>
				  </select> 
				 </div>
                </div>
                  </div> 
				  </div>
				  
				  
				  
 
				  <div class="col-md-3 ">
                  <div class="form-group pt-3">
                    <input type="submit" value="Search" class="btn btn-add btn-sm btn-search"/>
                  </div>
				  </div>
                  </div>
                </form>
   
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Store Name</th>
                        <th>Merchant</th>
                        <th>Pilot</th>
                        <th>Customer</th>
                        <th>Order id</th> 
                        <th>Total amount</th> 
					    <th>Rating</th> 
					    <th>Message</th> 
				        <th>Date</th> 
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($ratingModel as $ratinglist){
								?>
                                <tr>
                                 	<td><?php echo $x;?></td>
                                 	<td><?php echo $ratinglist['storename'];?></td>
                                 	<td><?php echo $ratinglist['merchant_name'];?></td>
									<td><?php echo $ratinglist['service_boy_name'];?></td>
									<td><?php echo $ratinglist['user_name'];?></td>
									<td><?php echo $ratinglist['order_id'];?></td>
									<td><?php echo $ratinglist['totalamount'];?></td>
									<td><?php echo $ratinglist['rating'];?></td>
									<td><?php echo $ratinglist['message'];?></td>
									<td><?php echo date('d M Y',strtotime($ratinglist['reg_date']));?></td>
                                </tr>
									<?php $x++; }?>
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
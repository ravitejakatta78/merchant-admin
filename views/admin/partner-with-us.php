<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$businessType = ['1' => 'Investment', '2' => 'Delivery and Self-Pickup', '3' => 'POS and Inventory Management
', '4' => 'Table reservation', '5' => 'Hotel Reservation', '6' => 'Flats Collaboration'
,'7' => 'Water Services', '8' => 'Home Chef', '9' => 'Personalized Chef', '10' => 'Food items subscription'
];

?>
<header class="page-header">
</header>
	<div class="loading" style="display:none">
  		<img src="<?php echo Url::base(); ?>/img/load.gif" >
  	</div>
 <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Partner With Us</h3>
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S No</th>
                        <th>Date & Time</th>
                                    <th>Business Type</th>
                                    <th>Business Name</th>
                                    <th>Contact Person</th>
                                    <th>Mobile Number</th>
                                    <th>Email</th>
                                    <th>Location</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($res as $res){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
                                  <td><?= date('d-M-Y h:i A' ,strtotime($res['reg_date'])); ?>
                                 	<td><?= $businessType[$res['business_type']]; ?></td>
									 <td><?= $res['business_name']; ?></td>
									 <td><?= $res['contact_person']; ?></td>
									 <td><?= $res['mobile_number']; ?></td>
									 <td><?= $res['email_id']; ?></td>
									 <td><?= $res['location_city']; ?></td>	
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
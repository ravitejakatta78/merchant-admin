
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<header class="page-header">
<?php if (Yii::$app->session->hasFlash('success')): 
   echo SweetAlert::widget([
    'options' => [
        'title' => "Order!",
        'text' => "Order Placed Successfully",
        'type' => SweetAlert::TYPE_SUCCESS,
		'timer' => 3000,
    ]
]);
 endif; ?>
          </header>
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Cuurent Orders</h3>
				<div class="col-md-6 text-right pr-0">
				

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                         <th>S No</th>
						<th>Table Name</th>
						<th>Current Status</th>
						<th>Amount</th>
						<th>Bill</th>
						<th>Status</th>
				   <th>Action</th>
                      </tr>
                    </thead>
						<tbody>
							<?php for($i=0;$i<count($tableDetails);$i++) { ?>
							<tr>
							<td><?= $i+1 ;?></td>
							<td><?= $tableDetails[$i]['name'] ;?></td>
							<td><?= Utility::orderstatus_details($tableDetails[$i]['orderprocess'] ?? 5) ;?></td>
							<td><?= $tableDetails[$i]['totalamount'] ;?></td>
							<td class="icons">
							<?php if(isset($tableDetails[$i]['orderprocess'])) { ?>
							<a onclick="billview('<?= $tableDetails[$i]['ID'] ;?>')"><span class="fa fa-eye"></span></a>
							<?php } ?>
							</td>
							<td>
							<?php if(isset($tableDetails[$i]['orderprocess'])) {
								?>
							<select id="change_status_<?= $tableDetails[$i]['ID'] ?>">
							<?php $orderFlowArr = Utility::orderflowdropdown($tableDetails[$i]['orderprocess']);
							foreach($orderFlowArr as $k => $v) { ?>
						<option value="<?= $k;?>" <?php if($tableDetails[$i]['orderprocess'] == $k){ echo "selected"; } ?>><?= $v;?></option>
						<?php } ?>

							</select>
							<?php } ?>
							</td>
							<td class="icons">
							<?php if(isset($tableDetails[$i]['orderprocess'])) { ?>
							<a onclick="tableorderstatuschange('<?= $tableDetails[$i]['ID'] ;?>','<?= $tableDetails[$i]['tableId'];?>')"><i class="fa fa-cogs"></i></a>
							<?php } ?>
							</td>
							
							</tr>
							<?php } ?>
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
$(document).ready(function(){
	

});
function tableorderstatuschange(id,tableId)
{
	var chageStatusId= $("#change_status_"+id).val();
	var request = $.ajax({
  url: "tableorderstatuschange",
  type: "POST",
  data: {id : id,chageStatusId : chageStatusId,tableId:tableId},
}).done(function(msg) {
	
	swal({
				title: "Order Status", 
				text: "Order Status Changed Sucessfully", 
				type: "success",
				confirmButtonText: "Ok",
				showCancelButton: false
		    })
		    	.then((result) => {
					if (result.value) {
						location.reload();
					}
				});

	});	
}

</script>

<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<script src="<?= Yii::$app->request->baseUrl.'/js/typeahead.js'?>"></script>
<header class="page-header">

</header>
 <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Deleted Employee Data</h3>
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
						<th>Merchant Name</th>
                        <th>Employee Name</th>
						<th>Email Id</<th>
						<th>Mobile No</th>
                       </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($usersModel as $userslist){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
                                 	<td><?php echo $userslist['storename'] ;?></td>
									<td><?php echo $userslist['emp_name'];?></td>
									<td><?php echo $userslist['emp_email'];?></td>
									<td><?php echo $userslist['emp_phone'];?></td>
								   </td>	
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
function deleteuser(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deleteuser",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}
</script>
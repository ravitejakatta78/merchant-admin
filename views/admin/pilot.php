
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<header class="page-header">
      
          </header>
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Pilot List</h3>
				<div class="col-md-6 text-right pr-0">
			
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                         <th>S No</th>
						<th>Pilot Id</th>
						<th>Pilot Name</th>
						<th>Mobile Number</th>
						<th>Email</th>
						<th>Logged In</th>
						<th>Status</th>
	
				   
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($pilotModel as $pilotModel){
								?>
                                  <tr>
                                 <td>
                                                        <?php echo $x; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['unique_id']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['mobile']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $pilotModel['email']; ?>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php if($pilotModel[ 'loginaccess']=='1' ){ echo 'checked';}?> 
															onChange="changeloginaccess('serviceboy',
                                                            <?php echo $pilotModel['ID'];?>);"> <span class="slider round"></span> </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php   if($pilotModel[ 'status']=='1' ){ echo 'checked';}?> 
															onChange="changestatus('serviceboy',
                                                            <?php echo $pilotModel['ID'];?>);"> <span class="slider round"></span> </label>
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
$(document).ready(function(){
	
	$('#example').DataTable();
});
</script>

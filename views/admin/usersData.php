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
                <h3 class="h4 col-md-6 pl-0 tab-title">User Data</h3>
				<div class="col-md-6 text-right pr-0">

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Reg. Date</th>
                        <th>User Name</th>
						<th>Email Id</<th>
						<th>Mobile No</th>
						<th>Reg date</th>
						<th>Order Details</th>
						<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($usersModel as $userslist){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
                                 	<td><?php echo date('d F Y',strtotime($userslist['reg_date']));?></td>
									<td><?php echo $userslist['name'];?></td>
									<td><?php echo $userslist['email'];?></td>
									<td><?php echo $userslist['mobile'];?></td>
									<td><?php echo date('d M Y H:i:s',strtotime($userslist['reg_date']));?></td>
											   <td class="icons"><a onClick="userorders('<?=$userslist['ID'] ?>')"   ><span class="fa fa-eye"></span></a>
											   <td class="icons"><a onClick="deleteuser('<?=$userslist['ID'] ?>')"   ><span class="fa fa-trash"></span></a>
								   </td>	
                                </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
              <div id="userorders" class="modal fade" role="dialog">
<div class="modal-dialog modal-xl" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">User Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="userordersbody">
		
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
function userorders(id){
    var request = $.ajax({
  url: "userorderspopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#userordersbody').html(msg);
	$('#userorders').modal('show');
});
} 
</script>
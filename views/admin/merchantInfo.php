<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;

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
                <h3 class="h4 col-md-6 pl-0 tab-title">Merchant Info</h3>
				<div class="col-md-6 text-right pr-0">
	<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Info</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S No</th>
                        <th>Merchant Info</th>
                        <th>Action</th>
                      </tr>
                    </thead>
		            <tbody>
                        <?php for($i=0; $i < count($resMerchant); $i++) { ?>
                            <tr>
                                <td><?= $i+1; ?></td>
                                <td><?= $resMerchant[$i]['merchant_description']; ?></td>
                                <td class="icons">
									<a title="Merchant - Delete" onClick="deletemerchantinfo('<?=$resMerchant[$i]['ID'] ?>')"   ><span class="fa fa-trash"></span></a>
							   </td>
                            </tr>    
                        <?php } ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
          
          
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Info</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" action="save-merchant-info">
        <!-- Modal body -->
        <div class="modal-body">
		   	<table id="tblAddRow" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                			<th>Merchant Name</th>
                			<th>Action</th>
                        </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea type="text"  name="info[]" class="form-control" ></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="merchantId" value="<?= $merchantId; ?>">
            <div class="modal-footer">
               <button id="btnAddRow" class="btn btn-add btn-xs" type="button">Add Info</button>
        		<?= Html::submitButton('Add Info', ['class'=> 'btn btn-add btn-hide']); ?>
             </div> 
            </form>     
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
// Add row the table
$('#btnAddRow').on('click', function() {
    var lastRow = $('#tblAddRow tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRow tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRow tbody tr:last input').val('');
});


// Delete row on click in the table
$('#tblAddRow').on('click', 'tr a', function(e) {
    var lenRow = $('#tblAddRow tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});

// Add button Delete in row
$('#tblAddRow tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>');


function deletemerchantinfo(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deletemerchantinfo",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							
							location.reload();
						});
					}
				});

}

</script>

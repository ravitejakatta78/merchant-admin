<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use aryelds\sweetalert\SweetAlert;
?>
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Food Categeries</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Categery</button>
				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Food Categery</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
		    <tbody>
			<?php
			 $categeryCount = count($allcategeries);
			 for($i=0;$i< $categeryCount ;$i++){?>
			<tr>
			    <td><?= $i+1 ; ?></td>
			    <td><?= $allcategeries[$i]['food_category'] ; ?></td>
			    <td class="icons text-center">
				<a id="<?php echo $allcategeries[$i]['ID']; ?>" onclick="editcategory('<?php echo $allcategeries[$i]['ID']; ?>');"><span class="fa fa-pencil"></span></a>
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
          <h4 class="modal-title">Add Categery</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	<form method="post" action="food-categeries">
        <div class="modal-body">

		
	<div class="form-horizontal">
		<div class="form-group row">
		<label class="control-label col-md-4">Food Category</label>
		<div class="col-md-8">
		<input type="text" id="food-category" name="food_category" class="form-control">
		</div>
		</div>
		</div>
	<table id="tblAddRow" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="checkedAll"/></th>
            <th>Quantity</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <input name="ckcDel[]" type="checkbox" />
            </td>
            
			<td>
                <input name="categorytypes[]" class="form-control">
            </td>
            
        </tr>
       
    </tbody>
</table>

		</div>
	   <div class="modal-footer">
	   <button id="btnAddRow" class="btn btn-add btn-xs" type="button">
    Add Row
</button>
		<?= Html::submitButton('Add Categery', ['class'=> 'btn btn-add']); ?>

      </div> 
</form>        

        
      </div>
    </div>
  </div>

<div id="updatefoodcategery" class="modal fade" role="dialog">
<div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Categery</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form method="post" action="updatefoodcategery">
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
<script>
function addrow() {
	     var lastRow = $('#tblAddRows tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRows tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRows tbody tr:last input').val('');

}

$(document).on("click", "i[name=deleterow]", function(e) {
	 var lenRow = $('#tblAddRows tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});
$(document).on("click", "input[id=checkedAll]", function(e) {
	e.preventDefault();
    $(this).closest('#tblAddRow').find('td input:checkbox').prop('checked', this.checked);
});

// Add button Delete in row

$('#tblAddRow tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>');

// For select all checkbox in table
$('#checkedAll').click(function (e) {
	//e.preventDefault();
    $(this).closest('#tblAddRow').find('td input:checkbox').prop('checked', this.checked);
});

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


</script>    
        
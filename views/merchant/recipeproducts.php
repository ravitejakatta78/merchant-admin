
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?>
<script src="<?= Yii::$app->request->baseUrl.'/js/bootstrap-typeahead.js'?>"></script>
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
                <h3 class="h4 col-md-6 pl-0 tab-title">Recipe Product List</h3>
				<div class="col-md-6 text-right pr-0">
			<!--	<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Ingredients</button> -->

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S No</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Recipe Description</th>
						<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php 
								if(count($productModel) > 0){
								$x=1; 
									foreach($productModel as $productModel){
								?>
                                  <tr>
                                 <td>
                                                    <?php echo $x; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $productModel['title_quantity']; ?>
                                                    </td>
                                                    <td>
														<img  src="<?= Yii::$app->request->baseUrl.'/uploads/productimages/'.$productModel['image'];?>" style="height:50px" />
                                                    </td>
                                                    <td>
                                                        <?php echo $productModel['title']; ?>
                                                    </td>
                                                    <td class="icons"><a onclick="updaterecipe('<?= $productModel['ID'];?>')"><span class="fa fa-pencil"></span>
													</a></td>
										</tr>			
								<?php $x++; } }?>
                       </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
 <div class="modal-header">
          <h4 class="modal-title">Add Categery</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		
		<form method="post" action="saverecipe" id="receipeform">
        <div class="modal-body">

<div id="addedrecipe">

</div>		

		<input type="hidden" id="productid" name="productid" class="form-control">
	<table id="tblAddRow"  class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="checkedAll"/></th>
            <th>Ingredient</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr id="1">
            <td>
                <input name="ckcDel[]"  type="checkbox" />
            </td>
            
			<td>
                <input type="text" name="ingredients[]" id="ingredient1" class="form-control ingredients">
				<span id="err_ingredient1" style="display:none;color:red">Please Add Ingredient</span>
			
            </td>
			<td>
                <input name="quantity[]" id="quantity1" class="form-control">
				<span id="err_quantity1" style="display:none;color:red">Please Add Quantity</span>
            </td>
			<td>
                <input name="price[]" id="price1" class="form-control">
				<span id="err_price1" style="display:none;color:red">Please Add Price</span>
            </td>			
            
        </tr>
       
    </tbody>
</table>

		</div>
	   <div class="modal-footer">
	   <button id="btnAddRow" class="btn btn-add btn-xs" type="button">
    Add Row
</button>
		
		<button id="btnAddRec" class="btn btn-add btn-xs" type="button">
    Add Recipe
</button>
	
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
$(document).ready(function(){
	
	$('#example').DataTable();
	


});
$("#btnAddRec").click(function(){
	var errDisplayStop = 0; 
	 $('#tblAddRow tr').not("thead tr").each(function() {
    if($("#ingredient"+this.id).val() == ''){
		$("#err_ingredient"+this.id).show();
		errDisplayStop = errDisplayStop + 1;
	}else{
		$("#err_ingredient"+this.id).hide();
	}
	if($("#quantity"+this.id).val() == ''){
		$("#err_quantity"+this.id).show();
		errDisplayStop = errDisplayStop + 1;
	}else{
		$("#err_quantity"+this.id).hide();
	}
	if($("#price"+this.id).val() == ''){
		$("#err_price"+this.id).show();
		errDisplayStop = errDisplayStop + 1;
	}else{
		$("#err_price"+this.id).hide();
	}
	
  });
	if(errDisplayStop == 0 )
	{
		$("#receipeform").submit();
	}else{
		return false;
	}
	

});
function updaterecipe(id){
	$("#productid").val(id);
	var ar = JSON.parse( '<?php echo $prevRecipeing ?>' );
	//alert(ar['78'][0]['ID']);
	$("#addedrecipe").html('');
	var strAppend = '';
	if(ar[id].length>0)
	{
		var strAppend = '<table id="tblAddRowsupdate" class="table table-bordered table-striped">\
    <thead>\
        <tr>\
            <th>Ingredient</th>\
			<th>Quantity</th>\
			<th>Price</th>\
			<th>Action</th>\
        </tr>\
    </thead>';
	for(var p=0,r=1;p<ar[id].length;p++,r++){
		strAppend += '<tr id="rowid'+r+'"><td>'+ar[id][p]['item_name']+'</td><td>'+ar[id][p]['ingred_quantity']+'</td><td>'+ar[id][p]['ingred_price']+'</td>\
		<td><a onclick="deleteaddedingredient('+ar[id][p]['ID']+',\''+ar[id][p]['item_name']+'\','+r+')" onchange="toggleOption(this)" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td></tr>';
	}
    $("#addedrecipe").append(strAppend);
	}
	
	$('#myModal').modal('show');
}


function deleteaddedingredient(id,item_name,trid){
	
	swal({
				title: "Are you sure?", 
				text: "You are going to delete ingredient "+item_name, 
				type: "warning",
				confirmButtonText: "Yes, Delete!",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
						var request = $.ajax({
						url: "deleteingredientfromrecipe",
						type: "POST",
						data: {id : id},
						}).done(function(msg) {
	$("#rowid"+trid).hide();					
						});
					} else if (result.dismiss === 'cancel') {
					    swal(
					      'Cancelled',
					      'Your stay here :)',
					      'error'
					    )
					}
				});
}
// Add row the table
$('#btnAddRow').on('click', function() {
    var lastRow = $('#tblAddRow tbody tr:last').html();
var lastid = $('#tblAddRow tr:last').attr('id');
var currentId = parseInt(lastid)+1;   
  lastRow =  '<td>\
                <input name="ckcDel[]" type="checkbox">\
            </td>\
            <td>\
                <input type="text" name="ingredients[]" id="ingredient'+currentId+'" class="form-control ingredients">\
				<span id="err_ingredient'+currentId+'" style="display:none;color:red">Please Add Ingredient</span>\
				<ul class="typeahead dropdown-menu"></ul>\
            </td>\
			<td>\
                <input name="quantity[]" id="quantity'+currentId+'" class="form-control">\
				<span id="err_quantity'+currentId+'" style="display:none;color:red">Please Add Quantity</span>\
            </td>\
			<td>\
                <input name="price[]" id="price'+currentId+'" class="form-control">\
				<span id="err_price'+currentId+'" style="display:none;color:red">Please Add Price</span>\
            </td>		\
<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>			';
    $('#tblAddRow tbody').append('<tr id='+currentId+'>' + lastRow + '</tr>');





$('#ingredient'+currentId+'').typeahead({
       ajax: 'autocompleteingredient',

					displayField: 'item_name',
					valueField: 'ID',
					                    onSelect: displayResult
 
    });

 //   $('#tblAddRow tbody').append('<tr><input type="text" id="in2"></tr>');  
  $('#tblAddRow tbody tr:last input').val('');
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
function displayResult(item)
{
	var addedIngreds = JSON.parse( '<?php echo $addedIngreds ?>' );	
		  if (jQuery.inArray(item.value, addedIngreds)!='-1') {
		  alert("Not It Is");		
	  }else{
		  alert("It Is");
	  }
}
$('#ingredient1').typeahead({
       ajax: 'autocompleteingredient',

					displayField: 'item_name',
					valueField: 'ID',
					 onSelect: displayResult
 
    });
	


</script>

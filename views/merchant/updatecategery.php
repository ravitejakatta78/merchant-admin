<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
    

		
	<div class="form-horizontal">
		<div class="form-group row">
		<label class="control-label col-md-4">Food Category</label>
		<div class="col-md-8">
		<input type="text" id="update_food_category" name="update_food_category" value="<?= $categorytypes[0]['food_category'];?>" class="form-control">
		<input type="hidden" id="update_food_id" name="update_food_id" value="<?= $id;?>">
		</div>
		</div>
		</div>
	<?php if(count($categorytypes)>0 &&  !empty($categorytypes[0]['fcid'])   ) {?>	
	<table id="tblAddRowsupdate" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
	<?php for($i=0;$i<count($categorytypes);$i++){ ?>
        <tr>
			<td>
                <input name="categorytypes_<?=$categorytypes[$i]['fcid']; ?>" value="<?= $categorytypes[$i]['food_type_name']?>" class="form-control">
            </td>
        </tr>
    <?php } ?>   
    </tbody>
</table>
	<?php } ?>
	<table id="tblAddRows" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Quantity</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
			<td>
                <input name="categorytypes[]" class="form-control">
            </td>
        </tr>
       
    </tbody>
</table>
	
		<div class="modal-footer">
	   <button id="btnAddRow" onclick="addrow()" class="btn btn-add btn-xs" type="button">
    Add Row
</button>
		<?= Html::submitButton('Update Categery', ['class'=> 'btn btn-add']); ?>

      </div>
   

   
<script>
$(document).ready(function(){
// Add button Delete in row
$('#tblAddRows tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow" ><i class="fa fa-trash border-red text-red deleterow" name="deleterow" ></i></a></td>');
	

	
});

</script>    
        
        
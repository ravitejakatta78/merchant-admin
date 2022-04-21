<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
  .selection{display: none;}
</style>    

		
	<div class="form-horizontal">
		<div class="form-group row">
		<label class="control-label col-md-4">Merchant Grouping</label>
		<div class="col-md-8">
		<select class="test" name="group[]" multiple="multiple">
		<!--	<option value="1">Option 1</option>
			<option value="2" selected>Option 2</option>
			<option value="3">Option 3</option>
			<option value="4" disabled>Manège</option>
			<option value="5">Bête</option> -->
			<?php for($g = 0;$g < count($rescoowner);$g++) { ?>
				<option value="<?= $rescoowner[$g]['ID']; ?>"><?= $rescoowner[$g]['storename'];?></option> 
			<?php } ?>
		</select>
		<input type="hidden" id="update_merchant_id" name="update_merchant_id" value="<?= $id;?>">
		</div>
		</div>
		</div>
	<?php if(count($group)>0 ) {?>	
	<table id="tblAddRowsupdate" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Quantity</th>
			<th>Delete</th>
        </tr>
    </thead>
    <tbody>
	<?php for($i=0;$i<count($group);$i++){ ?>
        <tr id="groupid<?= $group[$i]['ID']; ?>">
			<td><?= $i+1; ?></td>		
			<td><?= $group[$i]['storename']; ?></td>
			<td><i class="fa fa-trash border-red text-red deleterow" onclick="deleteGroupMerchant('<?=$group[$i]['ID'] ?>')" name="deleterow"></i></td>
        </tr>
    <?php } ?>   
    </tbody>
</table>
	<?php } ?>

	
		<div class="modal-footer">
	   
		<?= Html::submitButton('Update Grouping', ['class'=> 'btn btn-add']); ?>

      </div>
        
<script>
(function($) {
    $(function() {
        window.fs_test = $('.test').fSelect();
    });
})(jQuery);
function deleteGroupMerchant(id){
//	var res = confirm('Are you sure want to delete??')
		    swal({
				title: "Are you sure want to delete??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
					    var request = $.ajax({
						  url: "deletegroupmerchant",
						  type: "POST",
						  data: {id : id},
						}).done(function(msg) {
							$("#groupid"+id).hide();
							//location.reload();
						});
					}
				});

}
</script>        
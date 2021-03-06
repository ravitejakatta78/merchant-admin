<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
    <?php	$form = ActiveForm::begin([
    		'id' => 'update-coupon-form',
			'action'=>'editcoupon',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>


		

<div class="row">	

   
   
   <div class="col-md-4">
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Coupon Type</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'purpose')->dropdownlist(['Single'=>'Single Use','Multiple'=>'Multiple Use']
				  ,['prompt'=>'Select Coupon Type'])->label(false); ?>
	   </div></div>
	</div>
   
   
<div class="col-md-4">
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Coupon Code</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'code')->textinput(['class' => 'form-control','placeholder'=>'Coupon Code'])->label(false); ?>
	   	   <?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control','placeholder'=>'Coupon Code'])->label(false); ?>
	   </div></div>
	   </div>
	   
   


   <div class="col-md-4">
   	   <div class="form-group row">
	   <label class="control-label col-md-4">Discount Type</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'type')->dropdownlist(['amount'=>'Amount','percent'=>'Percentage']
				  ,['prompt'=>'Select Discount Type'])->label(false); ?>
	   </div></div>
	</div>




<div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Max Amount of Discount</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'maxamt')->textinput(['class' => 'form-control','placeholder'=>'Max Amount of Discount'])->label(false); ?>
	   </div></div>
	   </div>



<div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity From</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'fromdate')->textinput(['class' => 'form-control datepicker3','onclick'=>'datepickerfrom()'])->label(false); ?>
	   </div></div>
	   </div>

<div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Validity To</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'todate')->textinput(['class' => 'form-control datepicker4','onclick'=>'datepickerto()'])->label(false); ?>
	   </div></div>
	   </div>







<div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Amount of Discount</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'price')->textinput(['class' => 'form-control','placeholder'=>'Amount Of Discount'])->label(false); ?>
	   </div></div>
	   </div>




<div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Min Order Amount</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'minorderamt')->textinput(['class' => 'form-control','placeholder'=>'Min Order Amount'])->label(false); ?>
	   </div></div>
	   </div>



	   
	   <div class="col-md-4">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Description</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'description')->textarea(['class' => 'form-control','placeholder'=>'Description'])->label(false); ?>
	   </div></div>
	   </div>
	   
	   
	   
	   
	   
	   <div class="col-md-12">
	  <table id="tblAddRow1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="checkedAllEdit" /></th>
            <th>Product Name</th>
            <th>Price</th>
        </tr>
    </thead> 
    <tbody>
        <?php for($p=0;$p<count($product);$p++) { ?>
		<tr>
            <td>
                <input name="ckcDeledit[]" class="individualcheckEdit" 
				onclick="checkeditem('<?= $product[$p]['ID']; ?>')" type="checkbox" value="<?= $product[$p]['ID']; ?>" <?php if(in_array($product[$p]['ID'],$prodArr)) {?> checked <?php }  ?>)/>
            </td>
            <td>
                <i class="fa fa-inr"></i> <?= $product[$p]['title']; ?>
            </td>
            <td>
                <i class="fa fa-inr"></i> <?= $product[$p]['price']; ?>
            </td>
        </tr>
		<?php } ?>
       
    </tbody>
</table>
</div>
	   </div>

	   <div class="modal-footer">
		<button type="submit" class="btn btn-add">Update Coupon</button>
      </div> 

<?php ActiveForm::end() ?>       
<?php
$script = <<< JS
    $('#tblAddRow1').DataTable();
		$('select').select2();
JS;
$this->registerJs($script);
?>
   
<script>
$(document).on('click', '#checkedAllEdit', function(){
				$('.individualcheckEdit').prop('checked',true);

});
$(document).on('click', '.individualcheckEdit', function(){

$("#checkedAllEdit").prop("checked", false);	
});

</script>    
        
        
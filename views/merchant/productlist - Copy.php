
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="page-header">

          </header>
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Product List</h3>
				<div class="col-md-6 text-right pr-0">
				<button type="button" class="btn btn-add btn-xs" id="myBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"></i> Add Product</button>

				</div>
              </div>


              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Product Name</th>
                        <th>Product Icon</th>
                        <th>Product Tag</th>
						<th>Sale Price</th>
						<th>Price</th>
						<th>Serve for</th>
						<th>Food type</th>
						<th>Availabilty</th>
						<th>Status</th>
						<th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($productModel as $productlist){
								?>
                                  <tr>
                                 	<td><?php echo $x;?></td>
                                 	<td><?php echo $productlist['title'];?></td>
                                 	<td><img src="<?php echo  Yii::$app->request->baseUrl.'/uploads/productimages/'. $productlist['image'];?>" alt="" class="img-table dash-icon" style="height:50px"/></td> 
                                 	<td><?php echo $productlist['labeltag'];?></td>
                                 	<td><?php echo $productlist['saleprice'];?></td>
                                 	<td><?php echo $productlist['price'];?></td>
                                 	<td><?php echo $productlist['serveline'];?></td>
                                 	<td><?php echo Utility::foodtype_value($productlist['foodtype']);?></td>
					<td><label class="switch">
					  <input type="checkbox" <?php if($productlist['availabilty']=='1'){ echo 'checked';}?> onChange="changeavailabilty('product',<?php echo $productlist['ID'];?>);">
					  <span class="slider round"></span>
					</label>
					</td>
					<td>
<label class="switch">
					<input type="checkbox" <?php if($productlist['status']=='1'){ echo 'checked';}?> onChange="changestatus('product',<?php echo $productlist['ID'];?>);">
					<span class="slider round"></span> 

					</label>
					</td>
                    <td class="icons"><a onclick="editproductpopup('<?= $productlist['ID'];?>')"><span class="fa fa-pencil"></span></a> </td>
                                  </td>                                  </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Product</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'food-categery-form',
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
<div class="col-md-6">	

	   <div class="form-group row">
	   <label class="control-label col-md-4">Product Name</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'title')->textinput(['class' => 'form-control','placeholder'=>'Product Name'])->label(false); ?>
	   </div>
	   </div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Product Tag</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'labeltag')->textinput(['class' => 'form-control','placeholder'=>'Product Tag'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Serve Line</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'serveline')->textinput(['class' => 'form-control','placeholder'=>'Serve Line'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Price</label>
	   <div class="col-md-8">
	   <?= $form->field($model, 'price')->textinput(['class' => 'form-control','placeholder'=>'Price'])->label(false); ?>
	   </div></div>
</div>
<div class="col-md-6">
	   <div class="form-group row">
	   <label class="control-label col-md-4">Sale Price</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'saleprice')->textinput(['class' => 'form-control','placeholder'=>'Sale Price'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Category</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'foodtype')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\FoodCategeries::find()->all(), 'ID', 'food_category')
				  ,['prompt'=>'Select',
                    'onchange'=>'
                        $.get( "'.Url::toRoute('/merchant/quantitylist').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'food_category_quantity').'" ).html( data );
                            }
                        );
                    '])->label(false); ?>
	   </div></div>
	   	   <div class="form-group row">
	   <label class="control-label col-md-4">Category Quantity</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'food_category_quantity')
				  ->dropdownlist([]
				  ,['prompt'=>'Select'])->label(false); ?>
	   </div></div>
	   <div class="form-group row">
	   <label class="control-label col-md-4">Upload</label>
	   <div class="col-md-8">
			      <?= $form->field($model, 'image')->fileinput(['class' => 'form-control'])->label(false); ?>
	   </div></div>
	   </div>
	   </div>
	   </div>
	   <div class="modal-footer">
		<?= Html::submitButton('Add Categery', ['class'=> 'btn btn-add']); ?>

      </div> 


<?php ActiveForm::end() ?>
        
        
        
        
      </div>
    </div>
  </div>
  
    <div id="editproduct" class="modal fade" role="dialog">
<div class="modal-dialog modal-xl" >
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Product</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div class="modal-body" id="editproductbody">
		
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

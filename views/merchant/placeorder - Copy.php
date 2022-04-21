
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<style>
.fixed {position:fixed; top:0;right: 15px;width: 245px;}
</style>
<header class="page-header">

          </header>

		<section class="col-md-12">
		  <div class="row">
          <div class="col-lg-9">
            <div class="card">
              
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Items List</h3>
              </div>
              <div class="card-body p-3">
                <div class="main row"> 
                <!-- TENTH EXAMPLE -->
				
				<?php 
				$row = 0;
				foreach($mainProducts as $key => $value){ 
												
				$food_cat_arr = (array_filter(array_column(array_values($mainArr[$key]),'food_category_quantity')));
				?>
				<div class="col-md-4">
                <div class="view view-tenth">
			<?php 	
			if(empty($imgArr[$value])){ ?>
						<div class="title-noimg"><?= $key ;?></div>
			<?php }
			else if (file_exists( '../..'.\yii\helpers\Url::to(['uploads/productimages/'.$imgArr[$value]]) )) {

				?>
  <img src="<?= Yii::$app->request->baseUrl.'/uploads/productimages/'.$imgArr[$value];?>" />
  					<div class="res-title"><?= $key ;?></div>
 <?php }
 else{  ?>
	 					<div class="title-noimg"><?= $key ;?></div>
<?php  }?>

                   

                    <div class="mask col-md-12">
					<div class="row">
					
					
					<?php if(!empty($food_cat_arr)) {
						?>
					<div class="col-md-12">
						<?php 
						for($fc=0;$fc<count($food_cat_arr);$fc++){
						?>					
					<a onclick="productorder('<?= $idArr[$key.'_'.$food_cat_arr[$fc]]; ?>','<?= $key;?>','<?= $food_cat_qty_det[$food_cat_arr[$fc]]; ?>'
					,'<?= $priceArr[$key.'_'.$food_cat_arr[$fc]]; ?>')"><div><i class="fa fa-dot-circle-o" ></i> 
					<?= $food_cat_qty_det[$food_cat_arr[$fc]] ?> -  <i class="fa fa-inr"> <?php echo $priceArr[$key.'_'.$food_cat_arr[$fc]];?></i></div></a>
						<?php } ?>
					</div>
					<?php  }else{ ?>
					<div class="col-md-12">
					
					  <a onclick="productorder('<?= $idArr[$key.'_']; ?>','<?= $key;?>','','<?= $priceArr[$key.'_']; ?>')"><div>
					  <i class="fa fa-dot-circle-o" ></i> <?php echo $key ?> - <i class="fa fa-inr"> <?php echo $priceArr[$key.'_']   ?></i></div></a>
                      
					</div>
						
					<?php } ?>
					
					</div>
					</div>
                </div>
				</div>
				<?php $row++; } ?>
				
				

            </div>
              </div>
            </div>
          </div>
		  <div class="col-md-3" >
		  <div class="card" id="task_flyout">
		  <div class="card-header">
		  <h3 class="h4"><?= $tableName;?> Order</h3>
		  </div>
		  <div class="card-body p-3 scroller">
		  <form method="POST" action="savetableorder" onsubmit="return validate()">
		  <div id="addnewprod">
			<?php 
			$orderIdName = array_column($productDetails,'title','ID');
			$orderIdQty = array_column($productDetails,'food_category_quantity','ID');
			$previousIds = array_column($prevOrderDetails,'product_id');
			
			for($p=0;$p<count($prevOrderDetails);$p++) {
if(!empty($orderIdQty[$prevOrderDetails[$p]['product_id']])){
	$qtyName = $food_cat_qty_det[$orderIdQty[$prevOrderDetails[$p]['product_id']]];
	$qtyName = " (".$qtyName.")";
}
else{
	$qtyName = '';
}
				?>
						<div class="col-xs-12 item-shdw p-2 mb-2" id="productorder<?= $prevOrderDetails[$p]['product_id'] ?>">
		  <div class="row">
			<div class="col-md-9">
	  <h6><?= $orderIdName[$prevOrderDetails[$p]['product_id']]. $qtyName ;?>  			 </h6>
			</div>
			<div class="col-md-3 pl-0">
			<h6 class="amt"><i class="fa fa-inr"></i> <?= $prevOrderDetails[$p]['price']?></h6>
			</div>
		  </div>
                            <div class="product-qty row">
                                <div class="option-label col-md-3 pr-1">Qty</div>
                                <div class="qty qty-changer col-md-7 pr-2">
                                    <fieldset>
                                        <button type="button" class="decrease"  onclick="orderdecrement('<?= $prevOrderDetails[$p]['product_id'] ?>')"></button>
                                        <input type="text" class="qty-input" value="<?= $prevOrderDetails[$p]['count']?>" name="quantity" id="quantity_<?= $prevOrderDetails[$p]['product_id'] ?>" data-min="1"  readonly="true">
                                        <input type="hidden" value="<?= $prevOrderDetails[$p]['product_id'] ?>" name="product[]" id="product_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $prevOrderDetails[$p]['count'] ?>" name="order_quantity[]" id="order_quantity_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $prevOrderDetails[$p]['price']?>" name="order_price[]" id="order_price_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $tableid ; ?>" name="tableid"    readonly="true">
				   <button type="button" class="increase" id="increment_<?= $prevOrderDetails[$p]['product_id'] ?>" onclick="orderincrement('<?= $prevOrderDetails[$p]['product_id'] ?>')"></button>
                                    </fieldset>
                                </div>			
								<div class="col-md-2 pl-0 pr-1 pt-1"><a><i class="fa fa-trash text-red border-red" onclick="deleteprodorder('<?= $prevOrderDetails[$p]['product_id'] ?>')"></i></a></div>
                            </div>
                        </div>
			<?php } ?>
						<div class="col-md-12">
						<div class="row">

						<input type="submit"  class="btn btn-add btn-block" value="Place Order" />
						</div>
						</div>
			</div>
			</form>
		  </div>
		  </div>
		  </div>
		  </div>

        </section>
<script>
$(window).scroll(function(){
      if ($(this).scrollTop() > 135) {
          $('#task_flyout').addClass('fixed');
      } else {
          $('#task_flyout').removeClass('fixed');
      }
  });
  function orderincrement(id){
	  
	  var currentval = $("#quantity_"+id).val();
	  
	  var nextval = parseInt(currentval)+1;
	  $("#quantity_"+id).val(nextval);
	  $("#order_quantity_"+id).val(nextval);
	  
  }
    function orderdecrement(id){
		
	  var currentval = $("#quantity_"+id).val();
	  
	  var prevval = parseInt(currentval)-1;
	  if(prevval > '0'){
		$("#quantity_"+id).val(prevval);  
		$("#order_quantity_"+id).val(prevval);
	  }
	  
  }
  function deleteprodorder(id)
  {
	  $("#productorder"+id).hide();
	  		$("#order_quantity_"+id).val(0);
			$("#order_price_"+id).val(0);
  }
 
  function validate()
  {
	  var ord_qty = 0;
	  var values = $("input[name='order_quantity[]']")
              .map(function(){
				ord_qty = parseInt(ord_qty) + parseInt($(this).val())  ;
				
				  return $(this).val();
				  }).get();
	  if(ord_qty == 0)
	  {
		alert("Please Select Atleast One Product");  
		return false;  
	  }
	  
  }
 



  
  var productorder = (function() {
	
var arr = [];
    <?php foreach($previousIds as $key => $val){ ?>
        arr.push('<?php echo $val; ?>');
    <?php } ?>

  return function (id,product,qtyname,price) {
	  if (jQuery.inArray(id, arr)!='-1') {
		
		$("#productorder"+id).show();
	if($("#quantity_"+id).val() == 0){
		$("#quantity_"+id).val(1);
		$("#order_quantity_"+id).val(1);
	}
		
	  }
	  else{
		  if(qtyname != ''){
			qtyname= ' ('+qtyname  +')';
		  }
		  tableId = '<?php echo $tableid; ?>';
			arr.push(id);
	
	$("#addnewprod").prepend('<div class="col-xs-12 item-shdw p-2 mb-2" id="productorder'+id+'">\
		  <div class="row">\
			<div class="col-md-9">\
	  <h6>'+product+ ' ' +qtyname + '			 </h6>\
			</div>\
			<div class="col-md-3 pl-0">\
			<h6 class="amt"><i class="fa fa-inr"></i> '+price+'</h6>\
			</div>\
		  </div>\
                            <div class="product-qty row">\
                                <div class="option-label col-md-3 pr-1">Qty</div>\
                                <div class="qty qty-changer col-md-7 pr-1">\
                                    <fieldset>\
                                        <button type="button" class="decrease"  onclick="orderdecrement('+id+')"></button>\
                                        <input type="text" class="qty-input" value="1" name="quantity" id="quantity_'+id+'" data-min="1"  readonly="true">\
                                        <input type="hidden" value="'+id+'" name="product[]" id="product_'+id+'"   readonly="true">\
<input type="hidden" value="1" name="order_quantity[]" id="order_quantity_'+id+'"   readonly="true">\
<input type="hidden" value="'+price+'" name="order_price[]" id="order_price_'+id+'"   readonly="true">\
<input type="hidden" value="'+tableId+'" name="tableid"    readonly="true">\
				   <button type="button" class="increase" id="increment_'+id+'" onclick="orderincrement('+id+')"></button>\
                                    </fieldset>\
                                </div>\			<div class="col-md-2 pl-0 pr-1 pt-1"><a><i class="fa fa-trash text-red border-red" onclick="deleteprodorder('+id+')"></i></a></div>\
                            </div>\
                        </div>'); 

	  }
	 return arr}
})();
</script>
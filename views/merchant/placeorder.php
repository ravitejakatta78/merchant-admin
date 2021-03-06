
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<style>
.fixed {position:fixed; top:0;right: 15px;width: 245px;}
</style>
<script src="<?= Yii::$app->request->baseUrl.'/js/bootstrap-typeahead.js'?>"></script>
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

				$food_cat_arr = array_values(array_filter(array_column(array_values($mainArr[$key]),'food_category_quantity')));
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
		  <div class="row">
		  <h3 class="col-md-8 h4"><?= $tableName;?> Order 
		  <?php 

		  $totalBill = array_sum(array_column($prevOrderDetails,'totalprice')) ?? 0;
		  
		  ?>
		  
		  <h6 class="col-md-4 text-right amt"><i class="fa fa-inr"></i><span id="totalbill"><?= $totalBill;?></span></h6></h3>
		  </div>
		  </div>
		  <div class="card-body p-3 scroller">
		  <form method="POST"  >
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
			<h6 class="amt"><i class="fa fa-inr"></i> <span id="priceIncrement_<?= $prevOrderDetails[$p]['product_id'] ?>"><?= $prevOrderDetails[$p]['price'] * $prevOrderDetails[$p]['count']?></span></h6>
			</div>
		  </div>
                            <div class="product-qty row">
                                <div class="option-label col-md-3 pr-1">Qty</div>
                                <div class="qty qty-changer col-md-7 pr-2">
                                    <fieldset>
                                        <button type="button" class="decrease"  onclick="orderdecrement('<?= $prevOrderDetails[$p]['product_id'] ?>','<?= $prevOrderDetails[$p]['price'] ?>')"></button>
                                        <input type="text" class="qty-input" value="<?= $prevOrderDetails[$p]['count']?>" name="quantity" id="quantity_<?= $prevOrderDetails[$p]['product_id'] ?>" data-min="1"  readonly="true">
                                        <input type="hidden" value="<?= $prevOrderDetails[$p]['product_id'] ?>" name="product[]" id="product_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $prevOrderDetails[$p]['count'] ?>" name="order_quantity[]" id="order_quantity_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $prevOrderDetails[$p]['price']?>" name="order_price[]" id="order_price_<?= $prevOrderDetails[$p]['product_id'] ?>"   readonly="true">
<input type="hidden" value="<?= $tableid ; ?>" name="tableid"    readonly="true">
				   <button type="button" class="increase" id="increment_<?= $prevOrderDetails[$p]['product_id'] ?>" onclick="orderincrement('<?= $prevOrderDetails[$p]['product_id'] ?>','<?= $prevOrderDetails[$p]['price'] ?>','1')"></button>
                                    </fieldset>
                                </div>			
								<div class="col-md-2 pl-0 pr-1 pt-1"><a><i class="fa fa-trash text-red border-red" onclick="deleteprodorder('<?= $prevOrderDetails[$p]['product_id'] ?>','1')"></i></a></div>
                            </div>
                        </div>
			<?php } ?>
						<div class="col-md-12">
						<div class="row">

					<!--	<input type="submit"  class="btn btn-add btn-block" value="Place Order" />
					<button type="button" class="btn btn-add btn-block" data-toggle="modal" data-target="#myModal">Place Order</button> -->
					<button type="button" class="btn btn-add btn-block" onclick="orderpreview()">Place Order</button>
					
						</div>
						</div>
			</div>
			</form>
		  </div>
		  </div>
		  </div>
		  </div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			

	<form action="savetableorder" method="POST" onsubmit="return revalidate()">
<div class="row">	
<div class="col-md-5 scroller" style="max-height:250px;">	

	 						  <div id="edit_place_order_pop_up"></div>

</div>
<div class="col-md-2">
<div class="tax maintax click" style="cursor: pointer;" onclick="taxation('1')"><a>TAX</a></div>
<div class="tax subtax click" style="cursor: pointer;" onclick="taxation('2')"><a>FOODQ TAX</a></div>
</div>
<div class="col-md-5">
<div  class="">
		  <div class="row">
			<div class="col-md-8">Amount</div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i><span id="popupamount">  </span></div>
			<input type="hidden" id="popupamounthidden" name="popupamount">
		  </div>
		  <hr class="mt-1 mb-1">
		  <div class="row">
			<div class="col-md-8">Coupon Amount </div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i> <span id="popupcouponamt"><?= $prevFullSingleOrderDet['couponamount'] ?? 0 ?></div>
			<input type="hidden" id="couponamounthidden" value="<?= $prevFullSingleOrderDet['couponamount'] ?? '' ?>" name="couponamountpopup">
		  </div>
		  <hr class="mt-1 mb-1">
		  <div class="row">
			<div class="col-md-8">Tax Amount</div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i><span id="popuptaxamt"></span> </div>
			<input type="hidden" id="popuptaxamthidden" name="popuptaxamt">
		  </div>
		  <hr class="mt-1 mb-1">
		  <div class="row">
			<div class="col-md-8">Tip Amount</div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i> <span id="popuptipamt"><?= 1;?></span></div>
			<input type="hidden" id="popuptipamthidden" name="popuptipamt">
		  </div>
		  <hr class="mt-1 mb-1">
		  <div class="row">
			<div class="col-md-8">Subscription Amount</div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i> <span id="popupsubscriptionamt"></span></div>
			<input type="hidden" id="popupsubscriptionamthidden" name="popupsubscriptionamt">
		  </div>
		  <hr class="mt-1 mb-1">
		  <div class="row">
			<div class="col-md-8">Total Amount</div>
			<div class="col-md-4 text-right"><i class="fa fa-inr"></i> <span id="popuptotalamt"></span></div>
			<input type="hidden" id="popuptotalamthidden" name="popuptotalamt">
		  </div>
		  
		  </div>
</div>

	   </div>
	   <div class="row mt-2">
	   <div class="col-md-6">
	   
		<div class="form-group row">
		<label class="control-label col-md-4">Customer Name</label>
		<div class="col-md-8">
		<input type="text" id="customer_name" name="customer_name" placeholder="Customer Name" value="<?= $prevOrderDetails[0]['name'] ?? null?>" class="form-control">
		</div>
		</div>
		<div class="form-group row">
		<label class="control-label col-md-4">Payment Mode</label>
		<div class="col-md-8">
		<select class="form-control" name="payment_mode">
		<option value='cash' <?php if($prevFullSingleOrderDet['paymenttype'] == 'cash') { echo 'selected'; } ?>>Cash</option>
		<option value='online' <?php if($prevFullSingleOrderDet['paymenttype'] == 'online') { echo 'selected'; } ?>>Online</option>
		</select>
		</div>
		</div>
		</div>
		<div class="col-md-6">
		
		<div class="form-group row">
		<label class="control-label col-md-4">Customer Mobile</label>
		<div class="col-md-8">
		<input type="text" id="customer_mobile" name="customer_mobile" placeholder="Mobile Number" value="<?= $prevOrderDetails[0]['mobile'] ?? null?>" class="form-control">
		</div>
		</div>
		
				<div class="form-group row">
		<label class="control-label col-md-4">Apply Coupon</label>
		<div class="col-md-8">
		<input type="text" id="merchant_coupon" name="merchant_coupon" value="<?= $prevFullSingleOrderDet['coupon'] ?? '' ?>" autocomplete="off" placeholder="Apply Coupon" class="form-control">
		</div>
		</div>
		
		</div>
	   </div>
	   </div>
	   
	   
	   
	   
	   <div class="modal-footer">
		<?= Html::submitButton('Confirm Order', ['class'=> 'btn btn-add']); ?>

      </div> 
</form>

        </section>
<script>
$(window).scroll(function(){
      if ($(this).scrollTop() > 135) {
          $('#task_flyout').addClass('fixed');
      } else {
          $('#task_flyout').removeClass('fixed');
      }
  });
  function taxation(type)
  {
	if(type == '1'){
		 if( $(".maintax").hasClass("click") == true)
		 {
			 $(".maintax").removeClass("click");
			$("#popuptaxamt").html(0);

		 }
		 else{
			 $(".maintax").addClass("click");
			 	var nrmltotal = $("#totalbill").html();
				$("#popuptaxamt").html(((2.5/100)*parseInt(nrmltotal)).toFixed(2));

		 }
	}else{
		 if( $(".subtax").hasClass("click") == true)
		 {
			 $(".subtax").removeClass("click");
			 $("#popupsubscriptionamt").html(0);
			 
		 }
		 else{
			$(".subtax").addClass("click");
			 	var nrmltotal = $("#totalbill").html();
				$("#popuptaxamt").html(((2.5/100)*parseInt(nrmltotal)).toFixed(2));

			var subpercenttage = (Math.floor((1/100)*parseInt(nrmltotal)).toFixed(2));
			if(subpercenttage<1){
						var subpercenttage = 1;
					}
					if(subpercenttage>10){
						var  subpercenttage = 10;
					}
	$("#popupsubscriptionamt").html(subpercenttage);				
		 }
	}
	
commontrigger();	
   }
   function commontrigger()
   {

	    var nrml_total = parseInt($("#totalbill").html());
		var subscription_tax = parseFloat($("#popupsubscriptionamt").html());
		var tax_amt = parseFloat($("#popuptaxamt").html());
		var tip_amt = parseInt($("#popuptipamt").html());
		var coupon_amt = parseInt($("#popupcouponamt").html());	
		
		$("#popuptotalamt").html(nrml_total + subscription_tax +tax_amt +tip_amt-coupon_amt );
		$("#popuptotalamthidden").val(nrml_total + subscription_tax +tax_amt +tip_amt-coupon_amt);
		$("#popupamounthidden").val(nrml_total);
		$("#popupsubscriptionamthidden").val(subscription_tax);
		$("#popuptaxamthidden").val(tax_amt);
		$("#popuptipamthidden").val(tip_amt);

		
   }
  function orderpreview(){
	   validate();
	var x = $("form").serializeArray();
	var order_quantity_arr = $("input[name='order_quantity[]']")
              .map(function(){return $(this).val();}).get();
	var order_price_arr = $("input[name='order_price[]']")
              .map(function(){return $(this).val();}).get();	
	var order_product_arr = $("input[name='product[]']")
              .map(function(){return $(this).val();}).get();				  
	var type = 2;		  
	$("#edit_place_order_pop_up").html('');
	var  mainProductsName = '<?php echo json_encode($mainProductsName); ?>';
	mainProductsName = JSON.parse(mainProductsName);
	var tableId = '<?php echo $tableid; ?>';
		for(var i=0;i<order_quantity_arr.length;i++)
		{
			if(order_quantity_arr[i] > 0){
			$("#edit_place_order_pop_up").append('<div class="col-xs-12 item-shdw p-2 mb-2" id="productorderpopup'+order_product_arr[i]+'">\
		  <div class="row">\
			<div class="col-md-9">\
	  <h6>'+mainProductsName[order_product_arr[i]]+'  			 </h6>\
			</div>\
			<div class="col-md-3 pl-0">\
			<h6 class="amt"><i class="fa fa-inr"></i> <span  id="priceIncrementPopup_'+order_product_arr[i]+'">'+order_quantity_arr[i] * order_price_arr[i]+'</h6>\
			</div>\
		  </div>\
                            <div class="product-qty row">\
                                <div class="option-label col-md-3 pr-1">Qty</div>\
                                <div class="qty qty-changer col-md-7 pr-2">\
                                    <fieldset>\
                                        <button type="button" class="decrease" onclick="orderdecrement('+order_product_arr[i]+','+order_price_arr[i]+','+type+')"></button>\
                                        <input type="text" class="qty-input" value="'+order_quantity_arr[i]+'" name="quantity" id="quantityPopup_'+order_product_arr[i]+'" data-min="1" readonly="true">\
                                        <input type="hidden" value="'+order_product_arr[i]+'" name="product_popup[]" id="product_'+order_product_arr[i]+'" readonly="true">\
<input type="hidden" value="'+order_quantity_arr[i]+'" name="order_quantity_popup[]" id="order_quantity_popup_'+order_product_arr[i]+'" readonly="true">\
<input type="hidden" value="'+order_price_arr[i]+'" name="order_price_popup[]" id="order_price_'+order_product_arr[i]+'" readonly="true">\
<input type="hidden" value="'+tableId+'" name="tableid" readonly="true">\
				   <button type="button" class="increase" id="increment_'+order_product_arr[i]+'" onclick="orderincrement('+order_product_arr[i]+','+order_price_arr[i]+','+type+')"></button>\
                                    </fieldset>\
                                </div>			\
								<div class="col-md-2 pl-0 pr-1 pt-1"><a><i class="fa fa-trash text-red border-red" onclick="deleteprodorder('+order_product_arr[i]+','+type+')"></i></a></div>\
                            </div>\
                        </div>'
						);
			}
		}	  
	var nrmltotal = $("#totalbill").html();
	$("#popupamount").html(nrmltotal);  
	$("#popuptaxamt").html(number_format(((2.5/100)*parseInt(nrmltotal)),2));

		 var subpercenttage = number_format(((1/100)*parseInt(nrmltotal)),2);
	if(subpercenttage<1){
						var subpercenttage = 1;
					}
					if(subpercenttage>10){
						var  subpercenttage = 10;
					}
	$("#popupsubscriptionamt").html(subpercenttage);				
commontrigger();	
  }

  function orderincrement(id,price,type){
	  

	  var currentval = $("#quantity_"+id).val();
	  var nextval = parseInt(currentval)+1;
	  var priceInc = parseInt(price)*nextval;
	  $("#quantity_"+id).val(nextval);
	  $("#order_quantity_"+id).val(nextval);
	  $("#priceIncrement_"+id).html(priceInc);
var totalbill =parseInt($("#totalbill").html());
	  $("#totalbill").html(totalbill + parseInt(price));
	
	if(type == '2')
	{
		$("#quantityPopup_"+id).val(nextval);
		$("#priceIncrementPopup_"+id).html(priceInc);			
		$("#popupamount").html(totalbill + parseInt(price));
		
		$("#popuptaxamt").html(number_format(((2.5/100)*parseInt(totalbill + parseInt(price))),2));
		
		 var subpercenttage = number_format(((1/100)*parseInt(totalbill + parseInt(price))),2);
	if(subpercenttage<1){
						var subpercenttage = 1;
					}
					if(subpercenttage>10){
						var  subpercenttage = 10;
					}
	$("#popupsubscriptionamt").html(subpercenttage);
	
commontrigger();		
	
	}

	    }
    function orderdecrement(id,price,type){
		
	  var currentval = $("#quantity_"+id).val();
	  
	  var prevval = parseInt(currentval)-1;
	  if(prevval > '0'){
		 var priceInc = parseInt(price)*prevval;
		$("#quantity_"+id).val(prevval);  
	
		$("#order_quantity_"+id).val(prevval);
		$("#priceIncrement_"+id).html(priceInc);		
	  var totalbill =parseInt($("#totalbill").html());
	  $("#totalbill").html(totalbill - parseInt(price));
	  	if(type == '2')
		{
			$("#quantityPopup_"+id).val(prevval);
			$("#priceIncrementPopup_"+id).html(priceInc);			
			$("#popupamount").html(totalbill - parseInt(price));
			$("#popuptaxamt").html(number_format(((2.5/100)*parseInt(totalbill - parseInt(price))),2));
			var subpercenttage = number_format(((1/100)*parseInt(totalbill - parseInt(price))),2);
						if(subpercenttage<1){
						var subpercenttage = 1;
					}
					if(subpercenttage>10){
						var  subpercenttage = 10;
					}
	$("#popupsubscriptionamt").html(subpercenttage);
	
commontrigger();			
		}
	  }
	  
  }
  function deleteprodorder(id,type)
  {
	var deletablePrice = parseInt($("#priceIncrement_"+id).html());
	var totalbill =parseInt($("#totalbill").html());
	var quantity =parseInt($("#quantity_"+id).val());
	
	$("#priceIncrement_"+id).html(deletablePrice/quantity);
	$("#totalbill").html(totalbill - deletablePrice);
    $("#productorder"+id).hide();
	
	  		$("#order_quantity_"+id).val(0);
			$("#order_price_"+id).val(deletablePrice/quantity);

			if(type == '2')
			{
				$("#productorderpopup"+id).hide();
				$("#popupamount").html(totalbill - deletablePrice);
				$("#order_quantity_popup_"+id).val(0);
			
				$("#popuptaxamt").html(((2.5/100)*parseInt(totalbill - deletablePrice)).toFixed(2));
					var subpercenttage = number_format(((1/100)*parseInt(totalbill - deletablePrice)),2);
							if(subpercenttage<1){
						var subpercenttage = 1;
					}
					if(subpercenttage>10){
						var  subpercenttage = 10;
					}
	$("#popupsubscriptionamt").html(subpercenttage);		
	 commontrigger();	
			}
  }
 function revalidate(){
	 var ord_qty = 0;
	  var values = $("input[name='order_quantity_popup[]']")
              .map(function(){
				ord_qty = parseInt(ord_qty) + parseInt($(this).val())  ;
				
				  return $(this).val();
				  }).get();

	  if(ord_qty == 0)
	  {
		//alert("Please Select Atleast One Product");  
		swal(
				'Warning!',
				'Please Select Atleast One Product',
				'warning'
			);
		return false;  
	  }
	  else if($("#customer_name").val() != '' && $("#customer_mobile").val() == '' ){
		alert("Please Fill Both Customer Name and Mobile Number");
			return false;
	  }
	  else if ($("#customer_name").val() != '' && $("#customer_mobile").val() == '' ){
		alert("Please Fill Both Customer Name and Mobile Number");
	  return false;
	  }
	  else if($("#merchant_coupon").val() != ''){

		  var coupons = [];
    <?php foreach($merchantcoupons as $key => $val){ ?>
        coupons.push('<?php echo $val; ?>');
    <?php } ?>
	  if (jQuery.inArray($("#merchant_coupon").val(), coupons)!='-1') {
		  	
		}
        else{
		  alert("Not a Valid Coupon");
		  $("#couponamounthidden").val(0);
		  $("#popupcouponamt").html(0);
		  commontrigger();
		 
		  return false;
		}
	  }
	  else{
		  $("#couponamounthidden").val(0);
		  $("#popupcouponamt").html(0);
		  commontrigger();
	  }

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
		swal(
				'Warning!',
				'Please Select Atleast One Product',
				'warning'
			);//alert("Please Select Atleast One Product");  
		
		return false;  
	  }else{
		  
	  $("#myModal").modal('show');
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
	if($("#order_quantity_"+id).val() == 0){
		$("#quantity_"+id).val(1);
		$("#order_quantity_"+id).val(1);
	var totalbill =parseInt($("#totalbill").html());
	  $("#totalbill").html(totalbill + parseInt(price));
	
	}
		
	  }
	  else{
		  if(qtyname != ''){
			qtyname= ' ('+qtyname  +')';
		  }
		  tableId = '<?php echo $tableid; ?>';
			arr.push(id);
	var type = 1;
	var totalbill =parseInt($("#totalbill").html());
	  $("#totalbill").html(totalbill + parseInt(price));

	$("#addnewprod").prepend('<div class="col-xs-12 item-shdw p-2 mb-2" id="productorder'+id+'">\
		  <div class="row">\
			<div class="col-md-9">\
	  <h6>'+product+ ' ' +qtyname + '			 </h6>\
			</div>\
			<div class="col-md-3 pl-0">\
			<h6 class="amt"><i class="fa fa-inr"></i> <span id="priceIncrement_'+id+'">'+price+'</span></h6>\
			</div>\
		  </div>\
                            <div class="product-qty row">\
                                <div class="option-label col-md-3 pr-1">Qty</div>\
                                <div class="qty qty-changer col-md-7 pr-1">\
                                    <fieldset>\
                                        <button type="button" class="decrease"  onclick="orderdecrement('+id+','+price+')"></button>\
                                        <input type="text" class="qty-input" value="1" name="quantity" id="quantity_'+id+'" data-min="1"  readonly="true">\
                                        <input type="hidden" value="'+id+'" name="product[]" id="product_'+id+'"   readonly="true">\
<input type="hidden" value="1" name="order_quantity[]" id="order_quantity_'+id+'"   readonly="true">\
<input type="hidden" value="'+price+'" name="order_price[]" id="order_price_'+id+'"   readonly="true">\
<input type="hidden" value="'+tableId+'" name="tableid"    readonly="true">\
				   <button type="button" class="increase" id="increment_'+id+'" onclick="orderincrement('+id+','+price+','+type+')"></button>\
                                    </fieldset>\
                                </div>\			<div class="col-md-2 pl-0 pr-1 pt-1"><a><i class="fa fa-trash text-red border-red" onclick="deleteprodorder('+id+','+type+')"></i></a></div>\
                            </div>\
                        </div>'); 

	  }
	 return arr}
})();

function number_format(val, decimals){
    //Parse the value as a float value
    val = parseFloat(val);
    //Format the value w/ the specified number
    //of decimal places and return it.
    return val.toFixed(decimals);
}

                function displayResult(item) {
				var couponArr = 	item.value.split("-");			
				var coupontype = (couponArr[1]);
				if(coupontype == 'percent'){
					var popamt = parseInt($("#popupamount").html())
					var discountamt = number_format(((popamt * couponArr[0])/100),2);
					
					$("#popupcouponamt").html(discountamt);
					$("#couponamounthidden").val(discountamt);

				}else{
					$("#popupcouponamt").html(couponArr[0]);
					$("#couponamounthidden").val(couponArr[0]);

				}
		
		 
				commontrigger();
                }
                $('#merchant_coupon').typeahead({
                    ajax: 'applycouponautocomplete',

					displayField: 'code',
                    valueField: 'price',
                    onSelect: displayResult
                });
				
	


</script>
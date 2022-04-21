
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<script src="<?= Yii::$app->request->baseUrl.'/js/jquery.table2excel.js'?>"></script>

<header class="page-header">

          </header>
          <section>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header d-flex align-items-center pt-0 pb-0">
                <h3 class="h4 col-md-6 pl-0 tab-title">Order List</h3>
				<div class="col-md-6 text-right pr-0">
			
				</div>
              </div>


              <div class="card-body">
			  <form class="form-horizontal" method="POST" id="orderform" action="orders">
                <div class="row">
			  <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">Start Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker1" name="sdate" placeholder="Start Date" value="<?= $sdate ; ?>">
                </div>
                  </div>
				  </div>
				  </div>
				  
				 <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-2">End Date:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker2" name="edate" placeholder="End Date" value="<?= $edate ; ?>">
                </div>
				</div>
                  </div>
				  </div>
				  
				  
				  <div class="col-md-3">
                  <div class="form-group row">
                    <label class="control-label col-md-4 pt-1">Status:</label>
					<div class="col-md-8">
                  <div class="input-group mb-3 mr-3">
                  <select id="orderprocess" name="orderprocess">
				  <option value="" <?php if($orderprocess == '') { echo "selected"; } ?>>All</option>
				  				  <option value="" <?php if($orderprocess == '0') { echo "selected"; } ?>>New</option>
				  <option value="2" <?php if($orderprocess == '2') { echo "selected"; } ?>>Served</option>
				  <option value="1" <?php if($orderprocess == '1') { echo "selected"; } ?>>Accepted</option>
				  <option value="3" <?php if($orderprocess == '3') { echo "selected"; } ?>>Cancelled</option>
				  <option value="4" <?php if($orderprocess == '4') { echo "selected"; } ?>>Delivered</option>				  
				</select> 
				 </div>
                </div>
                  </div> 
				  </div>
				  
				  
				  
 
				  <div class="col-md-3 ">
                  <div class="form-group pt-3">
                    <input type="submit" value="Search" class="btn btn-add btn-sm btn-search"/>
                  </div>
				  </div>
                  </div>
  
                </form>
   
	<button class="exportToExcel" >Export to XLS</button>

                  <table  id="example" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                    <th>S No</th>
									<th>Date</th> 
									<th>Merchant Name</th>
																		<th>City</th>
																											<th>Location</th>
									<th>Order Id</th>
									<th>Paytype</th>
									<th>Order Type</th>
									<th>Table / Seat No</th>
									<th>User Name</th>
									<th>Mobile No</th>
									<th>Order Process</th> 
									<th>Amount</th> 
									<th>Tax</th> 
									<th>Tip</th> 
					<!--				<th>Subscription</th>  -->
									<th>Total amount</th>
																		<th>Action</th>
									<th>Bill</th>

								  </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($orderModel as $orderModel){
								?>
                                  <tr>
                                 <td><?php echo $x;?></td>
									<td><?php echo $orderModel['reg_date'];?></td> 
									<td><?php $merchantDet = \app\helpers\Utility::merchantDet($orderModel['merchant_id']); 
									echo $merchantDet['storename']; ?></td> 
									<td><?php echo $merchantDet['city'];?></td>
									<td><?php echo $merchantDet['location'];?></td>									
									<td><?php echo $orderModel['order_id'];?></td>
									<td><?php echo $orderModel['paymenttype'];?></td>
									<td><?php if($orderModel['ordertype'] == '2'){ echo "Offline"; }else{ echo "Online"; }?></td>
									
									<td><?php echo Utility::table_details($orderModel['tablename'],'name');?></td>
									<td><?php echo Utility::user_details($orderModel['user_id'],'name');?></td>
									<td><?php echo Utility::user_details($orderModel['user_id'],'mobile');?></td>
									<td><span class="pending"><?php echo Utility::orderstatus_details($orderModel['orderprocess']);?></span></td> 
									<td><?php echo $orderModel['amount'];?></td>
									<td><?php echo $orderModel['tax'];?></td>
									<td><?php echo $orderModel['tips'];?></td>
<!--									<td><?php //echo $orderModel['subscription'];?></td> -->
									<td><?php echo $orderModel['totalamount'];?></td>
									<td class="icons" >
									<?php if( $orderModel['orderprocess']  == '1' || $orderModel['orderprocess']  == '2' || $orderModel['orderprocess']  == '0') { ?>
									<a  onclick="orderstatuschange('<?= $orderModel['ID'] ?>','4')" title="bill"><span class="fa fa-check"></span></a>
									<a  onclick="orderstatuschange('<?= $orderModel['ID'] ?>','3')" title="bill"><span class="fa fa-times"></span></a>
									<?php } ?>
									</td>
									<td class="icons" ><a  onclick="billview('<?= $orderModel['ID'] ?>')" title="bill"><span class="fa fa-eye"></span></a></td>
								                                   </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>


               <table   class="table table-striped table-bordered table2excel table2excel_with_colors" style="display:none">
                    <thead>
                      <tr>
                    <th>S No</th>
									<th>Date</th> 
									<th>Merchant Name</th>
																		<th>City</th>
																											<th>Location</th>
									<th>Paytype</th>																		
									<th>Order Type</th>
									<th>Order Id</th>
									<th>Table / Seat No</th>
									<th>User Name</th>
									<th>Mobile No</th>
									<th>Order Process</th> 
									<th>Amount</th> 
									<th>Tax</th> 
									<th>Tip</th> 
					<!--				<th>Subscription</th>  -->
									<th>Total amount</th>
	
								  </tr>
                    </thead>
		    <tbody>
								<?php $x=1; 
									foreach($dumorderModel as $dumorderModel){
								?>
                                  <tr>
                                 <td><?php echo $x;?></td>
									<td><?php echo $dumorderModel['reg_date'];?></td> 
									<td><?php $merchantDet = \app\helpers\Utility::merchantDet($dumorderModel['merchant_id']); 
									echo $merchantDet['storename']; ?></td> 
									<td><?php echo $merchantDet['city'];?></td>
									<td><?php echo $merchantDet['location'];?></td>
									<td><?php echo $dumorderModel['paymenttype'];?></td>
									<td><?php if($dumorderModel['ordertype'] == '1'){ echo "Online"; }else{ echo "Offline"; }?></td>
									<td><?php echo $dumorderModel['order_id'];?></td>
									<td><?php echo Utility::table_details($dumorderModel['tablename'],'name');?></td>
									<td><?php echo Utility::user_details($dumorderModel['user_id'],'name');?></td>
									<td><?php echo Utility::user_details($dumorderModel['user_id'],'mobile');?></td>
									<td><span class="pending"><?php echo Utility::orderstatus_details($dumorderModel['orderprocess']);?></span></td> 
									<td><?php echo $dumorderModel['amount'];?></td>
									<td><?php echo $dumorderModel['tax'];?></td>
									<td><?php echo $dumorderModel['tips'];?></td>
<!--									<td><?php //echo $dumorderModel['subscription'];?></td> -->
									<td><?php echo $dumorderModel['totalamount'];?></td>
								                                   </tr>
									<?php $x++; }?>
                       </tbody>
                  </table>


              </div>
            </div>
          </div>

        </section>
		<?php
$script = <<< JS
    $('#example').DataTable({
  "scrollX": true
});
JS;
$this->registerJs($script);
?>
<script>
$(document).ready(function(){
	

});
function billview(id){


        var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','tablebill');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "id");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    


}
function orderstatuschange(id,orderprocess){
	
	swal({
				title: "Are you sure??", 
				type: "warning",
				showCancelButton: true
		    })
		    	.then((result) => {
					if (result.value) {
						var request = $.ajax({
						url: "orderstatuschange",
						type: "POST",
						data: {id : id,orderprocess:orderprocess},
						}).done(function(msg) {
			/*			swal(
				'Success!',
				'Order Status Changed Successfully',
				'success'
			);*/
						$("#orderform").submit();  
						});
					}
				});
	

}

$(function() {
				$(".exportToExcel").click(function(e){
					var tablelength = $('.table2excel tr').length;
					if(tablelength){
						var preserveColors = ($('.table2excel').hasClass('table2excel_with_colors') ? true : false);
						$('.table2excel').table2excel({
							exclude: ".noExl",
							name: "Excel Document Name",
							filename: "Orders List" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
							fileext: ".xls",
							exclude_img: true,
							exclude_links: true,
							exclude_inputs: true,
							preserveColors: preserveColors
						});
					}
				});
				
			});
</script>

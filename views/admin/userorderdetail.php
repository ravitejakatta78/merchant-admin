 <table id="example1" class="table table-striped table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Payment Type</th>
						<th>Order Amount</th>
						<th>Subscription</th>
						<th>Tax</th>
						<th>Tip</th>
						<th>Total Amount</th>
					</tr>
                    </thead>
		    <tbody>
		        <?php for($i=0;$i<count($res);$i++){ ?>
		            <tr>
		             <td><?= ($i+1); ?></td>
		             <td><?= $res[$i]['order_id']; ?></td>
		             <td><?= date('d M Y h:i:s A',strtotime($res[$i]['reg_date'])); ?></td>
		             <td><?= $res[$i]['paymenttype']; ?></td>		             
		             <td><?= $res[$i]['amount']; ?></td>
		             <td><?= $res[$i]['subscription']; ?></td>
		             <td><?= $res[$i]['tax']; ?></td>
		            <td><?= $res[$i]['tip']; ?></td>
		            <td><?= $res[$i]['totalamount']; ?></td>
		           </tr>      
		            
		        <?php } ?>
                       </tbody>
                  </table>
<script>
  $(function(){
    $("#example1").dataTable();
  })
  </script>
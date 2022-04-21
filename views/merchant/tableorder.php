
<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
 <header class="page-header">
            
          </header>
          
          <section class="col-md-12">
            
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="h4">Table View</h3>
                </div>
                <!-- Statistics -->
                <div class="card-body">
              <!-- Top to bottom-->
              <div class="row">
			  
                <?php  if(count($tableDetails) > 0) {
					for($i=0;$i<count($tableDetails);$i++) {
					?>
				
				<div class="col-sm-3">
                  <!-- normal -->
                  <div class="ih-item circle effect10 top_to_bottom" onclick="placeOrder('<?= $tableDetails[$i]['ID']?>','<?= $tableDetails[$i]['name']?>','<?= $tableDetails[$i]['current_order_id']?>')"><a href="#">
                      <div class="img">
					  <?php 
					  $table_status = ($tableDetails[$i]['table_status'] ?? 5);
					  if($table_status == '1' || $table_status == '2') { ?>
					  <img  src="<?= Yii::$app->request->baseUrl.'/img/table/servingtable.png' ?>" alt="img">
					  <?php } else {
	  ?>
						  <img  src="<?= Yii::$app->request->baseUrl.'/img/table/emptytable.png' ?>" alt="img">
						  
					   <?php }?>
					  </div>
                                              <p><?php $tableStatus = $tableDetails[$i]['table_status'] ?? 5 ;
						if($tableStatus == '5' || $tableStatus == '' ){ ?>
<div class="info Available">
                        <h3><?= $tableDetails[$i]['name']?></h3>
						
						<span class="badge badge-success">Available</span>
						</div>
						<?php }
						else if($tableStatus == '2'){ ?>
<div class="info Serving"> 
                        <h3><?= $tableDetails[$i]['name']?></h3>

							 <span class="badge badge-warning">Serving</span>
						</div>
						<?php }else { ?>
<div class="info occupied"> 
                        <h3><?= $tableDetails[$i]['name']?></h3>

							 <span class="badge badge-danger">Occupied</span>
						</div>

						<?php } ?> </p>
                      </a></div>
                  <!-- end normal -->
                </div>
					<?php } } else { //occupied?>
				No tables to display
				<?php } ?>
                
              </div>
              <!-- end Top to bottom-->
              
            </div>
              </div>
          </section>
		
<script>
function placeOrder(id,name,current_order_id)
{
	        var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','placeorder');
        //form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "tableid");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "tableName");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", name);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "current_order_id");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", current_order_id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();   
}
</script>
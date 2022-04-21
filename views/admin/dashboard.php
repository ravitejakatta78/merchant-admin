<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
?> <header class="page-header">
            
          </header>
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-users"></i></div>
                    <div class="title"><span>Total<br>Users</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                      </div>
                    </div>
                    <div class="number"><strong class="counter"><?= $userCount ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="fa fa-cutlery"></i></div>
                    <div class="title"><span>Registered<br>Restuarants</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 70%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?= $regResturant ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="fa fa-building-o"></i></div>
                    <div class="title"><span>Registered<br>Theaters</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?= $regTheatre; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="fa fa-location-arrow"></i></div>
                    <div class="title"><span>our<br>Locations</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?= count($resLocation) ?></strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row">
			   <?php 
		  $statsCntKeys = array_values(array_keys($ordStatusCount));
		  
		  ?>
                <!-- Statistics -->
                <div class="statistics col-lg-3 col-12">
                  <div  onclick="orderView(4)" class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-check"></i></div>
                    <div class="text"><strong><?php if(in_array('4',$statsCntKeys)){
					echo 	$ordStatusCount['4'] ;
					}else echo 0;?></strong><br><small>Delivered Orders</small></div>
                  </div>
                  <div onclick="orderView(0)" class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-violet"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong><?php if(in_array('0',$statsCntKeys)){
					echo 	$ordStatusCount['0'] ;
					}else echo 0;?></strong><br><small>New Orders</small></div>
                  </div>
                  <div onclick="orderView(1)" class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-spinner"></i></div>
                    <div class="text"><strong><?php if(in_array('1',$statsCntKeys)){
					echo 	$ordStatusCount['1'] ;
					}else echo 0;?></strong><br><small>Pending Orders</small></div>
                  </div>
                  <div onclick="orderView(3)" class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-times"></i></div>
                    <div class="text"><strong><?php if(in_array('3',$statsCntKeys)){
					echo 	$ordStatusCount['3'] ;
					}else echo 0;?></strong><br><small>Failed Orders</small></div>
                  </div>
                </div>
                <!-- Line Chart            -->
                <div class="chart col-lg-6 col-12">
                  <div id="chart-container"></div>
                </div>
                <div class="chart col-lg-3 col-12">
                  <!-- Bar Chart   -->
                  
                  <!-- Numbers-->
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-user-secret"></i></div>
                    <div class="text"><strong><a style="cursor: pointer;color:black;text-decoration:none;" href="<?= Url::to(['admin/merchants']); ?>">Merchants</a></strong></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-users"></i></div>
                    <div class="text"><strong><a style="cursor: pointer;color:black;text-decoration:none;" href="<?= Url::to(['admin/userdata']); ?>">Users Data</a></strong></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-violet"><i class="fa fa-list-alt"></i></div>
                    <div class="text"><strong><a style="cursor: pointer;color:black;text-decoration:none;" href="<?= Url::to(['admin/orders']); ?>">Orders</a></strong></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-user-secret"></i></div>
                    <div class="text"><strong ><a style="cursor: pointer;color:black;text-decoration:none;" href="<?= Url::to(['admin/pilot']); ?>">Pilots</a></strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
 <script src='https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js'></script>
<script src='https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js'></script>
<script src='https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js'></script>

		  <script>jQuery(function ($) {
    $('#example').DataTable();
});</script>	<script>
	$(document).ready(function(){

	$('select').select2();
  $("#chart-container").insertFusionCharts({
  type: "spline",
  width: "100%",
  height: "100%",
  dataFormat: "xml",
  dataSource: 'xml',
      dataSource: '<?= $str;?>'
});
});
function orderView(orderProcess){
	       var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','orders');
//        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "orderProcess");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", orderProcess);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    

}
	</script>

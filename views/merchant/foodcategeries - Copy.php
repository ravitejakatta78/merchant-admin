<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Food Categeries</h2>
            </div>
          </header>
          <section>
          <div class="col-lg-12">
            <div class="card">
              
              <div class="card-header d-flex align-items-center">
                <h3 class="h4">Food Categeries</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">   
                  <table id="example" class="table table-striped table-hover table-bordered ">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Food Categery</th>
                        <th>Action</th>
                      </tr>
                    </thead>
		    <tbody>
			<?php
			 $categeryCount = count($allcategeries);
			 for($i=0;$i< $categeryCount ;$i++){?>
			<tr>
			    <td><?= $i+1 ; ?></td>
			    <td><?= $allcategeries[$i]['food_category'] ; ?></td>
			    <td class="icons">
				<a id="<?php echo $allcategeries[$i]['ID']; ?>" onclick="editcategory('<?php echo $allcategeries[$i]['ID']; ?>');"><span class="fa fa-pencil"></span></a>
				</td>
			</tr>					
			<?php } ?>
                    </tbody>
                  </table>
		  <button type="button" class="btn btn-info btn-lg" id="myBtn" data-toggle="modal" data-target="#myModal">Add Categery</button>

                </div>
              </div>
            </div>
          </div>
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Categery</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php	$form = ActiveForm::begin([
    		'id' => 'food-categery-form',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-8',],
        	'layout' => 'horizontal',
		]) ?>	  
	   <div class="form-group">
			      <?= $form->field($foodcatgerymodel, 'food_category')->textinput(['class' => 'form-control','placeholder'=>'Food Categery'])->label(false); ?>
	   </div>
	   <div class="modal-footer">
        	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		<?= Html::submitButton('Add Categery', ['class'=> 'btn btn-success']); ?>

      </div> 


<?php ActiveForm::end() ?>
        </div>
        
        
        
      </div>
    </div>
  </div>

<div id="updatefoodcategery" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Likes</h4>
      </div>
      <div class="modal-body" id="foodcategerybody">
	   
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
$(document).ready(function() {
	alert("d0");
    $('#example').DataTable();
} );
</script`>

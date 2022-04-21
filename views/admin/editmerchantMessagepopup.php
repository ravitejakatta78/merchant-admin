<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">	

     <div class="form-group row">
	   <label class="control-label col-md-4">Allocated Messages</label>
	    <div class="col-md-8">
	        
	        <input type="text" id="allocated_msgs" name="allocated_msgs" value="<?= $model['allocated_msgs'] ?>">
	        <input type="hidden" id="id" name="id" value="<?= $model['ID'] ?>">
	    </div>
	 </div>
	 <div class="form-group row">
	    <label class="control-label col-md-4">Used Messages</label>
	    <div class="col-md-8">
		    <input type="text" name="used_msgs" id="used_msgs" value="<?= $model['used_msgs'] ?>" readonly>
	    </div>
	 </div>

	   </div>
	   </div>
	   <div class="modal-footer">
	        <button class="btn btn-danger btn-xs" style="border-radius:25px;" data-dismiss="modal">Cancel</button>
		    <button class="btn btn-danger btn-xs" style="border-radius:25px;" onClick="updateMerchant()">Update</button>

      </div> 
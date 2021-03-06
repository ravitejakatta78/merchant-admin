<?php
use app\helpers\Utility;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <div class="modal-body">
				<?php	$form = ActiveForm::begin([
    		'id' => 'edit-article-form',
			'action'=>'edit-article',
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
	   							<label class="control-label col-md-4">Title</label>
								<div class="col-md-8">
											<?= $form->field($model, 'title')->textinput(['class' => 'form-control'])->label(false); ?>
											<?= $form->field($model, 'ID')->hiddeninput(['class' => 'form-control'])->label(false); ?>

										</div>
	   						</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group row">
	   							<label class="control-label col-md-4">Image</label>
								<div class="col-md-8">
											<?= $form->field($model, 'image')->fileinput(['class' => 'form-control'])->label(false); ?>
								</div>
	   						</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group row">
	   							<label class="control-label col-md-4">Content</label>
								<div class="col-md-8">
											<?= $form->field($model, 'content')->textarea(['class' => 'form-control'])->label(false); ?>
								</div>
	   						</div>
						</div>



	   </div>

		
   <div class="modal-footer">
		<?= Html::submitButton('Edit Article', ['class'=> 'btn btn-add']); ?>
      </div> 
		<?php ActiveForm::end() ?>
        
        
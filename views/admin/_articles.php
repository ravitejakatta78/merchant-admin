<div class="col-md-12">
    <ul class="resp-tabs-list">
		<a href="<?= \yii\helpers\Url::to(['admin/articles']); ?>"><li class="resp-tab-item <?php if($actionId == 'articles') { echo "resp-tab-active" ;} ?>">Articles</li></a>		
		<a href="<?= \yii\helpers\Url::to(['admin/food-shorts']); ?>"><li class="resp-tab-item <?php if($actionId == 'food-shorts') { echo "resp-tab-active" ;} ?>" >Food Shorts</li></a>
    </ul>
</div>






    
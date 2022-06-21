<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
$actionId = Yii::$app->controller->action->id;
?>
<nav class="side-navbar">
          
          <!-- Sidebar Navidation Menus-->
          <ul class="list-unstyled">
    <!--      <li class="<?php if($actionId == 'index' || $actionId == 'transactiondash' ) { echo "active" ;} ?>">
			<a href="#maindropdownDropdown" aria-expanded="<?php if($actionId == 'index' || $actionId == 'transactiondash' ) { echo "true" ;}else { "false"; }  ?>" data-toggle="collapse">
			<i class="fa fa-home"></i>Merchants </a>
              <ul id="maindropdownDropdown" class="collapse list-unstyled <?php if($actionId == 'index' || $actionId == 'transactiondash' ) { echo "collapse show" ;} ?>">
                <li class="<?php if($actionId == 'index') { echo "active" ;} ?>"><a href="<?= Url::to(['site/index']); ?>">Dashboard</a></li>
                <li class="<?php if($actionId == 'transactiondash') { echo "active" ;} ?>"><a href="<?= Url::to(['site/transactiondash']); ?>">Transaction</a></li>
              </ul>
            </li> 

			<li class="<?php if($actionId == 'food-categeries' || $actionId == 'product-list' ) { echo "active" ;} ?>">
			<a href="#exampledropdownDropdown" aria-expanded="<?php if($actionId == 'food-categeries' || $actionId == 'product-list' ) { echo "true" ;}else { "false"; }  ?>" data-toggle="collapse"> <i class="fa fa-cube"></i>Manage Products </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled <?php if($actionId == 'food-categeries' || $actionId == 'product-list' ) { echo "collapse show" ;} ?>">
                <li class="<?php if($actionId == 'food-categeries') { echo "active" ;} ?>"><a href="<?= Url::to(['merchant/food-categeries']); ?>">Food Categories</a></li>
                <li class="<?php if($actionId == 'product-list') { echo "active" ;} ?>"><a href="<?= Url::to(['merchant/product-list']); ?>">Products</a></li>
              </ul>
            </li> -->
            <li class="<?php if($actionId == 'dashboard' ) { echo "active" ;} ?>">
			<a href="<?php echo Url::to(['admin/dashboard']); ?>"> <i class="fa fa-home"></i>Dashboard </a></li>

            <li class="<?php if($actionId == 'merchants' || $actionId == 'paydetails') { echo "active" ;} ?>">
			<a href="<?php echo Url::to(['admin/merchants']); ?>"> <i class="fa fa-users"></i>Merchants </a></li>
			<li class="<?php if($actionId == 'merchantgrouping') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/merchantgrouping']); ?>"> <i class="fa fa-users"></i>Merchant Groupings </a>
			</li>
            <li class="<?php if($actionId == 'rating') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/rating']); ?>"> <i class="fa fa-star-o"></i>Ratings </a>
			</li>
		    <li class="<?php if($actionId == 'bannerdetails') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/bannerdetails']); ?>"> <i class="fa fa-list-ul"></i>Banner List </a>
			</li>
			<li class="<?php if($actionId == 'rewards') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/rewards']); ?>"> <i class="fa fa-shield"></i>Rewards List </a>
			</li>
		
			<li class="<?php if($actionId == 'coupons') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/coupons']); ?>"> <i class="fa fa-tags"></i>Coupons </a>
			</li>


			<li class="<?php if($actionId == 'appnotifications' || $actionId == 'othernotifications'  ) { echo "active" ;} ?>">
			<a href="#userdropdownDropdown" aria-expanded="<?php if($actionId == 'appnotifications' || $actionId == 'othernotifications' ) { echo "true" ;}else { "false"; }  ?>" data-toggle="collapse"> <i class="fa fa-bell"></i>Notifications </a>
              <ul id="userdropdownDropdown" class="collapse list-unstyled <?php if($actionId == 'appnotifications' || $actionId == 'othernotifications'  ) { echo "collapse show" ;} ?>">
                <li class="<?php if($actionId == 'appnotifications') { echo "active" ;} ?>"><a href="<?php echo Url::to(['admin/appnotifications']); ?>"> App Notifications </a></li>
                <li class="<?php if($actionId == 'othernotifications') { echo "active" ;} ?>"><a href="<?php echo Url::to(['admin/othernotifications']); ?>"> Other Notifications </a></li>
              

              </ul>
            </li>

		<!--	<li class="<?php if($actionId == 'appnotifications') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/appnotifications']); ?>"> <i class="fa fa-bell"></i>App Notifications </a>
			</li>-->

			
			<li class="<?php if($actionId == 'userdata' || $actionId == 'deletedempoyee' || $actionId == 'deletedvendor' ) { echo "active" ;} ?>">
			<a href="#userdropdownDropdown" aria-expanded="<?php if($actionId == 'userdata' || $actionId == 'deletedempoyee' || $actionId == 'deletedvendor' ) { echo "true" ;}else { "false"; }  ?>" data-toggle="collapse"> <i class="fa fa-cube"></i>User Data </a>
			
              <ul id="userdropdownDropdown" class="collapse list-unstyled <?php if($actionId == 'userdata' || $actionId == 'deletedempoyee' || $actionId == 'deletedvendor'  ) { echo "collapse show" ;} ?>">
                <li class="<?php if($actionId == 'userdata') { echo "active" ;} ?>"><a href="<?= Url::to(['admin/userdata']); ?>">Users </a></li>
                <li class="<?php if($actionId == 'deletedempoyee') { echo "active" ;} ?>"><a href="<?= Url::to(['admin/deletedempoyee']); ?>">Deleted Employee</a></li>
                <li class="<?php if($actionId == 'deletedvendor') { echo "active" ;} ?>"><a href="<?= Url::to(['admin/deletedvendor']); ?>">Deleted Vendors</a></li>

              </ul>
            </li>
            <li class="<?php if($actionId == 'storetypes') { echo "active" ;} ?>">
			<a href="#condropdownDropdown" aria-expanded="<?php if($actionId == 'storetypes' ) { echo "true" ;}else { "false"; }  ?>" data-toggle="collapse"> <i class="fa fa-cube"></i>Configurations </a>
              <ul id="condropdownDropdown" class="collapse list-unstyled <?php if($actionId == 'storetypes') { echo "collapse show" ;} ?>">
                <li class="<?php if($actionId == 'storetypes') { echo "active" ;} ?>"><a href="<?= Url::to(['admin/storetypes']); ?>">Merchant Types </a></li>
              </ul>
            </li>
			<li class="<?php if($actionId == 'contest') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/contest']); ?>"> <i class="fa fa-bell"></i>Contest</a>
			</li>
			<li class="<?php if($actionId == 'partner-with-us') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/partner-with-us']); ?>"> <i class="fa fa-handshake-o"></i>Partner With Us</a>
			</li>
			<li class="<?php if($actionId == 'articles' || $actionId == 'food-shorts') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/articles']); ?>"> <i class="fa fa-newspaper-o"></i>Swing</a>
			</li>
			<li class="<?php if($actionId == 'articles' || $actionId == 'clients') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/clients']); ?>"> <i class="fa fa-newspaper-o"></i>Clients</a>
			</li>			
            <li class="<?php if($actionId == 'permissions') { echo "active" ;} ?> ">
				<a href="<?php echo Url::to(['admin/permissions']); ?>"> <i class="fa fa-bell"></i>Permissions</a>
			</li>
            
          </ul>
        </nav>
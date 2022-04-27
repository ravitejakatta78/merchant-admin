<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SuperPilot Admin</title>
    		<link rel="shortcut icon" href="<?php echo Url::base(); ?>/favicon.png" type="image/x-icon" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
<?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
	<script src="<?= Yii::$app->request->baseUrl.'/js/code.jquery-3.3.1.js'?>"></script> 
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->

  </head>
  <body>
	<?php $this->beginBody() ?>
    <div class="page">
<header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="<?= \yii\helpers\Url::to('../admin/dashboard'); ?>" class="navbar-brand d-none d-sm-inline-block">
                  <div class="brand-text d-none d-lg-inline-block">
				  <img src="<?= Yii::$app->request->baseUrl.'/img/superpilot-1.png';?>" style="max-height:4.3rem;" > </div>
                  <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>HM</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Search-->
                <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
                <li class="nav-item d-flex">
                <h1 class="h4 mt-1"><a href="<?= \yii\helpers\Url::to('../admin/dashboard'); ?>" style="text-decoration: none;"><i class="fa fa-user-circle-o" style="font-size:24"></i>
 SuperPilot Admin</a></h1>

                </li>
                <!-- Notifications-->
                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span class="badge bg-red badge-corner">12</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                          <div class="notification-time"><small>10 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li>
                  </ul>
                </li>
                <!-- Messages                        -->
                
                <!-- Languages dropdown    -->
                <!--      -->
                <li class="nav-item"><a href="<?php echo Url::to(['site/signout']); ?>" data-method="post" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
<div class="page-content d-flex align-items-stretch"> 
<?php
echo \Yii::$app->view->renderFile('@app/views/layouts/_sidebar.php');
?>
<div class="content-inner">
            <?= $content ?>
<footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6 text-right">
                  <p>©️ 2021 Super Pilot Innovation<a href="#" class="external"></a></p>
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
	<?php   $this->endBody() ?>
	<script>
	$(document).ready(function(){
	
	$('select').select2();
});
	</script>
  </body>
</html>
<?php $this->endPage() ?>

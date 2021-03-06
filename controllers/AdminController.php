<?php

namespace app\controllers;
use yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use app\helpers\Utility;
use \app\models\FoodCategeries;
use \app\models\Users;
use \app\models\Feedback;
use \app\models\Appnotifications;
use \app\models\Banners;
use \app\models\Rewards;
use \app\models\MerchantCoupon;
use \app\models\Merchant;
use \app\models\MerchantPaytypes;
use \app\models\Articles;
use \app\models\FoodShorts;
use \app\models\FoodShortsImages;
use \app\models\Client;
use yii\db\Query;


class AdminController extends GoController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionCategeries(){
		$categoryModel = FoodCategeries::find()
		->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
	return $this->render('categorylist',['categoryModel'=>$categoryModel]);
	}
	public function actionUserdata(){
		$usersModel = Users::find()
		->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
	return $this->render('usersData',['usersModel'=>$usersModel]);

	}
	public function actionRating(){
		extract($_POST);
		$sdate = $sdate ?? date('Y-m-d');
		$edate = $edate ?? date('Y-m-d');
		
		$merchants = \app\models\Merchant::find()->asArray()->all();
		
		$sqlrating = 'select m.name merchant_name,m.storename,u.name as user_name,fd.*,ord.serviceboy_id,ord.order_id, ord.totalamount,sb.name service_boy_name
		from feedback fd
		inner join orders ord on fd.order_id=ord.id
		left join serviceboy sb on ord.serviceboy_id = sb.ID
		left join users u on fd.user_id = u.ID
		left join merchant m on fd.merchant_id = m.ID 
		where fd.reg_date between \''.$sdate.'\' and \''.$edate.'\'';
		if(!empty($merchantId)){
		$sqlrating .= ' and  fd.merchant_id=\''.$merchantId.'\'';
		}
		else{
			$merchantId = '';
		}
		$ratingModel=Yii::$app->db->createCommand($sqlrating)->queryAll();		
		return $this->render('rating',['ratingModel'=>$ratingModel
		,'sdate'=>$sdate,'edate'=>$edate,'merchants'=>$merchants,'merchantId'=>$merchantId]);
	}
	public function actionAppnotifications(){
		
		$appNotificationModel = Appnotifications::find()
		->orderBy([
            'ID'=>SORT_DESC
        ])
		->asArray()->all();
		$model = new Appnotifications;
if ($model->load(Yii::$app->request->post()) ) {

		$model->admin_id = (string)Yii::$app->user->identity->ID;
		$model->reg_date = date('Y-m-d h:i:s');
		$model->mod_date = date('Y-m-d h:i:s');
		$image = UploadedFile::getInstance($model, 'image');
		if($image){
			$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
			$image->saveAs('uploads/notificationimage/' . $imagename);
			$model->image = $imagename;
		}
		if($model->validate()){
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'APP Notification',
		'text' => 'APP Notification Added Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			$model->save();

		return	$this->redirect('appnotifications');
		}
		else
		{
		//	echo "<pre>";print_r($model->getErrors());exit;
		}
	}

		return $this->render('appNotifications',['appNotificationModel'=>$appNotificationModel,'model'=>$model]);

	}
	public function actionEditappnotificationpopup()
    {
		extract($_POST);
		$rewardsModel = Appnotifications::findOne($id);
		return $this->renderAjax('editapnotificationpopup', ['model' => $rewardsModel,'id'=>$id]);	
    }
	public function actionUpdateappnotification()
	{
		extract($_POST);
$model = new Appnotifications;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$appnotifyArr = Yii::$app->request->post('Appnotifications');
		$appnotifyUpdate = Appnotifications::findOne($_POST['Appnotifications']['ID']);
		$appnotifyImage = $appnotifyUpdate['image'];

		$appnotifyUpdate->attributes = \Yii::$app->request->post('Appnotifications');
		$image = UploadedFile::getInstance($model, 'image');
			if($image){
				if(!empty($appnotifyUpdate['image'])){
					$imagePath =  '../../'.Url::to(['/uploads/notificationimage/'. $appnotifyUpdate['logo']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$image->saveAs('uploads/notificationimage/' . $imagename);
				$appnotifyUpdate->image = $imagename;
			}else{
				$appnotifyUpdate->image = $appnotifyImage;
			}
			
			
			
		if($appnotifyUpdate->validate()){
			$appnotifyUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'APP Notification',
		'text' => 'APP Notification Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('appnotifications');

	}
	public function actionBannerdetails(){
		$status = '1';
		$bannerdet = Banners::find()
		
		->orderBy([
            'ID'=>SORT_DESC
        ])
		->asArray()->all();
		$model = new Banners;
				if ($model->load(Yii::$app->request->post()) ) {
			$MerchantGalleryArr = Yii::$app->request->post('Banners');
			$model->user_id = (string)Yii::$app->user->identity->ID;
			$model->reg_date = date('Y-m-d h:i:s');
			$model->status = '1';
			$image = UploadedFile::getInstance($model, 'image');
			if($image){
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
			//	$image->saveAs('uploads/bannerimage/' . $imagename);
		        $image->saveAs('../../bannerimage/' . $imagename);
				$model->image = $imagename;
		
			}
			if($model->validate()){
				$model->save();
	Yii::$app->getSession()->setFlash('success', [
        'title' => 'Banner',
		'text' => 'Banner Uploaded Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('bannerdetails');
			}
			else
			{
				echo "<pre>";print_r($model->getErrors());exit;
			}
		}
		return $this->render('bannerDetails',['bannerdet'=>$bannerdet,'model'=>$model]);
	}
	public function actionDeletebanner()
	{
		extract($_POST);
				$bannerDet = Banners::findOne($id);
		if($bannerDet['image']){
			//	$imagePath =  '../../'.Url::to(['/uploads/bannerimage/'. $bannerDet['image']]);
				$imagePath =  '../../'.Url::to(['../../bannerimage/'. $bannerDet['image']]);

					if(file_exists($imagePath)){
					unlink($imagePath);	
					}
			\Yii::$app->db->createCommand()->delete('banners', ['id' => $id])->execute();
		}
	}
	public function actionEditbannerpopup()
    {
		extract($_POST);
		$rewardsModel = Banners::findOne($id);
		return $this->renderAjax('editbannerpopup', ['model' => $rewardsModel,'id'=>$id]);	
    }
	public function actionUpdatebanner()
	{
		extract($_POST);
		$model = new Banners;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$bannerArr = Yii::$app->request->post('Banners');
		$bannerUpdate = Banners::findOne($_POST['Banners']['ID']);
		$bannerOldImage = $bannerUpdate['image'];

		$bannerUpdate->attributes = \Yii::$app->request->post('Banners');
		$image = UploadedFile::getInstance($model, 'image');
			if($image){
				if(!empty($bannerUpdate['image'])){
					$imagePath =  '../../'.Url::to(['/uploads/bannerimage/'. $bannerUpdate['logo']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
//				$image->saveAs('uploads/bannerimage/' . $imagename);
				$image->saveAs('../../bannerimage/' . $imagename);
				$bannerUpdate->image = $imagename;
			}else{
				$bannerUpdate->image = $bannerOldImage;
			}
			
			
			
		if($bannerUpdate->validate()){
			$bannerUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Banner',
		'text' => 'Banner Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('bannerdetails');

	}
	public function actionDeleteappnotification()
	{
		extract($_POST);
				$appnotificationsDet = Appnotifications::findOne($id);
		if($appnotificationsDet['image']){
				$imagePath =  '../../'.Url::to(['/uploads/notificationimage/'. $appnotificationsDet['image']]);
					if(file_exists($imagePath)){
					unlink($imagePath);	
					}
			\Yii::$app->db->createCommand()->delete('appnotifications', ['id' => $id])->execute();
		}
	}
	public function actionDeleteuser()
	{
		extract($_POST);
				$usersDet = Users::findOne($id);
		if($usersDet['ID']){
			\Yii::$app->db->createCommand()->delete('users', ['id' => $id])->execute();
		}
	}

	public function actionRewards(){
		$rewardsdet = Rewards::find()
		->orderBy([
            'ID'=>SORT_DESC
        ])
		->asArray()->all();
		$model = new Rewards;
		$model->scenario = 'insertphoto';
		if ($model->load(Yii::$app->request->post()) ) {
		$model->user_id  = (string)Yii::$app->user->identity->ID;
		$model->soldout = '0';
		$model->status = '1';
		$model->validity = '1';
		$model->reg_date = date('Y-m-d h:i:s');
		$model->mod_date = date('Y-m-d h:i:s');
		$image = UploadedFile::getInstance($model, 'logo');
		if($image){
			$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
		//	$image->saveAs('uploads/rewardsimage/' . $imagename);
		    $image->saveAs('../../rewardsimage/' . $imagename);
			$model->logo = $imagename;
		}
		$coverimage = UploadedFile::getInstance($model, 'cover');
		if($coverimage){
			$coverimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$coverimage->extension;
			//$coverimage->saveAs('uploads/rewardsimage/' . $coverimagename);
			$coverimage->saveAs('../../rewardsimage/' . $coverimagename);
			$model->cover = $coverimagename;
		}
		
		if($model->validate()){
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Reward',
		'text' => 'Reward Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			$model->save();

		return	$this->redirect('rewards');
		}
		else
		{
		//	echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		return $this->render('rewards',['rewardsdet'=>$rewardsdet,'model'=>$model]);
	}
	public function actionEditrewardpopup()
	{
		extract($_POST);
		$rewardsModel = Rewards::findOne($id);
		return $this->renderAjax('editrewardpopup', ['model' => $rewardsModel,'id'=>$id]);		
	}
	public function actionUpdatereward()
	{
		extract($_POST);
		$model = new Rewards;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$rewardArr = Yii::$app->request->post('Rewards');
		$rewardUpdate = Rewards::findOne($_POST['Rewards']['ID']);
		$rewardLogo = $rewardUpdate['logo'];
		$rewardCover = $rewardUpdate['cover'];
		$rewardUpdate->attributes = \Yii::$app->request->post('Rewards');
		$image = UploadedFile::getInstance($model, 'logo');
			if($image){
				if(!empty($rewardUpdate['logo'])){
					//$imagePath =  '../../'.Url::to(['/uploads/rewardsimage/'. $rewardUpdate['logo']]);
					$imagePath =  '../../'.Url::to(['../../rewardsimage/'. $rewardUpdate['logo']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				//$image->saveAs('uploads/rewardsimage/' . $imagename);
				$image->saveAs('../../rewardsimage/' . $imagename);
				$rewardUpdate->logo = $imagename;
			}else{
				$rewardUpdate->logo = $rewardLogo;
			}
			$coverimage = UploadedFile::getInstance($model, 'cover');
			if($coverimage){
				if(!empty($rewardUpdate['cover'])){
					//$imagePath =  '../../'.Url::to(['/uploads/rewardsimage/'. $rewardUpdate['cover']]);
					$imagePath =  '../../'.Url::to(['../../rewardsimage/'. $rewardUpdate['cover']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$coverimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$coverimage->extension;
				//$coverimage->saveAs('uploads/rewardsimage/' . $coverimagename);
				$coverimage->saveAs('../../rewardsimage/' . $coverimagename);
				$rewardUpdate->cover = $coverimagename;
			}else{
				$rewardUpdate->cover = $rewardCover;
			}
			
			
		if($rewardUpdate->validate()){
			$rewardUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Reward',
		'text' => 'Reward Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('rewards');
	}
	public function actionCoupons(){
		$sqlcoupons = "select * from merchant_coupon where merchant_id <= '0' order by ID desc";
		$coupondet = Yii::$app->db->createCommand($sqlcoupons)->queryAll();
		$model = new \app\models\MerchantCoupon;
		if ($model->load(Yii::$app->request->post()) ) {
		$MerchantCouponArr = Yii::$app->request->post('MerchantCoupon');
			$model->merchant_id = '0';
			$model->status = 'Active';
			$model->minorderamt = 0;
			$model->reg_date = date('Y-m-d h:i:s');
			$model->validity = '0';
			if($model->validate()){
				$model->save();
					Yii::$app->getSession()->setFlash('success', [
        'title' => 'Coupon',
		'text' => 'Coupon Added Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('coupons');
			}
			else
			{
				echo "<pre>";print_r($model->getErrors());exit;
			}
		}
		return $this->render('coupons',['coupondet'=>$coupondet,'model'=>$model]);
	}
	public function actionEditcouponpopup()
	{
		extract($_POST);
		$couponModel = MerchantCoupon::findOne($id);
		return $this->renderAjax('editcouponpopup', ['model' => $couponModel,'id'=>$id]);
	}
public function actionUpdatecoupon()
	{
		extract($_POST);
		$model = new MerchantCoupon;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$couponArr = Yii::$app->request->post('MerchantCoupon');
		$couponUpdate = MerchantCoupon::findOne($_POST['MerchantCoupon']['ID']);

		$couponUpdate->attributes = \Yii::$app->request->post('MerchantCoupon');
			
			
		if($couponUpdate->validate()){
			$couponUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Coupon',
		'text' => 'Coupon Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('coupons');
	}
	public function actionMerchants(){
		$model = new Merchant;
		$model->scenario = 'insertemail';
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		if(!empty($_POST['storetype'])){
			$merchants = Merchant::find()
			->where(['storetype'=>$_POST['storetype']])
			->orderBy([
				'ID'=>SORT_DESC
			])
			->asArray()->all();
		}else{
			$merchants = Merchant::find()
			->orderBy([
				'ID'=>SORT_DESC
			])
			->asArray()->all();
			
		}
		$model = new Merchant;
        if ($model->load(Yii::$app->request->post()) ) {
	        $MerchantArr = Yii::$app->request->post('Merchant');
		
			$model->user_id = '1';
			$model->unique_id = Utility::get_uniqueid('merchant','FDME');
			$model->password = password_hash($MerchantArr['password'], PASSWORD_DEFAULT);
			$model->otp = 0;
			$model->status = '1';
			$model->reg_date = date('Y-m-d h:i:s');
			$logoimage = UploadedFile::getInstance($model, 'logo');
			$qrlogoimage = UploadedFile::getInstance($model, 'qrlogo');
			$coverpicimage = UploadedFile::getInstance($model, 'coverpic');	
			if($logoimage){
				$logoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$logoimage->extension;
				$logoimage->saveAs('../../merchant_images/merchantimages/' . $logoimagename);
				$model->logo = $logoimagename;

			}
	
			if($qrlogoimage){
				$qrlogoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$qrlogoimage->extension;
				$qrlogoimage->saveAs('../../merchant_images/merchantimages/' . $qrlogoimagename);
				$model->qrlogo = $qrlogoimagename;
			}
			if($coverpicimage){
				$coverpicimageimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$coverpicimage->extension;
				$coverpicimage->saveAs('../../merchant_images/merchantimages/' . $coverpicimageimagename);
				$model->coverpic = $coverpicimageimagename;
			}
			if($model->validate()){
				$model->save();
				
			$modelEmp = new \app\models\MerchantEmployee;
			$modelEmp->merchant_id = (string)$model->ID;
			$modelEmp->emp_id =  Utility::get_uniqueid('merchant','FDME');
			$modelEmp->emp_name = $MerchantArr['name'];
			$modelEmp->emp_email = $MerchantArr['email'];
			$modelEmp->emp_phone = $MerchantArr['mobile'];
			$modelEmp->emp_password = password_hash($MerchantArr['password'], PASSWORD_DEFAULT);
			$modelEmp->emp_role = 0;
			$modelEmp->emp_exp = 0;
			$modelEmp->date_of_join = date('Y-m-d');
			$modelEmp->emp_designation = 'OWNER';
			$modelEmp->emp_specialities = 'OWNER';
			$modelEmp->emp_status = '1';
			$modelEmp->emp_salary = 0;
			$modelEmp->reg_date = date('Y-m-d h:i:s');
			$modelEmp->mod_date = date('Y-m-d h:i:s');
			$modelEmp->created_by = Yii::$app->user->identity->name;
			if($modelEmp->validate()){
					$modelEmp->save();
			}
			else{
				echo "<pre>";print_r($modelEmp->getErrors());exit;
			}
			
			$modelRole =new \app\models\EmployeeRole;
			$modelRole->merchant_id = (string)$model->ID;
			$modelRole->role_name = 'OWNER';
			$modelRole->role_status = 1;
			$modelRole->created_by = Yii::$app->user->identity->name;
			$modelRole->reg_date = date('Y-m-d h:i:s');
			$modelRole->save();
			
			$modelRole =new \app\models\EmployeeRole;
			$modelRole->merchant_id = (string)$model->ID;
			$modelRole->role_name = 'PILOT';
			$modelRole->role_status = 1;
			$modelRole->created_by = Yii::$app->user->identity->name;
			$modelRole->reg_date = date('Y-m-d h:i:s');
			$modelRole->save();
			
			$modelSections = new \app\models\Sections;
			$modelSections->merchant_id = (string)$model->ID;
		    $modelSections->section_id= Utility::get_uniqueid('sections','SS');
		    $modelSections->section_name = 'Parcels';
		    $modelSections->save();
			
					Yii::$app->getSession()->setFlash('success', [
        'title' => 'Merchant',
		'text' => 'Merchant Added Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('merchants');
			}
			else
			{
				echo "<pre>";print_r($model->getErrors());exit;
			}
		}
		return $this->render('merchants',['merchantslist'=>$merchants,'model'=>$model]);
	}
	public function actionEditmerchantpopup()
	{
		extract($_POST);
		$merchantModel = Merchant::findOne($id);
		$merchantModel->password= null;
		return $this->renderAjax('editmerchantpopup', ['model' => $merchantModel,'id'=>$id]);
	}
	public function actionUpdatemerchant()
	{
		extract($_POST);
		$model = new Merchant;
		$model->scenario = 'updateemail';
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		

		$merchantArr = Yii::$app->request->post('Merchant');
		$model->password = password_hash($merchantArr['password'], PASSWORD_DEFAULT);
			
		$merchantUpdate = Merchant::findOne($_POST['Merchant']['ID']);
		if($merchantArr['password'] != '')
		{
			$newpassword = password_hash($merchantArr['password'], PASSWORD_DEFAULT);
					$sqlupdateMerchantUser = 'update merchant_employee	 set emp_password = \''.$newpassword.'\' 
					where merchant_id = \''.$_POST['Merchant']['ID'].'\' and emp_role = \'0\'';
		$updateMerchantUser = Yii::$app->db->createCommand($sqlupdateMerchantUser)->execute();	
		}
		else{
			$newpassword = $merchantUpdate['password'];
		}
		
		if($merchantUpdate['email'] != $merchantArr['email'])
		{
			$sqlupdateMerchantEmail = 'update merchant_employee	 set emp_email = \''.$merchantArr['email'].'\' 
					where merchant_id = \''.$_POST['Merchant']['ID'].'\' and emp_role = \'0\'';
		$updateMerchantEmail = Yii::$app->db->createCommand($sqlupdateMerchantEmail)->execute();	
   
		}
		if($merchantUpdate['mobile'] != $merchantArr['mobile'])
		{
			$sqlupdateMerchantEmail = 'update merchant_employee	 set emp_phone = \''.$merchantArr['mobile'].'\' 
					where merchant_id = \''.$_POST['Merchant']['ID'].'\' and emp_role = \'0\'';
		$updateMerchantEmail = Yii::$app->db->createCommand($sqlupdateMerchantEmail)->execute();	
   
		}
		
	$oldLogo = $merchantUpdate['logo'];
		$oldQrLogo = $merchantUpdate['qrlogo'];
		$oldCoverpic = $merchantUpdate['coverpic'];
		
		$merchantUpdate->attributes = \Yii::$app->request->post('Merchant');
		$merchantUpdate->password = $newpassword;
		
	$logoimage = UploadedFile::getInstance($merchantUpdate, 'logo');
	$qrlogoimage = UploadedFile::getInstance($merchantUpdate, 'qrlogo');
	$coverpicimage = UploadedFile::getInstance($merchantUpdate, 'coverpic');	
	if($logoimage){
					if(!empty($oldLogo)){
					$imagePath =  '../../'.Url::to(['../../merchant_images/merchantimages/'. $oldLogo]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
					
				}
				
				$logoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$logoimage->extension;
				$logoimage->saveAs('../../merchant_images/merchantimages/' . $logoimagename);
				$merchantUpdate->logo = $logoimagename;

			}else{
				$merchantUpdate->logo = $oldLogo;
			}
	
			if($qrlogoimage){
				if(!empty($oldQrLogo)){
					$imagePath =  '../../'.Url::to(['../../merchant_images/merchantimages/'. $oldQrLogo]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				$qrlogoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$qrlogoimage->extension;
				$qrlogoimage->saveAs('../../merchant_images/merchantimages/' . $qrlogoimagename);
				$merchantUpdate->qrlogo = $qrlogoimagename;
			}else{
				$merchantUpdate->qrlogo = $oldQrLogo;
			}
			if($coverpicimage){
				if(!empty($oldCoverpic)){
					$imagePath =  '../../'.Url::to(['../../merchant_images/merchantimages/'. $oldCoverpic]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				$coverpicimageimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$coverpicimage->extension;
				$coverpicimage->saveAs('../../merchant_images/merchantimages/' . $coverpicimageimagename);
				$merchantUpdate->coverpic = $coverpicimageimagename;
			}else{
				$merchantUpdate->coverpic = $oldCoverpic;
			}
			
		if($merchantUpdate->validate()){

			$merchantUpdate->save();
		}
		else{
			print_r($merchantUpdate->getErrors());exit;
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Merchant',
		'text' => 'Merchant Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('merchants');
	}
	public function actionDeletemerchant()
	{
		extract($_POST);
$merchantDet = Merchant::findOne($id);
		if($merchantDet['ID']){
				
			\Yii::$app->db->createCommand()->delete('merchant', ['id' => $id])->execute();
			\Yii::$app->db->createCommand()->delete('merchant_employee', ['merchant_id' => $id])->execute();
		}
	}
	public function actionDeletemerchantinfo()
	{
		extract($_POST);
        $merchantDet = \app\models\MerchantInfo::findOne($id);
		if($merchantDet['ID']){
			\Yii::$app->db->createCommand()->delete('merchant_info', ['id' => $id])->execute();
		}
	}
	public function actionChangeproductavailabilty(){
	extract($_POST);
	$productDetails = Product::findOne($tableid);
	if($productDetails['availabilty']=='1'){
				$availabilty ='0';
		}else{
				$availabilty = '1';
		}
	$productDetails->availabilty = $availabilty;
	$productDetails->save();

    }
    public function actionChangeproductstatus(){
	extract($_POST);
	if($tablename == 'banners')
	{
		$details = Banners::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'rewards')
	{
		$details = Rewards::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'merchant')
	{
		$details = Merchant::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'articles')
	{
		$details = Articles::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	} else if($tablename == 'foodShorts') {
		$details = FoodShorts::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
else if($tablename == 'coupon')
	{
		$details = MerchantCoupon::findOne($tableid);	
	if($details['status']=='Active'){
				$status ='Deactive';
		}else{
				$status = 'Active';
		}
	}
	else if($tablename == 'merchant_paytypes')
	{
		$details = MerchantPaytypes::findOne($tableid);	
	if($details['status']=='1'){
				$status =2;
		}else{
				$status = 1;
		}
	}

	$details->status = $status;
	if($details->save()){
		print_r($details->getErrors());exit;
	}
	

    }
	public function actionPaydetails()
	{
		extract($_REQUEST);
		if(!empty($merchantId)){
			$merchantId = $merchantId;
			$mer_id = $merchantId;
		}else if(isset($_POST['MerchantPaytypes']['merchant_id'])){
			$merchantId = $_POST['MerchantPaytypes']['merchant_id'];
		//$mer_id = '';
		}else{
			return $this->redirect('merchants');
		}
		$sqlmerchantPay = 'SELECT mp.ID,storename,paymenttype,merchantid,merchantkey,mp.status,service_types  FROM merchant_paytypes mp 
		inner join merchant m on mp.merchant_id = m.ID
		left join (select paytype_id,GROUP_CONCAT(case when service_type_id = 1 then \''.'Dine In'.'\'
		when service_type_id = 2 then \''.'Parcels'.'\'
		when service_type_id = 3 then \''.'Self-Pickup'.'\'
		when service_type_id = 4 then \''.'Delivery'.'\'
		else \''.'Table Reservation'.'\' end
		 ) service_types from merchant_paytype_services group by  merchant_id,paytype_id) st
		on st.paytype_id = mp.ID 
		where merchant_id = \''.$merchantId.'\' order by mp.ID desc';
		$merchantPay = Yii::$app->db->createCommand($sqlmerchantPay)->queryAll();
		$model = new MerchantPaytypes;

		
		if ($model->load(Yii::$app->request->post()) ) {

		$model->reg_date = date('Y-m-d h:i:s');
		
		if($model->validate()){
			$model->save();
			if(!empty($_POST['group'])){
				for($i=0;$i<count($_POST['group']);$i++)
				{
					$data[] = [$merchantId,$model->ID,$_POST['group'][$i],date('Y-m-d H:i:s A')];
				}
				Yii::$app->db
				->createCommand()
				->batchInsert('merchant_paytype_services', ['merchant_id','paytype_id','service_type_id', 'reg_date'],$data)
				->execute();	
			}

		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Payment Method',
		'text' => 'Payment Method Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			

//		return	$this->redirect('paydetails');
		return $this->redirect(['admin/paydetails','merchantId'=>$model->merchant_id]);
		}
		else
		{
		//	echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		return $this->render('merchantpaytypes',['merchantPay'=>$merchantPay,'model'=>$model,'merchantId'=>$merchantId]);
		
	}
	public function actionEditpaytypespopup()
	{
		extract($_POST);
		$paytypesModel = MerchantPaytypes::findOne($id);
		$serviceTypeDetails = \app\models\MerchantPaytypeServices::find()->where(['paytype_id' => $id])->asArray()->all();
		$serviceTypeDetailsArray = array_column($serviceTypeDetails,'service_type_id');
		return $this->renderAjax('editpaytypespopup', ['model' => $paytypesModel,'id'=>$id, 'serviceTypeDetailsArray' => $serviceTypeDetailsArray]);
	}
	public function actionUpdatepaymentmethod()
	{
		extract($_POST);
		$model = new MerchantPaytypes;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$merchantPaymentArr = Yii::$app->request->post('MerchantPaytypes');
		$merchantPaymentUpdate = MerchantPaytypes::findOne($_POST['MerchantPaytypes']['paymenttype']);

			
			 
		if(!empty($merchantPaymentUpdate)){
			if(!empty($_POST['updategroup'])){
				$sqlDelete = 'delete from merchant_paytype_services where paytype_id = \''.$_POST['MerchantPaytypes']['paymenttype'].'\'';
				$resDelete = Yii::$app->db->createCommand($sqlDelete)->execute();
				for($i=0;$i<count($_POST['updategroup']);$i++)
				{
					$data[] = [$_POST['MerchantPaytypes']['merchantId'],$_POST['MerchantPaytypes']['paymenttype'],$_POST['updategroup'][$i],date('Y-m-d H:i:s A')];
				}
				Yii::$app->db
				->createCommand()
				->batchInsert('merchant_paytype_services', ['merchant_id','paytype_id','service_type_id', 'reg_date'],$data)
				->execute();	
			}
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Payment Method',
		'text' => 'Payment Method Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect(['admin/paydetails','merchantId'=>$merchantPaymentUpdate['merchant_id']]);
	}
	public function actionDeletepaytype(){
		extract($_POST);
		$paydetails = \app\models\MerchantPaytypes::findOne($id);
		$paydetails->delete();

		$sqlDelete = 'delete from merchant_paytype_services where paytype_id = \''.$id.'\'';
		$resDelete = Yii::$app->db->createCommand($sqlDelete)->execute();

		return $this->redirect(['admin/paydetails','merchantId'=>$paydetails['merchant_id']]);
		
	}
	public function actionDeletecoupon(){
		extract($_POST);
		$coupondetails = \app\models\MerchantCoupon::findOne($id);
		$coupondetails->delete();
	}
	public function actionDeletereward(){
		extract($_POST);
		$rewarddetails = \app\models\Rewards::findOne($id);
		$rewarddetails->delete();
	}	
    public function actionDashboard()
	{
		$date = date('Y-m-d');
		$sqlUsersCount = 'select count(ID) usercount from users ';
		$resUsersCount = Yii::$app->db->createCommand($sqlUsersCount)->queryOne();
		
		$userCount = $resUsersCount['usercount'] ?? 0; 
		
		$sqlRegResturant = 'select count(*) regResturanrt  from merchant where storetype = \'Restaurant\' ';
		$resRegResturant = Yii::$app->db->createCommand($sqlRegResturant)->queryOne();
		
		$regResturant = $resRegResturant['regResturanrt'] ?? 0;
		
		$sqlRegTheatre = 'select count(*) regTheatre  from merchant where storetype = \'Theatre\' ';
		$resRegTheatre = Yii::$app->db->createCommand($sqlRegTheatre)->queryOne();
		
		$regTheatre = $resRegTheatre['regTheatre'] ?? 0;
		
		$sqlLocation = 'select DISTINCT(location) as location from merchant';
		$resLocation = Yii::$app->db->createCommand($sqlLocation)->queryAll();
		
		$sqlOrderStatusCount =' select count(orderprocess) cnt,orderprocess from orders where date(reg_date) = \''.$date.'\' 
		 group by orderprocess';
		$orderStatusCount = Yii::$app->db->createCOmmand($sqlOrderStatusCount)->queryAll();
		$ordStatusCount = array_column($orderStatusCount,'cnt','orderprocess');
		$year = date('Y').'-01-01';
		$sqlSales = 'SELECT MONTHNAME(reg_date) label,round(sum(totalamount),2)  value FROM orders 
		where date(reg_date) >= \''.$year.'\' group by MONTH(reg_date)';
		$resSales = Yii::$app->db->createCommand($sqlSales)->queryAll();
		$yearStartDate = date('Y').'-01-01';
		//echo json_encode($resSales);exit;
		$sqlChart = 'select mon_name,coalesce(sale_amount,0) sale_amount from (
select 1 mon_num,\'Jan\' mon_name
UNION
select 2,\'Feb\'
    UNION
select 3,\'Mar\'
    UNION
select 4,\'Apr\'
    UNION
select 5,\'May\'
    UNION
select 6,\'Jun\'
    UNION
select 7,\'Jul\'
    UNION
select 8,\'Aug\'
    UNION
select 9,\'Sep\'
    UNION
select 10,\'Oct\'
    UNION
select 11,\'Nov\'
    UNION
select 12,\'Dec\'
    ) as A left join (

SELECT sum(totalamount) sale_amount,month(reg_date) num_mon FROM orders where date(reg_date) between \''.$yearStartDate.'\' and \''.date('Y-m-d').'\'
group by month(reg_date)
        ) as B on A.mon_num = B.num_mon';
		$resChart = Yii::$app->db->createCommand($sqlChart)->queryAll();
		
	$str =	'<chart caption="Monthly Sale Value" subcaption="Current year" xaxisname="Month" yaxisname="Earnings" theme="fusion">';
    for($i=0;$i<count($resChart);$i++){
	$str.='<set label="'.$resChart[$i]['mon_name'].'" value="'.$resChart[$i]['sale_amount'].'"  tooltext="'.$resChart[$i]['mon_name'].' Month  Earnings is ??? '.round($resChart[$i]['sale_amount'],2).' "/>';	
	}
$str.='</chart>';
		
		return $this->render('dashboard',['userCount'=>$userCount,'regResturant'=>$regResturant
		,'regTheatre'=>$regTheatre,'resLocation'=>$resLocation,'ordStatusCount'=>$ordStatusCount
		,'resSales'=>json_encode($resSales),'str'=>$str]);
	}
    public function actionMerchantview()
	{
		return $this->render('merchantview');
	}
	public function actionOrders()
	{
		extract($_POST);
		$sdate = $_POST['sdate'] ?? date('Y-m-d'); 
		$edate = $_POST['edate'] ?? date('Y-m-d');

		$orderprocess = $_REQUEST['orderprocess'] ?? null;
		$sqlOrders = 'select * from orders where date(reg_date) between \''.$sdate.'\' and \''.$edate.'\' ';
		if(!empty($orderprocess)) { 
		$sqlOrders .=' and orderprocess = \''.$orderprocess.'\' ';
		}

		$sqlOrders .=' order by ID desc';
		$orderModel = Yii::$app->db->createCOmmand($sqlOrders)->queryAll();
		

		return $this->render('orders',['orderModel'=>$orderModel,'dumorderModel'=>$orderModel,'sdate'=>$sdate,'edate'=>$edate,'orderprocess'=>$orderprocess]);
	}	
	public function actionTablebill()
	{
		extract($_POST);
		$orderDet = \app\models\Orders::findOne($id);
		$tableDet = \app\models\Tablename::findOne($orderDet['tablename']);
		$orderProdDet = \app\models\OrderProducts::find()->where(['order_id'=>$orderDet['ID']])->asArray()->all();
		return $this->render('tablebill',['tableDet'=>$tableDet,'orderDet'=>$orderDet,'orderProdDet'=>$orderProdDet]);
	}
	 public function actionPilot()
	{
		$pilotModel = \app\models\Serviceboy::find()
		
		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
		
        return $this->render('pilot',['pilotModel'=>$pilotModel]);
    }
	public function actionMerchantgrouping(){
		$sql = 'select * from merchant where owner_type =\'1\'';
		$res = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $this->render('merchantgrouping',['res'=>$res]);
	}
	public function actionEditgroupingpopup()
    {
	extract($_POST);
	$sqlcoowner = 'select * from merchant m where owner_type = \'2\' and id not in (select child_id from merchant_group where status = \'1\')';
	$rescoowner = Yii::$app->db->createCommand($sqlcoowner)->queryAll();
	$sqlgroup = 'select mg.ID,storename,child_id from merchant m inner join merchant_group mg on mg.child_id = m.id and parent_id = \''.$id.'\'';
	$group = Yii::$app->db->createCommand($sqlgroup)->queryAll();
	
	return $this->renderAjax('updategroup', ['rescoowner' => $rescoowner,'group' => $group,'id'=>$id]);		
    }
	public function actionUpdategroup(){
		extract($_POST);
		
		
		if(isset($group) )
		{
			
			$deleteSql = 'delete  from merchant_group where parent_id = \''.$update_merchant_id.'\'';
		$resDelete = Yii::$app->db->createCommand($deleteSql)->execute();
				for($i=0;$i<count($group);$i++){
					$merchantGroups[$i]['parent_id'] = $update_merchant_id ;
					$merchantGroups[$i]['child_id'] = $group[$i] ;
					$merchantGroups[$i]['status'] = '1' ;
					$merchantGroups[$i]['reg_date'] = date('Y-m-d h:i:s') ;
				}
					Yii::$app->db
			->createCommand()
			->batchInsert('merchant_group', ['parent_id','child_id','status','reg_date'],$merchantGroups)
			->execute();
		}
		return $this->redirect('merchantgrouping');
	}
	public function actionDeletegroupmerchant()
	{
		extract($_POST);
		$deleteSql = 'delete  from merchant_group where ID = \''.$id.'\'';
		$resDelete = Yii::$app->db->createCommand($deleteSql)->execute();
		
	}
	public function actionDeletedempoyee()
	{
		extract($_POST);
		$deleteSql = 'select * from merchant_employee me inner join merchant m on m.ID = me.merchant_id where emp_status = \'17\'';
		$resDelete = Yii::$app->db->createCommand($deleteSql)->queryAll();
		return $this->render('deletedemployee',['usersModel'=>$resDelete]);
	}
	public function actionDeletedvendor()
	{
		extract($_POST);
		$deleteSql = 'select * from merchant_vendor me inner join merchant m on m.ID = me.merchant_id where me.status = \'17\'';
		$resDelete = Yii::$app->db->createCommand($deleteSql)->queryAll();
		return $this->render('deletedvendor',['usersModel'=>$resDelete]);
	}
	public function actionContest()
	{
		extract($_POST);
		$model = new \app\models\Contest;
		$sql = 'SELECT * FROM contest ';
		$res = Yii::$app->db->createCommand($sql)->queryAll();
			

		if ($model->load(Yii::$app->request->post()) ) {
		$model->contest_id = Utility::get_uniqueid('contest','CNTST');
		$model->created_on = date('Y-m-d');
		$model->created_by = (string)Yii::$app->user->identity->ID;
		if(!empty($_POST['Contest']['contest_participants'])){
		$model->contest_participants = implode(',',$_POST['Contest']['contest_participants']);	
		}
		
		$contestimage = UploadedFile::getInstance($model, 'contest_image');
			
			if($contestimage){
				$contestimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$contestimage->extension;
				$contestimage->saveAs('../../contestimages/' . $contestimagename);
				$model->contest_image = $contestimagename;

			}
		
		if($model->validate()){
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Contest',
		'text' => 'Contest Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			$model->save();

		return	$this->redirect('contest');
		}
		else
		{
			echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		$sqlLocation = 'select distinct location as location from merchant ';
		$resLocation = Yii::$app->db->createCommand($sqlLocation)->queryAll();
		
		return $this->render('contest',['model'=>$model,'contest'=>$res,'resLocation'=>$resLocation]);
	}
	public function actionEditcontestpopup()
	{
		extract($_POST);
		$contestModel = \app\models\Contest::findOne($id);
		return $this->renderAjax('editcontestpopup', ['model' => $contestModel,'id'=>$id]);
	}
		public function actionEditcontestparticpants()
	{
		extract($_POST);
		$contestModel = \app\models\Contest::findOne($id);
		$particpantsArr =	'select storename from merchant ';
		if(!empty($contestModel['contest_participants'])){
			$merchantIdIn = str_replace(",","','",$contestModel['contest_participants']);
		$particpantsArr .=	' where ID in (\''.$merchantIdIn.'\')';
		}

		$res = Yii::$app->db->createCommand($particpantsArr)->queryAll();
		
		return json_encode(($res));
	}
	public function actionUpdatecontest()
	{
		extract($_POST);
		$model = new \app\models\Contest;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$merchantPaymentArr = Yii::$app->request->post('Contest');
		$merchantPaymentUpdate = \app\models\Contest::findOne($_POST['Contest']['ID']);

		$merchantPaymentUpdate->attributes = \Yii::$app->request->post('Contest');
			
			 
		if($merchantPaymentUpdate->validate()){
			$merchantPaymentUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Contest',
		'text' => 'Contest Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('contest');
	}
	public function actionOrderstatuschange()
	{
		extract($_POST);
		$orderDet = \app\models\Orders::findOne($id);
		$tableUpdate = \app\models\Tablename::findOne($orderDet['tablename']);
		if(!empty($tableUpdate))
		{
			$table_status = null;
			$current_order_id = 0;
			$tableUpdate->table_status = $table_status;
			$tableUpdate->current_order_id = $current_order_id;
			$tableUpdate->save();
		}
		$orderDet->orderprocess = $orderprocess;
		$orderDet->save();
	}
	public function actionStoretypes()
	{
		$model = new \app\models\Storetypes;
		$sqlstoretype = 'select * from storetypes';
		$storetype = Yii::$app->db->createCommand($sqlstoretype)->queryAll();
	
		if ($model->load(Yii::$app->request->post()) ) {
		$model->type_status = 1;
		$model->reg_date = date('Y-m-d h:i:s A');
		if($model->validate()){
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Store Type',
		'text' => 'Store Type Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			$model->save();

		return	$this->redirect('storetypes');
		}
		else
		{
			echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		return $this->render('storetypes',['model'=>$model,'storetype'=>$storetype]);
	}
	public function actionUpdatestoretype()
	{
		extract($_POST);
		$storeModel = \app\models\Storetypes::findOne($id);
		return $this->renderAjax('editstoretypepopup', ['model' => $storeModel,'id'=>$id]);

	}
	public function actionEditstoretype()
	{
		extract($_POST);
		$model = new \app\models\Storetypes;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$merchantPaymentArr = Yii::$app->request->post('Storetypes');
		$merchantPaymentUpdate = \app\models\Storetypes::findOne($_POST['Storetypes']['ID']);

		$merchantPaymentUpdate->attributes = \Yii::$app->request->post('Storetypes');
			
			 
		if($merchantPaymentUpdate->validate()){
			$merchantPaymentUpdate->save();
		}
		else{
		echo "<pre>";	print_r($merchantPaymentUpdate->getErrors());exit;
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Store Types',
		'text' => 'Store Types Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('storetypes');
	}
	public function actionPermissions(){
        	$storetypes = \app\models\Storetypes::find()
		->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
        return $this->render('permissions', ['storetypes'=>$storetypes]);
    }
    public function actionAssignpermission()
    {
    extract($_POST);    
        $sql = 'SELECT * FROM tab_permissions where process_status=\'1\'';
        $permissions = Yii::$app->db->createCommand($sql)->queryAll();
        
        $storetype = \app\models\Storetypes::findOne($id);
		
		
		$sqlpermission = 'select distinct permission_id display_id from  tab_permissions mp left join storetype_permissions mprm 
		on mp.ID = mprm.permission_id
		where mprm.store_type = \''.$id.'\' and permission_status = \'1\'';
		$respermission = Yii::$app->db->createCommand($sqlpermission)->queryAll();
		$rolePermissionArray = array();
		$rolePermissionArray = (array_column($respermission,'display_id'));
		

        return $this->render('permissionview', ['permissions'=>$permissions,'storetype' => $storetype,'rolePermissionArray'=>$rolePermissionArray]);
    }
    public function actionSaverolepermissions()
	{
		extract($_POST);
		$sqlPermissionCheck = 'select permission_status,sp.ID from tab_permissions tp 
		INNER JOIN storetype_permissions sp 
		on tp.ID = sp.permission_id
		where  sp.store_type  = \''.$storeid.'\' 
		and sp.permission_id = \''.$main_pernission_id.'\'';
		$resPermissionCheck = Yii::$app->db->createCommand($sqlPermissionCheck)->queryAll();
		

		
		if(count($resPermissionCheck) == 0)
		{

		$sqlPermissionIds = 'select ID from tab_permissions 
		where ID = \''.$main_pernission_id.'\'';
		$resPermissionIds = Yii::$app->db->createCommand($sqlPermissionIds)->queryAll();
		
			for($i=0;$i<count($resPermissionIds);$i++)
			{
				$data[] = [$storeid,$resPermissionIds[$i]['ID'],1,date('Y-m-d H:i:s'),'admin',date('Y-m-d H:i:s'),'admin'];
			}
			Yii::$app->db
			->createCommand()
			->batchInsert('storetype_permissions', ['store_type','permission_id', 'permission_status','created_on','created_by','updated_on','updated_by'],$data)
			->execute();
		}
		else{

			if($resPermissionCheck[0]['permission_status'] == '1'){
				$permissionStatus = '0';
			}
			else{
				$permissionStatus = '1';
			}
			$idString = implode("','",(array_column($resPermissionCheck,'ID')));
			$sqlUpdate = 'update storetype_permissions set permission_status = \''.$permissionStatus.'\' 
			where store_type = \''.$storeid.'\'  AND ID IN ( \''.$idString.'\')';
			$resUpdate = Yii::$app->db->createCommand($sqlUpdate)->execute();
		}
		
		return 1;
	}
	public function actionMerchantInfo(){
	    extract($_REQUEST);
	    
	    $sqlMerchant = 'select * from merchant_info mi where mi.merchant_id = \''.$merchantId.'\'';
	    $resMerchant = Yii::$app->db->createCommand($sqlMerchant)->queryAll();
	    
	    return $this->render('merchantInfo',['merchantId' => $merchantId, 'resMerchant' => $resMerchant]);
	}
	
	public function actionSaveMerchantInfo(){
	    extract($_POST);
	    if(!empty($info))
	    {
	        for($i=0;$i < count($info); $i++)
	        {
    	        $model = new \app\models\MerchantInfo;
        	    $model->merchant_id = $merchantId;
        	    $model->merchant_description = $info[$i];
        	    $model->reg_date = date('Y-m-d H:i:s A');
        	    $model->save();
	        }
    	        
	    }
	    
	    return $this->redirect(['admin/merchant-info', 'merchantId' => $merchantId]);
	}
	
	public function actionMerchantAmenities()
	{
	    extract($_REQUEST);
	    $sqlMerchant = 'select * from merchant_amenities ma where ma.merchant_id = \''.$merchantId.'\'';
	    $resMerchant = Yii::$app->db->createCommand($sqlMerchant)->queryAll();
	    
	    $resMerchantAmenity = array_column($resMerchant,'status','amenity_id');
	    $resMerchantVisibilityAmenity = array_column($resMerchant,'amenity_visibility','amenity_id');
	    
	    return $this->render('merchantAmenity',['merchantId' => $merchantId, 'resMerchant' => $resMerchant
	                   , 'resMerchantAmenity' => $resMerchantAmenity, 'resMerchantVisibilityAmenity' => $resMerchantVisibilityAmenity]);
	}
	
	public function actionChangeAmenityStatus()
	{
	    extract($_POST);
	    $amenityDetails = \app\models\MerchantAmenities::find()->where(['merchant_id' => $merchantId, 'amenity_id' => $id])->asArray()->one();
	    if(!empty($amenityDetails)){
	        $modelUpdate = \app\models\MerchantAmenities::findOne($amenityDetails['ID']);
	        if($modelUpdate->status == 1){
	            $status = 2;
	        }
	        else{
	            $status = 1;
	        }
	        $modelUpdate->status = $status;
	        $modelUpdate->save();
	        
	    }
	    else{
	        $model = new \app\models\MerchantAmenities;
	        $model->merchant_id = $merchantId;
	        $model->amenity_id = $id;
	        $model->status = 1;
	        $model->amenity_visibility = 1;
	        $model->reg_date = date('Y-m-d H:i:s A');
	        $model->save();
	        
	    }
        return json_encode("1");
	}
	
	public function actionChangeAmenityVisibilityStatus()
	{
	    extract($_POST);
	    $amenityDetails = \app\models\MerchantAmenities::find()->where(['merchant_id' => $merchantId, 'amenity_id' => $id])->asArray()->one();
	    if(!empty($amenityDetails)){
	    
	        $modelUpdate = \app\models\MerchantAmenities::findOne($amenityDetails['ID']);
	        if($modelUpdate->amenity_visibility == 1){
	            $status = 2;
	        }
	        else{
	            $status = 1;
	        }
	        $modelUpdate->amenity_visibility = $status;
	        $modelUpdate->save();
	        $payload = ['status' => 1,'msg' => 'Amenity Visibility updated successfully' ];    
	    }
	    else{
	        $payload = ['status' => 2,'msg' => 'Please Add Amenity First!!' ];
	    }
	    
	    
	    return json_encode($payload);
	}

	public function actionPartnerWithUs()
	{
		$sql = 'select * from partner_with_us order by id desc';
		$res = Yii::$app->db->createCommand($sql)->queryAll();

		return $this->render('partner-with-us', ['res' => $res]);
	}

	public function actionArticles()
	{

		$sdate = isset($_POST['sdate']) ? $_POST['sdate'] : date('Y-m-d'); 
		$edate = isset($_POST['sdate']) ? $_POST['edate'] : date('Y-m-d');
		
		$sqlArticles = 'select * from articles where date(reg_date) between \''.$sdate.'\' and \''.$edate.'\' ';
		$articles = Yii::$app->db->createCommand($sqlArticles)->queryAll();

		$model = new Articles;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->status = 1;
            $model->reg_date = date('Y-m-d H:i:s A');
            $model->created_by = Yii::$app->user->identity->ID;
            $model->updated_by = Yii::$app->user->identity->ID;
            $model->updated_on = date('Y-m-d H:i:s A');

			$image = UploadedFile::getInstance($model, 'image');

			if($image){
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$path = '../../merchant_images/articles/';
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}
				$image->saveAs($path.$imagename);
				$model->image = $imagename;

			}
            if($model->validate()){
                $model->save();
                Yii::$app->getSession()->setFlash('success', [
                    'title' => 'Artcile',
                    'text' => 'Artcile Added Successfully',
                    'type' => 'success',
                    'timer' => 3000,
                    'showConfirmButton' => false
                ]);
                return $this->redirect('articles');
            }
            else
            {
                echo "<pre>";print_r($model->getErrors());exit;
            }
        }

        return $this->render("articles",['articles' => $articles,'model' => $model, 'sdate' => $sdate, 'edate' => $edate]);
	}

	public function actionDeleteArticle()
	{
		$articlesDelete = Articles::findOne($_POST['id']);
		$imagePath =  '../merchant_images/articles/'. $articlesDelete['image'];
		if(file_exists($imagePath)){
			unlink($imagePath);	
		}
		$articlesDelete->delete();
		return 1;
	}

	public function actionEditArticlePopup()
    {
        extract($_POST);
        $printerModel = Articles::findOne($id);
        return $this->renderAjax('editarticlepopup', ['model' => $printerModel,'id'=>$id]);
    }
    public function actionEditArticle()
    {
        $model = new Articles;
        //$model->scenario = 'updateprinter';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $articleArr = Yii::$app->request->post('Articles');
        $articleUpdate = Articles::findOne($_POST['Articles']['ID']);
		$oldArticleImage = $articleUpdate['image']; 
        $articleUpdate->attributes = \Yii::$app->request->post('Articles');
		$image = UploadedFile::getInstance($model, 'image');
		if($image){
			if(!empty($oldArticleImage)){
				$imagePath =  '../../merchant_images/articles/'. $oldArticleImage;
				if(file_exists($imagePath)){
					unlink($imagePath);	
				}
			}
		}
		$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
		$image->saveAs('../../merchant_images/articles/' . $imagename);
		$articleUpdate->image = $imagename;

        if($articleUpdate->validate()){
            $articleUpdate->save();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Article',
                'text' => 'Article Edited Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
        }
        return $this->redirect('articles');

    }

	public function actionFoodShorts()
	{
		$model = new FoodShorts;

		$sdate = isset($_POST['sdate']) ? $_POST['sdate'] : date('Y-m-d'); 
		$edate = isset($_POST['sdate']) ? $_POST['edate'] : date('Y-m-d');
		
		$sqlFoodShorts = 'select * from food_shorts where date(reg_date) between \''.$sdate.'\' and \''.$edate.'\' ';
		$foodShorts = Yii::$app->db->createCommand($sqlFoodShorts)->queryAll();

		if ($model->load(Yii::$app->request->post()) ) {
            $model->status = 1;
            $model->reg_date = date('Y-m-d H:i:s A');
            $model->created_by = Yii::$app->user->identity->ID;
            $model->updated_by = Yii::$app->user->identity->ID;
            $model->updated_on = date('Y-m-d H:i:s A');

			
            if($model->validate()){
                $model->save();

				$foodShortId =  $model->getPrimaryKey();	
				
				$imageArray = $_FILES['image']['name'];
				if(!empty($imageArray))
				{

					for($i=0;$i<count($imageArray);$i++)
					{
						$tmp_name = $_FILES['image']['tmp_name'][$i];
						$pic_extension = pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION);

						$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$pic_extension;
						$path = '../../merchant_images/food_shorts/';
						if (!is_dir($path)) {
							mkdir($path, 0777, true);
						}
						move_uploaded_file($tmp_name,$path.'/'.$imagename);
						
						$data[] = [$foodShortId,$imagename];
						
					}

					if(!empty($data)) {
						Yii::$app->db
						->createCommand()
						->batchInsert('food_shorts_images', ['food_short_id','image'],$data)
						->execute();
					}
				}

                Yii::$app->getSession()->setFlash('success', [
                    'title' => 'Food Shorts',
                    'text' => 'Food Short Added Successfully',
                    'type' => 'success',
                    'timer' => 3000,
                    'showConfirmButton' => false
                ]);
                return $this->redirect('food-shorts');
            }
            else
            {
                echo "<pre>";print_r($model->getErrors());exit;
            }
        }
        return $this->render("food-shorts",['foodShorts' => $foodShorts,'model' => $model, 'sdate' => $sdate, 'edate' => $edate]);


	}

	public function actionDeleteFoodShort()
	{
		$foodShort = FoodShorts::findOne($_POST['id']);
		if(!empty($foodShort)) {
			$sql = 'select * from food_shorts_images where food_short_id = \''.$_POST['id'].'\'' ;
			$foodShortImagesDetail = Yii::$app->db->createCommand($sql)->queryAll();
	
			for($i=0; $i < count($foodShortImagesDetail); $i++) {
				$imagePath =  '../../merchant_images/food_shorts/'. $foodShortImagesDetail[$i]['image'];
				if(file_exists($imagePath)){
					unlink($imagePath);	
				}
				$foodShortImage = FoodShortsImages::findOne($foodShortImagesDetail[$i]['ID']);
				$foodShortImage->delete();
			}
	
			
			$foodShort->delete();
	
		}			
		
		return 1;
	}
	public function actionEditFoodShortPopup()
    {
        extract($_POST);
        $foodShortsModel = FoodShorts::findOne($id);
		$imagesModel = FoodShortsImages::find()->where(['food_short_id' => $id])->asArray()->all();
        return $this->renderAjax('editfoodshortspopup', ['model' => $foodShortsModel,'id'=>$id,'imagesModel' => $imagesModel]);
    }

	public function actionEditFoodShort()
	{
		$model = new FoodShorts;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $foodShortsArr = Yii::$app->request->post('FoodShorts');
        $foodShortsUpdate = FoodShorts::findOne($_POST['FoodShorts']['ID']);
		 
        $foodShortsUpdate->attributes = \Yii::$app->request->post('FoodShorts');
		
        if($foodShortsUpdate->validate()){
            $foodShortsUpdate->save();

			$imageArray = $_FILES['updateImage']['name'];
				if(!empty($imageArray))
				{

					for($i=0;$i<count($imageArray);$i++)
					{
						$tmp_name = $_FILES['updateImage']['tmp_name'][$i];
						$pic_extension = pathinfo($_FILES['updateImage']['name'][$i], PATHINFO_EXTENSION);

						$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$pic_extension;
						$path = '../../merchant_images/food_shorts/';
						if (!is_dir($path)) {
							mkdir($path, 0777, true);
						}
						move_uploaded_file($tmp_name,$path.'/'.$imagename);
						
						$data[] = [$_POST['FoodShorts']['ID'],$imagename];
						
					}

					if(!empty($data)) {
						Yii::$app->db
						->createCommand()
						->batchInsert('food_shorts_images', ['food_short_id','image'],$data)
						->execute();
					}
				}

            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Food Shorts',
                'text' => 'Food Shorts Edited Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
        }
        return $this->redirect('food-shorts');

	}

	public function actionClients()
	{
		$model = new Client;

		$sdate = isset($_POST['sdate']) ? $_POST['sdate'] : date('Y-m-d'); 
		$edate = isset($_POST['sdate']) ? $_POST['edate'] : date('Y-m-d');
		
		$sqlClients = 'select c.*,m.storename from client c inner join merchant m on c.merchant_id = m.ID where date(c.reg_date) between \''.$sdate.'\' and \''.$edate.'\' ';
		$clients = Yii::$app->db->createCommand($sqlClients)->queryAll();

		if ($model->load(Yii::$app->request->post()) ) {
            $model->reg_date = date('Y-m-d H:i:s A');
            $model->created_by = Yii::$app->user->identity->ID;
            $model->updated_by = Yii::$app->user->identity->ID;
            $model->updated_on = date('Y-m-d H:i:s A');

			
            if($model->validate()){
                $model->save();

				
                Yii::$app->getSession()->setFlash('success', [
                    'title' => 'Clients',
                    'text' => 'Client Added Successfully',
                    'type' => 'success',
                    'timer' => 3000,
                    'showConfirmButton' => false
                ]);
                return $this->redirect('clients');
            }
            else
            {
                echo "<pre>";print_r($model->getErrors());exit;
            }
        }
        return $this->render("client",['clients' => $clients,'model' => $model, 'sdate' => $sdate, 'edate' => $edate]);
	
	}

	public function actionDeleteClient()
	{
		$client = Client::findOne($_POST['id']);

		if(!empty($client)) {
			$client->delete();
		}			
		
		return 1;
	}

	public function actionEditClientPopup()
    {
        extract($_POST);
        $client = Client::findOne($id);
        return $this->renderAjax('editclientpopup', ['model' => $client,'id'=>$id]);
    }
	public function actionEditClient()
	{
		$model = new Client;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $clientArr = Yii::$app->request->post('Client');
        $clientUpdate = Client::findOne($_POST['Client']['ID']);
		 
        $clientUpdate->attributes = \Yii::$app->request->post('Client');
		
        if($clientUpdate->validate()){
            $clientUpdate->save();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Clients',
                'text' => 'Client Edited Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
        }

        return $this->redirect('clients');
	}

	public function actionPilotDemoRequests()
	{
		$sql = 'select * from pilot_demo_requests order by ID desc';
		$res = Yii::$app->db->createCommand($sql)->queryAll();

		return $this->render('pilot_demo_requests', ['res' => $res]);
	}

	public function actionDeleteFoodShortImage() 
	{
		extract($_POST);
		$model = FoodShortsImages::findOne($id);
		$imagePath =  '../../'.Url::to(['../../merchant_images/food_shorts/'. $image]);
		if(file_exists($imagePath)){
			unlink($imagePath);	
		}
		$model->delete();
		return $id;
	}

	
}

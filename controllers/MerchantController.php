<?php
namespace app\controllers;
use yii;
use yii\helpers\Url;
use \app\models\Product;
use \app\models\Orders;
use \app\models\FoodCategeries;
use \app\models\Tablename;
use \app\models\Serviceboy;
use \app\models\MerchantCoupon;
use app\helpers\Utility;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use \app\models\MerchantGallery;
use \app\models\Ingredients;
use \app\models\MerchantRecipe;
use yii\db\Query;
class MerchantController extends GoController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionProductList(){
	$merchantId = Yii::$app->user->identity->ID;
	$productModel = Product::find()
        ->where(['merchant_id' => $merchantId])
	->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
	$model = new Product;
	if ($model->load(Yii::$app->request->post()) ) {
		$productArr = Yii::$app->request->post('Product');
		$model->merchant_id = (string)Yii::$app->user->identity->ID;
		$model->unique_id = Utility::get_uniqueid('product','PR');
		$model->slug = $productArr['title'];
		$model->availabilty = '1';
		$model->status = '1';
		$model->reg_date = date('Y-m-d h:i:s');
		$model->mod_date = date('Y-m-d h:i:s');
		$image = UploadedFile::getInstance($model, 'image');
		if($image){
			$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
			$image->saveAs('uploads/productimages/' . $imagename);
			$model->image = $imagename;
		}
		if($model->validate()){
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Product',
		'text' => 'Product Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			$model->save();

		return	$this->redirect('product-list');
		}
		else
		{
		//	echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		
        return $this->render('productlist',['productModel'=>$productModel,'model'=>$model]);
    }
	public function actionEditproductpopup()
	{
		extract($_POST);
		$productModel = Product::findOne($id);
		return $this->renderAjax('editproductpopup', ['model' => $productModel,'id'=>$id]);		
    
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
	if($tablename == 'product')
	{
		$details = Product::findOne($tableid);	
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'serviceboy')
	{
		$details = Serviceboy::findOne($tableid);
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'ingredients')
	{
		$details = \app\models\Ingredients::findOne($tableid);
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'tablename')
	{
		$details = Tablename::findOne($tableid);
	if($details['status']=='1'){
				$status ='0';
		}else{
				$status = '1';
		}
	}
	else if($tablename == 'gallery')
	{
		$details = \app\models\MerchantGallery::findOne($tableid);
	if($details['status']=='1'){
				$status =0;
		}else{
				$status = 1;
		}
	}
	
	else if($tablename == 'merchant_coupon')
	{
		$details = MerchantCoupon::findOne($tableid);

		if($details['status']=='Active'){
				$status ='Deactive';
		}else{
				$status = 'Active';
		}
	}

	$details->status = $status;
	if($details->save()){
		print_r($details->getErrors());exit;
	}
	

    }
    public function actionFoodCategeries(){
		extract($_POST);

		
	$allcategeries = FoodCategeries::allcategeries();
	
	$sqlcategorytypes = 'select * from food_categeries fc left join food_category_types fct on fc.id = fct.food_cat_id 
	and fc.merchant_id = \''.Yii::$app->user->identity->ID.'\'';
	$rescategorytypes = Yii::$app->db->createCommand($sqlcategorytypes)->queryAll();
	$foodcatgerymodel = new FoodCategeries;
	if (!empty($food_category)){
		$foodcatgerymodel['food_category'] = $food_category; 
		$foodcatgerymodel['merchant_id'] = (string)Yii::$app->user->identity->ID;
		$foodcatgerymodel['reg_date'] = date('Y-m-d h:i:s A');
		$foodcatgerymodel->save();
		$food_cat_id =  $foodcatgerymodel->getPrimaryKey();
		$catTypeArray = array_filter($categorytypes);
	    if(!empty($catTypeArray))
	    {
			for($i=0;$i<count($catTypeArray);$i++)
			{
				$data[] = [$food_cat_id,$catTypeArray[$i],(string)Yii::$app->user->identity->ID,date('Y-m-d h:i:s A')];
			}
			Yii::$app->db
			->createCommand()
			->batchInsert('food_category_types', ['food_cat_id','food_type_name','merchant_id', 'reg_date'],$data)
			->execute();	
			
	    }
	  Yii::$app->getSession()->setFlash('success', [
        'title' => 'Food Category',
		'text' => 'Food Category Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);

	return $this->redirect('food-categeries');
	
	}
	return $this->render('foodcategeries',['allcategeries'=>$allcategeries,'foodcatgerymodel'=>$foodcatgerymodel,'categorytypes'=>$rescategorytypes]);
    }
    public function actionEditcategorypopup()
    {
	extract($_POST);
	$categeryModel = FoodCategeries::findOne($id);
	$sqlcategorytypes = 'select fc.ID,fc.food_category,fct.food_type_name,fct.ID fcid  from food_categeries fc left join food_category_types fct on fc.id = fct.food_cat_id 
	where fc.merchant_id = \''.Yii::$app->user->identity->ID.'\' and fc.ID = \''.$id.'\'';
	$categorytypes = Yii::$app->db->createCommand($sqlcategorytypes)->queryAll();
	
	return $this->renderAjax('updatecategery', ['categorytypes' => $categorytypes,'id'=>$id]);		
    }
    public function actionUpdatefoodcategery()
    {
		extract($_POST);

	$foodCategoryUpdate = \app\models\FoodCategeries::findOne($_POST['update_food_id']);
	$foodCateQtys =  \app\models\FoodCategoryTypes::find()->where(['food_cat_id'=>$foodCategoryUpdate['ID']])->asArray()->all();

	if(trim($foodCategoryUpdate['food_category']) != trim($_POST['update_food_category']))
	{
		$foodCategoryUpdate->food_category = trim($_POST['update_food_category']);
		$foodCategoryUpdate->save();	
		

		
	}
	if(count($foodCateQtys) > 0)
	{
			for($i=0;$i<count($foodCateQtys);$i++)
			{
				if($_POST['categorytypes_'.$foodCateQtys[$i]['ID']] != $foodCateQtys[$i]['food_type_name'] )
				{
						$foodcategorytypes = \app\models\FoodCategoryTypes::findOne($foodCateQtys[$i]['ID']);
						$foodcategorytypes->merchant_id = (string)Yii::$app->user->identity->ID;
						$foodcategorytypes->food_type_name = $_POST['categorytypes_'.$foodCateQtys[$i]['ID']];
						$foodcategorytypes->save();
				}
			}
	}
	$catTypeArray = array_filter($categorytypes);
	if(!empty($catTypeArray))
	{
			for($i=0;$i<count($catTypeArray);$i++)
			{
				$data[] = [$_POST['update_food_id'],$catTypeArray[$i],(string)Yii::$app->user->identity->ID,date('Y-m-d h:i:s A')];
			}
			Yii::$app->db
			->createCommand()
			->batchInsert('food_category_types', ['food_cat_id','food_type_name','merchant_id', 'reg_date'],$data)
			->execute();
	}

  Yii::$app->getSession()->setFlash('success', [
        'title' => 'Food Category',
		'text' => 'Food Category Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
	return $this->redirect('food-categeries');		
    }
	public function actionManagetable()
	{
		$model = new Tablename;
		$tableDet = Tablename::find()->where(['merchant_id'=>Yii::$app->user->identity->ID])->asArray()->all();
		$merchantdetails = \app\models\Merchant::findOne(Yii::$app->user->identity->ID);
		if ($model->load(Yii::$app->request->post()) ) {
		$tableArr = Yii::$app->request->post('Tablename');
		$model->merchant_id = (string)Yii::$app->user->identity->ID;
		$model->status = '1';
		$model->reg_date = date('Y-m-d h:i:s');
		
		if($model->validate()){
			$model->save();
				Yii::$app->getSession()->setFlash('success', [
        'title' => 'Table',
		'text' => 'Table Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
			return $this->redirect('managetable');
		}
		else
		{
		//	echo "<pre>";print_r($model->getErrors());exit;
		}
	}
		return $this->render('managetable',['model'=>$model,'tableDet'=>$tableDet,'merchantdetails'=>$merchantdetails]);
	}
	public function actionEdittablepopup()
	{
		extract($_POST);
		$tableModel = Tablename::findOne($id);
		return $this->renderAjax('edittablepopup', ['model' => $tableModel,'id'=>$id]);		
	}
	public function actionEdittable()
	{
		$model = new Tablename;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$tableNameArr = Yii::$app->request->post('Tablename');
		$tableNameUpdate = Tablename::findOne($_POST['Tablename']['ID']);
		
		$tableNameUpdate->attributes = \Yii::$app->request->post('Tablename');
		
		if($tableNameUpdate->validate()){
			$tableNameUpdate->save();
			Yii::$app->getSession()->setFlash('success', [
        'title' => 'Table',
		'text' => 'Table Edited Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		}
			return $this->redirect('managetable');
	
	}
	public function actionQuantitylist($id = '')
    {				
		extract($_REQUEST);
        $foodCatTypes = \app\models\FoodCategoryTypes::find()
				->where(['food_cat_id' => $id])
				->all();

		if (!empty($foodCatTypes)) {
						echo "<option value=''>Select</option>"; 

			foreach($foodCatTypes as $foodCatTypes) {
			echo "<option value='".$foodCatTypes->ID."'>".$foodCatTypes->food_type_name."</option>";
			}
		} else {
			echo "<option>-</option>";
		}
		
    }
	public function actionUpdateproduct()
	{
		extract($_POST);
		
		$model = new Product;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$productArr = Yii::$app->request->post('Product');
		$productUpdate = Product::findOne($_POST['Product']['ID']);
		
		$productUpdate->attributes = \Yii::$app->request->post('Product');
		$image = UploadedFile::getInstance($model, 'image');
			if($image){
				if(!empty($productUpdate['image'])){
					$imagePath =  '../../'.Url::to(['/uploads/productimages/'. $productUpdate['image']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$image->saveAs('uploads/productimages/' . $imagename);
				$productUpdate->image = $imagename;
			}
		if($productUpdate->validate()){
			$productUpdate->save();
		}
		Yii::$app->getSession()->setFlash('success', [
        'title' => 'Product',
		'text' => 'Product Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		return $this->redirect('product-list');
	}
	public function actionPlaceorder()
	{
		extract($_POST);
		//echo "<pre>";print_r($_POST);exit;
		//$productDetails = Product::find()->where(['merchant_id'=>Yii::$app->user->identity->ID])->asArray()->all();
		$sqlproductDetails = 'select P.ID,P.title,P.food_category_quantity,P.price,P.image 
		,case when food_type_name is not null then concat(title ,\' (\' , food_type_name , \')\') else title end  title_quantity  
		from product P left join food_category_types fct on fct.ID =  P.food_category_quantity and fct.merchant_id =  \''.Yii::$app->user->identity->ID.'\'
		where P.merchant_id = \''.Yii::$app->user->identity->ID.'\'';
			$productDetails = Yii::$app->db->createCommand($sqlproductDetails)->queryAll();
		$mainProducts = array_column($productDetails,'ID','title');
		$mainProductsName = array_column($productDetails,'title_quantity','ID');
		
		$mainArr = [];
		$priceArr = [];
		$imgArr = [];$idArr=[];
		for($i=0;$i<count($productDetails);$i++)
		{
				$mainArr[$productDetails[$i]['title']][$i] = $productDetails[$i]; 
				$priceArr[$productDetails[$i]['title'].'_'.$productDetails[$i]['food_category_quantity']] = $productDetails[$i]['price'];
				$imgArr[$mainProducts[$productDetails[$i]['title']]] = $productDetails[$i]['image'];
				$idArr[$productDetails[$i]['title'].'_'.$productDetails[$i]['food_category_quantity']] = $productDetails[$i]['ID'];
		}
		

		$food_cat_qty_arr = \app\models\FoodCategoryTypes::find()->where(['merchant_id'=>Yii::$app->user->identity->ID])->asArray()->All();
		$food_cat_qty_det = array_column($food_cat_qty_arr,'food_type_name','ID');
		$prevOrderDetails = [];
		$prevFullSingleOrderDet = [];
		if(!empty($current_order_id))
		{
			$prevFullSingleOrderDet = \app\models\Orders::findOne($current_order_id);
			//$prevOrderDetails = \app\models\OrderProducts::find()->where(['order_id'=>$current_order_id])
			//->andWhere(['not in','count',['0']])
			//->asArray()->all();
			$sqlPrevOrderDetails = 'select op.ID,op.user_id,op.order_id,op.merchant_id,op.product_id,op.count,op.price,coalesce(op.count,0)*coalesce(op.price,0) 
			as totalprice,op.inc,op.reg_date,u.name,u.mobile from order_products op left join users u on op.user_id = u.ID 
			where order_id = \''.$current_order_id.'\' and count != \'0\'';
			$prevOrderDetails = Yii::$app->db->createCommand($sqlPrevOrderDetails)->queryAll();
		}
		else{
		  $prevFullSingleOrderDet['paymenttype'] = 'cash';	
		}
		//echo "<pre>";print_r($prevOrderDetails);exit;
		$sqlmerchantcoupon = 'SELECT  code from merchant_coupon where  merchant_id = \''.Yii::$app->user->identity->ID.'\'';
		$resmerchantcoupon = YIi::$app->db->createCommand($sqlmerchantcoupon)->queryAll();
		$merchantcoupons = array_column($resmerchantcoupon,'code');

		return $this->render('placeorder',['mainArr'=>$mainArr,'productDetails'=>$productDetails
		,'mainProducts'=>$mainProducts,'food_cat_qty_det'=>$food_cat_qty_det
		,'priceArr'=>$priceArr,'imgArr'=>$imgArr,'idArr'=>$idArr,'tableid'=>$tableid
		,'tableName'=>$tableName,'prevOrderDetails'=>$prevOrderDetails,'mainProductsName'=>$mainProductsName
		,'merchantcoupons'=>$merchantcoupons,'prevFullSingleOrderDet'=>$prevFullSingleOrderDet]);
	}
	public function actionTablebill()
	{
		extract($_POST);
		$orderDet = Orders::findOne($id);
		$tableDet = Tablename::findOne($orderDet['tablename']);
		$orderProdDet = \app\models\OrderProducts::find()->where(['order_id'=>$orderDet['ID']])->asArray()->all();
		return $this->render('tablebill',['tableDet'=>$tableDet,'orderDet'=>$orderDet,'orderProdDet'=>$orderProdDet]);
	}
	public function actionRating()
	{
		extract($_POST);
		$sdate = $_POST['sdate'] ?? date('Y-m-d'); 
		$edate = $_POST['edate'] ?? date('Y-m-d');
		//$sdate = '2020-02-03';
		
		$sqlRating = 'SELECT u.name as user_name,sb.name service_boy_name,f.order_id,totalamount,rating,message,f.reg_date
		FROM feedback f 
		left join orders o on f.order_id = o.ID
		left join serviceboy sb on o.serviceboy_id = sb.ID
		left join users u on f.user_id = u.ID
		where f.merchant_id = \''.Yii::$app->user->identity->ID.'\' 
		and DATE(f.reg_date) between \''.$sdate.'\' and \''.$edate.'\'';
		$rating = Yii::$app->db->createCommand($sqlRating)->queryAll();
		return $this->render('ratings',['rating'=>$rating,'sdate'=>$sdate,'edate'=>$edate]);
	}
    public function actionPilot()	
	{
		$merchantId = Yii::$app->user->identity->ID;
		$pilotModel = Serviceboy::find()
			->where(['merchant_id' => $merchantId])
		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
		$model = new Serviceboy;
		$model->scenario = 'passwordscenario';
		if ($model->load(Yii::$app->request->post()) ) {
			$serviceBoyArr = Yii::$app->request->post('Serviceboy');
			$model->merchant_id = (string)Yii::$app->user->identity->ID;
			$model->unique_id = Utility::get_uniqueid('product','SBOY');
			$model->status = '1';
			$model->password = password_hash($serviceBoyArr['password'], PASSWORD_DEFAULT);
			$model->reg_date = date('Y-m-d h:i:s');
			$model->loginstatus = '0';
			$model->loginaccess = '0';
			if($model->validate()){
				$model->save();
	Yii::$app->getSession()->setFlash('success', [
        'title' => 'Pilot',
		'text' => 'Pilot Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('pilot');
			}
			else
			{
//				echo "<pre>";print_r($model->getErrors());exit;
			}
		}
        return $this->render('pilot',['pilotModel'=>$pilotModel,'model'=>$model]);
    }
	public function actionChangeloginaccess()
	{
		extract($_POST);
		if($tablename == 'serviceboy')
		{
			$details = Serviceboy::findone($tableid);
				
			if($details['loginaccess']=='1'){
				$availabilty ='0';
		}else{
				$availabilty = '1';
		}
		$details->loginaccess = $availabilty;
		$details->save(); 
		}	
	}
	public function actionUpdatepilotpopup()
	{
		extract($_POST);
		$serviceBoyModel = Serviceboy::findOne($id);
		return $this->renderAjax('editpilot', ['model' => $serviceBoyModel,'id'=>$id]);		
	}
	public function actionUpdatepilot()
	{
		$model = new Serviceboy;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$serviceBoyArr = Yii::$app->request->post('Serviceboy');
		$pilotUpdate = Serviceboy::findOne($_POST['Serviceboy']['ID']);
		$currentPassword = $pilotUpdate->password;
		$pilotUpdate->attributes = \Yii::$app->request->post('Serviceboy');
		if(!empty($serviceBoyArr['password']))
		{
			$pilotUpdate->password = password_hash($serviceBoyArr['password'], PASSWORD_DEFAULT);
		}
		else{
			$pilotUpdate->password = $currentPassword;
		}
		if($pilotUpdate->validate()){
			$pilotUpdate->save();
			Yii::$app->getSession()->setFlash('success', [
        'title' => 'Pilot',
		'text' => 'Pilot Details Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		}
			return $this->redirect('pilot');
	
	}
	public function actionCoupon()
	{
		$productString = '';
		$merchantId = Yii::$app->user->identity->ID;
		$couponModel = MerchantCoupon::find()
			->where(['merchant_id' => $merchantId])
		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
	$product = Product::find()
        ->where(['merchant_id' => $merchantId])
	->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
		$model = new MerchantCoupon;
		$model->scenario = 'uniquescenario';
		if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
		if ($model->load(Yii::$app->request->post()) ) {

	$productString = '';		
if(!empty($_POST['ckcDel'])){
				$productString = implode(",",$_POST['ckcDel']);
}
	
				
		$MerchantCouponArr = Yii::$app->request->post('MerchantCoupon');
			
			
			$model->merchant_id = (string)Yii::$app->user->identity->ID;
			$model->status = 'Active';
			if(!empty($productString)){
			$model->product = $productString;	
			}
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
				return $this->redirect();
			}
			else
			{
				//echo "<pre>";print_r($model->getErrors());exit;
			}
		}


        return $this->render('coupon',['couponModel'=>$couponModel,'model'=>$model,'merchantId'=>$merchantId,'product'=>$product]);
    }
	public function actionEditcouponpopup()
	{
		extract($_POST);
		$merchantCouponModel = MerchantCoupon::findOne($id);
		$product = Product::find()
        ->where(['merchant_id' => $merchantCouponModel['merchant_id']])
	->orderBy([
            'ID'=>SORT_DESC
        ])
	->asArray()->all();
	$prodArr = [];
	$prodString = $merchantCouponModel['product'];
	if(!empty($prodString)){
		$prodArr = 	explode(",",$prodString);
	}

		return $this->renderAjax('editcouponpopup', ['model' => $merchantCouponModel,'id'=>$id,'product'=>$product,'prodArr'=>$prodArr]);		
	}
	
	public function actionEditcoupon()
	{
		$model = new MerchantCoupon;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$prodArr = Yii::$app->request->post('ckcDeledit');
		

		$MerchantCouponArr = Yii::$app->request->post('MerchantCoupon');
		$MerchantCouponUpdate = MerchantCoupon::findOne($_POST['MerchantCoupon']['ID']);
	
		$MerchantCouponUpdate->attributes = \Yii::$app->request->post('MerchantCoupon');
		if(!empty($prodArr)){
			$productString = implode(",",$prodArr);
		}else{
			$productString = '';
		}
		$MerchantCouponUpdate->product = $productString;
		if($MerchantCouponUpdate->validate()){
			$MerchantCouponUpdate->save();
						Yii::$app->getSession()->setFlash('success', [
        'title' => 'Coupon',
		'text' => 'Coupon Details Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		}
			return $this->redirect('coupon');
	
	}
	public function actionGallery()
	{
		$merchantId = Yii::$app->user->identity->ID;
		$galleryModel = MerchantGallery::find()
			->where(['merchant_id' => $merchantId])
		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
		$model = new MerchantGallery;
		
		if ($model->load(Yii::$app->request->post()) ) {
			$MerchantGalleryArr = Yii::$app->request->post('MerchantGallery');
			$model->merchant_id = (string)Yii::$app->user->identity->ID;
			$model->reg_date = date('Y-m-d h:i:s');
			$image = UploadedFile::getInstance($model, 'image');
			if($image){
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$image->saveAs('uploads/merchantgallery/' . $imagename);
				$model->image = $imagename;
			}
			if($model->validate()){
				$model->save();
	Yii::$app->getSession()->setFlash('success', [
        'title' => 'Gallery',
		'text' => 'Gallery Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('gallery');
			}
			else
			{
		//		echo "<pre>";print_r($model->getErrors());exit;
			}
		}
        return $this->render('gallery',['galleryModel'=>$galleryModel,'model'=>$model]);
    }
	public function actionDeletegallery()
	{
		extract($_POST);
		$galleryDet = MerchantGallery::findOne($id);
		if($galleryDet['image']){
				$imagePath =  '../../'.Url::to(['/uploads/merchantgallery/'. $galleryDet['image']]);
					if(file_exists($imagePath)){
					unlink($imagePath);	
					}
			\Yii::$app->db->createCommand()->delete('merchant_gallery', ['id' => $id])->execute();
		}
		return $this->redirect('gallery');
	}
	public function actionOrders()
	{
		extract($_POST);
		$sdate = $_POST['sdate'] ?? date('Y-m-d'); 
		$edate = $_POST['edate'] ?? date('Y-m-d');
		$merchantId = Yii::$app->user->identity->ID;
		$orderModel = Orders::find()
			->where(['between', 'date(reg_date)', $sdate, $edate ])
			->andWhere(['merchant_id' => $merchantId ])

		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
		//echo "<pre>";print_r($orderModel);exit;
		$model = new Orders;
		return $this->render('orders',['orderModel'=>$orderModel,'model'=>$model,'sdate'=>$sdate,'edate'=>$edate]);
	}
	public function userCreation($customer_mobile,$customer_name){
		$modelUser = new \app\models\Users;
		$sqlprevuser = 'select MAX(ID) as id from users';
		$prevuser = Yii::$app->db->createCommand($sqlprevuser)->queryOne();
		$newid = $prevuser['id']+1;
			$modelUser->unique_id = 'FDQ'.sprintf('%06d',$newid);
			$modelUser->name = ucwords($customer_name);
			$modelUser->mobile = trim($customer_mobile); 	
			$modelUser->password = password_hash('112233',PASSWORD_DEFAULT); 	
			$modelUser->status = '1';
			$modelUser->referral_code = 'REFFDQ'.$newid;
			$modelUser->reg_date = date('Y-m-d h:i:s');
			if($modelUser->validate()){
			$modelUser->save();	
			}
			else{
			print_r($modelUser->getErrors());exit;	
			}
			
			return $modelUser['ID']; 
	}
	public function actionSavetableorder()
	{
    $connection = \Yii::$app->db;	
	$transaction = $connection->beginTransaction();
    try {
		extract($_POST);
		$table_det = Tablename::findOne($tableid);

		$priceArr =  array_filter($_POST['order_price_popup']) ;
		$qtyArr =  array_filter($_POST['order_quantity_popup']) ;		
		$totalPrice = [];
		foreach ($priceArr as $key=>$price) {
			$totalPrice[] = $price * $qtyArr[$key];
		}
		$productprice = array_sum($totalPrice) ??  0;

		$orderArray = array_combine($_POST['product_popup'],$_POST['order_quantity_popup']);
		$orderPriceArray = array_combine($_POST['product_popup'],$_POST['order_price_popup']);

		foreach($orderArray as $key => $value)
		{
			if($value == 0){
				unset($orderArray[$key]);
				unset($orderPriceArray[$key]);
			}

		}

		if(!empty($customer_mobile)){
			$userDet = \app\models\Users::find()->where(['mobile'=>$customer_mobile])->asArray()->One();
			if(empty($userDet)){
				$userId = $this->userCreation($customer_mobile,$customer_name);	
			}
			else{
				$userId = $userDet['ID'];
			}
			
		}else{
			$userId = '';
		}
		
		if($table_det['table_status'] == '1'){
			$_POST['order_id'] =  $table_det['current_order_id'];
			$_POST['productprice'] = $productprice;
			$_POST['orderArray'] = $orderArray;
			$_POST['orderPriceArray'] = $orderPriceArray;
			$_POST['user_id'] = $userId;
			$this->re_order($_POST);
		}
		else{
		

		if(count($orderArray) > 0){
			$merchantid = (string)Yii::$app->user->identity->ID;
			$model = new Orders;
			$model->merchant_id = $merchantid;
			$model->tablename = $tableid;
			$model->user_id = $userId;
			$model->order_id = Utility::order_id($merchantid,'order'); 
			$model->txn_id = Utility::order_id($merchantid,'transaction');
			$model->txn_date = date('Y-m-d H:i:s');
			$model->amount = $popupamount ? number_format($popupamount, 2, '.', ',') : 0;
			
					$model->tax = $popuptaxamt;
					$model->tips = number_format($popuptipamt, 2, '.', '');
					$model->subscription = $popupsubscriptionamt;
					$model->couponamount = (string)$couponamountpopup;
					$model->totalamount = (string)$popuptotalamt;
					$model->coupon = $merchant_coupon;
					$model['paymenttype'] = $payment_mode;
							$model->orderprocess = '1';
							$model->status = '1';
							$model->paidstatus = '0';
							$model->paymentby = '1';
							$sqlprevmerchnat = 'select max(orderline) as id from orders where merchant_id = \''.$merchantid.'\' and date(reg_date) =  \''.date('Y-m-d').'\''; 
							$resprevmerchnat = Yii::$app->db->createCommand($sqlprevmerchnat)->queryOne();
							$prevmerchnat = $resprevmerchnat['id']; 
							$newid = $prevmerchnat>0 ? $prevmerchnat+1 : 100;  
							$model->orderline = (string)$newid;
						    $model->reg_date = date('Y-m-d h:i:s');
								
					if($model->save())
						{

							$orderTransaction = new \app\models\OrderTransactions;
							$orderTransaction->order_id = (string)$model->ID;
							$orderTransaction->user_id = $userId;			
							$orderTransaction->merchant_id = $merchantid;
							$orderTransaction->amount = !empty($popupamount) ? number_format(trim($popupamount),2, '.', ',') : 0; 
							$orderTransaction->couponamount =   (string)$couponamountpopup; 
							$orderTransaction->tax =  !empty($popuptaxamt) ? number_format(trim($popuptaxamt),2, '.', ',') : 0; 
							$orderTransaction->tips =  !empty($popuptipamt) ? number_format(trim($popuptipamt),2, '.', ',') : 0; 
							$orderTransaction->subscription =  !empty($popupsubscriptionamt) ? number_format(trim($popupsubscriptionamt),2, '.', ',') : 0; 
							$orderTransaction->totalamount =   !empty($popuptotalamt) ? number_format(trim($popuptotalamt),2, '.', ',') : 0; 
							$orderTransaction->paymenttype = $payment_mode;
							$orderTransaction->reorder= '0';
							$orderTransaction->paidstatus = '0';
							$orderTransaction->reg_date = date('Y-m-d h:i:s');
							$orderTransaction->save();
					//echo "<pre>";						print_r($orderTransaction->getErrors());exit;
						$productscount = []; $p=0;$r=1;
						foreach($orderArray as $k => $v)
						{
							$productscount[$p]['order_id'] = $model->ID;
										$productscount[$p]['user_id'] = $userId;
										$productscount[$p]['merchant_id'] = $merchantid;
										$productscount[$p]['product_id'] = trim($k);
										$productscount[$p]['count'] = trim($v);
										$productscount[$p]['price'] = trim($orderPriceArray[$k]);
										$productscount[$p]['inc'] = $r;
						$p++;$r++;
						}
					Yii::$app->db
			->createCommand()
			->batchInsert('order_products', ['order_id','user_id','merchant_id','product_id', 'count', 'price','inc'],$productscount)
			->execute();
						$tableUpdate = Tablename::findOne($tableid);
						$tableUpdate->table_status = '1';
						$tableUpdate->current_order_id = $model->ID;
						$tableUpdate->save();
						}
					
		}
	}
	 $transaction->commit();
                  Yii::$app->session->setFlash('success', "User created successfully."); 
	 return $this->redirect('tableorder');
    } catch(Exception $e) {
        $transaction->rollback();
    }
	}
	public function re_order($orderData){
//		echo "<pre>";		print_r($orderData);exit;
		$order_det = Orders::findOne($orderData['order_id']);
		$prevOrderProductDetails = \app\models\OrderProducts::find()->where(['order_id'=>$order_det->ID])->asArray()->all();
		$prevOrderIdArr = array_column($prevOrderProductDetails,'ID');
					$prevOrderProductsArr = (array_column($prevOrderProductDetails,'product_id'));
					
					$newProductIdArr = array_diff($orderData['product_popup'],$prevOrderProductsArr);
		
		$orderUpdateArray = array_combine($_POST['product_popup'],$_POST['order_quantity_popup']);
		$orderUpdatePriceArray = array_combine($_POST['product_popup'],$_POST['order_price_popup']);

					
					
		$productprice = $orderData['popupamount'];
		$order_det->amount = (string)$orderData['popupamount'];
					$tipsamount = $orderData['popuptipamt'];
					$taxsamount = number_format($orderData['popuptaxamt'], 2, '.', '');
					$subscriptionamount = number_format($orderData['popupsubscriptionamt'], 2, '.', '');
					$savingamt = 0;
					$order_det->user_id = $orderData['user_id'];
					$order_det->tax = $taxsamount;
					$order_det->tips = number_format($tipsamount, 2, '.', '');
					$order_det->subscription = $subscriptionamount;
					$order_det->couponamount = $orderData['couponamountpopup'];
					$order_det->coupon = $orderData['merchant_coupon'];
					$compleamt = $orderData['popuptotalamt'];
					$order_det->totalamount = (string)$compleamt;
					$order_det->reorderprocess = '1';
		
		

		if($order_det->save())
					{
							$orderTransaction = new \app\models\OrderTransactions;
							$orderTransaction->order_id = (string)$order_det->ID;
							$orderTransaction->user_id = $orderData['user_id'];
							$orderTransaction->merchant_id = (string)$order_det->merchant_id;
							$orderTransaction->amount = !empty($productprice) ? number_format(trim($productprice),2, '.', ',') : 0; 
							$orderTransaction->couponamount =   $orderData['couponamountpopup']; 
							$orderTransaction->tax =  !empty($taxsamount) ? number_format(trim($taxsamount),2, '.', ',') : 0; 
							$orderTransaction->tips =  !empty($tipsamount) ? number_format(trim($tipsamount),2, '.', ',') : 0; 
							$orderTransaction->subscription =  !empty($subscriptionamount) ? number_format(trim($subscriptionamount),2, '.', ',') : 0; 
							$orderTransaction->totalamount =   !empty($compleamt) ? number_format(trim($compleamt),2, '.', ',') : 0; 
							$orderTransaction->paymenttype = $orderData['payment_mode'];
							$orderTransaction->reorder= '1';
							$orderTransaction->paidstatus = '0';
							$orderTransaction->reg_date = date('Y-m-d h:i:s');
							$orderTransaction->save();
				
		for($prev = 0; $prev<count($prevOrderIdArr);$prev++){
			$prevOrderUpdate = \app\models\OrderProducts::findOne($prevOrderIdArr[$prev]);

			if(isset($orderUpdatePriceArray[$prevOrderUpdate['product_id']])){
				$prevOrderUpdate->user_id = $orderData['user_id'];
				$prevOrderUpdate->order_id = $prevOrderUpdate['order_id'];
				$prevOrderUpdate->price = $orderUpdatePriceArray[$prevOrderUpdate['product_id']];
				$prevOrderUpdate->count = $orderUpdateArray[$prevOrderUpdate['product_id']];
				$prevOrderUpdate->reorder = '1';
				$prevOrderUpdate->reg_date = date('Y-m-d h:i:s');
				$prevOrderUpdate->save();
			}
			else{
				$prevOrderUpdate->user_id = $orderData['user_id'];
				$prevOrderUpdate->order_id = $prevOrderUpdate['order_id'];
				$prevOrderUpdate->price = (string)$prevOrderUpdate['price'];
				$prevOrderUpdate->count = '0';
				$prevOrderUpdate->reorder = '0';
				$prevOrderUpdate->reg_date = date('Y-m-d h:i:s');
				$prevOrderUpdate->save();
			}
		}
		$newArray = [];
		for($new=0 ,$inc = count($prevOrderIdArr)+1;$new<count($newProductIdArr);$new++){
			$newArray[] = ['user_id' => $orderData['user_id'],'order_id'=>$order_det->ID,'merchant_id'=>$order_det->merchant_id,'product_id'=>$newProductIdArr[$new]
			,'count'=>$orderUpdateArray[$newProductIdArr[$new]]
			,'price'=>$orderUpdatePriceArray[$newProductIdArr[$new]],'inc'=>$inc];
		$inc++;
		}

					Yii::$app->db
			->createCommand()
			->batchInsert('order_products', ['order_id','merchant_id','product_id', 'count', 'price','inc'],$newArray)
			->execute();
		
		
					}
	}
	public function actionTableplaceorder()
	{
		$tableDetails = Tablename::find()->where(['merchant_id'=>Yii::$app->user->identity->ID])->asArray()->all();
		return $this->render('tableorder',['tableDetails'=>$tableDetails]);
	}
	public function actionTableorder()
	{
		$sqlTableDetails = 'select o.ID,tn.ID tableId,tn.name,o.orderprocess
		,o.totalamount from tablename tn left join orders o on tn.current_order_id = o.id 
		where tn.merchant_id = \''.Yii::$app->user->identity->ID.'\' ';
		$tableDetails = Yii::$app->db->createCommand($sqlTableDetails)->queryAll();
		return $this->render('tableorderstatus',['tableDetails'=>$tableDetails]);
	}
	public function actionTableorderstatuschange()
	{
		extract($_POST);
		$orderUpdate = Orders::findOne($id);
		$orderUpdate->orderprocess = $chageStatusId;
		$orderUpdate->save();
		$tableUpdate = Tablename::findOne($tableId);
		if($chageStatusId == '4' || $chageStatusId == '3')
		{
			$table_status = null;
			$current_order_id = null;
		}
		else{
			$table_status = $chageStatusId;
			$current_order_id = $id;
		}
		

		$tableUpdate->table_status = $table_status;
		$tableUpdate->current_order_id = $current_order_id;
		
		if($tableUpdate->save()){
			return "Status Updated Sucessfully";
		}
		else{
			return "Status Not Updated";
		}
		
	}
	public function actionProductautocomplete(){
		extract($_POST);
		$like = '%'.$query.'%';
		$sql = 'SELECT distinct title title from product where title like \''.$like.'\' and merchant_id = \''.Yii::$app->user->identity->ID.'\'';
		$res = YIi::$app->db->createCommand($sql)->queryAll();
			 return  stripslashes(json_encode(array_column($res,'title'), JSON_UNESCAPED_SLASHES));
	}
	public function actionApplycouponautocomplete()
	{
			extract($_REQUEST);

		$like = '%'.$query.'%';
		$sql = 'SELECT  code,concat(price,\'-\',type) price from merchant_coupon where code like \''.$like.'\' and merchant_id = \''.Yii::$app->user->identity->ID.'\'';
		$res = YIi::$app->db->createCommand($sql)->queryAll();
		 return  stripslashes(json_encode($res, JSON_UNESCAPED_SLASHES));

	}
	public function actionAutocompleteingredient(){
			extract($_REQUEST);

		$like = '%'.$query.'%';
		$sql = 'SELECT  * from ingredients where item_name like \''.$like.'\' and merchant_id = \''.Yii::$app->user->identity->ID.'\'';
		$res = YIi::$app->db->createCommand($sql)->queryAll();
		 return  stripslashes(json_encode($res, JSON_UNESCAPED_SLASHES));

	}
	public function actionUpdatemerchatprofile(){
		$model =  \app\models\Merchant::findOne(Yii::$app->user->identity->ID);
		$oldLogo = $model['logo'];
		$oldQrLogo = $model['qrlogo'];
		$oldCoverpic = $model['coverpic'];
if($model->load(Yii::$app->request->post())){
	$logoimage = UploadedFile::getInstance($model, 'logo');
	$qrlogoimage = UploadedFile::getInstance($model, 'qrlogo');
	$coverpicimage = UploadedFile::getInstance($model, 'coverpic');	
	if($logoimage){
					if(!empty($oldLogo)){
					$imagePath =  '../../'.Url::to(['/uploads/merchantimages/'. $oldLogo]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
					
				}
				
				$logoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$logoimage->extension;
				$logoimage->saveAs('uploads/merchantimages/' . $logoimagename);
				$model->logo = $logoimagename;

			}else{
				$model->logo = $oldLogo;
			}
	
			if($qrlogoimage){
				if(!empty($oldQrLogo)){
					$imagePath =  '../../'.Url::to(['/uploads/merchantimages/'. $oldQrLogo]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				$qrlogoimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$qrlogoimage->extension;
				$qrlogoimage->saveAs('uploads/merchantimages/' . $qrlogoimagename);
				$model->qrlogo = $qrlogoimagename;
			}else{
				$model->qrlogo = $oldQrLogo;
			}
			if($coverpicimage){
				if(!empty($oldCoverpic)){
					$imagePath =  '../../'.Url::to(['/uploads/merchantimages/'. $oldCoverpic]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				$coverpicimageimagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$coverpicimage->extension;
				$coverpicimage->saveAs('uploads/merchantimages/' . $coverpicimageimagename);
				$model->coverpic = $coverpicimageimagename;
			}else{
				$model->coverpic = $oldCoverpic;
			}

if($model->validate()){
			$model->save();
			$this->refresh();
		}
		else
		{
			echo "<pre>";print_r($model->getErrors());exit;
		}	

}		

		return $this->render('merchantprofile',['model'=>$model]);
	}
	public function actionRemoveimage(){
		extract($_POST);
		$model =  \app\models\Merchant::findOne($id);
		$removableImage = $model[$col];
		if(!empty($removableImage)){
					$imagePath =  '../../'.Url::to(['/uploads/merchantimages/'. $removableImage]);
					if(file_exists($imagePath)){
						unlink($imagePath);
						$model->$col = null;
						$model->save();
					}
				}
				 
	}
	public function actionChangepassword()
	{
		$model =  \app\models\Merchant::findOne(Yii::$app->user->identity->ID);
		$model->scenario = 'chagepassword';
		
			if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$password = password_hash($_POST['Merchant']['newpassword'],PASSWORD_DEFAULT);
		$sqlupdateMerchant = 'update merchant set password = \''.$password.'\' where ID = \''.Yii::$app->user->identity->ID.'\'';
		$updateMerchant = Yii::$app->db->createCommand($sqlupdateMerchant)->execute(); 
		return $this->redirect('updatemerchatprofile');

	}
	public function actionIngredients()
	{
		$merchantId = Yii::$app->user->identity->ID;
		$ingredientsModel = \app\models\Ingredients::find()
			->where(['merchant_id' => $merchantId])
		->orderBy([
				'ID'=>SORT_DESC
			])
		->asArray()->all();
		
		$model = new Ingredients;
		$model->scenario = 'addingredient';
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}

		if ($model->load(Yii::$app->request->post()) ) {
			$ingredientsArr = Yii::$app->request->post('Ingredients');
			$model->merchant_id = (string)Yii::$app->user->identity->ID;
			$model->status = '1';
			$model->reg_date = date('Y-m-d h:i:s');
			$image = UploadedFile::getInstance($model, 'photo');
			if($image){
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$image->saveAs('uploads/ingredients/' . $imagename);
				$model->photo = $imagename;
			}
			if($model->validate()){
				$model->save();
	Yii::$app->getSession()->setFlash('success', [
        'title' => 'Ingredient',
		'text' => 'Ingredient Created Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
				return $this->redirect('ingredients');
			}
			else
			{
				echo "<pre>";print_r($model->getErrors());exit;
			}
		}
    
    return $this->render('ingredients',['ingredientsModel'=>$ingredientsModel,'model'=>$model]);
    
	}
	public function actionUpdateingredientpopup()
	{
		extract($_POST);
		$ingredientsModel = Ingredients::findOne($id);
		return $this->renderAjax('editingredient', ['model' => $ingredientsModel,'id'=>$id]);		
	}
	public function actionUpdateingredients()
	{
		$model = new Ingredients;
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		$ingredientsArr = Yii::$app->request->post('Ingredients');
		$ingredientsUpdate = Ingredients::findOne($_POST['Ingredients']['ID']);
		$oldPhoto = $ingredientsUpdate['photo']; 
		$ingredientsUpdate->attributes = \Yii::$app->request->post('Ingredients');
		$ingredientsUpdate->modify_date = date('Y-m-d h:i:s');
		$image = UploadedFile::getInstance($model, 'photo');
			if($image){
				if(!empty($ingredientsUpdate['photo'])){
					$imagePath =  '../../'.Url::to(['/uploads/ingredients/'. $ingredientsUpdate['photo']]);
					if(file_exists($imagePath)){
						unlink($imagePath);	
					}
				}
				
				$imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
				$image->saveAs('uploads/ingredients/' . $imagename);
				$ingredientsUpdate->photo = $imagename;
			}else{
				$ingredientsUpdate->photo = $oldPhoto;
			}
		if($ingredientsUpdate->validate()){
			$ingredientsUpdate->save();
			Yii::$app->getSession()->setFlash('success', [
        'title' => 'Ingredients',
		'text' => 'Ingredient Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
		}else{
			echo "<pre>";print_r($ingredientsUpdate->getErrors());exit;
		}
			return $this->redirect('ingredients');
	
	}
	public function actionRecipeproducts()
	{
		$merchantId = Yii::$app->user->identity->ID;
	$sqlproductDetails = 'select P.ID,P.title,P.food_category_quantity,P.price,P.image 
		,case when food_type_name is not null then concat(title ,\' (\' , food_type_name , \')\') else title end  title_quantity  
		from product P left join food_category_types fct on fct.ID =  P.food_category_quantity and fct.merchant_id =  \''.Yii::$app->user->identity->ID.'\'
		where P.merchant_id = \''.Yii::$app->user->identity->ID.'\' ORDER BY ID DESC';
			$productDetails = Yii::$app->db->createCommand($sqlproductDetails)->queryAll();
			
	$sqlIngredients = 'select mr.ID,mr.ingredient_id,i.item_name,mr.product_id,mr.ingred_quantity,mr.ingred_price  from merchant_recipe mr  
	inner join ingredients i on mr.ingredient_id = i.ID
	where mr.merchant_id = \''.Yii::$app->user->identity->ID.'\' ';
	$resIngredients = Yii::$app->db->createCommand($sqlIngredients)->queryAll();
	
	$addedIngreds = array_column($resIngredients,'ingredient_id');
	$prevRecipeing = \yii\helpers\ArrayHelper::index($resIngredients, null, 'product_id');
			
	return 	$this->render('recipeproducts',['productModel'=>$productDetails,'prevRecipeing'=>json_encode($prevRecipeing),'addedIngreds'=>json_encode($addedIngreds)]);
	}
	public function actionSaverecipe()
	{
		extract($_POST);
		if(!empty(array_filter($ingredients))){
			$ingredientsDet =  Ingredients::find()->where(['merchant_id'=>Yii::$app->user->identity->ID])->asArray()->all();
			$ingredIdNameArr =  array_column($ingredientsDet,'ID','item_name');
			//echo "<pre>";print_r($_POST);exit;
			//echo count($ingredients);exit;
			for($i=0;$i<count($ingredients);$i++)
			{
				$data[] = [$productid,$ingredIdNameArr[$_POST['ingredients'][$i]],$_POST['quantity'][$i],$_POST['price'][$i]
				,'1',(string)Yii::$app->user->identity->ID,date('Y-m-d h:i:s A')];
			}
			
		
			Yii::$app->db
			->createCommand()
			->batchInsert('merchant_recipe', ['product_id','ingredient_id','ingred_quantity','ingred_price','status','merchant_id', 'reg_date'],$data)
			->execute();
		}
		else{

		}
		return $this->redirect('recipeproducts');
	}
	public function actionDeleteingredientfromrecipe()
	{
		extract($_POST);
		$sql = 'delete from merchant_recipe where ID = \''.$id.'\'';
		$res = Yii::$app->db->createCommand($sql)->execute();
		return 'sucess';
	}
}